# Troubleshooting

## Legacy styling

Uzyj `x-evo::layout` albo `evo::partials.assets`. Usun Bootstrap, jQuery, CDN,
`styles.min.css`, `tabpane.js` i legacy manager bundles z ekranow evo-ui-owned.

## Formularz zostaje dirty po zapisie

Uzyj `livewire:evo-ui.form`, `data-evo-form` i shared dirty-state bridge. Nie
kopiuj custom dirty scripts z consumer modules.

## Inny wyglad akcji w tabeli

Uzyj `x-evo::button`, `evo-ui-btn` i `evo-ui-row-action`. Szczegoly sa w
[Action Buttons](components/action-buttons.md).

## Mobile DnD overflow

Uzyj `data-evo-dnd`, `data-evo-dnd-item`, `data-evo-dnd-handle` i
`x-evo::reorder-rail`. Nie tworz lokalnych drag previews.
