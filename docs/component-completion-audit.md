# Component Completion Audit

Date: 2026-05-10

This audit captures the current WebUI component boundary after the sSeo,
sSettings, dIssues, sLang, sArticles and dDocs migrations. The goal is to keep
consumer modules declarative while evo-ui owns shared UI, state and assets.

## Current Shared Primitives

evo-ui already owns these reusable manager primitives:

| Area | Canonical primitive | Notes |
| --- | --- | --- |
| Shell | `x-evo::layout`, `evo::partials.assets` | Full evo-ui screens should use the layout. Transitional screens may use the assets partial. |
| Navigation | `x-evo::module-tab-shell`, `x-evo::module-tabs`, `x-evo::nav-tabs` | Use the guarded shell for dirty-state tabs. dDocs is the no-top-tabs exception. |
| Actions | `x-evo::button`, `.evo-ui-btn`, `.evo-ui-row-action` | Save/add/edit/delete/copy actions must use standard icon and tone rules. |
| Forms | `evo-ui.form`, `x-evo::form`, `x-evo::form.section`, `x-evo::settings-row` | Supports compact density, settings layout, section columns and shared save toast. |
| Fields | `x-evo::form.field`, table modal fields | Covers choices, csv, config-map, resource-parent, color, datetime, image/file, editor and custom field hooks. |
| Tables | `evo-ui.module-table`, table toolbar/filter/list/cell partials | Owns filters, search, sorting, pagination, list parity, inline edit, modal CRUD and row actions. |
| Dashboards | `x-evo::dashboard`, `x-evo::dashboard-card` | Owns card group spacing, responsive spans and the divider before following table content. |
| Builders | `x-evo::builder`, `x-evo::builder-row`, `x-evo::reorder-rail` | Shared reorder surface for builder/configuration rows. |
| Workspaces | `evo-ui.issue-workspace` | Provider-backed list/kanban/detail/comments contract. |
| Feedback | `.evo-ui-save-toast`, alerts, badges, chips | Save feedback must be compact and auto-dismiss. |
| Runtime | `window.EvoUI.*` | Dirty-state, table state, rich editor sync, issue kanban and filter helpers. |

## Remaining Drift From Consumers

`composer drift` currently reports 38 active findings. They are not all bugs,
but they mark the remaining boundary work.

| Consumer | Main drift | Direction |
| --- | --- | --- |
| sArticles | Builder templates still contain inline scripts. | Document builder-specific bridges first; promote repeated image/file/slider behavior into evo-ui runtime only when it is shared. |
| dIssues | Client views still carry local inline styles. | Keep public/client UI scoped unless it becomes a manager primitive; do not mix it into issue workspace. |
| sLang | Resource tabs and dictionary/settings still have inline scripts/styles and local evo-ui atom styling. | Constrain resource-tab bridge to the embedded resource contract and move shared tab/field behavior into evo-ui. |
| sSeo | `css/module.css`, Robots inline script and shell script remain. | Reduce module CSS after shared form variants land; move reusable editor dirty tracking into evo-ui if another module needs it. |
| sSettings | Configure/settings panels still have local Alpine/CSS around option editor and custom dirty tracking. | Convert repeated option-row/reorder behavior into shared form/builder primitives when stable. |
| dDocs | Tree/viewer owns inline script/style and local evo-ui atom styling. | Keep dDocs no-top-tabs UX module-owned for now; promote tree/viewer/markdown primitives only after API stabilizes. |

## Next Componentization Priorities

1. `evo-ui.option-list-editor`

   sSettings now needs option rows with add-after, delete, drag sort and
   `value==label` serialization. If another module needs option editing, promote
   the visual/editor primitive into evo-ui and keep serialization semantics in
   the consumer.

2. `evo-ui.editor-dirty-bridge`

   sSeo Robots and rich editor fields both need a reliable way to mark a form
   dirty from embedded editors. Promote only the generic dirty/saved bridge; keep
   file write rules in the module.

3. `evo-ui.markdown-viewer`

   dDocs needs GitHub-like Markdown, code copy, UML and safe links. Keep it
   local until dDocs stabilizes, then split a generic viewer primitive from
   dDocs-specific file indexing.

4. Resource tab adapter

   sLang and sSeo resource tabs still sit inside the legacy resource edit form.
   Keep the exception documented and move only shared field/tab controls into
   evo-ui.

5. Consumer CSS reduction

   Any selector that styles `.evo-ui-*` from a consumer package should either be
   moved to evo-ui or documented as a temporary scoped exception with a follow-up
   dIssues task.

## Documentation Standard

evo-ui now follows the dDocs package documentation structure:

```text
docs/
  README.md
  en/
    README.md
    user-guide.md
    developer-guide.md
    frontend-guide.md
  uk/
  ua/
  de/
  fr/
  pl/
```

Root docs keep canonical contracts. Localized guides are entrypoints for humans
and agents. All examples must use fenced language identifiers so dDocs can
highlight and copy code blocks correctly.

## Operating Rules

- New common UI behavior starts in evo-ui docs as a contract.
- Generic behavior is tested in evo-ui package tests.
- Module-specific behavior is tested in the consumer package.
- Consumer modules should not add CSS/JS for shared buttons, tabs, forms,
  tables, modals, badges, toasts or dirty-state behavior.
- dDocs remains a documented UX exception: sidebar/tree plus viewer, no upper
  module tabs.
