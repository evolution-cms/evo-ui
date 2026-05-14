# Troubleshooting

Використовуйте цю сторінку, коли EvoUI manager screen відрізняється від
канонічних компонентів.

## Екран підтягує legacy styling

Перевірте `x-evo::layout` або `evo::partials.assets`. Приберіть Bootstrap,
jQuery, CDN, `styles.min.css`, `tabpane.js` і legacy manager bundles з
evo-ui-owned screens.

## Форма лишається dirty після save

Форма має використовувати `livewire:evo-ui.form`, `data-evo-form` і shared
dirty-state bridge. Не копіюйте custom dirty scripts з consumer modules.

## Table action виглядає інакше

Використовуйте `x-evo::button`, `evo-ui-btn` і `evo-ui-row-action`. Header
actions, row actions, delete actions і save actions описані в
[Action Buttons](components/action-buttons.md).

## DnD виходить за межі на mobile

Використовуйте shared markers `data-evo-dnd`, `data-evo-dnd-item`,
`data-evo-dnd-handle` і `x-evo::reorder-rail`. Не створюйте module-local drag
previews.

## Authorization падає

Спочатку перевірте permissions і provider hooks у consumer module. EvoUI через
`EvoGate` кидає `AuthorizationException`, коли manager user не має доступу.
