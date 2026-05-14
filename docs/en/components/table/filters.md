# Table Filters

Table filters are declarative toolbar controls. EvoUI owns the UI, active state,
badges, dropdown chrome and apply/reset behavior. The provider owns the query
semantics.

Runtime markers that must stay documented include `filterGroups`,
`filter-search`, `filter-summary` and `.evo-ui-filter`.

Use this with the [Table Contract](contract.md) and [Table Action Buttons](action-buttons.md).

## Filter Anatomy

Every filter has a stable `state`, a `type`, an icon and a label:

```php
[
    'state' => 'status',
    'type' => 'multi-select',
    'icon' => 'tag',
    'label' => 'module::global.status',
]
```

The `state` value is the persisted key inside table filter state. Do not rename
it casually because URLs and manager-session state may already reference it.

## Option Source

Selectable filters read options from `filterGroups()` unless inline `options`
are provided:

```php
public function filterGroups(): array
{
    return [
        [
            'key' => 'status',
            'items' => [
                ['id' => 1, 'label' => 'Ready'],
                ['id' => 2, 'label' => 'Draft'],
            ],
        ],
    ];
}
```

EvoUI normalizes option display. The provider decides how selected ids map to a
database query.

## Multi-Select

`multi-select` is the default taxonomy/status filter. It renders as a dropdown
with checkboxes, search, selected-count badge, select-all/clear and apply.

```php
[
    'state' => 'tag',
    'type' => 'multi-select',
    'icon' => 'hash',
    'label' => 'module::global.all_tags',
    'search_label' => 'module::global.filter_by_tag',
    'default' => [],
]
```

Use `multi-select` when several values may combine: tags, categories, statuses,
assignees, projects, phases or priorities.

## Single Select

The canonical single-choice dropdown type is `select`. It renders a dropdown
with radio options and an apply button.

```php
[
    'state' => 'owner',
    'type' => 'select',
    'icon' => 'user',
    'label' => 'module::global.owner',
    'searchable' => true,
    'clearable' => true,
    'default' => '',
]
```

Use `select` when exactly one real value should be active at a time. If the
choices are just visual modes such as all/published/unpublished, prefer
`segmented`.

## Segmented

`segmented` renders a compact visible switcher. It is best for small mutually
exclusive state sets and binary visibility modes.

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

Use `segmented` for visible/not-visible, active/archived, table modes or other
states where immediate switching is better than opening a dropdown.

## Toggle

`toggle` is a single icon button that flips between the configured selected
value and default state.

```php
[
    'state' => 'only_missing',
    'type' => 'toggle',
    'icon' => 'eye-off',
    'label' => 'module::global.only_missing',
    'selected' => true,
    'default' => false,
]
```

Use `toggle` for one boolean table flag. If the user must choose among more
than two states, use `segmented` or `select`.

## Date Range

`date-range` renders a dropdown with `from` and `to` date inputs.

```php
[
    'state' => 'created_at',
    'type' => 'date-range',
    'icon' => 'calendar',
    'label' => 'global.date',
    'default' => ['from' => '', 'to' => ''],
]
```

The provider must interpret open-ended ranges correctly.

## Search

Search is not a filter type. It is a dedicated table state in the right toolbar
lane:

```php
'search' => [
    'enabled' => true,
    'state' => 'search',
    'width' => 'sm',
],
```

The provider decides which fields and relations are searched. Do not add a
second search input above the table.

## Sorting

Sorting belongs to columns, not filters:

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

Only sortable columns appear in the list order selector. When reorder is
enabled, reorder actions switch the table back to the configured position sort.

## State Persistence

Filter state is persisted as table state:

- URL filter state wins when present;
- otherwise EvoUI restores manager-session filter state;
- each filter must have a stable `state`;
- reset/clear changes UI state and provider query state together.

## Best Practices

- Use `multi-select` for combinable taxonomies and statuses.
- Use `select` for one real selected entity.
- Use `segmented` for small visible state switches.
- Use `toggle` for one boolean filter.
- Use `date-range` for intervals.
- Keep option labels translated in the consumer module.
- Keep filtering semantics in the provider.

## Anti-Patterns

Do not:

- create a custom filter row or a second toolbar;
- fake `select` with an `all` option when `segmented` expresses the state;
- use `toggle` for multi-state visibility;
- rename filter `state` without a migration/compatibility reason;
- add module-local CSS for filter dropdowns, badges or active state.
