# Embedded Resource Contract

Evolution resource edit tabs are an explicit evo-ui boundary. They are embedded
inside the core manager resource form, not standalone evo-ui manager screens.

Canonical consumers:

- `sLang` multilingual resource tabs;
- `sSeo` resource/module SEO fields;
- future package tabs that render inside the Evolution resource edit form.

## Ownership

Evolution manager owns:

- the HTML document and outer resource form;
- WebFX tab registration and resource tab ordering;
- resource submit lifecycle and payload names;
- `documentDirty`;
- legacy editor globals such as `tinymce`, `CodeMirror` and `myCodeMirrors`;
- manager pickers for resources, files, images and template variables.

`evo-ui` owns only reusable atoms that can safely live inside that host:

- button/icon/badge visual atoms;
- scoped field/help/error styling when the host already loads it;
- editor/media sync helpers that do not replace the resource form;
- small bridge markers such as `data-evo-resource-embedded`;
- documentation and tests for the exception.

The consuming module owns:

- resource field names and save payloads;
- multilingual mapping and SEO semantics;
- translation/auto-fill actions;
- validation, persistence and compatibility routes;
- scoped bridge JavaScript for legacy manager globals.

## Allowed

Embedded resource tabs may use:

- `documentDirty = true` or equivalent dirty-state bridge;
- TinyMCE/CodeMirror synchronization when the core resource editor owns the
  editor instance;
- legacy resource tab markup required by Evolution manager;
- `x-evo::icon`, `.evo-ui-btn`, `.evo-ui-row-action`, `.evo-ui-badge` and
  similarly small atoms;
- scoped data markers such as `data-slang-resource-action`,
  `data-sseo-resource-fields` and `data-evo-resource-embedded`;
- local bridge CSS/JS when it is scoped to the resource tab and has a follow-up
  task if it becomes reusable.

## Forbidden

Embedded resource tabs must not:

- render `x-evo::layout`;
- include `evo::partials.assets` as a full manager shell;
- expose `data-evo-ui-root`;
- load Bootstrap/CDN/jQuery/manager shell bundles for an evo-ui-owned primitive;
- create a second form around the core resource edit form;
- replace core resource payload names with evo-ui package-owned names;
- copy a module-local button/form/table system for shared behavior.

## Markers

Use clear host markers when a resource surface intentionally uses this boundary:

```blade
<div
    class="vendor-resource-tab"
    data-evo-resource-embedded
    data-evo-resource-owner="vendor-module"
>
    ...
</div>
```

Module-specific markers are allowed for domain actions. Common markers should be
promoted to `evo-ui` only after at least two consumers need the same behavior.

## Migration Rule

If an embedded resource behavior can be expressed as a standalone manager
screen, move it to `x-evo::layout` and normal evo-ui components. If it must
remain inside resource edit, keep it in the embedded boundary and document the
legacy bridge.

When changing `sLang` or `sSeo` resource tabs, keep a consumer test or smoke
that proves the resource tab loads, marks dirty state, syncs editors and submits
the same payload names as before.
