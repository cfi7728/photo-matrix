'use strict';

const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const source = fs.readFileSync(require('node:path').join(__dirname, '..', 'public', 'assets', 'app.js'), 'utf8');

function functionSource(name) {
  const start = source.indexOf(`function ${name}(`);
  assert.notEqual(start, -1, `${name} is defined`);
  const brace = source.indexOf('{', start);
  let depth = 0;
  for (let i = brace; i < source.length; i++) {
    if (source[i] === '{') depth++;
    if (source[i] === '}' && --depth === 0) return source.slice(start, i + 1);
  }
  throw new Error(`Unclosed function ${name}`);
}

class ClassList {
  constructor(names) { this.names = new Set(names || []); }
  add(...names) { names.forEach((name) => this.names.add(name)); }
  remove(...names) { names.forEach((name) => this.names.delete(name)); }
  contains(name) { return this.names.has(name); }
  toggle(name, force) { force ? this.add(name) : this.remove(name); }
}
class Element {
  constructor(attrs, classes) { this.attrs = attrs || {}; this.classList = new ClassList(classes); this.disabled = false; this.listeners = {}; this.style = {removeProperty() {}}; this.offsetHeight = 100; }
  getAttribute(name) { return this.attrs[name] === undefined ? null : String(this.attrs[name]); }
  setAttribute(name, value) { this.attrs[name] = String(value); }
  removeAttribute(name) { delete this.attrs[name]; }
  addEventListener(name, fn) { this.listeners[name] = fn; }
  click() { if (!this.disabled && this.listeners.click) this.listeners.click({currentTarget: this}); }
  querySelector(selector) { return selector === 'h1' ? {setAttribute() {}, classList:new ClassList(), focus() {}, removeAttribute() {}, addEventListener() {}} : null; }
}

const buttons = Array.from({length: 6}, (_, i) => new Element({'data-step-nav': i + 1}));
const stages = Array.from({length: 6}, (_, i) => new Element({'data-step': i + 1}, i === 0 ? ['stage', 'active'] : ['stage']));
const wait = new Element({id: 'wait-layer'});
const container = new Element({}, ['stage-container']);
const queryAll = (selector) => selector === '[data-step-nav]' ? buttons : selector === '.stage' ? stages : [];
const query = (selector) => {
  let match = selector.match(/^\.stage\[data-step="(\d)"\]$/);
  if (match) return stages[Number(match[1]) - 1];
  if (selector === '.stage.active') return stages.find((stage) => stage.classList.contains('active'));
  if (selector === '.stage-container') return container;
  if (selector === '#wait-layer') return wait;
  match = selector.match(/^\[data-step-nav="(\d)"\]$/);
  return match ? buttons[Number(match[1]) - 1] : null;
};

const context = {
  App: {state: {photoset_images:['set.jpg'], photoset_approved:true, profile:{height:'180'}, location:{value:'outside'}, scenes:['a','b','c'], scene_results:[{url:'result.jpg'}]}, step:1, isTransitioning:false, uploading:false, hasBootstrapped:false},
  stepLabels:{1:'Fotos',2:'FotoSet',3:'Look',4:'Location',5:'Szenen',6:'Resultat'},
  $: query, $$: queryAll, restoreStepView() {},
  window: {matchMedia:() => ({matches:true}), scrollTo() {}, requestAnimationFrame(fn) { fn(); }},
  setTimeout(fn) { fn(); }, parseInt
};
vm.createContext(context);
vm.runInContext(['reachableSteps','stepUnavailableReason','updateStepper','navigationBlocked','navigateToStep','gotoStep'].map(functionSource).join('\n'), context);

assert.match(source, /\$\$\('\[data-step-nav\]'\)\.forEach\(function\(button\)\{button\.addEventListener\('click'/, 'all step buttons receive a click handler');
buttons.forEach((button) => button.addEventListener('click', () => context.navigateToStep(button.getAttribute('data-step-nav'))));
context.updateStepper();

buttons.forEach((button, index) => {
  button.click();
  assert.equal(stages[index].classList.contains('active'), true, `clicking unlocked step ${index + 1} activates its section`);
});

console.log('OK: Jeder freigeschaltete Stepper-Schritt aktiviert im DOM seinen Abschnitt.');
