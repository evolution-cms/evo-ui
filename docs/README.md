# evo-ui Documentation

evo-ui is the shared Livewire + DaisyUI manager UI foundation for Evolution CMS
extras. It owns the manager iframe document, theme sync, Livewire bridge,
tables, forms, modals, issue workspaces, and local assets.

## Languages

- [English](en/README.md)
- [Українська, Evolution locale `ua`](ua/README.md)
- [Українська, ISO locale `uk`](uk/README.md)
- [Deutsch](de/README.md)
- [Français](fr/README.md)
- [Polski](pl/README.md)
- [Русский, legacy extra](ru/README.md)

Each supported dDocs language folder contains:

- `README.md` - localized overview and navigation.
- `user-guide.md` - manager user workflows and visible behavior.
- `developer-guide.md` - integration rules, examples and tests.
- `frontend-guide.md` - asset/theme guidance and frontend boundary.

## Canonical Developer Docs

- [Module Integration](module-integration.md)
- [Components And UI Kit](components.md)
- [DnD And Reorder Contract](dnd-reorder-contract.md)
- [DnD Implementation Guide](dnd-implementation-guide.md)
- [Form And Field Catalogue](forms.md)
- [Module Table Contract](module-table-contract.md)
- [Issue Workspace Contract](issue-workspace-contract.md)
- [Embedded Resource Contract](embedded-resource-contract.md)
- [Editor Media Adapter Contract](editor-media-adapter-contract.md)
- [Consumer Drift Guards](consumer-drift-guards.md)
- [Four-Module Release Gate](four-module-release-gate.md)
- [Component Completion Audit](component-completion-audit.md)
- [Testing Matrix](testing.md)
- [Consumers](consumers.md)
- [Release Checklist](release-checklist.md)
- [dDocs Tree/Viewer Notes](ddocs-tree-viewer-notes.md)
- [Roadmap](roadmap.md)

## dDocs Navigation Contract

- All package entrypoints must stay inside this `docs/` tree.
- Localized READMEs are navigation and onboarding pages; canonical contracts live
  in the root docs files listed above.
- `ua` and `uk` both point to Ukrainian content because Evolution CMS commonly
  uses `ua`, while external tooling often expects ISO `uk`.
- Use fenced code language identifiers in examples so dDocs can highlight code
  consistently.
- Do not link to local filesystem paths, manager URLs, or external docs from
  localized entrypoints unless a future task defines that boundary explicitly.

## Quality Rules

- Let evo-ui own the iframe document via `x-evo::layout`.
- Do not load legacy manager `styles.min.css`, Bootstrap, jQuery, `main.js`,
  `tabpane.js`, Roboto, or CDN UI assets inside evo-ui screens.
- Prefer config-driven `evo-ui.module-table`, `evo-ui.form`, and
  `evo-ui.issue-workspace` surfaces over hand-built repeated markup.
- Keep domain hooks in the consuming module. evo-ui owns generic UI runtime only.
- Use `EVO_*` constants in runtime code; old compatibility aliases should stay out of new UI code.
- Keep table/list views backed by the same row data and visual atoms.
- Use session persistence for current table/workspace UI state. Cross-session
  persistence is planned but intentionally not part of the first release.
- Add reusable CSS tokens/classes to evo-ui only when a pattern is shared by more
  than one module.
