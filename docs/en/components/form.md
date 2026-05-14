# Form Component

`Form` is the canonical EvoUI component for manager settings, config editors,
model-backed editors and resource-like edit screens. Consumers describe fields,
sections, tabs, actions and persistence through a declarative preset. EvoUI owns
the visual surface, labels, controls, action toolbar, dirty state, validation
metadata rendering, field casting, editor/media bridges and save/reset chrome.

Use this guide when building or reviewing forms in `sArticles`, `sSeo`,
`sLang`, `dIssues`, `dGramm`, `sSettings`, `sTask` or any new Evolution CMS
manager module.

This guide documents the form component only. A form may be rendered inside a
modal, but the modal shell is a separate component and is intentionally outside
this document.

## Component Anatomy

Every standard form has the same structure:

1. Form surface: `.evo-ui-form-surface` wraps the whole form and receives
   variant, density and layout classes.
2. Heading: optional icon, title, meta and description. Settings panels may hide
   the heading when the surrounding module tab already provides context.
3. Action toolbar: standard Save, Reset and URL actions. Save is disabled while
   the form is clean and becomes active only after dirty state changes.
4. Optional tabs: internal form tabs split one preset into logical panels.
5. Sections: grouped field blocks, with optional descriptions and column layout.
6. Field rows: `x-evo::form.field` renders labels, controls, help, hints and
   validation text from field config.
7. Dirty-state bridge: the root exposes `data-evo-form` and
   `data-evo-form-dirty` so module tabs can guard navigation.
8. Persistence source: config, model or resource services load, cast, validate
   and save data according to the preset.

Do not build custom settings grids, custom Save buttons, custom label columns or
custom dirty-state protocols in a consumer module. Add the missing primitive to
EvoUI first.

## When To Use

Use `Form` for:

- module settings stored in PHP config files;
- operational config panels such as integrations, analytics and sync settings;
- model-backed edit screens where the module owns the model;
- resource-like forms where fields map to Evolution resource fields, TVs or
  localized resource values;
- compact manager settings pages that need the shared label/control layout.

Do not use `Form` for:

- table/list data browsing; use `Table`;
- table modal shell documentation; use the future modal contract;
- full issue kanban/list workspaces; use `evo-ui.issue-workspace`;
- complex nested DnD builders when a shared DnD primitive is more precise;
- public site content output;
- one-off markup that exists only to patch spacing or button styling.

## Rendering Entry Points

Preferred Livewire entrypoint:

```blade
<livewire:evo-ui.form
    preset="vendor.module.settings"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

Typical module view inside the manager shell:

```blade
<x-evo::layout :title="$title">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        <livewire:evo-ui.form
            preset="vendor.module.settings"
            :context="['moduleUrl' => $moduleUrl]"
        />
    </x-evo::module-tab-shell>
</x-evo::layout>
```

The preset resolves from the `evo-ui.forms` config namespace. Consumer service
providers should merge their preset config into that namespace instead of
hardcoding form arrays in Blade.

Example registration shape:

```php
$this->mergeConfigFrom(__DIR__ . '/../config/settings/form.php', 'evo-ui.forms.vendor.module.settings');
```

## Minimal Preset

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'source' => [
        'type' => 'config',
        'file' => 'vendor/module/settings.php',
    ],
    'icon' => 'settings',
    'title' => 'vendor::global.settings',
    'description' => 'vendor::global.settings_help',
    'density' => 'compact',
    'layout' => 'settings',
    'show_heading' => true,
    'tabs' => [],
    'sections' => [
        [
            'key' => 'general',
            'title' => 'vendor::global.general',
            'fields' => [
                [
                    'name' => 'enabled',
                    'type' => 'checkbox',
                    'label' => 'vendor::settings.enabled',
                    'rules' => ['boolean'],
                    'default' => true,
                ],
            ],
        ],
    ],
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
        ['type' => 'reset', 'label' => 'evo::global.action_reset'],
    ],
];
```

## Preset Keys

Required keys:

| Key | Type | Purpose |
| --- | --- | --- |
| `key` | string | Stable form identity used in DOM markers and state. |
| `source` | array | Persistence source definition. |
| `sections` | array | Declarative section and field list. |

Common keys:

| Key | Type | Purpose |
| --- | --- | --- |
| `variant` | string | Visual/behavior variant such as `config`, `model` or `resource`. |
| `icon` | icon name | Heading icon. |
| `title` | translation key|string | Heading title. |
| `description` | translation key|string | Heading description. |
| `meta` | string|array|null | Optional heading metadata. |
| `density` | string | `default` or `compact`. |
| `layout` | string | Layout slug such as `settings`. |
| `show_heading` | bool | Hide the heading when a module shell already supplies context. |
| `tabs` | array | Optional internal form tabs. |
| `section_columns` | int|array|null | Shared section column layout. |
| `actions` | array | Save/reset/url toolbar actions. |
| `fields` | array | Optional flat field list when sections are resolved by helper code. |

## Source Types

### Config Form

Use config forms for module settings stored in PHP config files:

```php
'source' => [
    'type' => 'config',
    'file' => 'vendor/module/settings.php',
],
```

`ConfigFormService` loads the file, applies defaults, casts values by field
type, skips fields with `save => false`, validates configured rules and writes
the resulting PHP config array. The consumer owns config file location,
defaults, domain limits and any side effects after save.

### Model Form

Use model forms when the source is a module-owned model:

```php
'source' => [
    'type' => 'model',
    'class' => Vendor\Module\Models\Item::class,
],
```

EvoUI owns field rendering and form chrome. The consumer owns the model class,
fillable rules, authorization, persistence semantics and business validation.

### Resource Form

Use resource forms for resource-like screens where fields map to Evolution
resource fields, template variables or translated resource values:

```php
'source' => [
    'type' => 'resource',
    'class' => EvolutionCMS\Models\SiteContent::class,
],
```

EvoUI provides the layout, field casting and resource picker bridge. The
consumer owns which fields are exposed and how resource data is finally saved.
Embedded resource tabs must follow the Embedded Resource Contract and must not
render a full manager shell.

## Layouts And Density

Default forms use the normal manager form rhythm. Compact operational settings
should use the shared settings layout:

```php
'density' => 'compact',
'layout' => 'settings',
'show_heading' => false,
```

`layout => 'settings'` owns:

- right-aligned desktop labels;
- single-column mobile fallback;
- control width and spacing;
- section spacing;
- usage code chip placement;
- help and description placement;
- standard Save/Reset toolbar alignment.

Consumers should not scope CSS to their form ids for label alignment, spacing,
input width, Save button style or responsive behavior.

## Tabs And Sections

Internal form tabs are optional. Use them when one form preset has multiple
logical panels but one save/reset lifecycle:

```php
'tabs' => [
    ['name' => 'general', 'label' => 'vendor::tabs.general', 'icon' => 'settings'],
    ['name' => 'advanced', 'label' => 'vendor::tabs.advanced', 'icon' => 'sliders'],
],
```

Sections group fields inside a tab:

```php
'sections' => [
    [
        'key' => 'general',
        'tab' => 'general',
        'title' => 'vendor::settings.general',
        'description' => 'vendor::settings.general_help',
        'fields' => [
            ['name' => 'site_name', 'type' => 'text', 'label' => 'vendor::settings.site_name'],
        ],
    ],
],
```

Use `section_columns` only for real side-by-side settings groups. Do not fake
columns with module-local grids or wrapper CSS.

## Actions

Save action:

```php
['type' => 'save', 'label' => 'evo::global.action_save']
```

Reset action:

```php
['type' => 'reset', 'label' => 'evo::global.action_reset']
```

URL action:

```php
[
    'type' => 'url',
    'label' => 'vendor::settings.open_docs',
    'url' => 'https://example.test/docs',
    'icon' => 'external-link',
]
```

The shared Save action renders the primary filled button with check icon, tracks
loading state and disables itself while the form is clean. Do not create
module-local Save buttons, footer Save bars or special button CSS for normal
forms.

After a successful save, the same Save button keeps the visible Save label so
its width does not change. The short feedback state switches the icon/title and
`aria-label` to `evo::global.form_saved`, then returns to the disabled Save
state. The feedback must stay inside the button; consumers should not create
local saved toasts or banners. For the full button taxonomy, see
[Action Buttons](action-buttons.md).

For staged forms and schema builders, modals may edit a local draft before the
parent form is saved. In that case the modal primary action uses
`evo::global.action_apply`, stays disabled while the modal draft is clean,
applies the draft into the parent form, closes the modal, and marks the parent
form dirty. The parent form Save remains the only persistence action and should
refresh any schema-driven navigation after a successful save.

## Field Contract

Each field is declarative:

```php
[
    'name' => 'title',
    'type' => 'text',
    'label' => 'vendor::fields.title',
    'help' => 'vendor::fields.title_help',
    'rules' => ['required', 'string', 'max:120'],
    'default' => '',
    'span' => 'wide',
]
```

Common field keys:

| Key | Type | Purpose |
| --- | --- | --- |
| `name` | string | Stored field key. |
| `type` | string | Field renderer type. |
| `label` | translation key|string | Visible label. |
| `help` | translation key|string|null | Helper text near the control. |
| `hint` | translation key|string|null | Secondary hint text. |
| `hint_html` | string|null | Trusted HTML hint when a field needs rich help. |
| `rules` | array | Validation metadata. |
| `default` | mixed | Default value when source has no value. |
| `span` | string|null | Layout hint such as `compact`, `wide` or `full`. |
| `show_label` | bool | Hide only when the surrounding field UI supplies the label. |
| `config_key` | string|null | Alternate storage key for config-backed fields. |
| `save` | bool | `false` for display-only or derived fields. |
| `options` | array | Static option list. |
| `options_source` | array | Built-in option source. |
| `options_provider` | string | Provider/service method for dynamic options. |
| `rows` | int | Textarea row count. |
| `size` | string|null | Optional shared size variant. |
| `variant` | string|null | Optional shared visual variant. |
| `view` | string|null | Registered custom field view. |

## Field Types

Supported form and modal field vocabulary:

| Type | Use for | Storage behavior |
| --- | --- | --- |
| `text` | Short strings. | Stored as string. |
| `number` | Numeric settings and ordering values. | Validated/cast by rules and source service. |
| `textarea` | Plain multiline text. | Stored as string. |
| `checkbox` | Boolean toggles. | Cast to boolean-like value. |
| `select` | One value from a list. | Stores selected scalar. |
| `radio` | Small fixed one-of-many choices. | Stores selected scalar. |
| `multi-checkbox` | Small many-of-many choices. | Stores selected array. |
| `choices` | Relation-like single or multiple picker. | Stores scalar or array; provider owns options. |
| `csv` | Text-edited list config. | Stores trimmed array. |
| `datetime-local` | Manager local date/time input. | Consumer decides final timestamp/string/null semantics. |
| `color-picker` | Hex colors and taxonomy colors. | Stores string after validation. |
| `alias` | Slug generated from source fields. | Stores string; provider/model enforces uniqueness. |
| `image` | Image path picked from manager media browser. | Stores selected path. |
| `file` | File path picked from manager media browser. | Stores selected path. |
| `editor` | Rich HTML or configured manager editor content. | Syncs editor content before save. |
| `display` | Read-only/derived values. | Use `save => false` when not persisted. |
| `resource-parent` | Evolution resource parent selection. | Stores selected resource id after bridge checks. |
| `config-map` | Editable keyed config arrays. | Stores normalized keyed array. |
| `repeater` | Small nested arrays. | Stores array. |
| `builder` | Module-owned structured content. | Stores array; consumer owns block semantics. |
| custom view | Shared extension registered through EvoUI. | Must still follow form spacing and label rules. |

For field-level examples, casting notes and custom field registration, see
[Form And Field Catalogue](form-fields.md).

## Settings Row Primitive

When a module must render a dynamic settings panel manually, use
`x-evo::settings-row` instead of custom row CSS:

```blade
<div class="evo-ui-settings-values">
    <x-evo::settings-row
        :label="$fieldLabel"
        :for="$fieldId"
        :usage="$configUsage"
        :description="$fieldDescription"
    >
        <input id="{{ $fieldId }}" class="evo-ui-input" wire:model="data.key">
    </x-evo::settings-row>
</div>
```

Supported props:

| Prop | Purpose |
| --- | --- |
| `label` | Right-aligned desktop label and mobile label text. |
| `for` | Connects the label to the control. |
| `usage` | Shows a shared code chip for placeholders/config keys. |
| `description` | Shared description placement under the control. |
| `divider` | Renders a section divider row. |
| `textarea` | Applies textarea-aware row spacing. |

`x-evo::settings-row` is a bridge primitive for dynamic settings screens. If
the screen can be expressed as a stable preset, prefer `evo-ui.form`.

## Dirty State

Forms track dirty state by comparing current data to the last clean snapshot.
The root form exposes:

- `data-evo-form`;
- `data-evo-form-dirty`;
- `window.EvoUI.form.isDirty()`;
- `window.EvoUI.form.waitForClean()`.

Shared events:

- `evo-ui:form.saving`;
- `evo-ui:form.saved`;
- `evo-ui:form.reset`;
- `evo-ui:form.dirty`;
- `evo-ui:form-dirty` for Alpine listeners that need a modifier-safe event name;
- `evo-ui:resource-parent.selected`;
- `evo-ui:resource-parent.rejected`.

Module tabs should use `x-evo::module-tab-shell` and the shared
`EvoUI.form.waitForClean` bridge. Do not duplicate `pendingTab`,
`showUnsavedPrompt`, `saveAndSwitch` or custom dirty flags in consumer modules.

## Validation And Save

Validation rules belong in field config:

```php
[
    'name' => 'items_per_page',
    'type' => 'number',
    'label' => 'vendor::settings.items_per_page',
    'rules' => ['required', 'integer', 'min:1', 'max:100'],
    'default' => 10,
]
```

Use `save => false` for fields that are visible but not persisted:

```php
['name' => 'server_protocol', 'type' => 'display', 'save' => false]
```

EvoUI handles form validation display, casting and clean snapshot updates after
a successful save. Consumers still own authorization, domain validation,
business side effects and persistence rules that cannot be expressed as generic
field metadata.

## Standalone Form And Modal Boundary

The field vocabulary is shared between standalone forms and table modal forms.
The ownership boundary is different:

| Surface | EvoUI owns | Consumer owns |
| --- | --- | --- |
| Standalone `evo-ui.form` | Surface, sections, actions, dirty state, source save lifecycle. | Preset, fields, source, permissions and business rules. |
| Form inside modal | Field rendering and field atoms. | Modal defaults, submit handler, entity persistence and modal workflow. |

Do not document modal header, footer, sizing or close behavior in form presets.
Those belong to the modal/table contract.

## Canonical Consumer Patterns

- `sArticles`: settings form with `config-map`, choices, editor selection,
  image/file and builder-compatible fields.
- `sSeo`: compact settings and analytics forms, `section_columns`, display-only
  protocol fields and code/editor surfaces that must use shared field classes.
- `dIssues`: settings forms for workflow, artifacts and sync; rich text editor
  option sources and taxonomy color fields.
- `dGramm`: compact bot/integration settings form using the same settings
  density and button contract.
- `sSettings`: dynamic Configure builder uses DnD and `settings-row` donor
  patterns until stable pieces become declarative EvoUI primitives.
- `sLang`: resource-tab and dictionary behavior are embedded/resource
  boundaries, not a full standalone settings form.
- `sTask`: task runner and worker settings should use `evo-ui.form` or
  `x-evo::settings-row` before adding local form CSS.

## Anti-Patterns

- Do not create module-local Save buttons, button colors or footer bars for
  normal forms.
- Do not add module-local CSS for labels, settings rows, field spacing or input
  widths.
- Do not bypass `EvoUI.syncRichEditors` before saving editor fields.
- Do not create a second dirty-state bridge in the consumer.
- Do not load Bootstrap, CDN UI libraries, jQuery UI or legacy manager assets
  inside EvoUI-owned form screens.
- Do not put business workflow logic into EvoUI field renderers.
- Do not promote a custom field into EvoUI until at least two consumers need the
  same visual/behavior contract.

## Review Checklist

- The form uses `evo-ui.form` or `x-evo::settings-row` instead of custom settings
  markup.
- Save, Reset and URL actions use the shared `actions` contract.
- Dirty state clears after successful save and tab navigation uses
  `EvoUI.form.waitForClean`.
- Labels, help, validation and descriptions come from field config.
- Field types use the shared vocabulary from this guide and `form-fields.md`.
- Config/model/resource persistence stays in the consumer source/provider.
- No module-local CSS exists for common form layout, buttons or field rows.
- Modal-specific behavior is not mixed into the form contract.
