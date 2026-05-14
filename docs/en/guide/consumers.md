# evo-ui Consumers

This page records the canonical consumer patterns that shape `evo-ui`.

Use it when choosing a donor pattern for a new Evolution CMS manager module. It
does not make consumer modules dependencies of `evo-ui`; it documents which
real module proves each shared UI contract.

## Ownership Rule

`evo-ui` owns generic manager UI behavior:

- iframe shell, assets and theme bridge
- Livewire bridge and component registration
- module tabs, dirty-state UX and shared modal shells
- table/list rendering, filters, search, sorting, pagination and state
- config/model/resource form rendering and field primitives
- issue/workspace layout primitives
- design tokens, compact manager typography and local JS helpers

Consumers own domain behavior:

- queries, permissions, migrations and persistence
- provider methods and business actions
- module-specific save/delete/duplicate/sync rules
- translations and domain labels
- SEO, multilingual, article and workflow semantics

If a pattern is useful in more than one module, document it in `evo-ui` before
making it a shared primitive.

## sArticles

Use `sArticles` as the reference for data-heavy publishing modules.

What it takes from `evo-ui`:

- manager shell and module tabs
- table/list presets for publications, authors, tags, comments, polls,
  categories, features, TV parameters and settings dictionaries
- modal create/edit forms
- relation choices for categories, tags, features and related articles
- image and file picker fields
- rich editor fields selected through module settings
- content builder field rendering
- session-persistent table state
- config form for base settings and publication types
- integration surfaces for `sSeo` and `sLang`

What remains module-owned:

- article/resource queries
- publish, duplicate and delete behavior
- article type semantics
- content builder block schema and rendering semantics
- relation data, SEO integration and language integration rules

Good donor patterns:

- article table with filters and table/list parity
- article modal with relations and media fields
- settings form with `config-map`
- rich editor setting that controls dense editor fields

Do not copy:

- article-specific builder semantics into `evo-ui`
- publication type business rules
- resource tree or SEO save behavior

## dIssues

Use `dIssues` as the reference for workflow, board and settings-taxonomy
modules.

What it takes from `evo-ui`:

- manager shell and module tabs
- issue table with filters, list/table views and modal editing
- settings forms
- settings taxonomy tables for projects, statuses, categories and phases
- provider-backed `evo-ui.issue-workspace`
- list/kanban switching
- category/status/assignee/search/archive filters
- selected issue preview/detail layout
- comments, replies, close/reopen and assignment UI contracts
- parent/child issue UI markers
- kanban drag/drop contract
- taxonomy color picker and dynamic badge styles

What remains module-owned:

- issue schema and migrations
- workflow status/category/project/phase rules
- provider persistence and external provider mapping
- GitHub/GitLab sync behavior
- transition history and orchestration rules

Good donor patterns:

- issue workspace provider shape
- kanban/list state behavior
- settings taxonomy table with color picker and delete guard
- manager-user assignment surfaces

Do not copy:

- dIssues workflow semantics into `evo-ui`
- external provider sync logic
- dIssues database model assumptions

## sLang

Use `sLang` as the reference for multilingual dictionary and compact inline
editing modules.

What it takes from `evo-ui`:

- evo-ui-owned module root
- module panel and tabs
- dictionary table through `config/translates/table.php`
- inline create and inline field save
- dynamic language columns
- settings choices and evo-ui-styled settings panel
- dirty-state navigation behavior

What remains module-owned:

- translation key persistence
- language list and enabled language rules
- resource edit multilingual tab compatibility
- synchronization and runtime translation behavior

Good donor patterns:

- dictionary table with inline editing
- dynamic columns based on configured locales
- settings choices for language lists
- explicit boundary for legacy-compatible resource tabs

Do not copy:

- sLang translation sync logic into `evo-ui`
- language storage assumptions into generic table behavior

## sSeo

Use `sSeo` as the reference for mixed module/resource SEO modules.

What it takes from `evo-ui`:

- evo-ui shell and module panel
- redirects table with modal CRUD
- settings form and analytics form presets
- custom form field registration for server protocol
- dashboard/status cards
- robots editor and meta template editor styling
- resource SEO fields styled with evo-ui assets
- legacy route compatibility while screens migrate

What remains module-owned:

- metadata rules and defaults
- robots.txt file write rules
- analytics ID parsing
- sitemap and canonical behavior
- resource SEO persistence through the manager resource form path
- Pro/sLang/sCommerce conditional behavior

Good donor patterns:

- custom evo-ui form field registration
- mixed module tabs with legacy-compatible routing
- redirects table as a compact CRUD surface
- resource form partial that reuses evo-ui visual primitives

Do not copy:

- SEO metadata rules into `evo-ui`
- robots or sitemap persistence into shared UI code

## Choosing A Donor

| New module need | Start from |
| --- | --- |
| Publishing/catalog module with relations and media | `sArticles` |
| Workflow board, settings taxonomies or issue-like data | `dIssues` |
| Dictionary, language or inline-edit matrix | `sLang` |
| Mixed module/resource settings and custom fields | `sSeo` |

When no donor fits, write the local module behavior first, document the shared
contract candidate, then promote only the generic primitive into `evo-ui`.

## Release Implication

Before tagging or merging broad `evo-ui` changes:

- package tests must prove generic behavior;
- each affected consumer must prove module-specific behavior;
- no change is safe if it only works for one consumer while regressing another;
- consumer tests should not be the only place where generic `evo-ui` behavior is
  asserted.
