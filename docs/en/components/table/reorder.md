# Table Reorder

Table reorder is the table-specific DnD contract for position-based rows.
General nested builders use the [DnD contract](../dnd/reorder-contract.md);
tables use `ModuleTable` reorder providers and the shared table rail.

Use this with the [Table Contract](contract.md), [Table Sorting](sorting.md) and
[Table Action Buttons](action-buttons.md).

## When To Use

Use table reorder when rows have a real persisted order:

- taxonomy order;
- menu/category order;
- issue status/category/phase/project order;
- TV parameter rank/order.

Do not use table reorder for log/activity/history rows. Those should sort by
time or another domain field.

## Preset Contract

```php
'default_sort' => 'position',
'default_direction' => 'asc',
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

The `wire_target` must include both reorder methods:

```php
'wire_target' => 'search,perPage,setSort,switchView,moveRow,reorderRow,sortTableRowByUid,goToPage,firstPage,previousPage,nextPage,goLastPage',
```

## Provider Contract

```php
public function moveRow(int $id, string $direction): void;
public function reorderRow(int $id, int $targetId, string $placement = 'before'): void;
```

`ModuleTable` owns the DnD bridge method:

```php
public function sortTableRowByUid(string $uid, int $position, string $targetGroupUid = ''): void;
```

The browser sends a dragged row uid and target position. `ModuleTable` resolves
the currently visible row ids, maps that position to `targetId + placement`,
then calls the provider-backed `reorderRow()`. Consumers do not implement this
bridge in module views.

Provider rules:

- validate that both row ids exist in the same table scope;
- keep ordering stable and deterministic;
- normalize gaps/duplicates if the storage model needs it;
- enforce permissions and business guards;
- do not render reorder UI from the provider.

## Visual Contract

EvoUI renders:

- `x-evo::reorder-rail` for up/handle/down controls;
- `.evo-ui-reorder-rail--table` for table/list row rails;
- drag handles and drop affordances;
- `data-evo-dnd`, `data-evo-dnd-list`, `data-evo-dnd-item` and stable row uid
  markers for table and list view parity;
- row selection after reorder;
- return to the configured position sort.

The persisted position value is provider state, not visible UI. The table
should show only the compact rail in the `position` column or list meta area.
Do not render `0`, `1`, `2` chips or inputs beside the rail unless the product
has a separate editable rank field that is not the table reorder contract.
During table drag, EvoUI uses a transparent technical native drag image to
suppress the browser ghost, renders one EvoUI-owned floating row preview under
the pointer, and keeps the physical table placeholder as the drop marker. The
dragged source row leaves table layout while dragging, so there must not be an
additional empty row beside the placeholder. The browser must not draw a second
row preview or show hidden inputs, screen-reader labels, tab text or persisted
position values as extra fields.

Consumers must not copy the `sSettings` builder layout into tables. For table
rows, use the table `position` cell and `reorder` config. For nested forms and
option lists, use the DnD builder primitives.

## Table/List Parity

When `views` includes both `table` and `list`, reorder affordances must work in
both views. The same row data and provider methods are used.

## Good Consumers

- `sArticles` categories, features and TV parameters use position columns plus
  `moveRow`/`reorderRow`.
- `dIssues` settings categories, statuses, phases and projects use position
  columns plus shared table rail.

## Anti-Patterns

Do not:

- add local drag/drop scripts for table rows;
- use reorder on non-positioned log/activity tables;
- set `reorder.sort` to a non-sortable column;
- implement only drag/drop without up/down controls;
- implement only up/down controls without stable provider reorder hooks;
- show persisted position values as visible chips beside the rail;
- use module-local CSS for table rails, drag handles or drop placeholders.
