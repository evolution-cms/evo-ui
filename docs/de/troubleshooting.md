# Troubleshooting

## Legacy styling

Nutze `x-evo::layout` oder `evo::partials.assets`. Entferne Bootstrap, jQuery,
CDN, `styles.min.css`, `tabpane.js` und legacy manager bundles aus evo-ui-owned
screens.

## Formular bleibt dirty nach Save

Nutze `livewire:evo-ui.form`, `data-evo-form` und die shared dirty-state bridge.
Kopiere keine custom dirty scripts aus Consumer-Modulen.

## Tabellenaktion sieht anders aus

Nutze `x-evo::button`, `evo-ui-btn` und `evo-ui-row-action`. Details stehen in
[Action Buttons](components/action-buttons.md).

## Mobile DnD overflow

Nutze `data-evo-dnd`, `data-evo-dnd-item`, `data-evo-dnd-handle` und
`x-evo::reorder-rail`. Erzeuge keine lokalen drag previews.
