# Table Pagination

Pagination is a shared EvoUI table primitive. It is not a consumer partial and
must not be reimplemented in modules.

Runtime markers that must stay documented include `pagination.blade.php`,
`per_page_options`, `aria-current="page"` and `goLastPage`.

Use this with the [Table Contract](contract.md) and [Table Filters](filters.md).

## Footer Anatomy

Every paginated table footer has two lanes:

- left: total row count and `per_page_options` selector;
- right: first page, previous page, compact page buttons, next page and last
  page.

The current page button uses `aria-current="page"` and the shared active button
state. Disabled controls stay visible so the footer does not jump.

## Preset Keys

```php
[
    'per_page' => 10,
    'per_page_options' => [10, 20, 50, 100],
]
```

Rules:

- `per_page` is the initial page size;
- `per_page_options` must include practical manager sizes;
- EvoUI filters unusual values and keeps the default available;
- changing per-page resets to page `1`.

## Livewire Actions

The default `wire_target` should include pagination actions:

```php
'wire_target' => 'search,perPage,setFilter,applySelectFilter,applyMultiFilter,toggleFilter,setSort,switchView,goToPage,firstPage,previousPage,nextPage,goLastPage',
```

The table runtime owns:

- `goToPage`;
- `firstPage`;
- `previousPage`;
- `nextPage`;
- `goLastPage`;
- `perPage`.

Consumer providers should only return `rows()` and `total()` for the current
state.

## Provider Responsibilities

The provider must apply limit/offset or equivalent query slicing according to
the state it receives through the table constructor.

```php
public function rows(): array;
public function total(): int;
```

`total()` must count the filtered result, not the full unfiltered table.

## State Persistence

Pagination state includes:

- page (`page`);
- per-page (`perPage`);
- filters (`f`);
- search (`q`);
- sort (`sort`);
- direction (`dir`);
- view mode (`view`).

URL state wins over manager-session state. If filters/search/sort change, EvoUI
returns the user to page `1` so empty pages do not appear after narrowing a
query.

## Responsive Rules

- The footer can wrap, but controls must stay in the shared footer.
- Do not duplicate pagination above the table.
- Do not hide the per-page selector in one module and show it in another.
- Do not add a module-local pagination partial.

## Review Checklist

- preset defines `per_page` and `per_page_options`;
- provider returns deterministic `rows()` and filtered `total()`;
- pagination actions are present in `wire_target`;
- current page uses shared `aria-current="page"` markup;
- no consumer-local pagination CSS/JS exists.
