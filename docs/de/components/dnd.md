# DnD und Reorder

DnD in evo-ui ist der gemeinsame Vertrag fuer Reorder-Oberflaechen in
Manager-Modulen: Tabs, verschachtelte Felder, Tabellen und Optionen in Modals.
Der kanonische technische Vertrag liegt in
[DnD And Reorder Contract](../../en/components/dnd/reorder-contract.md) und
[DnD Implementation Guide](../../en/components/dnd/implementation-guide.md).

## evo-ui besitzt

- `x-evo::reorder-rail` fuer up/down controls und drag handle.
- `x-evo::dnd-option-list` und `x-evo::dnd-option-row` fuer value/label
  Optionen.
- CSS fuer `.evo-ui-dnd-row`, `.evo-ui-dnd-group-row`,
  `.evo-ui-dnd-option-row`, placeholder und compact actions.
- Native JavaScript runtime `window.EvoUI.initDnd(...)`.

## Consumer besitzt

- Stabile `_uid` Werte fuer Tabs, Zeilen und Optionen.
- Livewire methods wie `sortTabByUid`, `sortFieldByUid`, `sortOptionByUid`.
- Schema persistence, permissions und fachliche Validierung.

## Modal-Optionen

Bei Optionen in einem Modal ist der Handle der immediate native drag starter.
Die Zeile bleibt die Payload- und Drop-Target-Quelle. Inputs, Selects und
Textareas duerfen nie drag sources werden.

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

## Pruefung

Nach der Migration pruefe Drag zwischen Zeilen, Drag zwischen Tabs, manuelle
Pfeile, Save dirty state und Modals mit vielen Optionen.
