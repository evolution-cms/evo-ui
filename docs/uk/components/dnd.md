# DnD і порядок рядків

DnD у evo-ui - це спільний контракт для reorder-поверхонь у manager modules:
таби, вкладені поля, таблиці і опції всередині модалок. Канонічні технічні
деталі лежать у [DnD And Reorder Contract](../../en/components/dnd/reorder-contract.md)
та [DnD Implementation Guide](../../en/components/dnd/implementation-guide.md).

## Що належить evo-ui

- `x-evo::reorder-rail` для стрілок вгору/вниз і drag handle.
- `x-evo::dnd-option-list` та `x-evo::dnd-option-row` для value/label опцій.
- CSS для `.evo-ui-dnd-row`, `.evo-ui-dnd-group-row`,
  `.evo-ui-dnd-option-row`, placeholder і compact actions.
- Native JavaScript runtime `window.EvoUI.initDnd(...)`.

## Що належить consumer

- Стабільні `_uid` для табів, рядків і опцій.
- Livewire methods, наприклад `sortTabByUid`, `sortFieldByUid`,
  `sortOptionByUid`.
- Збереження схеми, права доступу і доменні перевірки.

## Модальні опції

Для опцій у модалці handle є immediate native drag starter, а рядок є джерелом
payload/drop target. Не дозволяйте інпутам ставати drag source.

```blade
<x-evo::dnd-option-list method="sortOptionByUid">
    <x-evo::dnd-option-row
        :uid="$option['_uid']"
        :index="$index"
        option-value="{{ $option['value'] }}"
        option-label="{{ $option['label'] }}"
    />
</x-evo::dnd-option-list>
```

## Перевірка

Після міграції consumer має пройти smoke: drag між рядками, drag між табами,
ручні стрілки, save dirty state і модалку з великою кількістю опцій.
