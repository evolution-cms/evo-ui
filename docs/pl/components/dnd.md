# DnD i reorder

DnD w evo-ui to wspolny kontrakt dla powierzchni reorder w modulach managera:
taby, zagniezdzone pola, tabele i opcje w modalach. Kanoniczny kontrakt
techniczny jest w [DnD And Reorder Contract](../../en/components/dnd/reorder-contract.md)
oraz [DnD Implementation Guide](../../en/components/dnd/implementation-guide.md).

## Wlasnosc evo-ui

- `x-evo::reorder-rail` dla strzalek gora/dol i drag handle.
- `x-evo::dnd-option-list` oraz `x-evo::dnd-option-row` dla opcji
  value/label.
- CSS dla `.evo-ui-dnd-row`, `.evo-ui-dnd-group-row`,
  `.evo-ui-dnd-option-row`, placeholderow i compact actions.
- Native JavaScript runtime `window.EvoUI.initDnd(...)`.

## Wlasnosc consumer

- Stabilne `_uid` dla tabow, wierszy i opcji.
- Metody Livewire, np. `sortTabByUid`, `sortFieldByUid`, `sortOptionByUid`.
- Zapis schematu, uprawnienia i walidacja domenowa.

## Opcje w modalu

Dla opcji w modalu handle jest immediate native drag starter, a wiersz pozostaje
zrodlem payload/drop target. Nie pozwalaj inputom zostac drag source.

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

## Test

Po migracji sprawdz drag miedzy wierszami, drag miedzy tabami, reczne strzalki,
save dirty state i modal z wieloma opcjami.
