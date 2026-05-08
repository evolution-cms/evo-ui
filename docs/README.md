# evo-ui Documentation

evo-ui is the shared Livewire + DaisyUI manager UI foundation for Evolution CMS
extras. It owns the manager iframe document, theme sync, Livewire bridge,
tables, forms, modals, issue workspaces, and local assets.

## Languages

- [English](en/README.md)
- [Українська](ua/README.md)
- [Русский](ru/README.md)
- [Deutsch](de/README.md)
- [Français](fr/README.md)
- [Polski](pl/README.md)

## Canonical Developer Docs

- [Module Integration](module-integration.md)
- [Components](components.md)
- [Module Table Contract](module-table-contract.md)
- [Consumers](consumers.md)
- [Release Checklist](release-checklist.md)
- [Roadmap](roadmap.md)

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
