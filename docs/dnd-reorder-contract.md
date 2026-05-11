# DnD And Reorder Contract

`evo-ui` owns shared drag/drop and reorder behavior for manager screens. A
consumer module declares reorderable groups, rows, actions and persistence
methods. It should not ship module-local CSS or JavaScript for common reorder
surfaces.

This contract is based on the sSettings Configure donor implementation. The
donor proved the required behavior for block/tab rows, nested field rows that
move between blocks, option rows inside modals, stable UID payloads, real-row
native drag previews, measured physical placeholders, dirty-state events,
compact up/handle/down rails, and mobile drag previews that stay inside the
visible panel.

## Ownership

Shared evo-ui behavior:

- visual rail, handle, row, placeholder, chip and action styling;
- native drag/drop runtime and morph-safe reinitialization;
- handle-armed dragging so inputs do not start drags;
- physical placeholder placement and measured height;
- real row for `setDragImage`; no offscreen cloned previews;
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

## Table Reorder

Table rows that support provider reorder hooks should use the same visual
language: compact rail, drag handle, up/down fallback and provider method
mapping. Table reorder must not use a different position-chip-only UI.
Module tables keep `moveRow(id, direction)` as the provider-safe fallback and
render position values next to the shared `x-evo::reorder-rail`.

## Data Markers

The runtime implementation should use evo-ui markers, not consumer prefixes:

| Marker | Purpose |
| --- | --- |
| `data-evo-dnd` | Root for a reorder runtime instance. |
| `data-evo-dnd-group` | Reorderable group/block row. |
| `data-evo-dnd-item` | Reorderable child row. |
| `data-evo-dnd-list` | Item list inside a group. |
| `data-evo-dnd-dropzone` | Explicit insertion target. |
| `data-evo-dnd-handle` | Handle that arms native dragging. |
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
- Ignore drag starts from inputs, selects, textareas, buttons, links and open
  modals unless the target is the active handle.
- Write both `text/plain` and an evo-ui custom payload to `dataTransfer`.
- Use the real row for `setDragImage`; do not create offscreen cloned previews.
- Hide the source row one animation frame after the native preview is captured.
- Insert a physical placeholder and measure the dragged row height.
- Commit the placeholder position before the Livewire redraw to avoid visual
  rollback.
- Reinitialize after Livewire morph/navigation.
- Dispatch a structural dirty event after a client-side reorder.
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
4. Use shared dirty-state events and save toasts.
5. Remove module-local DnD CSS and JavaScript.
6. Add consumer tests only for module-owned schema persistence and permissions.

Generic runtime, row visuals, modal option rows and table reorder controls are
tested in evo-ui. Consumer modules test business behavior.
