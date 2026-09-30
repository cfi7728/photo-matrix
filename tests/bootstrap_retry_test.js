'use strict';

// Regression test for the browser bootstrap state machine. This repository keeps
// its browser script dependency-free, so the test checks the actual shipped
// source rather than introducing a second DOM implementation just for tests.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const source = fs.readFileSync(path.join(__dirname, '..', 'public', 'assets', 'app.js'), 'utf8');

const functionBody = (name) => {
  const start = source.indexOf(`function ${name}(`);
  assert.notEqual(start, -1, `${name} is defined`);
  const next = source.indexOf('\n  function ', start + 10);
  return source.slice(start, next === -1 ? source.length : next);
};

const loadBootstrap = functionBody('loadBootstrap');
const configureUi = functionBody('configureUi');
const applyWorkflowState = functionBody('applyWorkflowState');
const populateUiCatalog = functionBody('populateUiCatalog');

// Failure: controls stay locked and the persistent inline error/retry UI wins
// over the old status fallback, which could make the form appear usable.
assert.match(loadBootstrap, /catalogControlsEnabled\(false\)/);
assert.match(loadBootstrap, /setBootstrapStatus\('error'/);
assert.match(loadBootstrap, /throw error/);
assert.doesNotMatch(loadBootstrap, /api\('status'\)/);
assert.match(source, /bootstrap-retry'\)\.onclick=function\(\)\{loadBootstrap\(\)/);

// Retry success: the same bootstrap request rebuilds the catalog first, then
// reapplies every persisted workflow concern before revealing usable controls.
assert.match(loadBootstrap, /api\('bootstrap'\)/);
assert.match(loadBootstrap, /configureUi\(data\)/);
assert.match(configureUi, /populateUiCatalog\(data\.ui\);applyWorkflowState\(data\.state\)/);
assert.match(populateUiCatalog, /validCatalogOptions/);
assert.match(populateUiCatalog, /catalogControlsEnabled\(true\)/);
assert.match(applyWorkflowState, /App\.state=state/);
assert.match(applyWorkflowState, /setValue\(\$\('#location'\)/);
assert.match(applyWorkflowState, /setValue\(\$\('#region'\)/);
assert.match(applyWorkflowState, /toggleRegion\(\)/);
assert.match(applyWorkflowState, /App\.state\.scenes/);
assert.match(applyWorkflowState, /gotoStep\(/);

console.log('OK: fehlgeschlagener Bootstrap bleibt gesperrt und ein erfolgreicher Retry stellt Katalog und Workflow wieder her.');
