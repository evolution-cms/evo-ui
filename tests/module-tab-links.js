const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');

const template = fs.readFileSync(require.resolve('../views/components/module-tab-shell.blade.php'), 'utf8');
const state = template.match(/x-data="([\s\S]*?)"\s+x-on:evo-ui:form\.saved/)[1]
    .replace(/activeTab: @if[^\n]*/, "activeTab: 'items',")
    .replaceAll("@js($responsiveWidthModel !== '' && $model !== '')", 'true')
    .replaceAll("@js($model !== '')", 'true')
    .replaceAll('@js($model)', "'activeTab'")
    .replaceAll('@js($responsiveWidthModel)', "'tableWidth'")
    .replaceAll('@js($urlParameter)', "'get'")
    .replaceAll('&quot;', '"');

function shell({ dirty = false, urlBacked = true, canSyncUrl = true } = {}) {
    const calls = [];
    const location = {
        search: '?a=112&get=items',
        reload() { calls.push(['reload', this.search]); },
    };
    const component = vm.runInNewContext(`(${state.replaceAll("@js($urlParameter !== '')", String(urlBacked))})`, {
        URLSearchParams,
        window: { location, EvoUI: {
            form: { isDirty: () => dirty },
            moduleTabs: {
                tableWidth: () => 640,
                syncUrl: (key, value) => {
                    calls.push(['url', key, value]);
                    if (canSyncUrl) {
                        const query = new URLSearchParams(location.search);
                        query.set(key, value);
                        location.search = '?' + query.toString();
                    }
                },
            },
        } },
    });
    component.$wire = {
        set: (...args) => calls.push(['set', ...args]),
        $refresh: () => calls.push(['refresh']),
    };
    component.$dispatch = (event, { tab }) => calls.push(['event', event, tab]);
    return { component, calls };
}

function click(tagName = 'A', overrides = {}) {
    return {
        button: 0, defaultPrevented: false, currentTarget: { tagName },
        preventDefault() { this.defaultPrevented = true; },
        ...overrides,
    };
}

async function run() {
    assert.match(template, /\$isLink = \$href !== '' && \$href !== '#'/);
    assert.match(template, /\$tag = \$isLink \? 'a' : 'button'/);
    assert.match(template, /'href' => e\(\$href\)/);
    assert.match(template, /'type' => 'button'/);
    assert.match(template, /x-on:click="requestModuleTabClick\(\$event, @js\(\$key\)\)"/);
    assert.match(template, /x-on:keydown\.space\.prevent/);
    assert.doesNotMatch(template, /(?:x-on:|@)(?:auxclick|contextmenu)\b/);

    for (const tag of ['A', 'BUTTON']) {
        const { component, calls } = shell();
        const event = click(tag);
        component.requestModuleTabClick(event, 'settings');
        assert.equal(event.defaultPrevented, tag === 'A');
        assert.equal(component.activeTab, 'settings');
        assert.deepEqual(calls, [
            ['set', 'tableWidth', 640, false],
            ['url', 'get', 'settings'],
            ['set', 'activeTab', 'settings'],
        ]);
    }

    const { component: dirty, calls: dirtyCalls } = shell({ dirty: true });
    const regular = click();
    dirty.requestModuleTabClick(regular, 'settings');
    assert.equal(regular.defaultPrevented, true);
    assert.equal(dirty.showUnsavedPrompt, true);
    assert.equal(dirty.pendingTab, 'settings');
    assert.equal(dirty.activeTab, 'items');
    assert.deepEqual(dirtyCalls, []);

    for (const options of [{ button: 1 }, { button: 2 }, { ctrlKey: true }, { metaKey: true }, { shiftKey: true }, { altKey: true }, { defaultPrevented: true }]) {
        const { component, calls } = shell({ dirty: true });
        const event = click('A', options);
        component.requestModuleTabClick(event, 'settings');
        assert.equal(event.defaultPrevented, options.defaultPrevented ?? false);
        assert.equal(component.showUnsavedPrompt, false);
        assert.equal(component.activeTab, 'items');
        assert.deepEqual(calls, []);
    }

    const expectedReload = [['url', 'get', 'settings'], ['reload', '?a=112&get=settings']];
    const { component, calls } = shell();
    component.requestModuleTabRefresh('settings');
    assert.deepEqual(calls, expectedReload);

    dirty.closeUnsavedPrompt();
    dirty.requestModuleTabRefresh('settings');
    assert.equal(dirty.showUnsavedPrompt, true);
    assert.equal(dirty.pendingRefresh, true);
    assert.deepEqual(dirtyCalls, []);
    dirty.discardAndSwitch();
    assert.deepEqual(dirtyCalls, expectedReload);

    for (const options of [{ urlBacked: false }, { canSyncUrl: false }]) {
        const { component, calls } = shell(options);
        component.requestModuleTabRefresh('settings');
        await Promise.resolve();
        assert.equal(calls.some(([method]) => method === 'reload'), false);
        assert.deepEqual(calls.slice(-2), [['event', 'evo-ui:module-tab-refresh', 'settings'], ['refresh']]);
    }
    console.log('Module tab links: native gestures, Livewire, guarded document reload, and in-place fallback passed.');
}

run().catch(error => {
    console.error(error);
    process.exitCode = 1;
});
