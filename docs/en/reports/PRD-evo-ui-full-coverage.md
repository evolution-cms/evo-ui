# PRD: evo-ui full coverage, consumer contracts, and developer docs

Date: 2026-05-09

## Purpose

`evo-ui` must become the stable declarative UI foundation for Evolution CMS manager modules. Module authors should be able to build admin interfaces without writing module-specific JavaScript or CSS for common screens. A module should declare its tabs, tables, forms, modals, workspace surfaces, providers, and backend data hooks; `evo-ui` should own the shared iframe shell, Livewire bridge, components, state behavior, assets, and documentation.

This PRD is a planning artifact only. It records the current state and the work that should be converted into dIssues backlog tasks after approval.

## Current scan

### evo-ui package

The package is a technical Composer library, not a manager module. It currently provides:

- manager iframe shell through `x-evo::layout` and `evo::partials.assets`;
- theme sync for current Evolution manager themes;
- Livewire bridge and component registration for `evo-ui.table`, `evo-ui.form`, `evo-ui.module-table`, and `evo-ui.issue-workspace`;
- module table surface with table/list views, filters, sorting, pagination, row actions, inline editing, modals, image/file/editor fields, reorder support, and session state;
- config/model/resource forms through `EvoUI\Livewire\Form`;
- issue workspace primitives through `EvoUI\Livewire\IssueWorkspace` and `EvoUI\Contracts\IssueWorkspaceProvider`;
- support services for manager context, permissions, config files, resource forms, language bridge, TV values, rich editors, field catalog, and resource layout resolution;
- local CSS/JS assets under `resources/css/evo-ui.css` and `resources/js/evo-ui.js`.

Current own test command:

```bash
composer test
```

Result during this scan: 6 passing tests in `tests/run.php`.

Important note: the `evo-ui` working tree already had uncommitted implementation changes before this PRD was added. The PRD must stay separate from those changes.

### sArticles consumer

`sArticles` is the broadest data-heavy consumer. It uses `evo-ui` for:

- manager shell and module tabs;
- table/list presets for articles, comments, authors, tags, categories, features, polls, and TV parameters;
- modal create/edit flows;
- rich editor fields;
- image/file fields;
- choices for categories, tags, features, related articles, and other relations;
- article content builder blocks;
- settings form with config-map for article types;
- sSeo and sLang integration surfaces.

The current gap is test ownership: this repo currently has no `tests/` directory, so several important `evo-ui` behaviors used only by `sArticles` are not locked by local automated tests.

### dIssues consumer

`dIssues` is the strongest workflow/workspace consumer. It uses `evo-ui` for:

- manager shell and module tabs;
- issue table and settings tables;
- settings forms;
- provider-backed issue workspace;
- list/kanban display modes;
- drag/drop Kanban movement;
- issue preview/detail, comments, replies, parent/child issues, transition history, assignment, archive and taxonomy surfaces;
- taxonomy color picker fields;
- rich editor adapter behavior.

`dIssues` has many contract tests that read `evo-ui` files directly through `EVO_UI_ROOT` or sibling paths. These tests are valuable, but core package safety should not depend on running a consumer test suite by accident.

### sLang consumer

`sLang` is partially migrated and proves multilingual/dictionary behavior:

- evo-ui-owned module root in `views/index.blade.php`;
- dictionary tab through `config/translates/table.php` and `TranslatesTableData`;
- inline create and inline field save for translation keys and dynamic language columns;
- settings panel using evo-ui visual primitives and choices;
- resource edit multilingual tabs remain legacy-compatible by design.

`sLang` has a regression script, but its evo-ui coverage should be converted into repeatable package and consumer contracts.

### sSeo consumer

`sSeo` is a partial-to-mature migration proving mixed module/resource SEO flows:

- evo-ui shell and module panel;
- redirects table through `config/redirects/table.php`;
- settings form and analytics form presets;
- custom form field registration for server protocol;
- robots editor, meta templates editor, dashboard cards, and resource SEO fields;
- tests covering provider wiring, module panel, redirects table, analytics/settings forms, resource fields, robots/meta editors, menu compatibility, and legacy cleanup.

The docs still describe only `sArticles` and `dIssues` as real consumers, so `sSeo` and `sLang` are underrepresented.

## Problem

`evo-ui` already carries the shared UI layer, but the acceptance surface is spread across consumer modules and documentation is behind the real API.

Main risks:

- package tests are too thin compared to the actual component surface;
- several real field types and behaviors are undocumented or only discoverable from consumer config;
- issue workspace API is evolving through `dIssues` tasks but not fully described in `evo-ui` docs;
- `sArticles` exercises complex builder/editor/file/relationship flows without local automated tests;
- consumer contract tests sometimes validate `evo-ui` by reading sibling files instead of a clear package-level fixture suite;
- future modules may copy module-specific CSS/JS because docs do not yet show enough declarative examples.

## Goals

1. Make `evo-ui` the tested source of truth for shared manager UI behavior.
2. Document every supported declarative surface with unique, real examples.
3. Turn current consumer usage into explicit package fixtures and consumer compatibility tests.
4. Keep module-specific business rules in the modules and generic UI behavior in `evo-ui`.
5. Prepare a dIssues project/backlog for implementation after this PRD is approved.

## Non-goals

- Do not move sSeo metadata rules, sLang translation rules, sArticles content semantics, or dIssues external sync logic into `evo-ui`.
- Do not rewrite all consumer modules in one task.
- Do not remove legacy-compatible resource tabs where they are intentionally still owned by Evolution manager forms.
- Do not introduce CDN UI dependencies or module-local styling for shared primitives.

## Required documentation work

Documentation should be expanded in `evo-ui/docs` so a module author can build a real module from docs alone.

Required docs:

- `consumers.md`: add complete sections for `sSeo` and `sLang`, and deepen `sArticles` and `dIssues` with actual surfaces and boundaries.
- `module-integration.md`: document provider registration, config merge keys, shell patterns, asset rules, and dirty-state tab switching.
- `module-table-contract.md`: cover all real table features: search, filters, URL/session state, table/list parity, columns, typed cells, inline editing, modal CRUD, delete guards, reorder, double-click edit, row states, dynamic actions, and provider hooks.
- `forms.md` or expanded `components.md`: document config forms, resource forms, `config-map`, `resource-parent`, `csv`, `datetime-local`, `color-picker`, `alias`, `choices`, `image`, `file`, `editor`, `repeater`, and `builder` field behavior.
- `issue-workspace-contract.md`: document provider methods, filters, display modes, assignees, comments, replies, close/reopen, parent/child issues, archive behavior, Kanban sorting, diagnostics, and state persistence.
- `testing.md`: document the required test matrix for package and consumer modules.
- localized entrypoints: update language README files to point to the new canonical docs.

Every example should be unique and based on one of the four consumers:

- `sArticles`: article table, relations choices, builder block, settings config-map.
- `dIssues`: issue workspace, taxonomy settings table, color picker, transition/comment behavior.
- `sLang`: inline translation dictionary and settings choices.
- `sSeo`: redirects table, analytics/settings form, resource SEO field, robots/meta editor.

## Required test work

### Package-level tests in evo-ui

Add or expand tests around:

- Composer/package identity and provider registration;
- Livewire bridge route and middleware contracts;
- Blade namespace and component registration;
- asset path, theme list, and no legacy manager asset leakage;
- module table state restoration and persistence;
- table filters: multi-select, select, segmented, toggle, date-range;
- sorting, pagination, view switching, and URL-over-session precedence;
- typed table cells: text, link, image, chips, badge, icon, date, position;
- inline create/save/revert behavior and provider hook contracts;
- modal field rendering and validation metadata;
- modal CRUD action hooks, delete confirmation, delete guards, duplicate/publish actions;
- reorder provider contracts for move and drag/drop;
- form fill/save for config and model sources;
- field casting: boolean, select, multi, CSV, datetime, config-map, resource parent, TV/resource multilingual values;
- custom form field registration and custom table cell view resolution;
- rich editor adapter output and submit synchronization hooks;
- image/file browser integration markers;
- issue workspace provider contract and display/filter state;
- issue workspace comments/replies/assignment/parent-child/archive/Kanban sorting;
- CSS token contracts for OKLCH palette, dynamic badges, color picker, issue cards, list cards, and compact manager typography;
- JS syntax and public `window.EvoUI` API markers.

### Consumer compatibility tests

Add or tighten consumer tests so each module proves its own contract while `evo-ui` proves generic behavior.

- `sArticles`: add tests for every table preset, settings form, article modal, builder field config, relation choices, rich editor config, image/file fields, publish/duplicate/delete action hooks, and docs examples.
- `dIssues`: keep existing broad contract tests, then move generic assertions that only inspect `evo-ui` into `evo-ui` package fixtures where possible.
- `sLang`: convert the regression script into repeatable tests for inline dictionary flow, dynamic language columns, choices settings, dirty state, and resource-tab compatibility boundary.
- `sSeo`: keep existing tests and add documentation parity tests for redirects, analytics/settings forms, custom form field registration, resource SEO fields, robots editor and meta template editor.

### Smoke and manual verification

For UI work, the implementation phase should add smoke scripts or documented browser checks for:

- module shell loads with `data-evo-ui-root`;
- no legacy manager CSS/JS bundles are loaded inside evo-ui-owned screens;
- tab switching keeps dirty-state prompts stable;
- table/list state survives refresh and tab switch;
- modal save/cancel/delete paths work;
- rich editors initialize and sync;
- image/file picker updates Livewire state;
- dIssues Kanban drag/drop persists through provider;
- sLang inline dictionary save works;
- sSeo resource SEO fields still save through the existing manager resource form path.

## Acceptance criteria

The work is done when:

1. `evo-ui` has a package-level test suite that covers all shared components and contracts currently exercised by the four consumers.
2. Each consumer has tests for its module-specific usage of `evo-ui`.
3. `evo-ui/docs` describes all supported declarative surfaces and includes unique examples from `sArticles`, `dIssues`, `sLang`, and `sSeo`.
4. Generic behavior is tested in `evo-ui`; module-specific business logic is tested in the consuming module.
5. The release checklist references the new docs and test matrix.
6. The dIssues backlog contains scoped tasks before implementation begins.

## Proposed dIssues project

After approval, create a dedicated project in the shared dIssues board:

- project key: `evo-ui`
- project name: `evo-ui`
- description: `Shared Evolution CMS manager UI foundation: tests, docs, and consumer contracts.`
- color: `#2563EB`
- icon: `layout-dashboard`

Use the visible workflow:

`Backlog -> Decomposition -> In progress -> Ready to test -> Closed`

Before any dIssues write, create a backup:

```bash
php /Users/dmi3yy/PhpstormProjects/MiddleDuck/skills/dissues-demo-ops/scripts/dissues-demo.php backup
```

List only the relevant project before choosing work:

```bash
php /Users/dmi3yy/PhpstormProjects/MiddleDuck/skills/dissues-demo-ops/scripts/dissues-demo.php list evo-ui
```

## Proposed backlog

### evo-ui-docs-001: Consumer coverage docs

Document `sArticles`, `dIssues`, `sLang`, and `sSeo` as canonical consumers. Include what each module uses, what stays module-owned, and which examples map to which docs.

### evo-ui-docs-002: Module table contract expansion

Expand table docs for typed cells, filters, inline editing, modal CRUD, row actions, delete guards, reorder, table/list parity, state persistence, and provider hooks.

### evo-ui-docs-003: Form and field catalogue

Create a complete form/field catalogue with config examples for settings forms, resource forms, config-map, choices, alias, color picker, image/file, rich editor, repeater, builder, CSV, datetime, and custom fields.

### evo-ui-docs-004: Issue workspace contract

Document the full provider-backed issue workspace contract used by `dIssues`, including Kanban/list, filters, assignment, comments/replies, parent-child, archive, diagnostics, and sorting.

### evo-ui-tests-005: Package test harness upgrade

Replace or extend `tests/run.php` into a clearer package contract suite that can validate PHP files, views, config shapes, CSS/JS markers, and support classes without relying on consumer repos.

### evo-ui-tests-006: Module table package contracts

Add package tests for module table state, filters, sorting, pagination, typed cells, inline editing, modal fields, row actions, delete guards, and reorder provider hooks.

### evo-ui-tests-007: Form package contracts

Add package tests for config/model/resource form fill/save, field casting, custom field registration, multilingual resource/TV behavior, dirty state events, and validation metadata.

### evo-ui-tests-008: Issue workspace package contracts

Add package tests for issue workspace provider API, state persistence, filters, Kanban/list rendering markers, comments/replies, assignment, archive, parent-child, and drag/drop contract markers.

### evo-ui-tests-009: Asset and design token contracts

Add tests for CSS tokens, OKLCH palette, dynamic badge colors, compact typography, color picker classes, list-card consistency, and JS public API/syntax.

### evo-ui-consumer-010: sArticles compatibility tests

Add `sArticles` tests for its evo-ui tables, settings, article modal, builder, relation choices, rich editor, image/file fields, and sSeo/sLang integration boundaries.

### evo-ui-consumer-011: dIssues compatibility split

Keep dIssues-specific tests in `dIssues`, but move generic `evo-ui` assertions into `evo-ui` fixtures. Leave dIssues tests focused on workflow data, taxonomy, provider behavior, and board state.

### evo-ui-consumer-012: sLang compatibility tests

Convert the current regression script into repeatable tests for dictionary inline editing, dynamic language columns, settings choices, dirty-state navigation, and legacy resource-tab boundary.

### evo-ui-consumer-013: sSeo compatibility tests

Tighten sSeo tests around redirects, settings/analytics forms, custom server protocol field, robots/meta editors, resource SEO fields, and legacy route compatibility.

### evo-ui-release-014: Release checklist and smoke matrix

Update release docs with exact commands for package tests, consumer tests, syntax checks, and browser/manual smoke checks for all four consumers.

## Open questions for approval

1. Should the new package test suite stay as a lightweight custom PHP runner, or should we move `evo-ui` to PHPUnit/Pest like the consumer modules?
2. Should `sArticles` get a full test harness now, or should the first pass use static contract tests plus demo smoke checks?
3. Should docs be written first in English only and then mirrored to localized entrypoints, or should Ukrainian developer docs be canonical for this internal phase?
4. Should generic consumer-derived tests be duplicated into `evo-ui` first, or moved gradually as each dIssues task is completed?

