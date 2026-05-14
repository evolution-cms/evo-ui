# Choices And Option Lists

Choices and option lists cover selectable values, multi-select chips and
value/label rows that may be reordered. EvoUI owns controls, row density, chips,
add/delete affordances, DnD visuals and mobile-safe drag behavior. The consumer
owns meaning, validation and persistence.

## Primitives

| Primitive | Surface | Use for |
| --- | --- | --- |
| Choices field | `type => choices` | Multi-value selection in forms or modals. |
| Static options | `options` | Small fixed option lists. |
| Provider options | `options_provider` | Dynamic module-owned option lists. |
| Option-list DnD | `x-evo::dnd-option-list` | Reorderable value/label rows. |
| Option row | `x-evo::dnd-option-row` | One configurable option row. |

## Choices Field

```php
[
    'name' => 'relations',
    'type' => 'choices',
    'label' => 'vendor::global.relations',
    'options_provider' => 'relationOptions',
    'multiple' => true,
    'rules' => ['array'],
]
```

Provider options should return stable scalar values and labels:

```php
public function relationOptions(): array
{
    return [
        ['value' => 'article', 'label' => 'Article'],
        ['value' => 'topic', 'label' => 'Topic'],
    ];
}
```

## Option-List DnD

Use option-list DnD when a user edits configurable options:

```blade
<x-evo::dnd-option-list method="sortOptionByUid">
    <x-evo::dnd-option-row
        :uid="$option['_uid']"
        :index="$index"
        option-value="{{ $option['value'] }}"
        option-label="{{ $option['label'] }}"
        add-after="addOptionAfter('{{ $option['_uid'] }}')"
        delete="deleteOption('{{ $option['_uid'] }}')"
    />
</x-evo::dnd-option-list>
```

The consumer Livewire component owns:

```php
public function addOptionAfter(string $uid): void;
public function deleteOption(string $uid): void;
public function sortOptionByUid(string $uid, int $position): void;
```

EvoUI owns the rail, drag handle, row spacing, button palette, placeholder,
disabled states and mobile drag width.

## Value And Label Defaults

A new option may default to `value == label` until the user changes either
field. This is a consumer serialization rule, not an EvoUI visual rule. EvoUI
only renders the two controls consistently.

Recommended behavior:

- create a stable `_uid` immediately;
- create `value` and `label` as the same readable default;
- keep `_uid` separate from the persisted value;
- validate duplicate values in the consumer before save.

## Consumer Notes

| Consumer | Pattern |
| --- | --- |
| `sArticles` | Good donor for relation choices and builder option semantics. |
| `sSettings` | Good donor for option-row behavior; final visual contract belongs in EvoUI. |
| `dIssues` | Good donor for taxonomy/filter option providers. |
| `sLang` | Language choices should keep language/domain semantics in the module. |

## Anti-Patterns

- Do not create module-local option row borders, buttons or drag handles.
- Do not persist `_uid` as the public option value.
- Do not use option-list DnD for table row ordering; use table reorder.

