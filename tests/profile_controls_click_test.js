'use strict';

const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');

const js = fs.readFileSync(path.join(__dirname, '..', 'public', 'assets', 'app.js'), 'utf8');
const css = fs.readFileSync(path.join(__dirname, '..', 'public', 'assets', 'app.css'), 'utf8');
const bind = js.slice(js.indexOf('function bind()'), js.indexOf('\n  function uploadFiles('));
const gotoStep = js.slice(js.indexOf('function gotoStep('), js.indexOf('\n  function optionFill('));

assert.match(bind, /var profileForm=\$\('#profile-form'\),profileNext=\$\('#profile-next'\)/);
assert.match(bind, /profileForm\.addEventListener\('submit',function\(e\)\{e\.preventDefault\(\);submitProfile\(profileForm\)\}\)/);
assert.match(bind, /profileNext\.addEventListener\('click',function\(e\)\{e\.preventDefault\(\);submitProfile\(profileForm\)\}\)/);
assert.doesNotMatch(css, /\.stage\.stage-exiting,\.stage\.stage-entering\{pointer-events:none\}/);
assert.match(css, /\.stage\.stage-exiting\{pointer-events:none/);
assert.match(gotoStep, /target\.contains\(document\.activeElement\)/);

console.log('OK: Profil-Selects und „Location wählen“ bleiben während des Einblendens direkt bedienbar.');
