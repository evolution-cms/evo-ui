# Table Component

`Table` is the canonical EvoUI surface for manager lists and CRUD. Use the root
[Table Component](table/README.md) contract as the source of truth.

## Standard Shape

Every EvoUI table contains:

- a toolbar with title/actions on the left and filters, view switcher, control
  actions and search on the right;
- a table view and optional list view backed by the same row data;
- a final row-action column for edit, delete, duplicate or domain actions;
- optional double-click edit through the shared modal;
- the shared pagination footer;
- optional shared create/edit and delete modals.

## Basic Usage

```blade
<x-evo::table.livewire
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

```php
return [
    'key' => 'vendor.module.items',
    'provider' => Vendor\Module\Tables\ItemsTableData::class,
    'per_page' => 10,
    'views' => ['table', 'list'],
    'default_sort' => 'updated_at',
    'search' => ['enabled' => true, 'state' => 'search'],
    'actions' => [],
    'filters' => [],
    'columns' => [],
    'list' => [],
    'modal' => [],
    'row_actions' => [],
];
```

## Ownership

EvoUI owns toolbar layout, filters, search, sorting controls, table/list chrome,
row action visuals, modals, pagination and state persistence.

The consumer provider owns queries, search/filter mapping, domain validation,
modal save, delete guards, reorder persistence and business actions.

## Do Not

- Do not create module-local table CSS or pagination.
- Do not add a second search/filter toolbar.
- Do not put actions outside the toolbar or final row-action column.
- Do not make list view show different business state than table view.
- Do not copy modal, delete or double-click behavior into a consumer.

