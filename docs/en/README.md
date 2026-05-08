# evo-ui

evo-ui is the shared Livewire + DaisyUI UI foundation for Evolution CMS manager
modules.

It is used by `sArticles` and `dIssues` and is designed for future migrations of
`sLang`, `sSeo`, and other manager extras.

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

- [Module Integration](../module-integration.md)
- [Components](../components.md)
- [Module Table Contract](../module-table-contract.md)
- [Consumers](../consumers.md)
- [Release Checklist](../release-checklist.md)
- [Roadmap](../roadmap.md)

## Rule Of Thumb

Put shared UI runtime into evo-ui. Keep module-specific business logic in the
module provider.
