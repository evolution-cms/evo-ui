# Declarative packages

Register trusted UI configuration once from a consumer service provider:

```php
$this->mergeConfigFrom(__DIR__ . '/../config/ui.php', 'example.ui');
$this->app->make(\EvoUI\EvoUI::class)->registerPackage('example', $this->app['config']->get('example.ui'));
```

The entry point checks its own manager access, then returns the shared document:

```php
return view('evo::package', ['preset' => 'example', 'activeTab' => 'settings', 'context' => []]);
```

`activeTab` and `context` are optional. Context must be public, nonsecret data. It
is locked after mount. The package preset is also locked; definitions and provider
results stay server-side rather than becoming public component properties.

```php
return [
    'module' => [
        'title' => 'example::module.title',
        'default_tab' => 'settings',
        'permission' => 'settings',
        'url_parameter' => 'tab',
        'tabs' => [
            ['key' => 'settings', 'label' => 'example::module.settings', 'icon' => 'settings',
                'blocks' => [['type' => 'form', 'preset' => 'example.settings']]],
            ['key' => 'items', 'label' => 'example::module.items', 'icon' => 'package',
                'blocks' => [['type' => 'table', 'preset' => 'example.items']]],
        ],
    ],
];
```

Forms use `evo-ui.forms.*` presets; tables use their existing `preset.table`
contract. A form/table block may specify `component` to select a declared business
adapter. Optional top-level maps `components`, `form_fields`, `table_cells`,
`filters`, and `actions` feed the existing EvoUI registries. No component or data
service is instantiated while these maps are registered.

The shared `evo-ui.package` component owns navigation through `module-tab-shell`,
including the unsaved-form guard and URL state. Only the active tab mounts its
widgets. Hidden tabs and tabs with denied `permission` cannot run data hooks.
Native manager authentication and the optional module `permission` are checked
on initial mount and reactive requests. For additional domain authorization,
declare `module.authorize => [AccessPolicy::class, 'assertAllowed']`. Child
adapters and data actions must still protect their own independent endpoints.

A tab may declare `data_provider => [DashboardData::class, 'data']`. Native
constructor injection resolves this instance hook only when that tab renders.
Its method may accept `array $context` and must return an array of public view
data. This is a read hook, not a place for synchronization writes or implicit
remote loading. Keep authorization policies cheap: they run on each request.

Supported blocks:

- `form` / `table`: require `preset`, optional `component` and public `parameters`.
- `dashboard`: native `cards` configuration.
- `card`: translated `label` and `text`, optional `icon` and tab-navigation
  `actions` containing `tab`, `label`, and `icon`.
- `view`: trusted `view` name; receives `context` and `data` from the active tab.

Use `['bind' => 'path.to.value']` for a value inside an active block to read the
active provider's data. This performs a data lookup, never expression evaluation.
For example, a dashboard stat can declare `['value' => ['bind' => 'connection']]`.
Business providers supply values while labels, layout, and icons stay in config.

Existing manual registration and standalone forms/tables remain supported. The
package builder adds no new CSS or JavaScript runtime. The offline contract is
included in `php tests/run.php` and can also run as `php tests/packages.php`.
Install Composer dependencies first, or set `EVO_UI_TEST_AUTOLOAD` to an existing
host's `vendor/autoload.php`. The test loader always selects this checkout's EvoUI
sources even when dependencies come from another installed EvoUI version.
