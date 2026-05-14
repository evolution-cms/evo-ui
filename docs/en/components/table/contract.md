# Table Contract

This page freezes the declarative contract for EvoUI tables. Consumer modules
describe what they need; EvoUI owns how the manager table looks, behaves and
persists UI state.

Use this with the main [Table overview](README.md), [Table Action Buttons](action-buttons.md),
[Table Filters](filters.md) and [Table Pagination](pagination.md).

## Ownership

`evo-ui` owns:

- toolbar layout, responsive wrapping and spacing;
- table/list rendering and typed cell chrome;
- filters, search, sorting controls and active markers;
- row selection, double-click behavior and row action placement;
- modal shell, delete confirmation shell and inline edit markers;
- reorder handles, position controls and drag/drop visuals;
- pagination footer and manager-session state persistence.

The consumer provider owns:

- query construction and business filtering;
- permission checks and delete guards;
- row data shaping for the configured columns;
- modal defaults/data/save/delete behavior;
- inline create/save and reorder persistence;
- domain labels, option lists and validation rules.

Do not move consumer business rules into EvoUI. Do not move EvoUI visual rules
into consumer CSS or Blade partials.

## Rendering Entry Points

Preferred Blade entrypoint:

```blade
<x-evo::table.livewire
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

Direct Livewire entrypoint:

```blade
<livewire:evo-ui.module-table
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

The preset resolves to `config($preset . '.table')`.

## Minimal Preset

```php
return [
    'key' => 'vendor.module.items',
    'provider' => Vendor\Module\Tables\ItemsTableData::class,
    'wire_target' => 'search,perPage,setFilter,applySelectFilter,applyMultiFilter,toggleFilter,setSort,switchView,openCreateModal,openEditModal,saveModal,closeModal,openDeleteModal,closeDeleteModal,deleteConfirmed,goToPage,firstPage,previousPage,nextPage,goLastPage',
    'per_page' => 10,
    'per_page_options' => [10, 20, 50, 100],
    'views' => ['table', 'list'],
    'default_view' => 'table',
    'default_sort' => 'updated_at',
    'default_direction' => 'desc',
    'search' => ['enabled' => true, 'state' => 'search'],
    'actions' => [],
    'filters' => [],
    'columns' => [],
    'list' => [],
    'modal' => [],
    'row_actions' => [],
];
```

Required keys:

| Key | Type | Purpose |
| --- | --- | --- |
| `key` | string | Stable table identity used in DOM markers and persisted state. |
| `provider` | class-string | Module-owned data and mutation provider. |
| `columns` | array | Declarative column list. |

Common keys:

| Key | Type | Purpose |
| --- | --- | --- |
| `wire_target` | string | Loading target list for Livewire operations. Keep it complete. |
| `title` | translation key | Optional toolbar title. |
| `title_icon` | icon name | Optional toolbar title icon. |
| `title_placement` | string | Use `table_header` when the title must attach to the table frame. |
| `per_page` | int | Default row count. |
| `per_page_options` | int[] | Options shown in the footer selector. |
| `views` | array | `['table']` or `['table', 'list']`. |
| `default_view` | string | `table` or `list`. |
| `default_sort` | string | Column key used for initial sort. |
| `default_direction` | string | `asc` or `desc`. |
| `storage_key` | string|null | Optional explicit manager-session storage key. |
| `row_states` | array | Visual state classes driven by row values. |
| `search` | array | Search state config. |
| `actions` | array | Toolbar and control-lane actions. |
| `filters` | array | Filter definitions. |
| `list` | array | List view mapping. |
| `inline` | array | Inline create/save provider names. |
| `reorder` | array | Drag/up/down reorder provider names. |
| `modal` | array | Shared modal form config. |
| `row_actions` | array | Last-column row actions. |

## Table/List View State

`viewMode` is EvoUI-owned state. The `views` preset key enables the switcher,
`default_view` chooses the initial mode and `switchView` must be present in
`wire_target` whenever list mode is enabled.

The renderer must keep these markers intact:

- `data-evo-table-view` on the table surface;
- view-keyed toolbar root;
- view-keyed content root;
- separate table and list row keys.

These markers are not decorative. They prevent Livewire from morphing a list
card tree into a table tree, which can otherwise leave the active switcher,
search, filters or row actions in a half-updated state without any console
error.

## Provider Contract

Recommended constructor shape:

```php
public function __construct(
    protected array $context = [],
    protected array $state = [],
    protected array $config = [],
) {}
```

Core methods:

```php
public function rows(): array;
public function total(): int;
public function filterGroups(): array;
```

Optional methods:

```php
public function columns(array $columns): array;
public function filters(array $filters): array;
public function rowActions(array $actions): array;
public function modalDefaults(): array;
public function modalData(int $id): array;
public function modalAlias(string $source, ?int $id = null): string;
public function saveModal(array $data, ?int $id = null, string $mode = 'create'): int;
public function deleteName(int $id): string;
public function deleteRow(int $id): bool|string|null;
public function createInlineRow(): int;
public function updateInlineField(int $id, string $field, string $value, array $column = []): string;
public function moveRow(int $id, string $direction): void;
public function reorderRow(int $id, int $targetId, string $placement = 'before'): void;
```

Provider responsibilities:

- apply search, filters, sorting and pagination to the query;
- return rows already shaped for typed EvoUI cells;
- validate and persist modal/inline/action mutations;
- enforce delete guards;
- keep domain semantics in the consumer module.

## Row Shape

Each row is an array. Required:

```php
[
    'id' => 123,
    'wire_key' => 'item-row-123',
]
```

Recommended:

```php
[
    'edit_url' => 'index.php?...',
    'delete_name' => 'Human-readable name',
]
```

Typed cell values:

```php
'title' => [
    'label' => 'How to prepare publication #1',
    'href' => 'index.php?a=112&id=123',
    'strong' => true,
],

'cover' => [
    'src' => MODX_BASE_URL . 'assets/example.svg',
    'alt' => 'Cover',
],

'tags' => ['EVO', 'Longread'],

'status' => [
    'label' => 'Ready',
    'tone' => 'success',
],
```

Do not pass arbitrary arrays to plain `text` cells. If the value is structured,
use a typed column.

## Columns

```php
[
    'key' => 'title',
    'type' => 'link',
    'label' => 'global.name',
    'class' => 'evo-ui-table__title-column',
    'sortable' => true,
    'sort_field' => 'items.title',
    'default_direction' => 'asc',
]
```

Supported column types:

| Type | Use for |
| --- | --- |
| `text` | Plain labels, ids, counters, summaries. |
| `link` | Manager or frontend links. |
| `image` | Cover/avatar thumbnails and editable image cells. |
| `chips` | Tags, categories, feature lists. |
| `badge` | Status, type, priority, counters. |
| `icon` | Boolean or symbolic status. |
| `date` | Date/time labels. |
| `position` | Reorderable position badge with up/down controls. |

Column options:

| Option | Purpose |
| --- | --- |
| `value` | Row path when it differs from `key`. |
| `label` | Translation key or literal label. |
| `class` | Header/table column class. Prefer existing EvoUI classes. |
| `cell_class` | Body cell class. |
| `sortable` | Enables header sorting. |
| `sort_field` | Provider/database sort field. |
| `default_direction` | Direction when sorting by this column for the first time. |
| `editable` | Enables inline editing. |
| `edit_field` | Provider field for inline saving. Defaults to `key`. |
| `edit_type` | Inline input type, usually `text` or `number`. |
| `rules` | Validation rules for inline/modal input. |
| `header_actions` | Compact actions tied to this column. |
| `inline_actions` | Compact actions tied to an editable cell. |
| `meta_icon` | Icon used when the column appears in list meta. |

## Table View

The table view renders:

- configured columns;
- sortable header cells;
- typed body cells;
- selected row state;
- row state classes such as `is-dimmed`;
- optional double-click modal/link behavior;
- optional final row action column.

The final action column is not optional when row actions exist. Do not place row
actions in the middle of the table.

## List View

Use list view when rows need easier scanning on narrow screens or dense manager
surfaces:

```php
'list' => [
    'media' => false,
    'icon' => 'list-checks',
    'title' => 'title',
    'subtitle' => 'section',
    'meta' => ['status', 'updated_at', 'views'],
]
```

Rules:

- list view uses the same row data and row actions as table view;
- title/subtitle/meta reference existing columns or row keys;
- set `media => false` for dictionaries and operational tables where images are
  noise;
- never make table and list view show different business state.

## State Persistence

The table state includes:

- search (`q`);
- page (`page`);
- sort (`sort`);
- direction (`dir`);
- per-page (`perPage`);
- filters (`f`);
- view mode (`view`).

URL state wins over session state. If no URL state is present, EvoUI restores
the last manager-session state for the preset/context storage key.

## Review Checklist

- preset has `key`, `provider`, `columns`, search and pagination config;
- provider applies search, filters, sorting and pagination;
- table and list view use the same row data;
- no consumer-local table CSS or JS was added;
- tests cover config shape and provider hooks for the consumer.
