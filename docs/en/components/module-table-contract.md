# Module Table Contract

`evo-ui.module-table` is the default table/list surface for Evolution CMS
manager modules. It is config-driven and provider-backed.

For the human-facing component guide, standard anatomy, donor module patterns
and anti-drift checklist, start with [Table](table/README.md).

## Config Shape

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
    'storage_key' => null,
    'row_states' => [],
    'search' => ['enabled' => true, 'state' => 'search'],
    'actions' => [],
    'filters' => [],
    'columns' => [],
    'list' => [],
    'row_actions' => [],
    'inline' => [],
    'reorder' => [],
    'modal' => [],
];
```

## Persistent State

Module tables remember current manager-session state on the server: search,
page, per-page count, filters, sorting, direction, and table/list view. This
keeps tab switching and iframe refreshes stable without adding a client-side
storage protocol to the first release.

The default storage key is generated from the table `preset` and stable context
values such as `type`, `site`, and `module`.

Use `storage_key` only when a module needs to intentionally share or isolate the
state beyond the default preset/context boundary:

```php
'storage_key' => 'vendor.module.items.default',
```

Explicit URL parameters (`q`, `page`, `sort`, `dir`, `perPage`, `f`, `view`)
take priority over session state, so bookmarked or shared manager URLs still
open exactly as requested.

## Row Shape

Every row is an array. Required:

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
    'delete_url' => 'index.php?...',
    'delete_name' => 'Human-readable name',
]
```

Typed values:

```php
'title' => [
    'label' => 'Article title',
    'href' => '/article/',
    'target' => '_blank',
    'strong' => true,
],

'cover' => [
    'src' => EVO_SITE_URL . 'assets/example.svg',
    'alt' => 'Article title',
],

'tags' => ['Design', 'Release'],

'views' => 153,

'gender' => [
    'icon' => 'gender-female',
    'tone' => 'female',
    'label' => 'Woman',
],
```

Do not pass arbitrary arrays into text/date/badge cells. If a value is
structured, use a supported typed cell.

## Columns

```php
[
    'key' => 'title',
    'type' => 'link',
    'label' => 'global.name',
    'class' => 'evo-ui-table__title-column',
    'sortable' => true,
    'sort_field' => 'items.title',
]
```

Supported `type` values:

- `text`
- `link`
- `image`
- `chips`
- `badge`
- `icon`
- `date`
- `position`

Optional column keys:

- `value`: row path if it differs from `key`
- `class`: header class
- `cell_class`: body cell class
- `meta_icon`: icon used in list meta
- `sortable`: enables header/list sorting
- `sort_field`: provider-level field name for sorting
- `default_direction`: `asc` or `desc`
- `editable`: renders a compact inline editor for this column
- `edit_field`: provider field key for inline saving; defaults to `key`
- `edit_type`: inline input type, currently `text` or `number`
- `rules`: validation rules for inline or modal form input

## Inline Editing

For small dictionaries, use inline editing for existing rows. Creation can be
inline for very small maintenance screens, or modal-based when adding an empty
row would feel noisy:

```php
'inline' => [
    'create_provider' => 'createInlineRow',
    'save_provider' => 'updateInlineField',
],

'actions' => [
    [
        'key' => 'create',
        'type' => 'wire',
        'method' => 'createInlineRow',
        'icon' => 'plus',
        'label' => 'module::global.add_item',
        'tone' => 'success',
        'icon_only' => true,
    ],
],

'columns' => [
    [
        'key' => 'name',
        'type' => 'text',
        'label' => 'module::global.name',
        'editable' => true,
        'rules' => ['required', 'string', 'max:255'],
        'sortable' => true,
    ],
],
```

Inline fields save on blur or Enter and revert the local value on Escape. The
provider hooks are:

```php
public function createInlineRow(): int;
public function updateInlineField(int $id, string $field, string $value, array $column = []): string;
```

`updateInlineField()` should return the normalized saved value so the input can
stay in sync after slugging, trimming, or uniqueness checks.

## Reordering

For dictionaries with a `position` column, enable row reordering in config:

```php
'reorder' => [
    'enabled' => true,
    'sort' => 'position',
    'move_provider' => 'moveRow',
    'reorder_provider' => 'reorderRow',
],

'columns' => [
    [
        'key' => 'position',
        'type' => 'position',
        'label' => 'global.position',
        'sortable' => true,
        'sort_field' => 'position',
    ],
],
```

`type => position` renders compact up/down controls around the position badge.
When reorder is enabled, table and list rows are also draggable. The provider
owns persistence:

```php
public function moveRow(int $id, string $direction = 'up'): void;
public function reorderRow(int $id, int $targetId, string $placement = 'before'): void;
```

After a reorder action the table switches back to the configured position sort,
so the user immediately sees the canonical order.

## List View

```php
'list' => [
    'image' => 'cover',
    'icon' => 'file-text',
    'media' => true,
    'title' => 'title',
    'subtitle' => 'section',
    'meta' => ['published_at', 'tags', 'views'],
],
```

`title` and `subtitle` can reference normal columns or plain row keys. `image`
defaults to `cover`; `icon` is used when there is no image. Set
`'media' => false` for dictionary-like lists where an image/icon column would
only waste space.

The list uses the same visual atoms as the table: image, link, chips, badge,
icon badge, position controls, and dimmed state.

## Filters

Multi-select:

```php
[
    'state' => 'tag',
    'type' => 'multi-select',
    'icon' => 'hash',
    'label' => 'Tags',
    'search_label' => 'Filter by tag',
]
```

Date range:

```php
[
    'state' => 'published_at',
    'type' => 'date-range',
    'icon' => 'calendar',
    'label' => 'Published',
    'default' => ['from' => '', 'to' => ''],
]
```

Segmented:

```php
[
    'state' => 'availability',
    'type' => 'segmented',
    'label' => 'Publication',
    'options' => [
        ['value' => 'all', 'icon' => 'list', 'label' => 'All'],
        ['value' => 'published', 'icon' => 'eye', 'label' => 'Published'],
        ['value' => 'unpublished', 'icon' => 'eye-off', 'label' => 'Unpublished'],
    ],
]
```

Provider `filterGroups()` must return selectable options for select-like
filters:

```php
public function filterGroups(): array
{
    return [
        [
            'key' => 'tag',
            'items' => [
                ['id' => 1, 'label' => 'Design'],
            ],
        ],
    ];
}
```

## Toolbar Actions

Link action:

```php
[
    'key' => 'create',
    'icon' => 'plus',
    'label' => 'global.add',
    'href_provider' => 'createUrl',
    'tone' => 'success',
    'icon_only' => true,
]
```

Wire action:

```php
[
    'key' => 'duplicate',
    'type' => 'wire',
    'method' => 'duplicateSelected',
    'icon' => 'copy',
    'label' => 'global.duplicate',
    'tone' => 'info',
    'icon_only' => true,
    'selection' => 'single',
]
```

Selection-aware actions are disabled until one row is selected:

```php
'selection' => 'single'
```

## Row Actions

```php
[
    'key' => 'edit',
    'type' => 'link',
    'href' => 'edit_url',
    'icon' => 'edit',
    'label' => 'global.edit',
    'tone' => 'primary',
    'attributes' => [
        'data-evo-manager-link' => true,
        'data-tab-back' => 'edit_back',
    ],
]
```

Delete action:

```php
[
    'key' => 'delete',
    'type' => 'delete',
    'href' => '#',
    'icon' => 'trash',
    'label' => 'global.remove',
    'tone' => 'danger',
    'attributes' => [
        'data-href' => 'delete_url',
        'data-delete' => 'id',
        'data-name' => 'delete_name',
    ],
]
```

`type => delete` is intercepted by `evo-ui.js` and shown through the shared
evo-ui confirmation modal before opening `data-href`.

State-driven action:

```php
[
    'key' => 'publish',
    'type' => 'wire',
    'method' => 'togglePublished',
    'argument' => 'id',
    'icon_field' => 'published',
    'icon_true' => 'eye',
    'icon_false' => 'eye-off',
    'tone_field' => 'published',
    'tone_true' => 'success',
    'tone_false' => 'danger',
]
```

## Row States

Use row states to make important row state visible outside action buttons:

```php
'row_states' => [
    [
        'field' => 'published',
        'value' => false,
        'class' => 'is-dimmed',
    ],
],
```

`is-dimmed` lowers opacity for the content while keeping row actions readable.

## Provider Responsibilities

The provider owns data access and should apply:

- search
- filters
- sort
- pagination
- mutation methods for row actions

The Livewire component owns:

- URL state
- selected row
- toolbar state
- table/list rendering
- pagination UI

Keep provider methods deterministic and side-effect free except explicit action
methods such as `duplicate()` or `togglePublished()`.

## Modal Forms

Module tables can open create/edit forms in the shared evo-ui modal:

```php
'actions' => [
    [
        'key' => 'create',
        'type' => 'wire',
        'method' => 'openCreateModal',
        'icon' => 'plus',
        'label' => 'global.add',
        'tone' => 'success',
        'icon_only' => true,
    ],
    [
        'key' => 'edit',
        'type' => 'wire',
        'method' => 'openEditModal',
        'icon' => 'edit',
        'label' => 'global.edit',
        'tone' => 'primary',
        'icon_only' => true,
        'selection' => 'single',
    ],
],

'modal' => [
    'enabled' => true,
    'row_dblclick' => true,
    'icon' => 'user',
    'title_create' => 'module::global.add_author',
    'title_edit' => 'module::global.edit_author',
    'fields' => [
        ['name' => 'image', 'type' => 'image', 'label' => 'module::global.image'],
        ['name' => 'name', 'type' => 'text', 'label' => 'module::global.name', 'rules' => ['required']],
        ['name' => 'alias', 'type' => 'alias', 'source' => ['name']],
        ['name' => 'gender', 'type' => 'radio', 'options' => [
            ['value' => 'man', 'label' => 'module::global.gender_man', 'icon' => 'gender-male'],
            ['value' => 'woman', 'label' => 'module::global.gender_woman', 'icon' => 'gender-female'],
        ]],
        ['name' => 'answers', 'type' => 'repeater', 'label' => 'module::global.answers', 'fields' => [
            ['name' => 'answer', 'type' => 'text', 'label' => 'module::global.answer', 'rules' => ['required']],
            ['name' => 'votes', 'type' => 'number', 'label' => 'module::global.votes'],
        ]],
    ],
],
```

Set `row_dblclick` to `false` when the modal is only used for creation and row
editing remains inline.

Supported modal field types:

- `text`
- `email`
- `number`
- `date`
- `select`
- `textarea`
- `alias`
- `radio`
- `image`
- `repeater`

For `alias` fields, provide `source` fields. The table keeps aliases generated
from source fields until the user edits the alias manually.

`repeater` fields edit nested modal arrays. Configure `default_item` plus item
`fields`; each item field can use `text`, `number`, `textarea`, `static`, or
`badge`. The table exposes `addModalItem()`, `removeModalItem()`, and
`moveModalItem()` for the modal UI and validates nested rules as
`modalData.<name>.*.<item>`.

Provider hooks:

```php
public function modalDefaults(): array;
public function modalData(int $id): array;
public function modalAlias(string $source, ?int $id = null): string;
public function saveModal(array $data, ?int $id = null, string $mode = 'create'): int;
```

`saveModal()` must return the saved row id so the table can keep the row
selected after saving.

## Action Contract

Toolbar and row actions are declarative. A table action should describe the UI
command and point to a provider or Livewire method that owns the behavior.

Common toolbar action keys:

```php
'actions' => [
    [
        'key' => 'create',
        'type' => 'wire',
        'method' => 'openCreateModal',
        'icon' => 'plus',
        'label' => 'global.add',
        'tone' => 'success',
        'icon_only' => true,
    ],
],
```

Common row action keys:

```php
'row_actions' => [
    [
        'key' => 'publish',
        'type' => 'wire',
        'method' => 'togglePublished',
        'icon' => 'eye',
        'label' => 'global.publish',
    ],
    [
        'key' => 'duplicate',
        'type' => 'wire',
        'method' => 'duplicate',
        'icon' => 'copy',
        'label' => 'global.duplicate',
    ],
    [
        'key' => 'delete',
        'type' => 'wire',
        'method' => 'deleteRow',
        'icon' => 'trash',
        'tone' => 'danger',
        'confirm' => true,
    ],
],
```

Action rules:

- `type => wire` calls a Livewire method or a provider-backed table method.
- `type => link` opens a URL resolved directly or through a provider.
- `selection => single` requires a selected row.
- `confirm => true` must use the shared delete/confirm UI, not a module-local
  browser prompt.
- destructive providers must enforce their own delete guards.

Provider hooks commonly used by actions:

```php
public function createUrl(array $action): string;
public function selectedEditUrl(array $action, ?int $selectedId): string;
public function selectedDeleteHref(array $action, ?int $selectedId): string;
public function selectedDeleteActionAttributes(array $action, ?int $selectedId): array;
public function duplicate(int $id): void;
public function togglePublished(int $id): void;
public function deleteRow(int $id): void;
```

## Header Actions

Column header actions are for compact operations tied to one column, such as
auto-translate on an sLang language column. Define them on the column:

```php
[
    'key' => 'uk',
    'type' => 'text',
    'label' => 'Українська',
    'editable' => true,
    'header_actions' => [
        [
            'key' => 'auto_translate',
            'icon' => 'wand-sparkles',
            'label' => 'Auto translate',
            'provider' => 'autoTranslateInlineField',
        ],
    ],
],
```

The table validates the action against the configured column and then delegates
to the provider method. Header actions must be compact and column-scoped; larger
operations belong in the toolbar.

## Delete Guards

The modal or provider may prevent deletion when a row is in use. The provider
must be the source of truth because only the module knows its domain relations.

Recommended provider shape:

```php
public function deleteGuard(int $id): array
{
    return [
        'blocked' => true,
        'message' => 'This status is used by existing issues.',
        'count' => 12,
    ];
}
```

The generic UI should render the guard state, but the consumer provider decides
whether deletion is allowed.

## Extended Modal Field Types

Real consumers use more than the minimal modal field set. Supported table modal
fields include:

- `text`
- `email`
- `number`
- `date`
- `datetime-local`
- `select`
- `textarea`
- `checkbox`
- `alias`
- `radio`
- `choices`
- `image`
- `file`
- `editor`
- `repeater`
- `builder`
- `color-picker`

Field behavior is documented in the form/field catalogue. Table modal configs
may use the same validation metadata, option providers and media/editor markers
as forms, but table providers own modal defaults, row data and persistence.

## Consumer Examples

Use these consumers as references:

- `sArticles` for article tables, relation choices, media/editor fields,
  publish/duplicate/delete actions and content builder fields.
- `dIssues` for settings taxonomy tables, color picker fields, delete guards
  and issue table filters.
- `sLang` for inline dictionary editing and language-column header actions.
- `sSeo` for redirects table CRUD and compact settings-linked module tabs.

## Contract Checklist

Before adding a new table preset, confirm:

- the preset key and config merge key match;
- the provider returns deterministic `total()`, `rows()` and `filterGroups()`;
- every sortable column has a provider-safe `sort_field`;
- every filter has a stable `state`;
- table/list views use the same row data;
- modal fields have validation rules where user input is saved;
- destructive actions are guarded by the provider;
- reorder providers validate row ids and placement;
- generic UI behavior stays in `evo-ui`;
- module-specific persistence stays in the consumer module.
