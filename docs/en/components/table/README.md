# Table Component

`Table` is the canonical EvoUI component for manager lists and CRUD surfaces.
Consumers describe data, columns, filters, actions and persistence through a
configuration preset plus a provider class. EvoUI owns the shell, toolbar,
table/list rendering, filters, sorting, pagination, row action chrome, modals,
double-click behavior, drag/reorder visuals and state persistence.

Use this guide when building or reviewing tables in `sArticles`, `sSeo`,
`sLang`, `dIssues`, `dGramm`, `sTask` or any new Evolution CMS manager module.

## Documentation Map

Table is a component family, not one Blade snippet. Read the pages in this
order when implementing a new manager table:

- [Table Contract](contract.md): preset shape, provider hooks, columns, row
  data, state ownership and table/list parity.
- [Table Action Buttons](action-buttons.md): toolbar actions, control-lane
  actions, header actions, inline actions and row actions.
- [Table Filters](filters.md): `multi-select`, `select`, `segmented`,
  `toggle`, `date-range` and provider option groups.
- [Table Search](search.md): search state, toolbar placement, provider query
  mapping and anti-duplication rules.
- [Table Sorting](sorting.md): `default_sort`, sortable columns, `sort_field`,
  list order selector and provider-safe ordering.
- [Table Reorder](reorder.md): position columns, `moveRow`, `reorderRow`,
  shared table rail, drag/drop and DnD boundary.
- [Table Pagination](pagination.md): shared footer, per-page selector, page
  buttons, accessibility and state persistence.
- [General Action Buttons](../action-buttons.md): button taxonomy shared by
  forms, modals, tables and DnD builders.

## Component Anatomy

Every standard table has the same structure:

1. Toolbar: title and primary actions on the left; filters, view switcher,
   optional list sorting, secondary control actions and search on the right.
2. Data surface: table view by default, with optional list view parity.
3. Row action column: the last table column contains edit/delete/duplicate or
   domain actions. In list view the same actions appear in the list card action
   cluster.
4. Double-click behavior: rows open the shared edit modal when modal editing is
   enabled, otherwise they may open the configured manager link.
5. Pagination footer: total rows, per-page selector and first/previous/page/
   next/last controls.
6. Shared modals: form modal and delete confirmation modal are owned by EvoUI.

Do not build a custom toolbar, custom pagination, custom table footer or custom
row action column in a consumer module. Add the missing primitive to EvoUI
first.

## View Switching Contract

When a table exposes both table and list modes, EvoUI owns the complete
`switchView()` lifecycle. Consumers only declare:

```php
'views' => ['table', 'list'],
'default_view' => 'table',
'wire_target' => 'search,perPage,setSort,switchView,goToPage,firstPage,previousPage,nextPage,goLastPage',
```

The shared renderer keys the toolbar and content by the active view mode and
marks the surface with `data-evo-table-view`. This is required: Livewire must
replace the list DOM with the table DOM as one unit, otherwise controls such as
search, filters, actions or row markup can drift after a `list -> table` switch.

Do not add local JavaScript to switch between list and table. Do not hide or
duplicate search in a consumer view. If a consumer needs different table/list
behavior, extend the EvoUI table contract first.

## When To Use

Use `Table` for:

- content lists such as `sArticles` publications;
- settings taxonomies such as `dIssues` categories, statuses and phases;
- dictionary-like inline editing such as `sLang` translations;
- redirects and activity logs such as `sSeo`;
- operational lists such as `dGramm` bots/logs and `sTask` tasks/workers/logs.

Do not use `Table` for:

- full issue kanban/list workspaces; use `evo-ui.issue-workspace`;
- complex nested settings builders; use DnD/form primitives;
- public site content output;
- one-off layout cards that are not row-based data.

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

The preset resolves to `config($preset . '.table')`. For example
`preset="sarticles.articles"` reads `config('sarticles.articles.table')`.

## Minimal Preset

```php
return [
    'key' => 'vendor.module.items',
    'provider' => Vendor\Module\Tables\ItemsTableData::class,
    'wire_target' => 'search,perPage,setSort,switchView,openCreateModal,openEditModal,saveModal,closeModal,openDeleteModal,closeDeleteModal,deleteConfirmed,goToPage,firstPage,previousPage,nextPage,goLastPage',
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
| `key` | string | Stable table identity used in DOM markers. |
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
| `actions` | array | Toolbar actions. |
| `filters` | array | Filter definitions. |
| `list` | array | List view mapping. |
| `inline` | array | Inline create/save provider names. |
| `reorder` | array | Drag/up/down reorder provider names. |
| `modal` | array | Shared modal form config. |
| `row_actions` | array | Last-column row actions. |

## Provider Contract

Providers own domain logic. EvoUI must not know table business rules.

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

EvoUI responsibilities:

- toolbar layout and responsive behavior;
- filter widgets and active filter badges;
- table/list parity;
- sorting controls;
- selected row state;
- modal and delete confirmation chrome;
- pagination UI;
- manager-session state persistence.

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

'polling' => [
    'icon' => 'circle-check',
    'tone' => 'success',
    'label' => 'Active',
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
| `markdown` | Safe inline emphasis, code and links without embedded HTML. |
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

## Toolbar

Toolbar layout is standard:

- left: optional `title`, `title_icon`, then toolbar actions;
- right: filters, view switcher, list order selector, control-placement
  actions and search.

Toolbar action:

```php
[
    'key' => 'create',
    'type' => 'wire',
    'method' => 'openCreateModal',
    'icon' => 'plus',
    'label' => 'global.add',
    'tone' => 'success',
    'icon_only' => true,
]
```

Control-lane action:

```php
[
    'key' => 'synchronize',
    'type' => 'wire',
    'provider' => 'synchronizeTranslations',
    'icon' => 'refresh',
    'label' => 'module::global.synchronize',
    'tone' => 'success',
    'variant' => 'filled',
    'placement' => 'controls',
]
```

Selection-aware action:

```php
[
    'key' => 'edit',
    'type' => 'wire',
    'method' => 'openEditModal',
    'icon' => 'edit',
    'label' => 'global.edit',
    'tone' => 'primary',
    'icon_only' => true,
    'selection' => 'single',
]
```

Rules:

- create: `plus`, success tone;
- edit: `edit`, primary tone;
- duplicate: `copy`, info tone;
- delete: `trash`, danger tone;
- toolbar actions may be links or Livewire actions;
- large domain actions go in the toolbar, not inside column headers;
- do not manually place search or filters outside the shared toolbar.

## Filters

Filters are declarative. The provider maps filter state to queries.

Multi-select:

```php
[
    'state' => 'tag',
    'type' => 'multi-select',
    'icon' => 'hash',
    'label' => 'module::global.all_tags',
    'search_label' => 'module::global.filter_by_tag',
]
```

Segmented:

```php
[
    'state' => 'availability',
    'type' => 'segmented',
    'icon' => 'list',
    'label' => 'module::global.availability',
    'default' => 'all',
    'options' => [
        ['value' => 'all', 'icon' => 'list', 'label' => 'global.all'],
        ['value' => 'published', 'icon' => 'eye', 'label' => 'global.published'],
        ['value' => 'unpublished', 'icon' => 'eye-off', 'label' => 'global.unpublished'],
    ],
]
```

Date range:

```php
[
    'state' => 'created_at',
    'type' => 'date-range',
    'icon' => 'calendar',
    'label' => 'global.date',
    'default' => ['from' => '', 'to' => ''],
]
```

Provider options:

```php
public function filterGroups(): array
{
    return [
        [
            'key' => 'tag',
            'items' => [
                ['id' => 1, 'label' => 'Release'],
            ],
        ],
    ];
}
```

Best practice:

- use `multi-select` for real taxonomies and statuses that can combine;
- use `segmented` for small mutually exclusive states;
- use `date-range` for date intervals;
- avoid fake `select` filters with static `all` defaults when a multi-select or
  segmented control expresses the behavior better.

## Search

```php
'search' => [
    'enabled' => true,
    'state' => 'search',
    'width' => 'sm',
],
```

Search lives in the right toolbar lane. The provider decides which columns or
relations it searches. Do not add a second custom search input above the table.

## Sorting

Header sorting is enabled per column:

```php
[
    'key' => 'updated_at',
    'type' => 'date',
    'label' => 'global.updated',
    'sortable' => true,
    'sort_field' => 'items.updated_at',
    'default_direction' => 'desc',
]
```

Rules:

- `key` is the UI state value.
- `sort_field` is the provider/database field.
- only sortable columns appear in the list order menu.
- when reorder is enabled, reorder actions switch the table back to the
  configured position sort.

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

## Row Actions

```php
'row_actions' => [
    [
        'key' => 'edit',
        'type' => 'wire',
        'method' => 'openEditModal',
        'argument' => 'id',
        'icon' => 'edit',
        'label' => 'global.edit',
        'tone' => 'primary',
    ],
    [
        'key' => 'delete',
        'type' => 'wire',
        'method' => 'openDeleteModal',
        'argument' => 'id',
        'icon' => 'trash',
        'label' => 'global.remove',
        'tone' => 'danger',
    ],
]
```

Provider-backed row action:

```php
[
    'key' => 'publish',
    'type' => 'wire',
    'provider' => 'togglePublished',
    'argument' => 'id',
    'icon_field' => 'published',
    'icon_true' => 'eye',
    'icon_false' => 'eye-off',
    'tone_field' => 'published',
    'tone_true' => 'success',
    'tone_false' => 'danger',
]
```

Rules:

- row actions are icon buttons with accessible labels;
- all common tones and sizes come from EvoUI;
- destructive actions use shared delete confirmation;
- business guards stay in the provider.

## Modal CRUD

Enable shared create/edit modal:

```php
'modal' => [
    'enabled' => true,
    'row_dblclick' => true,
    'icon' => 'file-text',
    'size' => 'lg',
    'title_create' => 'module::global.create_item',
    'title_edit' => 'module::global.edit_item',
    'submit_label' => 'evo::global.action_save',
    'cancel_label' => 'evo::global.action_cancel',
    'fields' => [
        ['name' => 'title', 'type' => 'text', 'label' => 'global.name', 'span' => 'full', 'rules' => ['required']],
        ['name' => 'alias', 'type' => 'alias', 'label' => 'global.alias', 'source' => ['title']],
        ['name' => 'status', 'type' => 'select', 'label' => 'global.status', 'options_provider' => 'modalOptionsForField'],
    ],
]
```

Provider hooks:

```php
public function modalDefaults(): array;
public function modalData(int $id): array;
public function modalOptionsForField(string $field): array;
public function modalAlias(string $source, ?int $id = null): string;
public function saveModal(array $data, ?int $id = null, string $mode = 'create'): int;
```

Double-click opens the modal when `modal.enabled` is true and
`modal.row_dblclick` is not false. If the table uses external edit pages, provide
`edit_url` in the row and keep the modal disabled or set `row_dblclick` to
false.

## Inline Editing

Use inline editing for small dictionaries and translation-like tables:

```php
'inline' => [
    'create_provider' => 'createInlineRow',
    'save_provider' => 'updateInlineField',
],

'columns' => [
    [
        'key' => 'title',
        'type' => 'text',
        'label' => 'global.name',
        'editable' => true,
        'rules' => ['required', 'string', 'max:255'],
    ],
],
```

Provider hooks:

```php
public function createInlineRow(): int;
public function updateInlineField(int $id, string $field, string $value, array $column = []): string;
```

Use the [inline create primitive](../README.md#inline-create) when the newly
created row should scroll into view and focus the first field.

## Reorder

Use shared reorder for position-based tables:

```php
'reorder' => [
    'enabled' => true,
    'sort' => 'position',
    'move_provider' => 'moveRow',
    'reorder_provider' => 'reorderRow',
],

'columns' => [
    ['key' => 'position', 'type' => 'position', 'label' => 'global.position', 'sortable' => true, 'sort_field' => 'position'],
],
```

Provider hooks:

```php
public function moveRow(int $id, string $direction): void;
public function reorderRow(int $id, int $targetId, string $placement = 'before'): void;
```

The table owns drag handles, up/down controls and visual affordances. The
provider owns persistence.

## Pagination

Pagination is always the shared footer:

- left: total row count and per-page selector;
- right: first, previous, compact page buttons, next and last;
- current page uses `aria-current="page"`;
- page, per-page, filters, search, sort and view are persisted in the manager
  session unless the URL explicitly provides table state.

Do not add a module-local pagination partial inside EvoUI-owned manager tables.

## State Persistence

The table state includes:

- search (`q`);
- page (`page`);
- sort (`sort`);
- direction (`dir`);
- per-page (`perPage`);
- filters (`f`);
- view mode (`view`).

URL state wins over session state. If no URL state is present, EvoUI restores the
last manager-session state for the preset/context storage key.

## Canonical Consumer Patterns

Use these as donor references:

| Module | Table pattern |
| --- | --- |
| `sArticles` | Full content table: filters, table/list parity, modal CRUD, publish/duplicate/delete actions. |
| `sSeo` | Redirects table: compact CRUD modal, search, sortable URL columns, delete guard. |
| `sLang` | Dictionary table: inline create/edit, dynamic language columns, header/inline actions. |
| `dIssues` | Settings taxonomies: modal CRUD plus position reorder. |
| `dGramm` | Operational entities: filters, table/list views, modal edit, external onboarding action. |
| `sTask` | Operational task tables: status/priority filters, progress/status cells, detail links. |
| `sSettings` | Not a table donor today; use form/DnD primitives unless a real row-based CRUD table is added. |

## Anti-Patterns

Do not:

- build custom table CSS in a consumer module;
- load Bootstrap, jQuery, CDN UI assets or legacy manager table styles;
- create a custom toolbar, filter row, search input or pagination partial;
- place action buttons outside the standard toolbar or final row action column;
- render different business state in table and list views;
- use inline Blade conditionals inside complex opening tags;
- hide missing EvoUI primitives behind module-local scripts;
- duplicate modal shell, delete confirmation or double-click behavior.

If the canonical table cannot express a case, create an EvoUI backlog task and
extend the primitive before copying UI into a module.

## Review Checklist

Before closing a table task:

- preset has `key`, `provider`, `columns`, search and pagination config;
- provider applies search, filters, sorting and pagination;
- toolbar uses `actions`, `filters`, `views`, `search`;
- table and list view use the same row data;
- row actions are in `row_actions`;
- create/edit/delete use shared modal or shared action patterns;
- double-click behavior is intentional;
- pagination is the shared EvoUI footer;
- no consumer-local table CSS or JS was added;
- tests cover config shape and provider hooks for the consumer.
