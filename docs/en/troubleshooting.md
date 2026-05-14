# Troubleshooting

Use this page when an EvoUI-based manager screen behaves differently from the
canonical components.

## A screen loads legacy styling

Check that the screen uses `x-evo::layout` or includes `evo::partials.assets`.
Remove Bootstrap, jQuery, CDN links, `styles.min.css`, `tabpane.js`, and legacy
manager bundles from evo-ui-owned screens.

## A form stays dirty after save

The form must use `livewire:evo-ui.form`, `data-evo-form`, and the shared
dirty-state bridge. Do not copy custom dirty scripts from `sLang`, `sSettings`,
or another consumer.

## A table action looks different

Use `x-evo::button`, `evo-ui-btn`, and `evo-ui-row-action`. Header actions,
row actions, delete actions, and save actions have documented variants in
[Action Buttons](components/action-buttons.md).

## DnD overflows on mobile

Use the shared DnD markers: `data-evo-dnd`, `data-evo-dnd-item`,
`data-evo-dnd-handle`, `x-evo::reorder-rail`, and the shared DnD row classes.
Do not create module-local drag previews.

## Authorization fails unexpectedly

Review consumer permissions and provider hooks first. EvoUI throws
`AuthorizationException` through `EvoGate` when a screen asks for an action the
manager user cannot perform.

## Release Checks

Run both coverage tools:

```bash
php DuckBook/scripts/evo-ui-doc-coverage.php --evo-ui=/Users/dmi3yy/PhpstormProjects/Extras/evo-ui
php DuckBook/scripts/extras-doc-coverage.php --extras=/Users/dmi3yy/PhpstormProjects/Extras --modules=evo-ui
```
