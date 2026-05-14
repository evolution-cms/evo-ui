# DnD et reorder

Dans evo-ui, DnD est le contrat commun pour les surfaces de reorder des modules
manager: tabs, champs imbriques, tables et options dans les modals. Le contrat
technique canonique se trouve dans
[DnD And Reorder Contract](../../en/components/dnd/reorder-contract.md) et
[DnD Implementation Guide](../../en/components/dnd/implementation-guide.md).

## evo-ui possede

- `x-evo::reorder-rail` pour les fleches haut/bas et le drag handle.
- `x-evo::dnd-option-list` et `x-evo::dnd-option-row` pour les options
  value/label.
- CSS pour `.evo-ui-dnd-row`, `.evo-ui-dnd-group-row`,
  `.evo-ui-dnd-option-row`, placeholders et compact actions.
- Runtime JavaScript natif `window.EvoUI.initDnd(...)`.

## Le consumer possede

- Des `_uid` stables pour tabs, lignes et options.
- Les methodes Livewire, par exemple `sortTabByUid`, `sortFieldByUid`,
  `sortOptionByUid`.
- La persistance du schema, les permissions et la validation metier.

## Options de modal

Pour les options dans une modal, le handle est l'immediate native drag starter.
La ligne reste la source de payload/drop target. Ne laissez pas les inputs
devenir drag source.

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

## Verification

Apres migration, verifiez le drag entre lignes, le drag entre tabs, les fleches
manuelles, le save dirty state et une modal avec beaucoup d'options.
