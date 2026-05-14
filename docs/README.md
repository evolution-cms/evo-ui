# evo-ui Documentation

evo-ui is the shared manager UI foundation for Evolution CMS extras. This root
page is only a language and navigation entrypoint.

Canonical implementation docs are English-first and live under
[`docs/en`](en/README.md). Localized release entrypoints live under `docs/uk`,
`docs/pl`, `docs/de`, and `docs/fr`.

## Languages

- [English](en/README.md)
- [Українська](uk/README.md)
- [Deutsch](de/README.md)
- [Français](fr/README.md)
- [Polski](pl/README.md)
- [Русский, legacy extra](ru/README.md)

## Locale Status

| Locale | Status | Notes |
| --- | --- | --- |
| `en` | `complete` | Canonical source for implementation contracts. |
| `uk` | `complete` | Ukrainian documentation locale. Legacy manager input `ua` maps to `uk`. |
| `pl` | `complete` | Localized release entrypoints and core reference pages. |
| `de` | `complete` | Localized release entrypoints and core reference pages. |
| `fr` | `complete` | Localized release entrypoints and core reference pages. |
| `ru` | `legacy` | README-only legacy extra; not part of the release locale gate. |

## English Canonical Docs

- [English Guide](en/guide/README.md)
- [English Components](en/components/README.md)
- [English Contracts](en/contracts/README.md)
- [English Reports](en/reports/README.md)
- [Module Integration](en/guide/module-integration.md)
- [Components And UI Kit](en/components/README.md)
- [Action Buttons](en/components/action-buttons.md)
- [Modal And Confirmation](en/components/modal.md)
- [Table](en/components/table/README.md)
- [Form Component](en/components/form.md)
- [Choices And Option Lists](en/components/choices-option-lists.md)
- [Inline Create And Inline Edit](en/components/inline-create-edit.md)
- [Dashboard Cards](en/components/dashboard-cards.md)
- [Design Tokens And Visual System](en/components/design-tokens.md)
- [Consumer Adoption Checklist](en/guide/consumer-adoption-checklist.md)
- [Configuration](en/configuration.md)
- [Reference](en/reference.md)
- [Troubleshooting](en/troubleshooting.md)
- [Documentation Standards](en/documentation-standards.md)
- [EvoUI Implementation Lessons](en/guide/implementation-lessons.md)
- [DnD And Reorder Contract](en/components/dnd/reorder-contract.md)
- [DnD Implementation Guide](en/components/dnd/implementation-guide.md)
- [Embedded Resource Contract](en/contracts/embedded-resource.md)
- [Editor Media Adapter Contract](en/contracts/editor-media-adapter.md)
- [Consumer Drift Guards](en/contracts/consumer-drift-guards.md)
- [Component Completion Audit](en/reports/component-completion-audit.md)
- [Table Consumer Audit](en/reports/table-consumer-audit-2026-05-13.md)
- [Primitive Coverage Matrix](en/reports/primitive-coverage-matrix-2026-05-13.md)

## Structure Rules

- Root `docs/` must stay clean: no canonical component/guide/contract/report
  folders at root.
- Canonical docs live in `docs/en/...`.
- Localized docs live in `docs/<lang>/...`.
- Ukrainian docs use `uk` only. Legacy Evolution manager value `ua` is an input
  alias, not a documentation folder.
- Relative Markdown links must stay inside this package so dDocs can render them.
