# Table Action Buttons

Table buttons use the shared [Action Buttons](../action-buttons.md) taxonomy,
but tables have stricter placement rules. The goal is that `sArticles`, `sSeo`,
`sLang`, `dIssues`, `dGramm`, `sTask` and future modules all read as one UI.

## Placement Map

| Placement | Config key | Visual shape | Use for |
| --- | --- | --- | --- |
| Toolbar Actions | `actions` | Icon square, optional label when space demands it | Create, edit selected, duplicate selected, delete selected. |
| Control Lane Actions | `actions` with `placement => controls` | Compact icon button near filters/search | Refresh, sync, import/export, secondary view controls. |
| Header Actions | column `header_actions` | Small icon beside a column header | Column-specific metadata actions such as edit language. |
| Inline Actions | column `inline_actions` | Small icon beside an editable cell | Translate, reset, copy field value. |
| Row Actions | `row_actions` | Final column icon buttons | Edit, delete, duplicate, publish, archive, open detail. |

Do not create module-local button classes for table actions. If the standard
button does not fit, extend EvoUI first.

## Toolbar Actions

Toolbar actions live on the left side of the table toolbar after the optional
title.

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
]
```

Canonical tones:

| Action | Icon | Tone |
| --- | --- | --- |
| Create | `plus` | `success` |
| Edit | `edit` | `primary` |
| Duplicate | `copy` | `info` |
| Delete | `trash` | `danger` |

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

## Control Lane Actions

Control actions live on the right side near filters, view switcher, list order
and search.

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

Use this lane for secondary table-wide operations. Do not put create/delete
there just to make the left toolbar look smaller.

## Header Actions

Header actions belong to one column. They are useful for `sLang` dynamic
language columns and similar metadata.

```php
[
    'key' => 'title_uk',
    'type' => 'text',
    'label' => 'Українська',
    'header_actions' => [
        [
            'key' => 'edit-language',
            'type' => 'wire',
            'provider' => 'openLanguageModal',
            'argument' => 'uk',
            'icon' => 'edit',
            'label' => 'slang::global.edit_language',
            'tone' => 'primary',
        ],
    ],
]
```

Rules:

- header actions must stay compact and icon-only;
- use accessible `label` even when the icon is the only visible content;
- avoid domain workflows that belong in the main toolbar.

## Inline Actions

Inline actions attach to an editable cell and should not replace row actions.

```php
[
    'key' => 'title',
    'type' => 'text',
    'editable' => true,
    'inline_actions' => [
        [
            'key' => 'copy',
            'type' => 'wire',
            'provider' => 'copyValue',
            'argument' => 'id',
            'icon' => 'copy',
            'label' => 'global.copy',
            'tone' => 'info',
        ],
    ],
]
```

Use inline actions for operations that directly modify or inspect that cell.

## Row Actions

Row actions always render in the final table column and in the list-card action
cluster.

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

- destructive actions use the shared delete confirmation;
- row actions are icon buttons with accessible labels;
- row actions must not appear before domain data columns;
- business guards stay in the provider.

## Anti-Patterns

Do not:

- place table actions in custom wrappers above or below the table;
- mix text buttons and icon buttons inside one row action cluster;
- add module-local CSS for icon size, color, padding or disabled state;
- use a row action for table-wide operations;
- use a toolbar action for one-row operations unless selection is explicit.
