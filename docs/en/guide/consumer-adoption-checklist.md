# Consumer Adoption Checklist

Use this checklist before implementing or reviewing a consumer module. The goal
is to choose the right EvoUI primitive before copying code from another module.

## Primitive Selection

| Need | Use | Do not use |
| --- | --- | --- |
| Manager screen shell | `x-evo::layout` | Bootstrap/CDN/legacy manager assets |
| Top module sections | `x-evo::module-tab-shell` | Local tab CSS/dirty-state scripts |
| Row-based data | `evo-ui.module-table` | Custom table toolbar/pagination |
| Settings/config editor | `evo-ui.form` | Custom Save button and label grid |
| Create/edit modal | Table modal config or `x-evo::modal` | Module-local modal frame |
| Reorderable rows | DnD/reorder primitives | Local drag preview/placeholder CSS |
| Dashboard stats | `x-evo::dashboard-card` | Local dashboard grid CSS |
| Workflow board | `evo-ui.issue-workspace` | Dashboard cards pretending to be a board |
| Resource edit tab | Embedded Resource Contract | Full EvoUI manager shell |
| Docs tree/viewer | dDocs local exception | Forcing module tabs into dDocs |

## Donor Modules

| Module | Good donor for | Do not copy |
| --- | --- | --- |
| `sArticles` | Table CRUD, rich modal fields, image/file/editor flows | Article builder semantics |
| `sSeo` | Dashboard card plus table composition, redirects table | SEO business rules or site output CSS |
| `sLang` | Dictionary inline editing and language-aware labels | Legacy resource tabpane scripts |
| `sSettings` | Nested DnD behavior and inline create focus | Local DnD/settings CSS |
| `sTask` | Operational table states and read-only detail modals | Legacy shell/CDN assets |
| `dIssues` | Issue workspace, provider-backed filters, settings tables | Workflow/business rules |
| `dDocs` | Documentation workspace ideas | Tree/viewer CSS until promoted |

## Review Questions

- Can the screen be expressed with `module-table`, `form`, `dashboard`,
  `modal`, `dnd` or `issue-workspace` config?
- Is every common action using `x-evo::button` or `.evo-ui-row-action`?
- Does the consumer load only EvoUI manager assets?
- Are local CSS selectors limited to domain output or documented exceptions?
- Are provider methods handling business rules instead of Blade templates?
- Is there a visible EvoUI backlog task when a shared primitive is missing?

