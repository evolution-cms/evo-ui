# Inline Create And Inline Edit

Inline create and inline edit cover interactions where a user creates or edits a
row without opening a modal. EvoUI owns scroll, focus, highlight, bottom create
visibility, inline edit controls and shared events. Consumers own mutation
methods and validation.

## Inline Create Root

```blade
<div class="evo-ui-inline-create" data-evo-inline-create="settings-config">
    <div
        class="evo-ui-dnd-row"
        data-evo-inline-created="{{ $field['_uid'] }}"
        data-evo-inline-create-id="{{ $field['_uid'] }}"
    >
        <input data-evo-inline-focus wire:model.live="fields.0.label">
    </div>

    <div class="evo-ui-inline-create-bottom" data-evo-inline-create-bottom hidden>
        <x-evo::button icon="plus" tone="success" wire:click="addField" />
    </div>
</div>
```

Markers:

| Marker | Purpose |
| --- | --- |
| `data-evo-inline-create` | Names the inline-create root. |
| `data-evo-inline-created` | Marks a row that may receive highlight/focus. |
| `data-evo-inline-create-id` | Stable id for a created item. |
| `data-evo-inline-focus` | First focus target inside a created item. |
| `data-evo-inline-create-bottom` | Optional duplicate create action for long pages. |

## Created Event

After the consumer creates an item and Livewire has rendered it, dispatch:

```js
window.dispatchEvent(new CustomEvent('evo-ui:inline-create.created', {
    detail: { root: 'settings-config', id: newUid }
}));
```

EvoUI scrolls to the item, highlights it and focuses the first
`data-evo-inline-focus` control.

## Bottom Create Action

Use a bottom create action when the user may be editing below the first viewport
and creating another row should not require scrolling back to the top.

Rules:

- the bottom action mirrors the same Livewire method as the top action;
- EvoUI controls visibility based on overflow/scroll state;
- the button remains a standard `x-evo::button`;
- do not create a second local sticky toolbar.

## Table Inline Edit

```php
'inline' => [
    'enabled' => true,
    'create_method' => 'createInlineRow',
    'update_method' => 'updateInlineField',
],
```

Provider hooks:

```php
public function createInlineRow(): int;
public function updateInlineField(int $id, string $field, string $value, array $column = []): string;
```

## Consumer Notes

| Consumer | Pattern |
| --- | --- |
| `sLang` | Canonical donor for dictionary inline edit. |
| `sSettings` | Donor for config row creation, scroll/focus and bottom add. |
| `sArticles` | Use inline behavior only when modal CRUD is too heavy; keep builder semantics local. |

## Review Checklist

- Created item has a stable id.
- Focus target uses `data-evo-inline-focus`.
- Consumer dispatches `evo-ui:inline-create.created` only after render.
- Long panels use `data-evo-inline-create-bottom` instead of local sticky hacks.
- Table inline edit uses provider hooks, not direct SQL in Blade.

