# Action Buttons

Action buttons are the shared EvoUI command controls for forms, tables, rows,
modals and compact manager toolbars. Consumers describe the action, icon, tone,
label and handler; EvoUI owns the visual system, spacing, hover/focus states,
disabled state, accessibility labels and save feedback.

Use this guide before adding a button to `sArticles`, `sSeo`, `sLang`,
`dIssues`, `dGramm`, `sSettings`, `sTask` or a new manager module.

## Button Taxonomy

| Surface | Component/classes | Text | Shape | Use for |
| --- | --- | --- | --- | --- |
| Form primary save | `x-evo::button`, `.evo-ui-btn` | Yes | Primary filled | Saving a standalone form/settings screen. |
| Form secondary action | `x-evo::button`, `.evo-ui-btn--icon` | No | Icon square | Reset, external docs, compact utility actions. |
| Table toolbar action | `.evo-ui-table-actions .evo-ui-btn` | Usually no | Large icon square | Add, edit selected, duplicate, delete selected. |
| Table control action | `.evo-ui-table-controls .evo-ui-btn` | No | Compact icon square | View-related controls near filters/search. |
| Row action | `.evo-ui-row-actions .evo-ui-row-action` | No | Inline icon | Edit, delete, add, duplicate or state action per row. |
| Modal footer action | `.evo-ui-modal__footer .evo-ui-btn` | Yes | Text button | Apply local draft, save direct modal data, cancel, confirm. |
| Pagination/filter control | `.evo-ui-pager`, `.evo-ui-filter-*` | Contextual | Control-specific | Navigation/filter UI, not business actions. |

Do not invent a new button surface when one of these applies.

## Base Button

Use `x-evo::button` for normal commands:

```blade
<x-evo::button
    type="button"
    icon="plus"
    tone="success"
    variant="soft"
    :label="__('evo::global.action_add')"
/>
```

Parameters:

| Parameter | Type | Default | Notes |
| --- | --- | --- | --- |
| `type` | string | `button` | Use `submit` only for real form submit. |
| `label` | string|null | null | Required for visible text and icon-only accessibility. |
| `icon` | string|null | null | Tabler icon name rendered through `x-evo::icon`. |
| `tone` | string | `neutral` | `neutral`, `primary`, `info`, `success`, `warning`, `danger`. |
| `variant` | string | `soft` | `soft` or `filled` in the shared button atom. |
| `icon-only` | bool | false | Use only in dense toolbars or row/action lanes. |
| `disabled` | bool | false | Use real disabled state, not only visual opacity. |
| `href` | string|null | null | Renders an anchor when enabled. |

## Form Save Action

Standalone forms use a visible text Save button:

```php
'actions' => [
    ['type' => 'save', 'label' => 'evo::global.action_save'],
],
```

The rendered button uses:

- `icon="check"`;
- `tone="primary"`;
- `variant="filled"`;
- visible label text;
- disabled state while the form is clean;
- loading disabled state while `save` runs;
- `evo-ui:form.saved` event after successful save;
- inline saved feedback inside the same button.

After a successful save, the button keeps the visible Save label so its width
does not change. The short feedback window switches the icon/state and exposes
`evo::global.form_saved` through the button title and `aria-label`, then returns
to the disabled Save state. Repeated edit/save cycles must repeat this same
in-button feedback. Consumers must not create a local saved alert, toast or
custom save notification for standard forms.

## Modal Apply Action

Use `evo::global.action_apply` when a modal only commits its local draft into
the surrounding form or builder. This is the standard for staged editors such as
schema builders: the modal action is enabled only while the modal draft is
dirty, applies the draft, closes the modal, and marks the parent form dirty.

Use `evo::global.action_save` in a modal only when that modal directly persists
data to the backend. Do not label a local draft action as Save; it creates two
competing save concepts on the same screen.

## Form Secondary Actions

Reset and URL actions are compact icon buttons in the form toolbar:

```php
'actions' => [
    ['type' => 'reset', 'label' => 'evo::global.action_reset'],
    ['type' => 'url', 'label' => 'vendor::settings.docs', 'icon' => 'external-link', 'url' => 'https://example.test'],
],
```

Rules:

- Reset is disabled while the form is clean.
- URL actions use `icon_only` by default in compact form toolbars.
- Do not use secondary actions for the main save command.

## Table Toolbar Actions

Table actions are declared in the table preset:

```php
'actions' => [
    [
        'key' => 'create',
        'type' => 'wire',
        'method' => 'openCreateModal',
        'label' => 'evo::global.action_add',
        'icon' => 'plus',
        'tone' => 'success',
        'icon_only' => true,
    ],
    [
        'key' => 'delete-selected',
        'type' => 'wire',
        'method' => 'openBulkDeleteModal',
        'label' => 'evo::global.action_delete',
        'icon' => 'trash',
        'tone' => 'danger',
        'icon_only' => true,
        'selection' => 'single',
    ],
],
```

Common action keys:

| Key | Purpose |
| --- | --- |
| `key` | Stable action id. |
| `type` | `wire`, `link` or action-specific type. |
| `method` | Livewire method for `wire` actions. |
| `provider` | Provider action key when using table provider actions. |
| `href` | Link target for link actions. |
| `label` | Translation key for tooltip/aria and optional text. |
| `icon` | Shared icon name. |
| `tone` | Shared semantic tone. |
| `variant` | `soft` or `filled`. |
| `icon_only` | Usually `true` above tables. |
| `placement` | Use `controls` for right-side controls near filters/search. |
| `selection` | `single` disables the action until one row is selected. |
| `attributes` | Extra safe attributes when a module needs data markers. |

Rules:

- Add is `plus` + `success`.
- Edit selected is `edit` + `primary`.
- Duplicate/copy is `copy` or `copy-plus` + `info`.
- Delete is `trash` + `danger`.
- Toolbar action buttons are usually icon-only because the table tab/title gives
  context and space is limited.
- If an action needs text, it must still use `.evo-ui-btn`, not custom markup.

## Table Control Actions

Use `placement => 'controls'` for controls that belong near the view switcher,
filters, order menu or search:

```php
[
    'key' => 'refresh',
    'type' => 'wire',
    'method' => 'refreshTable',
    'label' => 'evo::global.action_refresh',
    'icon' => 'refresh',
    'placement' => 'controls',
    'icon_only' => true,
]
```

These are still table actions, but they live in the right control lane. Do not
place create/delete business actions in the control lane unless the workflow is
explicitly view-related.

## Row Actions

Row actions are dense inline icon buttons in the final table column, list cards,
DnD rows, config-map rows and builder rows:

```php
'row_actions' => [
    [
        'key' => 'edit',
        'type' => 'wire',
        'method' => 'openEditModal',
        'label' => 'evo::global.action_edit',
        'icon' => 'edit',
        'tone' => 'primary',
    ],
    [
        'key' => 'delete',
        'type' => 'wire',
        'method' => 'openDeleteModal',
        'label' => 'evo::global.action_delete',
        'icon' => 'trash',
        'tone' => 'danger',
    ],
],
```

Rules:

- Row actions are always icon-only.
- Every row action must have `title` and `aria-label`.
- Row actions belong in the final table column or the list/card action cluster.
- Use tones only for semantic meaning, not decoration.
- Disabled row actions use real `disabled` state or a disabled placeholder.

## Modal Footer Actions

Modal footers use text buttons because the user is committing or cancelling a
focused dialog:

- Cancel: neutral/default text button.
- Save: primary filled text button with check icon.
- Delete/Confirm destructive: danger filled text button.

Do not use icon-only buttons for primary modal footer actions.

## Save Feedback Contract

The standard save feedback stays inside the Save button:

```text
Dirty form:      [check] Save       enabled
Save succeeds:  [check] Saved      disabled, short-lived
Clean form:     [check] Save       disabled
Dirty again:    [check] Save       enabled
```

Runtime behavior:

- form save dispatches `evo-ui:form.saved`;
- the form captures a new clean snapshot;
- the Save button sets `savedFeedback = true`;
- the visible label stays on `evo::global.action_save` to keep the button width
  stable;
- the icon/title/`aria-label` switch to the saved state;
- after the short feedback window, the icon/title/`aria-label` return to Save
  while the button stays disabled because the form is clean;
- the next input/change clears saved feedback and enables Save.

## Anti-Patterns

- Do not create module-local button classes for Save/Add/Edit/Delete.
- Do not use text labels for dense row actions.
- Do not make Save icon-only in standalone forms or modal footers.
- Do not use Save copy for a modal action that only applies a local draft to a
  parent unsaved form; use Apply and keep the global Save as the persistence
  action.
- Do not put row actions outside the final action column/list action cluster.
- Do not use danger tone for non-destructive actions.
- Do not fake disabled state with opacity only.
- Do not use Bootstrap, manager legacy buttons or CDN button styles.

## Review Checklist

- The action uses `x-evo::button`, `.evo-ui-btn` or `.evo-ui-row-action`.
- Icon, tone and label match the shared semantic rules.
- Icon-only actions have `title` and `aria-label`.
- Save buttons show text and use primary filled styling.
- Repeated form saves show `Saved` inside the same Save button every time.
- Table actions are declared in config, not hardcoded in module Blade.
- Row actions are in the final row action lane.
