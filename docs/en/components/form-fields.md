# Form And Field Catalogue

`evo-ui.form` renders declarative manager forms. Use it for module settings,
model-backed editors and resource-like forms. Table modal fields use the same
field vocabulary where possible, while the table provider owns modal defaults
and persistence.

For the human-facing component contract, anatomy, presets, dirty state, settings
rows and anti-drift rules, start with [Form Component](form.md). This document is
the field catalogue and source behavior reference.

Runtime/server markers that must stay documented include `FieldCatalog`,
`form/field.blade.php`, `config-map`, `resource-parent`, `color-picker` and
`editor`.

## Form Sources

### Config Form

Use config forms for module settings stored in PHP config files:

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'source' => [
        'type' => 'config',
        'file' => 'vendor/module/settings.php',
    ],
    'sections' => [
        [
            'key' => 'general',
            'fields' => [
                ['name' => 'enabled', 'type' => 'checkbox', 'label' => 'Enabled'],
            ],
        ],
    ],
];
```

The config form service loads the file, casts values by field type, skips fields
with `save => false`, and writes the resulting PHP config array.

### Model Form

Use model forms when the source is an Eloquent-style model owned by the module:

```php
'source' => [
    'type' => 'model',
    'class' => Vendor\Module\Models\Item::class,
],
```

The module owns the model, fillable rules and persistence semantics.

### Resource Form

Use resource forms for resource-like screens where fields map to Evolution
resource fields, template variables or translated resource values:

```php
'source' => [
    'type' => 'resource',
    'class' => EvolutionCMS\Models\SiteContent::class,
],
```

`evo-ui` provides layout, field casting and language/TV bridges. The consuming
module owns which resource fields and TVs are exposed.

## Sections, Tabs And Actions

```php
'tabs' => [
    ['name' => 'general', 'label' => 'global.settings_config', 'icon' => 'settings'],
],
'sections' => [
    [
        'key' => 'general',
        'tab' => 'general',
        'title' => 'VendorModule::global.general',
        'fields' => [],
    ],
],
'actions' => [
    ['type' => 'save', 'label' => 'evo::global.action_save'],
],
```

Default Save actions render as the shared visible primary filled button with a
check icon. Override only when a workflow genuinely needs a different command.

Compact operational forms may opt into the shared dense settings contract:

```php
'density' => 'compact',
'layout' => 'settings',
'show_heading' => false,
```

`layout => settings` is the canonical compact manager settings layout. It owns
the two-column label/control alignment, section spacing, compact card headers
and mobile fallback, so consumers should not scope CSS to their form ids for
those concerns.

Code-like file editors that are enhanced by CodeMirror should use the shared
field class instead of module-local editor CSS:

```blade
<label class="evo-ui-field evo-ui-field--full evo-ui-field--no-label evo-ui-code-editor-field">
    <textarea class="evo-ui-input evo-ui-textarea evo-ui-textarea--code"></textarea>
</label>
```

When a module must render settings rows manually, use `x-evo::settings-row` and
the `evo-ui-settings-values` wrapper instead of module-local row CSS:

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

`x-evo::settings-row` supports divider rows, usage code, description placement,
right-aligned desktop labels and mobile single-column fallback. Consumers keep
field semantics, options and persistence local.

Fields may include `rules`, `default`, `help`, `span`, `tab`, `section`,
`options`, `options_source`, `options_provider`, `save => false` and custom
view metadata.

## Field Types

### text

```php
['name' => 'title', 'type' => 'text', 'label' => 'Title', 'rules' => ['required', 'string']]
```

Stored as a string.

### number

```php
['name' => 'per_page', 'type' => 'number', 'label' => 'Per page', 'rules' => ['integer', 'min:1']]
```

Stored as a numeric value after validation. The module should still enforce
domain limits in its provider or model.

### textarea

```php
['name' => 'description', 'type' => 'textarea', 'rows' => 4, 'label' => 'Description']
```

Stored as a string. Use `editor` for rich HTML content.

### checkbox

```php
['name' => 'enabled', 'type' => 'checkbox', 'label' => 'Enabled', 'rules' => ['boolean']]
```

Casts truthy form values to a boolean-like value for storage.

### select

```php
[
    'name' => 'default_editor',
    'type' => 'select',
    'label' => 'Editor',
    'options_source' => ['type' => 'rich_text_editors', 'system_value' => 'system'],
]
```

Options may be static or provided by a source/provider. Select values are stored
as the selected scalar unless the field explicitly allows arrays.

### radio

```php
[
    'name' => 'gender',
    'type' => 'radio',
    'options' => [
        ['value' => 'man', 'label' => 'Man', 'icon' => 'gender-male'],
        ['value' => 'woman', 'label' => 'Woman', 'icon' => 'gender-female'],
    ],
]
```

Use radio for a small fixed set of mutually exclusive options.

### multi-checkbox

```php
['name' => 'features', 'type' => 'multi-checkbox', 'options' => $options]
```

Stores an array of selected values.

### choices

```php
[
    'name' => 'tag_ids',
    'type' => 'choices',
    'multiple' => true,
    'searchable' => true,
    'clearable' => true,
    'options_provider' => 'modalOptionsForField',
]
```

Use choices for compact relation picking. Single choices store one value;
multiple choices store an array. The provider owns option lists and relation
meaning.

### csv

```php
['name' => 'ignored_templates', 'type' => 'csv', 'label' => 'Ignored templates']
```

Renders a comma-separated text field and stores a trimmed array. This is useful
for config values that are easier to edit as text but should be read as lists.

### datetime-local

```php
['name' => 'published_at', 'type' => 'datetime-local', 'label' => 'Published at']
```

Casts date/time input to the configured storage value. The module should decide
whether the stored value is a timestamp, string or nullable field.

### color-picker

```php
[
    'name' => 'color',
    'type' => 'color-picker',
    'default' => '#64748B',
    'rules' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
]
```

Use for user-managed hex colors such as dIssues taxonomy colors. `evo-ui`
renders the input, picker and swatch; the module validates allowed color values.

### alias

```php
['name' => 'alias', 'type' => 'alias', 'source' => ['name']]
```

Generates an alias from source fields until the user edits the alias manually.
The provider/model must still enforce uniqueness.

### image

```php
['name' => 'cover', 'type' => 'image', 'label' => 'Cover image']
```

Uses the Evolution manager media browser through evo-ui JS helpers and updates
the form state after selection.

### file

```php
['name' => 'download', 'type' => 'file', 'label' => 'File']
```

Uses the same picker pattern as image fields but does not imply image preview
semantics.

### editor

```php
[
    'name' => 'introtext',
    'type' => 'editor',
    'height' => '260px',
    'editor_switcher' => false,
    'editor' => $configuredEditor,
]
```

`evo-ui` initializes the Evolution rich editor and syncs editor content before
save. The module decides which editor setting is used.

### config-map

```php
[
    'name' => 'types',
    'type' => 'config-map',
    'key_field' => 'key',
    'fields' => [
        ['name' => 'name', 'type' => 'text', 'label' => 'Name'],
        ['name' => 'enabled', 'type' => 'checkbox', 'label' => 'Enabled'],
    ],
]
```

Use for editable keyed config arrays such as sArticles publication types.
`evo-ui` handles adding/removing rows, unique keys and display casting. The
module owns default values and any delete guard.

### resource-parent

```php
['name' => 'parent', 'type' => 'resource-parent', 'label' => 'Parent resource']
```

Uses the Evolution resource picker and rejects obvious parent loops. The module
owns final resource save rules.

### repeater

```php
[
    'name' => 'answers',
    'type' => 'repeater',
    'default_item' => ['answer' => '', 'votes' => 0],
    'fields' => [
        ['name' => 'answer', 'type' => 'text', 'label' => 'Answer'],
        ['name' => 'votes', 'type' => 'number', 'label' => 'Votes'],
    ],
]
```

Use for small nested arrays inside a modal or form.

### builder

```php
[
    'name' => 'content_builder',
    'type' => 'builder',
    'blocks_provider' => 'articleBuilderBlocks',
    'rules' => ['array'],
]
```

Use for module-owned structured content. `evo-ui` may render generic builder
controls, but block semantics and frontend rendering stay in the consumer.

### display

```php
['name' => 'server_protocol', 'type' => 'display', 'save' => false]
```

Display-only fields are not persisted when `save => false`.

### custom fields

Register a custom field view when a module needs a reusable local extension:

```php
app(\EvoUI\EvoUI::class)->registerFormField(
    'sseo-server-protocol',
    'sSeo::components.form.server-protocol'
);
```

Custom fields must still follow evo-ui spacing, labels, help and validation
patterns. Promote a custom field into evo-ui only after it is useful for more
than one module.

## Dirty State Events

Forms track dirty state by comparing current data to the last clean snapshot.
Shared events:

- `evo-ui:form.saving`
- `evo-ui:form.saved`
- `evo-ui:form.reset`
- `evo-ui:resource-parent.selected`
- `evo-ui:resource-parent.rejected`

Module panels should listen for these events instead of inventing their own
dirty-state protocol.

## Consumer References

- `sArticles`: config-map, choices, rich editor, image/file and builder fields.
- `dIssues`: color-picker, settings forms and issue body editor.
- `sLang`: choices and dirty-state settings flow.
- `sSeo`: custom field registration, analytics/settings forms and resource SEO
  field styling.
