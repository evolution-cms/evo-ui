# Table Sorting

Sorting is column-driven. EvoUI owns the header controls, active direction,
list-order selector and persisted state. Providers own safe query mapping.

Use this with the [Table Contract](contract.md), [Table Search](search.md) and
[Table Reorder](reorder.md).

## Preset Contract

```php
'default_sort' => 'updated_at',
'default_direction' => 'desc',
```

`default_sort` must be a sortable column `key`, not a database field. If the
column sorts by another database expression, put that in `sort_field`.

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

## State Flow

EvoUI stores:

- `sort` as the sortable column key;
- `dir` as `asc` or `desc`;
- active state in headers and list order controls;
- table state in URL/session with page reset on changes.

The `wire_target` must include `setSort` when a table exposes sortable columns:

```php
'wire_target' => 'search,perPage,setSort,switchView,goToPage,firstPage,previousPage,nextPage,goLastPage',
```

## Provider Mapping

Provider code must map UI column keys to safe database fields:

```php
$sort = (string) ($this->state['sort'] ?? ($this->config['default_sort'] ?? 'updated_at'));
$direction = ((string) ($this->state['direction'] ?? 'desc')) === 'asc' ? 'asc' : 'desc';

$field = collect($this->config['columns'] ?? [])
    ->firstWhere('key', $sort)['sort_field'] ?? null;

if ($field) {
    $query->orderBy($field, $direction);
}
```

Never trust arbitrary request sort values as raw SQL fields.

## Default Sort Rules

- `default_sort` must match a sortable column key.
- `sort_field` may be a database column or provider-safe expression name.
- `default_direction` should match the natural reading order for that column.
- If a table has no user sorting, omit sortable columns and either omit
  `default_sort` or ensure provider fallback ordering is explicit.

This matters because `ModuleTable::syncConfigState()` clears a `default_sort`
that does not match a sortable column key. The provider may still apply a
fallback, but the UI state will not show an active sort.

## Reorder Interaction

When table reorder is enabled, `reorder.sort` must also be a sortable column key
and normally points to a `position` column. After `moveRow` or `reorderRow`,
EvoUI switches the table back to that position sort.

## Anti-Patterns

Do not:

- set `default_sort` to a database field that is not a column key;
- expose `setSort` in `wire_target` while no column is sortable;
- hide sorting in custom dropdowns outside the shared toolbar;
- use provider ordering that contradicts active EvoUI sort state;
- add local CSS for sort icons, active sort state or list order controls.
