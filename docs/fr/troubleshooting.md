# Troubleshooting

## Legacy styling

Utilisez `x-evo::layout` ou `evo::partials.assets`. Supprimez Bootstrap, jQuery,
CDN, `styles.min.css`, `tabpane.js` et les legacy manager bundles des ecrans
evo-ui-owned.

## Le formulaire reste dirty apres Save

Utilisez `livewire:evo-ui.form`, `data-evo-form` et le shared dirty-state
bridge. Ne copiez pas de custom dirty scripts depuis les modules consommateurs.

## Une action de table a un style different

Utilisez `x-evo::button`, `evo-ui-btn` et `evo-ui-row-action`. Voir
[Action Buttons](components/action-buttons.md).

## Mobile DnD overflow

Utilisez `data-evo-dnd`, `data-evo-dnd-item`, `data-evo-dnd-handle` et
`x-evo::reorder-rail`. Ne creez pas de drag previews locales.
