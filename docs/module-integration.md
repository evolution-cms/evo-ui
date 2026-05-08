# Module Integration

This guide shows how a module should consume evo-ui.

## Composer

Require the package from the consuming module:

```json
{
  "require": {
    "evolution-cms/evo-ui": "^1.0"
  }
}
```

The package service provider registers:

- Blade namespace: `evo::...`
- Livewire components: `evo-ui.table`, `evo-ui.form`, `evo-ui.module-table`,
  `evo-ui.issue-workspace`
- Theme/assets helpers required by the manager iframe

## Module Shell

Use `x-evo::layout` as the outer document wrapper for new manager screens.

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tabs
        :items="$tabs"
        :active="$activeTab"
    />

    <livewire:evo-ui.module-table
        preset="vendor.module.items"
        :context="[
            'moduleUrl' => $moduleUrl,
            'type' => $type,
        ]"
    />
</x-evo::layout>
```

The iframe should not include manager `styles.min.css`, Bootstrap, jQuery,
`main.js`, `tabpane.js`, Roboto, or CDN UI libraries. evo-ui assets are local and
theme-aware.

## Assets

The layout includes the package asset partial. If a legacy shell must include
assets manually, use:

```blade
@include('evo::partials.assets')
```

The asset partial loads:

- `assets/modules/evo-ui/evo-ui.css`
- `assets/modules/evo-ui/evo-ui.js`
- Livewire styles/scripts when available
- theme configuration for `evolight`, `evolightness`, `evodark`, `evodarkness`

## Module Table Preset

Create a table config in the consuming module, for example:

```php
// config/items/table.php
return [
    'key' => 'vendor.module.items',
    'provider' => Vendor\Module\Tables\ItemsTableData::class,
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

Merge it from the module service provider:

```php
$this->mergeConfigFrom(__DIR__ . '/../config/items/table.php', 'vendor.module.items.table');
```

Then render it:

```blade
<livewire:evo-ui.module-table
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

## Settings Form Preset

Use `evo-ui.form` for module settings or resource-like forms:

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'title' => 'module::global.settings',
    'source' => [
        'type' => 'config',
        'file' => 'vendor/module/settings.php',
    ],
    'tabs' => [
        ['name' => 'general', 'label' => 'module::global.general', 'icon' => 'settings'],
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

## Provider

The provider receives `context`, Livewire `state`, and the resolved `config`:

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

Optional provider methods can back actions:

- `selectedEditUrl(array $action, ?int $selectedId): string`
- `selectedDeleteHref(array $action, ?int $selectedId): string`
- `selectedDeleteActionAttributes(array $action, ?int $selectedId): array`
- `createUrl(array $action): string`
- `duplicate(int $id): void`
- `togglePublished(int $id): void`

## Implementation Checklist

- Set `wire_target` to every Livewire method that can refresh the table.
- Keep default `per_page` small enough for manager pages; `10` is the safe
  default for rich rows.
- Add `sortable => true` and `sort_field` to every column that should sort.
- Add `default_sort` for the most useful operational order.
- Add list view only when the same data can be scanned better as cards.
- Use `row_states` for visual state such as unpublished rows.
- Clear Evolution/Laravel view cache after changing Blade:

```bash
php artisan view:clear
php artisan cache:clear
```
