'use strict';
const fs = require('node:fs');
const vm = require('node:vm');
const assert = require('node:assert/strict');
const source = fs.readFileSync(require('node:path').join(__dirname, '../resources/js/evo-ui.js'), 'utf8');
const between = (start, end) => source.slice(source.indexOf('    function ' + start), source.indexOf('    function ' + end));
const calls = [];
const storage = new Map();
const context = vm.createContext({
    Promise, Number, Math, Array,
    window: {innerWidth: 1440, sessionStorage: {getItem: k => storage.get(k) || null, setItem: (k,v) => storage.set(k,v), removeItem: k => storage.delete(k)}},
    livewireComponent: () => ({call: (...args) => { calls.push(args); return Promise.resolve(); }}),
    tableResponsiveStorageKey: () => 'test.table',
});
vm.runInContext(between('moduleTableWidth(', 'tableResponsiveStorageKey(') + between('tableSupportsView(', 'initResponsiveTableView('), context);
const element = width => ({getBoundingClientRect: () => ({width}), querySelectorAll: () => []});
function surface(width, current = 'table', origin = 'default', supported = ['table', 'list'], breakpoint = 1200) {
    const attrs = {'data-evo-table-view': current, 'data-evo-table-view-origin': origin, 'data-evo-responsive-list': String(breakpoint)};
    return {...element(width), getAttribute: key => attrs[key] ?? null, hasAttribute: key => Object.hasOwn(attrs, key),
        querySelector: selector => supported.some(view => selector.includes("'" + view + "'")) ? {} : null};
}
assert.equal(context.moduleTableWidth(null), 0);
assert.equal(context.moduleTableWidth(element(617.9)), 617);
assert.equal(context.moduleTableWidth(element(0)), 0);
assert.equal(context.moduleTableWidth(element(NaN)), 0);
assert.equal(context.moduleTableWidth({...element(900), querySelectorAll: () => [element(580), element(0)]}), 580);
assert.equal(context.moduleTableWidth({...element(900), querySelectorAll: () => [element(400), element(500)]}), 900);
function expectCalls(target, expected) {
    calls.length = 0;
    context.syncResponsiveTableView(target);
    assert.deepEqual(calls, expected);
}
expectCalls(surface(617), [['switchView', 'list', true]]);
expectCalls(surface(617, 'list', 'auto'), []);
expectCalls(surface(1280, 'table', 'auto'), []);
expectCalls(surface(1280, 'list', 'auto'), [['switchView', 'table', true]]);
expectCalls(surface(617, 'table', 'manual'), []);
expectCalls(surface(1280, 'list', 'manual'), []);
expectCalls(surface(617, 'table', 'default', ['table']), []);
expectCalls(surface(617, 'table', 'default', ['list']), []);
expectCalls(surface(617, 'table', 'default', ['table', 'list'], 0), []);
expectCalls(surface(800, 'table', 'default', ['table', 'list'], 768), []);
const pending = surface(617); pending.__evoResponsiveViewPending = 'list'; expectCalls(pending, []);
const manualPending = surface(617); manualPending.__evoResponsiveManualChoice = true; expectCalls(manualPending, []);
const legacy = surface(617); legacy.hasAttribute = () => false; expectCalls(legacy, [['switchView', 'list']]);
context.window.sessionStorage.getItem = () => { throw Error('Storage blocked'); };
expectCalls(surface(617), [['switchView', 'list', true]]);
console.log('20 responsive table JavaScript checks passed');
