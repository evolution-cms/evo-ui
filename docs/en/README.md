# evo-ui

evo-ui is the shared Livewire + DaisyUI UI foundation for Evolution CMS manager
modules.

It is used by `sArticles`, `dIssues`, `sLang`, `sSeo`, and `dDocs` as the
canonical manager UI layer. Consumer modules describe tabs, tables, forms,
workspaces, fields, providers, and persistence rules declaratively; evo-ui owns
the shared shell, components, state behavior, theme bridge, and local assets.

## When To Use

Use evo-ui when a module needs a manager screen, settings form, table/list CRUD,
resource-like editor, issue workspace, or a shared visual primitive. Keep
business rules, data ownership, provider semantics, and module-specific
workflow decisions in the consuming package.

## Main Features

- Manager iframe layout with local assets.
- Evolution manager theme sync.
- Livewire 4 bridge for manager routes, CSRF and sessions.
- Config-driven tables with filters, search, sorting, pagination, table/list
  view, inline edit, modal edit, row actions and drag reorder.
- Config-driven forms for settings and resource-like editors.
- Provider-backed issue workspace for kanban/list workflows.
- Shared components for buttons, icons, tabs, modals, badges, cards, choices,
  image/file fields and rich editors.
- Current UI state persistence in the manager session.

## Common Workflows

- Build a module shell with `x-evo::layout`, `evo::partials.assets`, module
  tabs, and Livewire components.
- Define table/list surfaces through `evo-ui.module-table` presets.
- Define settings and model forms through `evo-ui.form` presets.
- Reuse issue workspace contracts for provider-backed list/kanban workflows.
- Add new shared UI behavior first as a documented contract, then as package
  tests, and only then consume it from modules.

## Example

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tabs :items="$tabs" :active="$activeTab" />

    <livewire:evo-ui.module-table
        preset="vendor.module.items"
        :context="['moduleUrl' => $moduleUrl]"
    />
</x-evo::layout>
```

## Developer Entry Points

- [User Guide](user-guide.md)
- [Developer Guide](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Module Integration](../module-integration.md)
- [Components](../components.md)
- [Form And Field Catalogue](../forms.md)
- [Module Table Contract](../module-table-contract.md)
- [Issue Workspace Contract](../issue-workspace-contract.md)
- [Testing Matrix](../testing.md)
- [Consumers](../consumers.md)
- [Release Checklist](../release-checklist.md)
- [dDocs Tree/Viewer Notes](../ddocs-tree-viewer-notes.md)
- [Roadmap](../roadmap.md)

## dDocs Rules

- These links intentionally stay inside the package `docs/` tree.
- Localized pages are entrypoints; canonical technical contracts are the linked
  root documents.
- Code examples must use fenced language identifiers so dDocs can highlight
  them predictably.

## Rule Of Thumb

Put shared UI runtime into evo-ui. Keep module-specific business logic in the
module provider.
