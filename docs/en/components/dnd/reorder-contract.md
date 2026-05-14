# DnD And Reorder Contract

`evo-ui` owns shared drag/drop and reorder behavior for manager screens. A
consumer module declares reorderable groups, rows, actions and persistence
methods. It should not ship module-local CSS or JavaScript for common reorder
surfaces.

This contract is based on the sSettings Configure donor implementation. The
donor proved the required behavior for block/tab rows, nested field rows that
move between blocks, option rows inside modals, stable UID payloads, native row
drag previews, measured physical placeholders, dirty-state events,
compact up/handle/down rails, and mobile drag previews that stay inside the
visible panel.

## Ownership

Shared evo-ui behavior:

- visual rail, handle, row, placeholder, chip and action styling;
- native drag/drop runtime and morph-safe reinitialization;
- handle-armed dragging so inputs do not start drags;
- physical placeholder placement and measured height;
- native drag preview selection for `setDragImage`;
- structural dirty event dispatch after client-side reorder;
- table/list/modal option reorder visual parity.

Consumer-owned behavior:

- business schema and data persistence;
- labels, field types, option semantics and validation;
- permission checks and delete guards;
- Livewire methods that mutate the consumer data structure;
- module-specific translations and domain-specific empty states.

## Nested DnD Group

Use nested groups for tabs/blocks with child rows:

```php
[
    'key' => 'settings-schema',
    'type' => 'nested',
    'groups' => [
        [
            'uid' => 'tab-social',
            'label' => 'Social links',
            'items' => [
                ['uid' => 'field-instagram', 'title' => 'Instagram'],
            ],
        ],
    ],
    'methods' => [
        'sort_group' => 'sortTabByUid',
        'sort_item' => 'sortFieldByUid',
    ],
]
```

The runtime payload for a group move is:

```php
sortTabByUid(string $groupUid, int $position): void
```

The runtime payload for an item move is:

```php
sortFieldByUid(string $itemUid, int $position, string $targetGroupUid): void
```

## Reorder Rail

Every draggable row uses the same rail:

```blade
<x-evo::reorder-rail :move-up="$moveUp" :move-down="$moveDown" handle />
```

The rail is the standard up/drag/down control. Do not create separate position
chips, oversized arrows or module-specific drag handles for common reorder rows.

## Modal Option List

Use a modal option list for option rows inside field modals:

```php
[
    'type' => 'option-list',
    'items' => [
        ['uid' => 'option-news', 'value' => 'news', 'label' => 'News'],
    ],
    'columns' => ['value', 'label'],
]
```

The shared primitive owns value/label row layout, add-after, delete, up/down,
drag handle, measured placeholder height and scroll-contained modal behavior.
The consumer serializes the resulting option array.

Modal option rows keep `draggable="true"` on the row and on the handle. The
handle is the immediate browser drag starter, while the runtime resolves the
payload, placeholder size and drop position from the parent row. This mirrors
the main-row contract and avoids timing races where a fast drag starts text
selection inside the value/label inputs instead of native DnD.

## Table Reorder

Table rows that support provider reorder hooks should use the same visual
language: compact rail, drag handle, up/down fallback and provider method
mapping. Table reorder must not use a different position-chip-only UI.
Module tables keep `moveRow(id, direction)` as the provider-safe fallback and
use `sortTableRowByUid(uid, position)` as the shared drag/drop bridge into
`reorderRow(id, targetId, placement)`. The position value is provider state,
not visible UI, so table/list reorder renders only the shared rail.

## Data Markers

The runtime implementation should use evo-ui markers, not consumer prefixes:

| Marker | Purpose |
| --- | --- |
| `data-evo-dnd` | Root for a reorder runtime instance. |
| `data-evo-dnd-group` | Reorderable group/block row. |
| `data-evo-dnd-item` | Reorderable child row. |
| `data-evo-dnd-list` | Item list inside a group. |
| `data-evo-dnd-dropzone` | Explicit insertion target. |
| `data-evo-dnd-handle` | Shared reorder handle. It starts native row DnD outside modal option lists and pointer-owned option DnD inside modal option lists. |
| `data-evo-dnd-option-list` | Modal option-list root. |
| `data-evo-dnd-option-row` | Modal option row. |

Rows must expose stable UID values. Indexes are display metadata only; they must
not be the persistence identity.

Use `.evo-ui-dnd-row`, `.evo-ui-dnd-group-row`, `.evo-ui-dnd-option-row`,
`.evo-ui-dnd-list`, `.evo-ui-dnd-option-list`, `.evo-ui-dnd-key`,
`.evo-ui-dnd-badge` and `.evo-ui-dnd-actions` when the consumer renders custom
markup. Existing builder components use the same visual contract.

For modal choices/options, prefer `x-evo::dnd-option-list` and
`x-evo::dnd-option-row`. The row component owns the compact rail, stable
`data-evo-dnd-uid`, value/label inputs, add-after action and delete action
placement; the consumer owns option data and persistence.

## Runtime Rules

- Start dragging only after the handle is pressed.
- For modal option rows, keep the row, handle and inputs `draggable="false"`;
  EvoUI owns the pointer reorder path and dispatches `evo-ui:dnd.option.changed`
  plus `evo-ui:dnd-option-changed` for Alpine listeners, because dots in
  `x-on` names can be parsed as modifiers.
- Pointer-owned modal option DnD renders `.evo-ui-dnd-floating-preview` while
  the source row is hidden and the placeholder keeps layout stable.
- Ignore drag starts from inputs, selects, textareas, buttons, links and open
  modals unless the target is the active handle.
- For native group/item rows, write both `text/plain` and an evo-ui custom
  payload to `dataTransfer`.
- For native group/item rows, EvoUI owns the `setDragImage` element. Table rows
  use a transparent technical image so the physical placeholder is the only
  browser-native marker, while EvoUI renders its own table-row floating preview
  under the pointer. The source `<tr>` leaves table layout while dragging.
  Non-table rows use the real row as the native drag image so the dragged plaque
  keeps the same component styling as the row being moved.
- Hide the source row one animation frame after the native preview is captured.
- Insert a physical placeholder and measure the dragged row height.
- Commit the placeholder position before the Livewire redraw to avoid visual
  rollback.
- Reinitialize after Livewire morph/navigation.
- Dispatch a structural dirty event after a client-side reorder. Screens that
  listen through Alpine should use the `evo-ui:form-dirty` alias because dotted
  custom event names can be parsed as modifiers.
- Keep modal option-list drops from bubbling into parent group drops.

## Mobile Rules

DnD rows must stay within their current panel width on mobile. The shared row
and placeholder CSS must use `min-width: 0`, responsive grid tracks and
container-constrained drag previews. A dragged row must not become wider than
the list or cover unrelated page content.

## Adoption Order

1. Define the consumer data model with stable UIDs.
2. Wire Livewire methods for group/item/option moves.
3. Render rows through evo-ui primitives and data markers.
4. Use shared dirty-state events and in-button save feedback.
5. Remove module-local DnD CSS and JavaScript.
6. Add consumer tests only for module-owned schema persistence and permissions.

Generic runtime, row visuals, modal option rows and table reorder controls are
tested in evo-ui. Consumer modules test business behavior.
