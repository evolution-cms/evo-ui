# Компонент Table

`Table` - канонічна EvoUI поверхня для manager-списків і CRUD. Повний контракт
описаний у root документі [Table Component](../../en/components/table/README.md).

## Стандартна структура

Кожна EvoUI таблиця має:

- toolbar: зліва title/actions, справа filters, перемикач view, control actions
  і search;
- table view і опційний list view на тих самих row data;
- останню колонку row actions для edit/delete/duplicate/domain actions;
- опційне відкривання edit modal по double-click;
- спільний pagination footer;
- спільні create/edit і delete modals.

## Базове використання

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

EvoUI відповідає за toolbar layout, filters, search, sorting controls,
table/list chrome, row action visuals, modals, pagination і state persistence.

Consumer provider відповідає за queries, search/filter mapping, domain
validation, modal save, delete guards, reorder persistence і business actions.

## Не робити

- Не створювати module-local CSS або pagination для таблиць.
- Не додавати другий search/filter toolbar.
- Не виносити row actions за межі toolbar або останньої колонки.
- Не показувати в list view інший бізнес-стан, ніж у table view.
- Не копіювати modal/delete/double-click behavior у consumer.


## Адаптивний перший рендер

У поточній гілці розробки parent-компонент може передати ширину контейнера в тому самому запиті, що перемикає вкладку. Оголосіть `public int $tableWidth = 0`, додайте `responsive-width-model="tableWidth"` до `x-evo::module-tab-shell` і передайте `responsive_width` у context вкладеної таблиці.

Явний URL та збережений ручний вибір вигляду мають пріоритет. Поріг `responsive_list` — 1200 CSS px; значення 0 вимикає автоматичне перемикання. Без підказки або при зміні ширини працює попередній механізм. Початкове завантаження документа ще може потребувати додаткового запиту.

```blade
<x-evo::module-tab-shell model="activeTab" responsive-width-model="tableWidth">
    <x-evo::table.livewire
        :preset="$activePreset"
        :context="['tab' => $activeTab, 'responsive_width' => $tableWidth]"
        :wire-key="$activePreset"
    />
</x-evo::module-tab-shell>
```

[Responsive first render](../../en/components/module-table-contract.md#responsive-first-render).
