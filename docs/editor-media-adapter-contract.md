# Editor Media Adapter Contract

`evo-ui` provides the shared lifecycle for common manager editor and media
fields. Consumers choose the field type, editor profile and persistence target;
`evo-ui` owns the reusable boot, sync and picker bridges.

## Shared APIs

Runtime helpers:

- `window.EvoUI.initRichEditorField(root)`
- `window.EvoUI.syncRichEditors(form, wire)`
- `window.EvoUI.clearRichEditors(form)`
- `window.EvoUI.browseMediaField(inputId, mode)`
- `window.EvoUI.browseImageField(inputId)`

Server helper:

- `EvoUI\Support\RichTextEditor::html($ids, $height, $editor, $options)`
- `EvoUI\Support\RichTextEditor::configuredEditor($editor, $fallback)`
- `EvoUI\Support\RichTextEditor::registered()`

Field markers:

- `data-evo-rich-editor`
- `data-evo-rich-editor-model`
- `data-evo-media-bridge`

## Rich Text Fields

Use `type => editor` for common rich text fields in forms, modal forms and
workspace composers. The rendered textarea must carry `data-evo-rich-editor`
and `data-evo-rich-editor-model`; save actions must call
`EvoUI.syncRichEditors(...)` before Livewire persistence.

Supported editor families:

- `dTuiEditor` for Markdown/rich manager editors;
- Evolution/TinyMCE adapters through `OnRichTextEditorInit`;
- fallback textarea when no editor is registered.

Consumers may configure the editor name, height, theme and field-specific
options. They should not duplicate generic editor boot/sync code.

## Code Editors

CodeMirror and `window.myCodeMirrors` are allowed when the surface is a genuine
code editor, such as `sSeo` Robots. The consumer may own file-specific safety,
target selection and write validation. Shared expectations:

- save syncs CodeMirror/TinyMCE state into the textarea before persistence;
- dirty state is raised when editor content changes;
- editor assets are local manager assets, not CDN dependencies;
- reusable sync behavior should be promoted to evo-ui if a second consumer needs
  the same CodeMirror lifecycle.

## Media And File Pickers

Use `EvoUI.browseImageField(inputId)` for image fields and
`EvoUI.browseMediaField(inputId, mode)` for image/file fields. The helper owns
the manager media bridge and dispatches `input`/`change` events so Livewire state
updates.

Common modes:

- `images`
- `files`

Consumers own storage paths, validation and whether a preview is shown.

## Specialized Workspaces

`dDocs` owns its Markdown viewer/editor workspace for now because it combines
tree navigation, Markdown preprocessing, UML rendering, Prism highlighting and
dTui/TOAST UI viewer behavior. `evo-ui` may later promote generic Markdown
viewer or editor primitives, but that requires a separate contract and consumer
adoption task.

`sSeo` Robots owns its file editor lifecycle for now because it writes
site-specific robots.txt targets and needs CodeMirror file safety. It must still
reuse evo-ui buttons, form toolbar atoms and dirty-state conventions where
possible.

## Anti-Drift Rules

Do not add module-local editor boot code for ordinary rich text, image or file
fields. Add or extend an evo-ui helper first.

Do not load remote editor/media assets for evo-ui-owned manager screens.

Do not bypass `EvoUI.syncRichEditors` before saving a form that contains
`data-evo-rich-editor`.

Do not use consumer-specific globals such as `data-ddocs-editor` or
`data-sseo-robots-editor` as generic evo-ui contracts unless a follow-up task
promotes them explicitly.
