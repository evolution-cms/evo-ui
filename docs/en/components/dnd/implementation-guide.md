# DnD Implementation Guide

Use this guide when adding reorder behavior to an Evolution manager module.
The contract lives in [DnD And Reorder Contract](reorder-contract.md); this
file is the practical path for humans and agents.

## Decision Table

| Need | Use | Consumer owns |
| --- | --- | --- |
| Reorder blocks/tabs with nested rows | `data-evo-dnd`, `.evo-ui-dnd-group-row`, `.evo-ui-dnd-row`, `x-evo::reorder-rail` | group/item schema and Livewire methods |
| Reorder field options in a modal | `x-evo::dnd-option-list`, `x-evo::dnd-option-row` | option array, validation and save behavior |
| Reorder provider-backed table rows | module-table `position` column | provider `moveRow`/`reorderRow` persistence |
| Move a single row by keyboard/manual controls | `x-evo::reorder-rail` | method names and disabled state |

Do not create module-local CSS or JavaScript for common reorder rows, handles,
placeholders, option rows or table position controls.

## Nested Groups

Use this for sSettings-style tabs/blocks with child fields:

```blade
<div
    class="evo-ui-dnd"
    data-evo-dnd
    data-evo-dnd-group-method="sortTabByUid"
    data-evo-dnd-item-method="sortFieldByUid"
>
    @foreach($tabs as $tabIndex => $tab)
        <section
            class="evo-ui-dnd-group-row"
            data-evo-dnd-group
            data-evo-dnd-uid="{{ $tab['_uid'] }}"
            draggable="true"
        >
            <x-evo::reorder-rail
                move-up="moveTabStep('{{ $tab['_uid'] }}', -1)"
                move-down="moveTabStep('{{ $tab['_uid'] }}', 1)"
            />

            <div class="evo-ui-dnd-list" data-evo-dnd-list data-evo-dnd-group-uid="{{ $tab['_uid'] }}">
                @foreach($tab['fields'] as $field)
                    <div
                        class="evo-ui-dnd-row"
                        data-evo-dnd-item
                        data-evo-dnd-uid="{{ $field['_uid'] }}"
                        draggable="true"
                    >
                        <x-evo::reorder-rail />
                        <span class="evo-ui-dnd-key">[[{{ $field['key'] }}]]</span>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</div>
```

Required Livewire methods:

```php
public function sortTabByUid(string $groupUid, int $position): void
{
    // Update the group order in module-owned state.
}

public function sortFieldByUid(string $itemUid, int $position, string $targetGroupUid): void
{
    // Move the item into the target group and persist module-owned state.
}
```

Use stable UIDs. Do not persist by array index.

## Modal Option Rows

Use the modal option primitive for value/label options:

```blade
<x-evo::dnd-option-list method="sortOptionByUid" :label="__('Options')">
    @foreach($options as $index => $option)
        <x-evo::dnd-option-row
            :uid="$option['_uid']"
            :index="$index"
            option-value="{{ $option['value'] }}"
            option-label="{{ $option['label'] }}"
            add-after="addOptionAfter('{{ $option['_uid'] }}')"
            delete="deleteOption('{{ $option['_uid'] }}')"
        />
    @endforeach
</x-evo::dnd-option-list>
```

The component owns row layout, drag handle, add/delete placement and compact
actions. The module owns the option schema, localized labels, validation and
save behavior.

For modal option rows, EvoUI uses a pointer-owned reorder path instead of
native HTML5 DnD. Keep the option row, handle and value/label inputs
`draggable="false"`. This avoids the modal timing race where DevTools changes
whether the browser or EvoUI owns the first drag event. EvoUI renders the
dragged option as `.evo-ui-dnd-floating-preview`; consumers must not create a
module-local drag ghost for option rows.

## Table Reorder

For provider-backed tables, prefer a declarative `position` column:

```php
[
    'key' => 'position',
    'label' => 'Position',
    'type' => 'position',
]
```

ModuleTable renders the shared table rail, calls `moveRow(id, direction)` for
arrow fallback, and maps drag/drop through `sortTableRowByUid(uid, position)`.
That bridge resolves the visible target row and then calls the provider
`reorderRow(id, targetId, placement)`.

Provider-specific persistence stays in the consumer provider. Do not replace
the position cell with custom arrows or a standalone position chip. The
position value is provider state, not visible UI, so table/list rows show only
the rail.

## Dirty State

The shared runtime dispatches `evo-ui:dnd.changed`, `evo-ui:dnd.option.changed`,
the Alpine-safe alias `evo-ui:dnd-option-changed`, `evo-ui:form.dirty`, and the
Alpine-safe form alias `evo-ui:form-dirty` where relevant. Consumers should not
copy dirty-state scripts from another module. If a reorder changes unsaved
configuration state, the screen should use the standard EvoUI form/tab guard.

When modal option rows belong to a local modal draft, the
`evo-ui:dnd-option-changed` handler must update that draft state immediately.
The modal Apply action then commits the draft to the parent form, and the parent
Save action persists it. Do not move the DOM only; if the draft array is not
updated, Alpine/Livewire will redraw the old order after drop.

The runtime entrypoint is `initDnd`. It is evo-ui-owned and is re-applied after
Livewire morphs/navigation; consumers declare markers and Livewire methods, not
their own initialization script.

## Mobile Rules

- Keep rows in `.evo-ui-dnd-row`, `.evo-ui-dnd-group-row` or
  `.evo-ui-dnd-option-row`.
- Do not set fixed widths on draggable rows.
- Do not create module-local drag previews.
- Let EvoUI create the native `setDragImage` element: transparent for table
  rows with an EvoUI-owned visible table preview, real-row preview for non-table
  rows.
- Keep modal option lists inside the modal body scroll area.

## Adoption Checklist

1. Add stable `_uid` values to groups/items/options.
2. Choose the primitive from the decision table.
3. Wire Livewire methods with the documented signatures.
4. Use shared classes/components only.
5. Remove local reorder CSS/JS after migration.
6. Test consumer-owned persistence, validation and permissions.

Shared runtime, styling, option rows and table reorder visuals are tested in
`evo-ui`. Consumer modules test only their business behavior.
