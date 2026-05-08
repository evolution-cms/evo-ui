# Components

All Blade components use the `evo::` namespace.

## Layout

`x-evo::layout` owns the manager iframe document.

```blade
<x-evo::layout title="Publications">
    ...
</x-evo::layout>
```

Use it for full evo-ui screens. It applies theme classes and includes local CSS,
JS, and Livewire assets.

## Icons

`x-evo::icon` renders Tabler icons through the configured SVG helper.

```blade
<x-evo::icon name="table" />
<x-evo::icon name="tabler-user" />
<x-evo::icon name="o-edit" />
```

Accepted names:

- `table` becomes `tabler-table`
- `tabler-table` stays unchanged
- `o-table` becomes `tabler-table`

## Buttons

`x-evo::button` is the base command button.

```blade
<x-evo::button icon="plus" tone="success" label="Add" />
<x-evo::button icon="trash" tone="danger" icon-only label="Delete" />
```

Use icon-only buttons for dense toolbars. Always provide a label so the
component can render accessible text.

## Navigation Tabs

Use tabs for module sections, not for table filtering.

```blade
<x-evo::module-tabs :items="$tabs" :active="$activeTab" />
```

Each item should include:

```php
[
    'key' => 'articles',
    'label' => 'Articles',
    'icon' => 'rss',
    'href' => $moduleUrl . '&get=articles',
]
```

## Tables

There are two table surfaces.

`x-evo::table` is for resource-style object tables backed by
`EvoUI\Livewire\Table`.

`x-evo::table.module` is the lower-level render surface used by
`evo-ui.module-table`. Most modules should use the Livewire component:

```blade
<livewire:evo-ui.module-table preset="vendor.module.items" :context="$context" />
```

Supported module table cell types:

- `text`: plain scalar text
- `link`: `['label' => string, 'href' => string, 'target' => '_blank']`
- `image`: `['src' => string, 'alt' => string]`
- `chips`: array of strings rendered as compact chips
- `badge`: compact rounded numeric/string badge
- `icon`: Tabler icon; supports optional tone badge
- `date`: compact date text

Icon badge value:

```php
[
    'icon' => 'gender-male',
    'tone' => 'male',
    'label' => 'Man',
]
```

Built-in icon tones:

- `male`
- `female`
- `neutral`

## Filters

`x-evo::table.filter` is config-driven and used by module tables.

Supported filter types:

- `multi-select`
- `select`
- `segmented`
- `toggle`
- `date-range`

Filter state lives in Livewire URL state under `f`.

## Pagination And Sorting

`x-evo::table.pagination` renders the footer, per-page select, and page buttons.
`x-evo::table.order` renders compact list-view sort controls.

Tables sort through config:

```php
[
    'key' => 'published_at',
    'label' => 'Published',
    'type' => 'date',
    'sortable' => true,
    'sort_field' => 'items.published_at',
    'default_direction' => 'desc',
]
```

## Forms

`x-evo::form` renders config-driven forms. It is designed for manager editors,
settings screens, and item forms.

Field types include:

- `text`
- `number`
- `textarea`
- `select`
- `checkbox`
- `radio`
- `multi-checkbox`
- `display`
- `resource-parent`
- `config-map`
- custom field views registered through `EvoUI::registerFormField()`

Use form actions for save/cancel/reset commands instead of custom button bars.

### Rich Editor Fields

Module modal fields can use `type => editor`. The field can either use the
Evolution system editor or a module-level editor setting:

```php
[
    'name' => 'introtext',
    'type' => 'editor',
    'label' => 'Intro',
    'height' => '260px',
    'editor_switcher' => false,
    'editor' => $configuredEditor,
]
```

Use `editor_switcher => false` when the editor is selected in a settings form.
This keeps dense content forms clean.

### Choices

Modal fields can use the choices pattern for tags, categories, related records
and other compact relations:

```php
[
    'name' => 'tag_ids',
    'type' => 'choices',
    'label' => 'Tags',
    'multiple' => true,
    'searchable' => true,
    'clearable' => true,
    'options_provider' => 'modalOptionsForField',
]
```

Supported behavior:

- single or multiple values;
- selected values rendered as compact chips;
- optional search input;
- optional clear/cancel controls;
- server/provider-backed options;
- clicking an already selected option toggles it off when the field allows it.

This follows the useful API direction from Mary UI choices while keeping the
rendering and state handling inside evo-ui.

## Modals

`x-evo::modal` is the shared dialog shell for manager workflows that should not
leave the current table.

```blade
<x-evo::modal :open="$open" title="Edit author" icon="user">
    <form class="evo-ui-modal__form">
        <div class="evo-ui-modal__body">...</div>
        <footer class="evo-ui-modal__footer">...</footer>
    </form>
</x-evo::modal>
```

The modal provides the header, title icon, close button, backdrop, scrollable
body, and footer layout. Module table forms should prefer the built-in
`modal` config on `evo-ui.module-table`.

Modal image fields use `EvoUI.browseImageField(inputId)`, which integrates with
the Evolution manager media browser and dispatches `input`/`change` events so
Livewire state updates immediately.

## Inline Editors

`x-evo::table.module.inline-edit` is used by module tables when a column has
`editable => true`. It keeps editing lightweight for small dictionaries:

- blur or Enter saves through `updateInlineField`
- Escape restores the last saved value
- the provider returns the normalized value to keep the field synced

Prefer inline editors for one-line text/alias tables. Use modal forms when a row
has several fields, media, long text, or grouped controls.

## Issue Workspace

`x-evo::issues.workspace` renders the provider-backed workspace used by
`dIssues`:

```blade
<x-evo::issues.workspace
    preset="dissues.issues"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

The Livewire component is `evo-ui.issue-workspace`. It supports:

- list and kanban display modes;
- category/status/assignee filters;
- search;
- selected issue preview;
- provider-backed issue actions;
- native drag/drop kanban lane sorting;
- manager-session state persistence.

Providers must implement `EvoUI\Contracts\IssueWorkspaceProvider`.

## Cards

`x-evo::card` is a small framing primitive for repeated items, dialogs, or
contained tools. Do not nest cards inside cards.

## Styling Tokens

Use existing evo-ui classes and tokens before adding module CSS:

- `evo-ui-btn`
- `evo-ui-row-action`
- `evo-ui-meta-chip`
- `evo-ui-badge`
- `evo-ui-table-icon`
- `evo-ui-table-image`
- `evo-ui-list-item`
- `evo-ui-table-surface`
- `evo-ui-modal`
- `evo-ui-image-field`
- `evo-ui-choice`
- `evo-ui-issue-workspace`

Avoid one-off colors in module views. Add reusable tokens/classes to evo-ui when
a pattern is shared by more than one module.
