# Components And UI Kit

All reusable manager UI primitives live in `evo-ui` and use the `evo::`
Blade namespace. Consuming modules should describe screens declaratively through
config, providers and small module-owned Livewire state. They should not copy
shared CSS, JS, button markup, tab behavior, modal shells or field rendering
from another consumer.

## Layer Ownership

`evo-ui` owns:

- manager iframe shell and theme bridge;
- local package assets, design tokens and component CSS;
- shared Blade components;
- Livewire table, form and issue workspace surfaces;
- modal, delete confirmation, dirty-state and save/discard UI behavior;
- field rendering, editor/media picker hooks and common runtime helpers;
- table/list state, filters, sorting, pagination and generic row actions;
- reusable visual primitives such as buttons, tabs, badges, chips, alerts,
  cards, surfaces, toolbars and empty states.

The consuming module owns:

- routes, permissions, translations and manager module registration;
- table/form/workspace config presets;
- providers, queries, persistence and validation semantics;
- business actions such as publish, duplicate, translate, archive or workflow
  transitions;
- domain-specific editor content, SEO rules, translation rules, article builder
  semantics, settings schema semantics and issue workflow semantics.

If a pattern appears in more than one manager module, add it to `evo-ui` first.
Temporary module-local CSS/JS must be scoped, documented and backed by a follow-up
task to promote or remove it.

## Component Inventory

| Primitive | Canonical surface | Owned by | Consumer input |
| --- | --- | --- | --- |
| Manager shell | `x-evo::layout` | evo-ui | title, root content |
| Assets | `evo::partials.assets` | evo-ui | none |
| Icons | `x-evo::icon` | evo-ui | Tabler icon name |
| Buttons | `x-evo::button`, `.evo-ui-btn` | evo-ui | label, icon, tone, variant |
| Row actions | `.evo-ui-row-action` | evo-ui | action type, icon, label, handler |
| Module tabs | `x-evo::module-tab-shell`, `x-evo::module-tabs`, `x-evo::nav-tabs` | evo-ui | tab config, active key, dirty guard |
| Forms | `evo-ui.form`, `x-evo::form` | evo-ui | form preset |
| Fields | `x-evo::form.field` and modal fields | evo-ui | field config |
| Tables | `evo-ui.module-table` | evo-ui | table preset and provider |
| Modals | `x-evo::modal`, table form/delete modals | evo-ui | open state, title, actions |
| Badges/chips | `x-evo::badge`, `.evo-ui-chip` | evo-ui | label, tone, color |
| Alerts | `.evo-ui-alert` | evo-ui | tone, message |
| Cards/surfaces | `x-evo::card`, `.evo-ui-surface` | evo-ui | content only |
| Builders/reorder | `x-evo::builder`, `x-evo::builder-row`, `x-evo::reorder-rail` | evo-ui | row ids, labels, Livewire reorder method |
| Issue workspace | `evo-ui.issue-workspace` | evo-ui | provider and workspace preset |
| Runtime helpers | `window.EvoUI.*` | evo-ui | data attributes/config only |

## Manager Shell

Use `x-evo::layout` for full evo-ui manager screens:

```blade
<x-evo::layout :title="$pageTitle">
    <livewire:vendor.module-panel :active-tab="$activeTab" />
</x-evo::layout>
```

Parameters:

| Parameter | Type | Required | Notes |
| --- | --- | --- | --- |
| `title` | string | yes | Browser title and manager document title. |
| slot | HTML | yes | The manager screen body. |

The layout applies theme classes, exposes `data-evo-ui-root`, sets color-scheme
metadata and includes local evo-ui assets. Transitional shells may include
`evo::partials.assets`, but new full screens should use the layout component.

Never load Bootstrap, jQuery, Roboto, manager `styles.min.css`, `main.js`,
`tabpane.js` or CDN UI assets inside an evo-ui-owned screen.

## Icons

Use `x-evo::icon` for all standard icons:

```blade
<x-evo::icon name="settings" />
<x-evo::icon name="tabler-layout-dashboard" />
<x-evo::icon name="o-check" />
```

Parameters:

| Parameter | Type | Required | Notes |
| --- | --- | --- | --- |
| `name` | string | yes | `settings`, `tabler-settings` and `o-settings` all resolve to Tabler. |
| `class` | string | no | Extra class for sizing or placement. Prefer evo-ui classes. |

Consumers should expose manager menu icons through translation/config metadata
such as `module_icon`. Do not hardcode Font Awesome menu HTML in new modules.

## Buttons

Use the shared button system for every command. A Save button should look the
same in every module:

```blade
<x-evo::button
    type="submit"
    icon="check"
    tone="primary"
    variant="filled"
    :label="__('evo::global.action_save')"
/>
```

Parameters:

| Parameter | Type | Default | Notes |
| --- | --- | --- | --- |
| `type` | string | `button` | Use `submit` for form save. |
| `label` | string | empty | Required for accessible icon-only buttons too. |
| `icon` | string|null | null | Tabler icon name. |
| `tone` | string | `default` | `default`, `primary`, `success`, `info`, `warning`, `danger`. |
| `variant` | string | `plain` | `plain`, `filled`, `ghost` depending on component support. |
| `icon-only` | bool | false | Dense toolbar/action buttons only. |
| `disabled` | bool | false | Use real disabled state, not visual-only classes. |

Rules:

- Save uses `icon="check"`, `tone="primary"`, `variant="filled"` and
  `evo::global.action_save`.
- Add uses `icon="plus"` and usually `tone="success"`.
- Edit uses `icon="edit"` and usually `tone="primary"`.
- Duplicate/copy uses `copy` or `copy-plus` and usually `tone="info"`.
- Delete uses `icon="trash"` and `tone="danger"`.
- Cancel/discard use default buttons unless the action is destructive.
- Do not create module-specific button colors for common commands.

## Row Actions

Use `.evo-ui-row-actions` and `.evo-ui-row-action` for dense table/list/builder
actions:

```blade
<div class="evo-ui-row-actions">
    <button type="button" class="evo-ui-row-action evo-ui-row-action--primary">
        <x-evo::icon name="edit" />
    </button>
</div>
```

Supported tones:

- `evo-ui-row-action--primary`
- `evo-ui-row-action--success`
- `evo-ui-row-action--info`
- `evo-ui-row-action--warning`
- `evo-ui-row-action--danger`

Every row action needs a `title` and `aria-label`. Consumers provide handlers;
evo-ui owns spacing, color, icon size, hover/focus and disabled states.

## DnD And Reorder

Use the [DnD And Reorder Contract](dnd-reorder-contract.md) and
[DnD Implementation Guide](dnd-implementation-guide.md) for tabs/blocks, nested
rows, modal option rows and reorderable tables. Consumers declare stable UIDs
and Livewire methods; evo-ui owns the rail, handle, placeholder, drag runtime,
mobile constraints and table/list visual standard.

Shared classes:

- `.evo-ui-dnd` for the runtime root.
- `.evo-ui-dnd-list` and `.evo-ui-dnd-option-list` for reorder containers.
- `.evo-ui-dnd-row`, `.evo-ui-dnd-group-row` and `.evo-ui-dnd-option-row` for
  compact rows.
- `.evo-ui-dnd-rail` or `x-evo::reorder-rail` for up/handle/down controls.
- `.evo-ui-dnd-chip`, `.evo-ui-dnd-key` and `.evo-ui-dnd-badge` for row
  metadata.
- `.evo-ui-dnd-actions` or `.evo-ui-row-actions--compact` for compact action
  clusters.

Modal option rows should use the dedicated components:

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

## Module Tabs

Use `x-evo::module-tab-shell` for top-level manager sections when the screen
contains forms or other dirty-state surfaces:

```blade
<x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
    @if($activeTab === 'items')
        <livewire:evo-ui.module-table preset="vendor.module.items" />
    @elseif($activeTab === 'settings')
        <livewire:evo-ui.form preset="vendor.module.settings" />
    @endif
</x-evo::module-tab-shell>
```

Parameters:

| Parameter | Type | Default | Notes |
| --- | --- | --- | --- |
| `tabs` | array | `[]` | Module tab config. Supports `key`, `argument`, `label`, `icon`, `permission`, `hidden` and `data`. |
| `model` | string | `activeTab` | Livewire property entangled with the selected tab. |
| `label` | string|null | null | Accessible label for the tablist. |
| `panelClass` | string | empty | Extra classes for the tab content wrapper. |
| `surface` | bool | true | Wrap slot content in `evo-ui-surface`. |

The shell owns active tab markup, the shared unsaved-changes prompt and the
`EvoUI.form` save/wait-for-clean navigation bridge. Consumers should not copy
`pendingTab`, `showUnsavedPrompt`, `saveAndSwitch` or modal footer markup into
module panels.

Use `x-evo::module-tabs` only as the lower-level tabbar atom for screens that
already own a compatible navigation shell:

```blade
<x-evo::module-tabs :items="$tabs" :active="$activeTab" />
```

Tab item contract:

```php
[
    'key' => 'settings',
    'label' => 'global.settings_config',
    'icon' => 'settings',
    'href' => $moduleUrl . '&get=settings',
]
```

Rules:

- Module tabs switch manager sections, not table filters.
- Use icons from `x-evo::icon`.
- Dirty form navigation must use `x-evo::module-tab-shell` or the shared
  `EvoUI.form` dirty-state contract.
- Do not duplicate tab height, active state, icon alignment or unsaved modal CSS
  in consumers.
- dDocs is a documented exception: it uses a sidebar/tree and document viewer UX
  without upper module tabs. Do not force `x-evo::module-tabs` into dDocs.

## Forms

Use `evo-ui.form` for declarative settings, model and resource-like forms:

```blade
<livewire:evo-ui.form preset="vendor.module.settings" />
```

Preset keys live under `evo-ui.forms.*`:

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'source' => ['type' => 'config', 'file' => 'vendor/module/settings.php'],
    'tabs' => [],
    'sections' => [],
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

Common form parameters:

| Key | Type | Notes |
| --- | --- | --- |
| `key` | string | Stable form identity. |
| `variant` | string | `config`, `model`, `resource` or module-supported variant. |
| `source` | array | The persistence source; module owns semantics. |
| `tabs` | array | Optional form-level tabs. |
| `sections` | array | Groups of fields. |
| `fields` | array | Field definitions inside sections. |
| `actions` | array | Use standard save/cancel/reset actions. |
| `layout` | string | Optional named layout variant. Generic variants belong in evo-ui. |
| `density` | string | `default` or `compact`. Use `compact` for dense operational settings. |
| `show_heading` | bool | Set `false` to keep the shared action toolbar without a visible heading. |

Dirty state:

- Forms expose `data-evo-form`.
- Dirty state is reflected with `data-evo-form-dirty`.
- Saves dispatch `evo-ui:form.saving` and `evo-ui:form.saved`.
- Navigation guards should call `window.EvoUI.form.isDirty()` and
  `window.EvoUI.form.waitForClean()`.

Compact settings forms:

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'density' => 'compact',
    'layout' => 'settings',
    'show_heading' => false,
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

The default Save action is a visible text button with `icon="check"`,
`tone="primary"` and `variant="filled"`. Consumers should not create local Save
button styles for settings screens.

Use `x-evo::settings-row` when a module renders custom settings values instead
of `evo-ui.form` field configs:

```blade
<div class="evo-ui-settings-values">
    <x-evo::settings-row
        :label="$label"
        :for="$inputId"
        :usage="$usage"
        :description="$description"
    >
        <input id="{{ $inputId }}" class="evo-ui-input" wire:model="data.site_name">
    </x-evo::settings-row>

    <x-evo::settings-row :label="$sectionLabel" divider />
</div>
```

`evo-ui` owns the two-column desktop grid, right-aligned labels, usage code chip,
description placement, option stacks, media field rows, image previews and mobile
single-column fallback. The consumer owns values, option lists and persistence.

## Fields

Field config belongs in the consuming module. Rendering belongs in `evo-ui`.

Common field keys:

| Key | Type | Notes |
| --- | --- | --- |
| `name` | string | Stored field key. |
| `type` | string | Field renderer type. |
| `label` | string | Translation key or label. |
| `help` | string|null | Helper text. |
| `default` | mixed | Default value. |
| `rules` | array | Validation metadata. |
| `span` | string|null | Layout hint such as `compact` or `wide`. |
| `options` | array | Static options. |
| `options_source` | array | Built-in option source. |
| `options_provider` | string | Provider method for dynamic options. |
| `save` | bool | `false` for display-only fields. |

Supported form/modal vocabulary includes:

- `text`
- `number`
- `textarea`
- `checkbox`
- `select`
- `radio`
- `multi-checkbox`
- `choices`
- `csv`
- `datetime-local`
- `color-picker`
- `alias`
- `image`
- `file`
- `editor`
- `display`
- `resource-parent`
- `config-map`
- `repeater`
- `builder`
- custom views registered through `EvoUI::registerFormField()`

If a field needs a new reusable visual behavior, add the behavior to evo-ui and
only keep the domain-specific value meaning in the consumer.

## Tables And Lists

Use `evo-ui.module-table` for provider-backed manager tables:

```blade
<livewire:evo-ui.module-table
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

Preset keys:

| Key | Type | Notes |
| --- | --- | --- |
| `key` | string | Stable table identity. |
| `provider` | class-string | Module-owned data provider. |
| `columns` | array | Declarative column config. |
| `filters` | array | Declarative filters. |
| `row_actions` | array | Standard action config. |
| `toolbar_actions` | array | Standard toolbar commands. |
| `views` | array | Usually `table` and/or `list`. |
| `default_view` | string | Initial view. |
| `search` | array | Search state contract. |
| `per_page` | int | Initial page size. |
| `per_page_options` | array | Allowed page sizes. |
| `default_sort` | string|null | Initial sort. |
| `default_direction` | string | `asc` or `desc`. |

`evo-ui` owns table/list parity, filters, search, sorting, pagination, inline
editing, modal metadata, delete modal, row action rendering and session state.
Providers own queries, permissions, labels, rows, options and persistence.

## Cell Types

Supported module table cells:

- `text`
- `link`
- `image`
- `chips`
- `badge`
- `icon`
- `date`
- `boolean`
- `status`
- `actions`

Example:

```php
[
    'key' => 'status',
    'label' => 'Status',
    'type' => 'badge',
    'sortable' => true,
]
```

Do not render raw HTML cells for common badges, chips, images or icons when a
typed cell exists.

## Filters

Use declarative filters:

```php
[
    'key' => 'status',
    'type' => 'multi-select',
    'label' => 'Status',
    'options_provider' => 'statusOptions',
]
```

Supported filter types:

- `multi-select`
- `select`
- `segmented`
- `toggle`
- `date-range`

Filter UI, summary chips, apply/reset controls and URL/session state belong to
`evo-ui`. Option values and filtering semantics belong to the provider.

## Modals

Use `x-evo::modal` for custom dialogs and table modal config for CRUD:

```blade
<x-evo::modal :open="$open" title="Edit" icon="edit">
    <div class="evo-ui-modal__body">...</div>
    <footer class="evo-ui-modal__footer">...</footer>
</x-evo::modal>
```

Modal shell ownership:

- backdrop;
- header/title/icon;
- close button;
- body spacing and scrolling;
- footer alignment;
- small/default/wide sizing;
- keyboard/escape behavior when supported by the surface.

Consumers own the action methods and saved data.

## Badges, Chips And Status Markers

Use `x-evo::badge`, `.evo-ui-badge`, `.evo-ui-chip` and typed table cells.

Rules:

- Semantic colors use evo-ui tokens.
- Dynamic colors use CSS custom properties such as `--evo-ui-badge-color`.
- Do not create new yellow/green/red badge systems in consumers.
- If a taxonomy color is user-managed, the consumer stores the value and
  `evo-ui` renders the badge/chip.

## Alerts And Empty States

Use `.evo-ui-alert` for validation, permission and runtime messages:

```blade
<div class="evo-ui-alert evo-ui-alert--danger">
    @lang('vendor::global.not_writable')
</div>
```

Supported tones:

- `info`
- `success`
- `warning`
- `danger`

Use `.evo-ui-empty` for empty tables, forms or panels. Consumers provide the
message; `evo-ui` owns spacing, typography and tone.

## Cards And Surfaces

Use `x-evo::card` and `.evo-ui-surface` for framed manager content. Use cards
for repeated items or genuinely framed tools, not for nesting whole page sections
inside other cards.

Guidelines:

- cards should use evo-ui border radius and tokenized colors;
- avoid module-specific card CSS for common dashboard/stat/list items;
- repeated dashboard cards should become a shared primitive when used by more
  than one module.

## Dashboard Cards

Use `x-evo::dashboard` and `x-evo::dashboard-card` for module dashboard widgets
that sit above tables or other operational surfaces. The dashboard primitive
owns card wrapping, span widths, responsive fallback and the standard divider
spacing before the following content.

Declarative card config:

```blade
<x-evo::dashboard
    :cards="[
        [
            'title' => 'sSeo::global.pages_in_sitemap',
            'icon' => 'list',
            'span' => 6,
            'stats' => [
                ['value' => 51, 'label' => 'sSeo::global.sitemap_ready'],
            ],
            'badges' => [
                ['label' => 'sSeo::global.sitemap_ready', 'color' => '#16A34A'],
            ],
            'meta' => [
                ['label' => 'sSeo::global.last_generated', 'value' => '8 May 2026', 'strong' => true],
                ['value' => '/path/to/sitemap.xml'],
            ],
        ],
    ]"
>
    <x-slot:body>
        <livewire:evo-ui.module-table preset="vendor.module.activity" />
    </x-slot:body>
</x-evo::dashboard>
```

Slot-based cards are also supported:

```blade
<x-evo::dashboard>
    <x-evo::dashboard-card title="sSeo::global.pages_in_sitemap" icon="list" span="6">
        <span class="evo-ui-card__label">/path/to/sitemap.xml</span>
    </x-evo::dashboard-card>

    <x-slot:body>
        <x-evo::table.livewire preset="sseo.activity" />
    </x-slot:body>
</x-evo::dashboard>
```

Rules:

- `span="6"` means half-width on desktop manager viewports and full width on
  narrow screens.
- Supported spans are `3`, `4`, `6`, `8` and `12`.
- Keep dashboard data preparation in the consumer module.
- Do not create module-local `.module-dashboard-card--span-6` CSS for shared
  width behavior.
- Use the default divided card group when a table follows the cards.

## Builders And Reorder

Use builder primitives for compact configurable lists, schema builders and other
manager rows that need move buttons plus drag/drop:

```blade
<x-evo::builder reorder-method="reorderFields">
    <div class="evo-ui-builder-list" data-evo-builder-list="fields">
        <x-evo::builder-row :id="$field['_uid']" type="field" :title="$fieldLabel" :chip="$fieldType">
            <x-slot:rail>
                <x-evo::reorder-rail
                    move-up="moveFieldStep({{ $index }}, -1)"
                    move-down="moveFieldStep({{ $index }}, 1)"
                    :up-disabled="$index === 0"
                    :down-disabled="$index === $last"
                />
            </x-slot:rail>

            <div class="evo-ui-row-actions">...</div>
        </x-evo::builder-row>
    </div>
</x-evo::builder>
```

Runtime contract:

- `data-evo-builder` initializes `window.EvoUI.initBuilder()`.
- `data-evo-builder-list` scopes a reorderable list.
- `data-evo-builder-row` marks a draggable row.
- `data-evo-drag-handle` limits drag start to the shared handle.
- `data-evo-builder-reorder-method` names the Livewire method called on drop.
- `window.EvoUI.builderPayload(root)` returns list keys, parent ids and ordered
  item ids.

`evo-ui` owns row density, reorder rail styling, drag handle, placeholder,
drag-over/dragging states, fallback up/down buttons, row action palette, chips
and modal shell hooks. Consumers own schema semantics, validation, edit fields,
provider methods and persistence.

## Issue Workspace

Use `evo-ui.issue-workspace` for provider-backed workflow workspaces:

```blade
<livewire:evo-ui.issue-workspace
    preset="dissues.issues"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

`evo-ui` owns:

- list/kanban display modes;
- workspace toolbar and filters;
- selected issue preview;
- comment/reply UI contract;
- native kanban drag/drop mechanics;
- session state;
- issue cards, chips, compact typography and visual density.

The provider owns issue rows, taxonomy, workflow transitions, comments,
permissions, archive behavior, external sync and persistence.

## Editor And Media Helpers

Use the shared runtime helpers for common fields:

- `window.EvoUI.syncRichEditors(form, wire)`
- `window.EvoUI.initRichEditorField(root)`
- `window.EvoUI.browseMediaField(inputId, mode)`
- `window.EvoUI.browseImageField(inputId)`
- `window.EvoUI.form.isDirty()`
- `window.EvoUI.form.waitForClean(callback)`

The full editor/media lifecycle is documented in
[Editor Media Adapter Contract](editor-media-adapter-contract.md).

Consumers may choose an editor profile or own domain-specific editor content.
Common editor lifecycle, media selection and dirty-state sync belong to `evo-ui`
or to a documented editor adapter such as `dTui-editor`.

## Embedded Resource Screens

Evolution resource edit tabs are a special boundary. `sLang` multilingual
resource tabs and `sSeo` resource/product SEO fields may need manager globals,
`documentDirty`, TinyMCE/CodeMirror and legacy form contracts.

The full boundary lives in [Embedded Resource Contract](embedded-resource-contract.md).
Use that contract before changing resource edit tabs.

Rules:

- embedded resource screens must not load a full `x-evo::layout` shell;
- they should not load full evo-ui module assets unless the contract explicitly
  allows it;
- they should not expose `data-evo-ui-root`;
- they may use `data-evo-resource-embedded` to mark the exception explicitly;
- local bridge CSS/JS must stay scoped and documented;
- common embedded buttons, fields, dirty markers and editor sync should move to
  evo-ui when they are reused.

## dDocs Workspace Exception

dDocs intentionally uses a documentation workspace: sidebar/tree navigation,
document viewer, breadcrumbs and edit/view modes. It does not use the standard
upper module tab UX.

Reusable pieces from dDocs should be promoted carefully:

- tree row shell;
- viewer surface;
- code copy controls;
- empty/loading/error states;
- editor asset hooks.

dDocs keeps documentation storage, source registry, Markdown safety and authoring
semantics local.

## Anti-Drift Rules

New consumer code should not introduce:

- local CSS for standard buttons, tabs, forms, fields, tables, modals, badges,
  cards or issue workspace primitives;
- inline `<style>` for common evo-ui components;
- large inline `<script>` blocks for shared dirty-state, DnD, modal, editor,
  picker or table behavior;
- Bootstrap/CDN/jQuery/legacy manager assets in evo-ui-owned screens;
- duplicated Save button markup or custom Save button colors;
- raw HTML table cells for supported typed cell behavior.

Allowed local code:

- provider methods and business actions;
- domain-specific algorithms and persistence;
- config preset declarations;
- localized labels;
- temporary scoped bridge code with a visible follow-up task.

When in doubt, add a new `evo-ui` primitive or document an explicit boundary
before copying code from a consumer.
