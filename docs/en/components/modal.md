# Modal And Confirmation

Modals are EvoUI-owned manager overlays. Consumers provide action methods,
domain data and validation rules; EvoUI owns the dialog shell, spacing, header,
close affordance, footer action placement, delete confirmation chrome, focus
behavior and form/editor sync hooks.

Use this guide for custom dialogs, module-table create/edit modals,
read-only/action detail modals and destructive confirmations.

## Modal Types

| Type | Canonical surface | Use for | Consumer owns |
| --- | --- | --- | --- |
| Custom modal | `x-evo::modal` | Small custom manager dialogs | Open state and action methods |
| Table form modal | `evo-ui.module-table` modal config | Create/edit CRUD forms | Provider defaults and save semantics |
| Action detail modal | table action/read-only modal config | Logs, task details, diagnostics | Detail payload and action methods |
| Delete confirmation | table delete modal | Guarded destructive actions | Delete guard and final mutation |

Do not create module-local modal frames, footer button CSS or duplicated close
buttons. If a module needs a modal variant, add the variant to EvoUI.

## Custom Modal

```blade
<x-evo::modal :open="$open" title="Connect bot" icon="send" size="wide">
    <div class="evo-ui-modal__body">
        ...
    </div>

    <x-slot:footer>
        <x-evo::button icon="x" label="Cancel" wire:click="closeModal" />
        <x-evo::button
            icon="check"
            tone="primary"
            variant="filled"
            label="Save"
            wire:click="saveModal"
        />
    </x-slot:footer>
</x-evo::modal>
```

Rules:

- use `x-evo::button` in the footer;
- align primary submit actions to the right;
- use `tone="danger"` only for destructive confirmation;
- reduce top padding through EvoUI modal size/density rules, not module CSS.

## Table Form Modal

Table CRUD modals are configured in the table preset:

```php
'modal' => [
    'enabled' => true,
    'title_create' => 'vendor::global.create_item',
    'title_edit' => 'vendor::global.edit_item',
    'icon' => 'edit',
    'size' => 'wide',
    'fields' => [
        ['name' => 'title', 'type' => 'text', 'label' => 'vendor::global.title'],
        ['name' => 'status', 'type' => 'select', 'options_provider' => 'statusOptions'],
    ],
],
```

The provider owns:

```php
public function modalDefaults(): array;
public function modalData(int $id): array;
public function saveModal(array $data, ?int $id = null, string $mode = 'create'): int;
```

EvoUI owns field rendering, submit footer, rich editor sync before save, close
behavior and validation display.

## Read-Only Action Modal

Use read-only/action modals for logs, diagnostics, task details and records that
open from row double-click without exposing a Save action.

```php
'modal' => [
    'enabled' => true,
    'mode' => 'action',
    'show_submit' => false,
    'fields' => [
        ['name' => 'message', 'type' => 'code', 'label' => 'Log message'],
        ['name' => 'status', 'type' => 'badge', 'label' => 'Status'],
    ],
],
```

Rules:

- do not fake a disabled form submit button;
- row double-click may open the action modal when `data-evo-modal-action` is
  present;
- use `static`, `code` and `badge` fields for display-only content.

## Delete Confirmation

Delete flow belongs to EvoUI chrome and consumer provider semantics:

```php
public function deleteName(int $id): string;
public function deleteRow(int $id): bool|string|null;
```

`deleteRow()` returns `true` or `null` for success, `false` for a generic
failure and a string for a delete guard message.

## Consumer Notes

| Consumer | Pattern |
| --- | --- |
| `sArticles` | Good donor for table CRUD modal fields, image/file/editor fields and delete guards. |
| `sSeo` | Use table modal/action patterns for redirects and details; keep SEO rules in providers. |
| `sSettings` | Field option modals should use EvoUI form/modal spacing and option-list primitives. |
| `sTask` | Detail/log modals should use read-only action modal config and avoid legacy shell assets. |
| `dIssues` | Good donor for provider-backed issue/detail modal behavior. |

## Review Checklist

- Modal shell is `x-evo::modal` or table modal config.
- Footer actions use `x-evo::button`.
- Delete guard messages come from the provider.
- Read-only/action modals have no submit button.
- No module-local modal frame, border, footer or spacing CSS exists.

