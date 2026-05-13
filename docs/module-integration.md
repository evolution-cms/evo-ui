# Module Integration

This guide is the canonical integration contract for consuming `evo-ui` from an
Evolution CMS manager module.

`evo-ui` owns the shared manager UI runtime: iframe shell, local assets,
Evolution theme bridge, Livewire bridge, Blade components, declarative table,
form and workspace rendering, and manager-session UI state. The consuming module
owns routes, permissions, data providers, persistence, domain actions,
translations, migrations and business rules.

## Install

Require the package from the consuming module:

```json
{
  "require": {
    "evolution-cms/evo-ui": "^1.0"
  }
}
```

During package discovery the service provider registers:

- Blade namespace: `evo::...`
- anonymous Blade components: `x-evo::...`
- Livewire components: `evo-ui.table`, `evo-ui.form`,
  `evo-ui.module-table`, `evo-ui.issue-workspace`
- manager-aware Livewire update/script routes
- local asset publishing under `assets/modules/evo-ui`
- shared support services such as manager context, permissions, config forms,
  resource forms, language bridge, rich editor integration and TV values

Publish EvoUI resources from the Evolution root whenever the package is
installed or updated:

```bash
php artisan vendor:publish --tag=evo-ui --force
```

The config file is copied to the project config path. Runtime CSS and JavaScript
are registered as Evolution symlink publishables and point
`assets/modules/evo-ui/evo-ui.css` plus `assets/modules/evo-ui/evo-ui.js` back to
the package files when symlinks are allowed. If the filesystem rejects symlinks,
Evolution falls back to copying the assets. Use `--force` after updates so an old
copied file can be replaced by the current symlink or refreshed fallback copy.

## Service Provider Pattern

The consuming module should register its own views, translations, routes and
config presets. Merge table and form presets under stable keys that match the
rendered `preset` value.

```php
public function boot(): void
{
    $this->loadViewsFrom(__DIR__ . '/../views', 'VendorModule');
    $this->loadTranslationsFrom(__DIR__ . '/../lang', 'VendorModule');

    $this->mergeConfigFrom(
        __DIR__ . '/../config/items/table.php',
        'vendor.module.items.table'
    );

    $this->mergeConfigFrom(
        __DIR__ . '/../config/settings/form.php',
        'evo-ui.forms.vendor.module.settings'
    );
}
```

Use module-owned route/controller names. Do not register `evo-ui` as a manager
module and do not copy `evo-ui` provider internals into the consuming module.

## Manager Shell

Use `x-evo::layout` as the outer document wrapper for new evo-ui-owned manager
screens:

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        @if($activeTab === 'items')
            <livewire:evo-ui.module-table
                preset="vendor.module.items"
                :context="[
                    'moduleUrl' => $moduleUrl,
                    'type' => $type,
                ]"
            />
        @elseif($activeTab === 'settings')
            <livewire:evo-ui.form preset="vendor.module.settings" />
        @endif
    </x-evo::module-tab-shell>
</x-evo::layout>
```

When a module still has a transitional custom shell, it must include the
evo-ui asset partial and expose the evo-ui root marker:

```blade
@include('evo::partials.assets')

<main class="evo-ui {{ $themeClasses }}" data-evo-ui-root>
    ...
</main>
```

Prefer the layout component for new screens. Use the transitional shell only
when a module must keep legacy-compatible outer markup while individual surfaces
are migrated.

## Asset Rules

An evo-ui-owned screen must not load the old manager UI stack:

- no manager `styles.min.css`
- no Bootstrap as a UI dependency
- no jQuery or jQuery UI for shared evo-ui behavior
- no `main.js`
- no `tabpane.js`
- no Roboto or CDN UI assets
- no module-local CSS/JS for primitives already owned by evo-ui

The package asset partial loads:

- `assets/modules/evo-ui/evo-ui.css`
- `assets/modules/evo-ui/evo-ui.js`
- Livewire styles/scripts when available
- theme configuration for `evolight`, `evolightness`, `evodark`,
  `evodarkness`

Module-specific scripts are allowed only for genuinely domain-specific behavior.
If the behavior is a reusable table, form, modal, workspace, editor, picker,
dirty-state or state-persistence primitive, it belongs in `evo-ui`.

Consuming modules must not publish EvoUI assets under their own vendor tags.
Keeping the asset publication in EvoUI preserves one shared runtime for packages
such as `sArticles`, `sLang`, `sSeo`, and `dIssues`.

## Module Tabs

Use module tabs for manager sections, not for table filters:

```php
$tabs = [
    [
        'key' => 'items',
        'label' => 'VendorModule::global.items',
        'icon' => 'table',
        'href' => $moduleUrl . '&get=items',
    ],
    [
        'key' => 'settings',
        'label' => 'global.settings_config',
        'icon' => 'settings',
        'href' => $moduleUrl . '&get=settings',
    ],
];
```

Dirty-state behavior is shared: form surfaces dispatch `evo-ui:form.saved`,
`evo-ui:form.saving` and `evo-ui:form.reset` events. Use
`x-evo::module-tab-shell` for the canonical tab switcher with a shared
unsaved-changes prompt, Save/Discard actions and `EvoUI.form.waitForClean`
navigation bridge.

The consuming module may decide which tab keys exist and what each tab renders,
but it should not duplicate `pendingTab`, `showUnsavedPrompt`, `saveAndSwitch`
or unsaved modal markup. dDocs is the documented exception: its documentation
workspace uses a sidebar/tree viewer UX and should not be forced into upper
module tabs.

## Module Table Preset

Create a table config in the consuming module:

```php
return [
    'key' => 'vendor.module.items',
    'provider' => Vendor\Module\Tables\ItemsTableData::class,
    'wire_target' => 'search,perPage,applyMultiFilter,setSort,switchView',
    'per_page' => 10,
    'per_page_options' => [10, 20, 50, 100],
    'views' => ['table', 'list'],
    'default_view' => 'table',
    'default_sort' => 'published_at',
    'default_direction' => 'desc',
    'search' => ['enabled' => true, 'state' => 'search'],
    'filters' => [],
    'columns' => [],
    'row_actions' => [],
];
```

Render it with the same preset key:

```blade
<livewire:evo-ui.module-table
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

The provider receives `context`, Livewire `state`, and resolved `config`:

```php
final class ItemsTableData
{
    public function __construct(
        protected array $context = [],
        protected array $state = [],
        protected array $config = [],
    ) {}

    public function total(): int {}

    public function rows(int $page, int $perPage): array {}

    public function filterGroups(): array
    {
        return [];
    }
}
```

Providers own data retrieval, query filtering and persistence. `evo-ui` owns the
toolbar, filters, sorting controls, table/list rendering, modal shell, inline
edit UI and session state.

## Settings Form Preset

Use `evo-ui.form` for config, model or resource-like forms:

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'title' => 'VendorModule::global.settings',
    'source' => [
        'type' => 'config',
        'file' => 'vendor/module/settings.php',
    ],
    'tabs' => [
        ['name' => 'general', 'label' => 'global.settings_config', 'icon' => 'settings'],
    ],
    'sections' => [
        [
            'key' => 'general',
            'tab' => 'general',
            'fields' => [
                ['name' => 'enabled', 'type' => 'checkbox', 'label' => 'Enabled'],
            ],
        ],
    ],
];
```

Render it:

```blade
<livewire:evo-ui.form preset="vendor.module.settings" />
```

Form configs describe fields and save behavior; the module owns the config file,
model or resource being saved.

## Issue Workspace Preset

Use `evo-ui.issue-workspace` when a module needs a board/list workspace instead
of a plain table:

```php
return [
    'key' => 'vendor.module.issues',
    'provider' => Vendor\Module\Workspaces\IssuesWorkspaceData::class,
    'default_display' => 'kanban',
    'default_filters' => [
        'category_ids' => [],
        'status_ids' => [],
        'assignee' => 'all',
        'display' => 'kanban',
        'search' => '',
    ],
];
```

```blade
<x-evo::issues.workspace
    preset="vendor.module.issues"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

The provider owns projects, statuses, categories, assignees, issue persistence
and workflow rules. `evo-ui` owns the generic list/kanban UI, filters, selected
issue preview, editor shell, drag/drop contract and state behavior.

## Integration Checklist

- Register module views, translations, routes and config in the consuming
  module provider.
- Use `x-evo::layout` for new evo-ui-owned manager documents.
- Keep legacy manager assets out of evo-ui screens.
- Merge table presets under stable keys and render the same key.
- Merge form presets under `evo-ui.forms.*`.
- Pass only stable context values such as `moduleUrl`, `type`, `site` or
  `module`.
- Keep module-specific data, permissions and actions in providers.
- Use session-persistent table/workspace state unless a task explicitly requires
  another storage contract.
- Clear Evolution/Laravel view cache after changing Blade:

```bash
php artisan view:clear
php artisan cache:clear
```
