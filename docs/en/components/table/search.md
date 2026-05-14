# Table Search

Search is a first-class table state, not a custom input that consumers place
above a table. EvoUI owns the toolbar control, state persistence and responsive
placement. The provider owns query semantics.

Use this with the [Table Contract](contract.md), [Table Filters](filters.md) and
[Table Sorting](sorting.md).

## Preset Contract

```php
'search' => [
    'enabled' => true,
    'state' => 'search',
    'placeholder' => 'module::global.search_items',
    'width' => 'sm',
],
```

Rules:

- `enabled` controls whether the search button/input appears.
- `state` must normally stay `search`.
- `placeholder` is translated in the consumer module.
- `width` is a visual hint for the shared toolbar, not a consumer CSS hook.

The table `wire_target` must include `search` when search is enabled:

```php
'wire_target' => 'search,perPage,setSort,switchView,goToPage,firstPage,previousPage,nextPage,goLastPage',
```

## Toolbar Placement

Search lives in the right toolbar lane after filters, view switcher, list order
selector and control-lane actions. Do not add a second search row, custom search
card or module-local search input.

EvoUI owns:

- search open/close behavior;
- focus when the search control opens;
- loading/disabled state through `wire_target`;
- URL key `q`;
- manager-session restoration.

## Provider Mapping

Providers read the search term from state:

```php
$search = trim((string) ($this->state['search'] ?? ''));

if ($search !== '') {
    $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $search) . '%';

    $query->where(function ($scope) use ($like): void {
        $scope->where('title', 'like', $like)
            ->orWhere('alias', 'like', $like);
    });
}
```

Provider rules:

- escape SQL wildcard characters before `like` queries;
- support numeric shortcuts only when the domain needs them;
- keep relation joins and search fields in the provider;
- reset to page `1` is handled by EvoUI.

## Good Consumers

- `sArticles` uses search on article, taxonomy, author, comment and poll tables.
- `sSeo` uses search for redirects and activity.
- `sTask` uses domain-specific placeholders for tasks, workers and logs.
- `sLang` uses search for dictionary keys/text and inline editing.

## Anti-Patterns

Do not:

- render `data-*-search` controls outside `x-evo::table.livewire`;
- build a custom search toolbar in a consumer module;
- store search in module-local Alpine state;
- use search as a substitute for filters when the user needs selectable state;
- add local CSS for search width, icon, focus or dropdown behavior.
