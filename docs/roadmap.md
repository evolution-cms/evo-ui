# evo-ui Base Roadmap

This is the small base backlog before migrating `sLang`, `sSeo`, and more
manager extras onto evo-ui.

## Keep In evo-ui

- Generic manager shell, theme sync and Livewire bridge.
- Tables, lists, filters, sorting, pagination, state persistence and row actions.
- Config/resource forms.
- Modals and confirmation dialogs.
- Choices/select primitives inspired by Mary UI: compact chips, optional search,
  optional clear/cancel controls, and server-backed options.
- Rich editor abstraction that can use the Evolution system editor or a module
  setting.
- Image/file picker fields backed by Evolution manager browser integration.
- Workspace primitives that are generic enough for dashboards, boards and issue
  lists.

## Keep In Consuming Modules

- Domain-specific data providers.
- Module-specific save/delete/duplicate hooks.
- sArticles article content builder schema.
- sSeo field mapping and metadata rules.
- sLang translation sync rules.
- dIssues provider actions and external GitHub/GitLab sync.

## Useful Additions After First Release

- Toast/alert feedback surface for save/delete errors and success states.
- Skeleton loading states for dense tables and workspaces.
- Drawer/sidebar primitive for future inspector-style modules.
- Stats/cards primitive for dashboards and read-only metadata blocks.
- A stricter PHP config schema validator for table/form presets.
- Optional persisted user preferences beyond the current session.
- Browser smoke scripts for common manager flows.

## External UI Notes

- Livewire 4 supports URL-bound state and session-bound state. evo-ui currently
  combines URL attributes for shareable table query state with explicit
  server-side session persistence for manager convenience.
- DaisyUI's current component catalogue covers the same broad primitives evo-ui
  keeps internally: buttons, dropdowns, modals, tabs, pagination, alerts,
  skeletons, toast, tooltip, inputs, selects and textareas. The missing evo-ui
  primitives worth adding next are toast/alert, skeleton and drawer.
- Mary UI choices are a good API reference for `single`, `clearable`,
  `searchable`, custom option labels and server-side search. evo-ui should keep
  that direction while preserving Evolution manager styling and Livewire
  provider contracts.

## Design Direction

evo-ui should stay quiet, dense and operational. It should borrow the useful API
ideas from DaisyUI, Mary UI and Livewire, but keep Evolution CMS manager behavior
first: iframe-safe assets, manager theme sync, manager auth/session rules and
module-owned domain logic.
