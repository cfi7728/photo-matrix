'use strict';

const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');

const source = fs.readFileSync(path.join(__dirname, '..', 'public', 'assets', 'app.js'), 'utf8');
const bindStart = source.indexOf('function bind()');
const bindEnd = source.indexOf('\n  function uploadFiles(', bindStart);
const bind = source.slice(bindStart, bindEnd);

assert.notEqual(bindStart, -1, 'bind is defined');
assert.notEqual(bindEnd, -1, 'bind can be isolated');
assert.match(bind, /locationForm\.addEventListener\('submit',function\(e\)\{e\.preventDefault\(\);submitLocation\(locationForm\)\}\)/);
assert.match(bind, /locationNext\.addEventListener\('click',function\(e\)\{e\.preventDefault\(\);submitLocation\(locationForm\)\}\)/);

console.log('OK: Der sichtbare „Szenen auswählen“-Button löst die Location-Aktion direkt aus.');
