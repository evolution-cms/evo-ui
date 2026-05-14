# evo-ui dIssues Full Task Report

Date: 2026-05-09

Project: `evo-ui`

Board source: local dIssues demo board in `/Users/dmi3yy/PhpstormProjects/Extras/sArticles/demo`

Main repository: `/Users/dmi3yy/PhpstormProjects/Extras/evo-ui`

Consumer repositories touched:

- `/Users/dmi3yy/PhpstormProjects/Extras/sArticles`
- `/Users/dmi3yy/PhpstormProjects/Extras/dIssues`
- `/Users/dmi3yy/PhpstormProjects/Extras/sLang`
- `/Users/dmi3yy/PhpstormProjects/Extras/sSeo`
- `/Users/dmi3yy/PhpstormProjects/Extras/dDocs` was inspected only for primitive notes.

## Executive Summary

The evo-ui work was organized as a platform hardening pass for Evolution CMS manager UI modules. The goal was to stop treating `sArticles`, `dIssues`, `sLang` and `sSeo` as random copy-paste donors, and instead make `evo-ui` the canonical declarative UI foundation for:

- manager shell and local assets;
- Livewire bridge;
- table/list contracts;
- form and field catalogue;
- issue workspace;
- design tokens;
- docs;
- package and consumer compatibility tests.

All 18 planned backlog tasks were moved through the dIssues workflow:

`Decomposition -> In progress -> Ready to test`

At the end of execution, the board shows all planned tasks in `ready_to_test`. Two additional board-level core tasks were already present and are also in `ready_to_test`.

## Board Snapshot

| Task | Status | Type | Priority | Title |
|---|---|---|---|---|
| `evo-ui-core-001` | `ready_to_test` | bug | high | Reset dirty navigation guard after successful form save |
| `evo-ui-core-002` | `ready_to_test` | feature | normal | Add module-table column header action slot |
| `evo-ui-001` | `ready_to_test` | feature | high | Create canonical module integration contract docs |
| `evo-ui-002` | `ready_to_test` | feature | high | Document canonical consumer patterns |
| `evo-ui-003` | `ready_to_test` | feature | high | Expand module table contract docs |
| `evo-ui-004` | `ready_to_test` | feature | high | Create form and field catalogue docs |
| `evo-ui-005` | `ready_to_test` | feature | high | Document issue workspace contract |
| `evo-ui-006` | `ready_to_test` | feature | high | Create testing matrix docs |
| `evo-ui-007` | `ready_to_test` | feature | high | Upgrade package test harness |
| `evo-ui-008` | `ready_to_test` | feature | high | Add module shell and asset contract tests |
| `evo-ui-009` | `ready_to_test` | feature | high | Add module table contract tests |
| `evo-ui-010` | `ready_to_test` | feature | high | Add form and field contract tests |
| `evo-ui-011` | `ready_to_test` | feature | high | Add issue workspace contract tests |
| `evo-ui-012` | `ready_to_test` | feature | normal | Add design token and visual contract tests |
| `evo-ui-013` | `ready_to_test` | feature | normal | Add sArticles compatibility tests |
| `evo-ui-014` | `ready_to_test` | feature | normal | Split dIssues compatibility assertions |
| `evo-ui-015` | `ready_to_test` | feature | normal | Convert sLang regression to repeatable tests |
| `evo-ui-016` | `ready_to_test` | feature | normal | Tighten sSeo compatibility tests |
| `evo-ui-017` | `ready_to_test` | feature | normal | Create release checklist and smoke matrix |
| `evo-ui-018` | `ready_to_test` | feature | normal | Add dDocs tree/viewer primitive notes |

## Workflow Used

For each backlog item:

1. Created or used task artifacts under `docs/tasks/<task-id>/`.
2. Moved the task to `in_progress` in dIssues.
3. Added an implementation-scope comment.
4. Implemented docs/tests/consumer changes.
5. Ran targeted verification.
6. Added `REPORT.md`.
7. Created a dIssues database backup.
8. Moved the task to `ready_to_test`.
9. Added a final dIssues comment with artifacts, summary, verification and self-review score.

## Wave 0: Board-Level Core Items

These two items exist in the dIssues `evo-ui` project and are in `ready_to_test`, but they do not have local `docs/tasks/<id>` artifact folders from this 18-task backlog batch.

### `evo-ui-core-001` — Reset dirty navigation guard after successful form save

Group: core runtime / dirty-state navigation

Board status: `ready_to_test`

Original task intent:

- Ensure module tab navigation does not remain blocked after an evo-ui form saves successfully.
- Keep the dirty-state prompt accurate after `evo-ui:form.saved`.

Relevant surfaces:

- evo-ui JS form dirty-state runtime.
- module-panel dirty navigation consumers in `sArticles`, `sLang`, `sSeo`.

Notes:

- This task is represented on the board as completed.
- The larger Wave 1-4 work added documentation and tests around dirty-state behavior in forms and consumer shells.

### `evo-ui-core-002` — Add module-table column header action slot

Group: core module table

Board status: `ready_to_test`

Original task intent:

- Allow table columns to expose compact header actions.
- Support provider-backed header actions such as sLang bulk auto-translate.

Relevant surfaces:

- `EvoUI\Livewire\ModuleTable`
- `views/components/table/header-cell.blade.php`
- module table contract docs and tests.

Notes:

- This task is represented on the board as completed.
- The package suite now includes header action contract coverage.

## Wave 1: Docs Contracts First

Goal: establish canonical docs before adding or expanding tests, so new modules have one source of truth instead of copying accidental patterns from consumers.

### `evo-ui-001` — Create canonical module integration contract docs

Group: docs / integration contract

Original task:

- Document the correct way to integrate evo-ui into an Evolution manager module.
- Cover service provider, routes, views namespace, `x-evo::layout`, `evo::partials.assets`, Livewire components, config merge keys, tabs, dirty-state behavior and asset restrictions.

Implemented:

- Rewrote `docs/module-integration.md` as the canonical integration contract.
- Documented install, provider registration, manager shell, asset rules, tabs, table/form/workspace presets and provider boundaries.
- Explicitly separated evo-ui-owned runtime from module-owned business logic.

Artifacts:

- `docs/module-integration.md`
- `docs/tasks/evo-ui-001/REPORT.md`

Verification:

- Documentation review.

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-002` — Document canonical consumer patterns

Group: docs / consumers

Original task:

- Create consumer documentation for `sArticles`, `dIssues`, `sLang`, `sSeo`.
- Explain what each consumer takes from evo-ui, what remains module-owned, and which examples should be used as donor patterns.

Implemented:

- Rewrote `docs/consumers.md`.
- Added donor-pattern map for all four canonical consumers.
- Added ownership boundaries and donor selection guidance.

Artifacts:

- `docs/consumers.md`
- `docs/tasks/evo-ui-002/REPORT.md`

Verification:

- Documentation review.

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-003` — Expand module table contract docs

Group: docs / module table

Original task:

- Document table/list contract: columns, typed cells, filters, search, sorting, pagination, session/url state, inline editing, modal CRUD, row actions, delete guards, duplicate/publish actions, reorder/drag-sort, double-click edit and provider hooks.

Implemented:

- Expanded `docs/module-table-contract.md`.
- Added action contracts, header actions, delete guards, modal field types, consumer references and checklist.
- Kept business persistence in provider-owned module code.

Artifacts:

- `docs/module-table-contract.md`
- `docs/tasks/evo-ui-003/REPORT.md`

Verification:

- Documentation review.

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-004` — Create form and field catalogue docs

Group: docs / forms and fields

Original task:

- Document supported form fields and behavior: config/model/resource forms, config-map, resource-parent, CSV, datetime-local, color-picker, alias, choices, image, file, editor, repeater, builder, custom fields, validation metadata and dirty state.

Implemented:

- Added `docs/forms.md`.
- Documented form sources, actions, sections, supported fields, casting/save behavior, dirty-state events and consumer references.
- Linked the catalogue from `docs/README.md`.

Artifacts:

- `docs/forms.md`
- `docs/README.md`
- `docs/tasks/evo-ui-004/REPORT.md`

Verification:

- Documentation review.

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-005` — Document issue workspace contract

Group: docs / issue workspace

Original task:

- Document provider-backed issue workspace used by dIssues: list/kanban, filters, assignees, comments, replies, close/reopen, parent-child, archive, sorting, diagnostics and state persistence.

Implemented:

- Added `docs/issue-workspace-contract.md`.
- Documented workspace preset, provider interface, display modes, filters, payloads, comments/replies, assignment, parent/child, archive, Kanban sorting and diagnostics.
- Linked the contract from `docs/README.md`.

Artifacts:

- `docs/issue-workspace-contract.md`
- `docs/README.md`
- `docs/tasks/evo-ui-005/REPORT.md`

Verification:

- Documentation review.

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-006` — Create testing matrix docs

Group: docs / testing

Original task:

- Define what is tested in evo-ui package and what remains in consumer modules.
- Generic behavior belongs in evo-ui; module business behavior belongs in consumers.

Implemented:

- Added `docs/testing.md`.
- Documented package-owned vs consumer-owned test scopes for evo-ui, sArticles, dIssues, sLang and sSeo.
- Added smoke matrix and blocking rules.
- Linked from `docs/README.md`.

Artifacts:

- `docs/testing.md`
- `docs/README.md`
- `docs/tasks/evo-ui-006/REPORT.md`

Verification:

- Documentation review.

Self-review: `9/10`

Status: `ready_to_test`

## Wave 2: Package Test Foundation

Goal: convert evo-ui from mostly undocumented/static safety into a grouped package contract suite that covers shell, assets, tables, forms, issue workspace and visual tokens.

### `evo-ui-007` — Upgrade package test harness

Group: package tests / harness

Original task:

- Expand or replace `tests/run.php` with a grouped package contract suite.
- Keep lightweight PHP runner if PHPUnit/Pest is unnecessary.

Implemented:

- Reworked `tests/run.php` into a grouped runner.
- Added helpers for groups, path resolution, file/config reads and assertions.
- Preserved existing package/provider/asset/state/header action/CSV/display-only checks.

Artifacts:

- `tests/run.php`
- `docs/tasks/evo-ui-007/REPORT.md`

Verification:

- `php -l tests/run.php`
- `composer test`

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-008` — Add module shell and asset contract tests

Group: package tests / shell and assets

Original task:

- Cover provider registration, Blade namespace, component registration, layout markers, evo assets, theme bridge, `data-evo-ui-root`, no legacy manager asset leakage, JS syntax and `window.EvoUI` markers.

Implemented:

- Added tests for manager layout shell markers.
- Added theme markers and asset partial checks.
- Added checks that evo-ui screens do not load legacy manager bundles.
- Added public `window.EvoUI` API marker tests.

Artifacts:

- `tests/run.php`
- `docs/tasks/evo-ui-008/REPORT.md`

Verification:

- `composer test`
- `node --check resources/js/evo-ui.js`

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-009` — Add module table contract tests

Group: package tests / module table

Original task:

- Cover table config shape, filters, sorting, pagination, view switching, URL/session state, typed cells, inline edit markers, modal metadata, row actions, delete guards and reorder provider hooks.

Implemented:

- Added tests for filters, sort, pagination and view state.
- Added URL state key checks.
- Added typed cell and list parity tests.
- Added inline editing and provider hook checks.
- Added modal CRUD, delete guard and reorder contract checks.

Artifacts:

- `tests/run.php`
- `docs/tasks/evo-ui-009/REPORT.md`

Verification:

- `composer test`

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-010` — Add form and field contract tests

Group: package tests / forms and fields

Original task:

- Cover config/model/resource form contracts, field casting, choices, CSV, datetime, color-picker, alias, image/file markers, editor sync markers, custom field registration, validation metadata and dirty-state events.

Implemented:

- Added tests for dirty-state events and resource-parent markers.
- Added field catalogue tests for color-picker, config-map, multi-checkbox, resource-parent, datetime-local and custom rendering.
- Added modal field tests for choices, image/media bridge, editor sync, builder fields and color picker.
- Added custom field registry tests.
- Added casting tests for config-map, CSV, datetime and resource-parent.

Artifacts:

- `tests/run.php`
- `docs/tasks/evo-ui-010/REPORT.md`

Verification:

- `php -l tests/run.php`
- `composer test`

Result:

- `OK 20 tests` at task completion.

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-011` — Add issue workspace contract tests

Group: package tests / issue workspace

Original task:

- Cover provider interface shape, display/filter state, list/kanban markers, comments/replies contract, assignment markers, archive markers, parent-child markers and drag/drop sorting contract.

Implemented:

- Added provider method surface tests for `IssueWorkspaceProvider`.
- Added filter/display/archive/session persistence tests.
- Added list/kanban Blade and JS marker tests.
- Added comments/replies/body-editor tests with rich editor sync.
- Added assignment/archive/parent-child marker tests.
- Added drag/drop sorting payload tests.

Artifacts:

- `tests/run.php`
- `docs/tasks/evo-ui-011/REPORT.md`

Verification:

- `php -l tests/run.php`
- `composer test`

Result:

- `OK 26 tests` at task completion.

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-012` — Add design token and visual contract tests

Group: package tests / design tokens and visual contract

Original task:

- Cover CSS tokens, OKLCH palette, dynamic badge colors, color picker styles, issue cards/list cards, compact manager typography and dark/light markers.

Implemented:

- Added tests for manager theme selectors, light/dark color schemes and OKLCH palette usage.
- Added semantic token tests.
- Added dynamic badge and issue chip color tests.
- Added color picker primitive tests.
- Added issue card/list card/compact typography tests.
- Added missing `--evo-ui-radius-sm` shared token used by existing CSS.

Artifacts:

- `resources/css/evo-ui.css`
- `tests/run.php`
- `docs/tasks/evo-ui-012/REPORT.md`

Verification:

- `php -l tests/run.php`
- `composer test`
- `node --check resources/js/evo-ui.js`

Result:

- `OK 31 tests` at task completion.

Self-review: `9/10`

Status: `ready_to_test`

## Wave 3: Consumer Compatibility

Goal: make each canonical consumer repeatably prove that it still uses evo-ui correctly, while keeping business logic in the consumer modules.

### `evo-ui-013` — Add sArticles compatibility tests

Group: consumer tests / sArticles

Original task:

- Add lightweight sArticles tests for table presets, settings form, article modal, builder config, relation choices, rich editor, image/file fields, publish/duplicate/delete hooks.

Implemented:

- Added sArticles lightweight runner.
- Added `composer test` script.
- Covered evo-ui shell usage, dirty navigation guard, article table/list preset, filters, typed columns, modal CRUD, builder fields, config-map settings and provider hooks.
- Covered builder markers for rich text, image, file, slider and article preview.

Artifacts:

- `/Users/dmi3yy/PhpstormProjects/Extras/sArticles/tests/run.php`
- `/Users/dmi3yy/PhpstormProjects/Extras/sArticles/composer.json`
- `docs/tasks/evo-ui-013/REPORT.md`

Verification:

- `php -l tests/run.php`
- `composer test`

Result:

- sArticles: `OK 7 tests`

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-014` — Split dIssues compatibility assertions

Group: consumer tests / dIssues

Original task:

- Leave workflow/taxonomy/provider/board behavior in dIssues.
- Move or duplicate generic assertions into evo-ui fixtures/package tests.

Implemented:

- Added dIssues scope document defining the boundary between package-level generic evo-ui contracts and dIssues-owned workflow/provider behavior.
- Added a dIssues delegation contract test proving generic contracts now exist in the evo-ui package suite.
- Kept dIssues tests focused on workflow, taxonomy, provider, assignment, conversation, archive and client-surface behavior.

Artifacts:

- `/Users/dmi3yy/PhpstormProjects/Extras/dIssues/docs/evo-ui-compatibility-scope.md`
- `/Users/dmi3yy/PhpstormProjects/Extras/dIssues/tests/Unit/EvoUIPackageDelegationContractTest.php`
- `docs/tasks/evo-ui-014/REPORT.md`

Verification:

- `php -l tests/Unit/EvoUIPackageDelegationContractTest.php`
- `demo/core/vendor/bin/phpunit --configuration demo/core/phpunit.xml tests/Unit/EvoUIPackageDelegationContractTest.php`
- `composer test` in evo-ui

Results:

- dIssues delegation test: `OK (2 tests, 20 assertions)`
- evo-ui package suite: `OK 31 tests`

Self-review: `8/10`

Status: `ready_to_test`

Note:

- Older dIssues tests were not mass-deleted because several still mix generic surface checks with dIssues-specific provider/workflow assertions. The new scope file and delegation test establish the correct future split.

### `evo-ui-015` — Convert sLang regression to repeatable tests

Group: consumer tests / sLang

Original task:

- Cover dictionary inline editing, dynamic language columns, settings choices, dirty-state navigation and legacy resource-tab boundary.

Implemented:

- Added repeatable sLang compatibility runner.
- Added `composer test`.
- Normalized sLang composer package type to `evolution-cms-module` so Composer can run scripts under current schema.
- Covered dictionary inline editing, dynamic language columns, inline/header auto-translate actions, settings choices, dirty-state navigation and legacy resource-tab boundary.
- Kept existing DB-backed regression script as a separate smoke entrypoint.

Artifacts:

- `/Users/dmi3yy/PhpstormProjects/Extras/sLang/tests/run.php`
- `/Users/dmi3yy/PhpstormProjects/Extras/sLang/composer.json`
- `docs/tasks/evo-ui-015/REPORT.md`

Verification:

- `php -l tests/run.php`
- `composer test`

Result:

- sLang: `OK 7 tests`

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-016` — Tighten sSeo compatibility tests

Group: consumer tests / sSeo

Original task:

- Cover redirects table, settings/analytics forms, custom server protocol field, robots/meta editors, resource SEO fields and legacy route compatibility.

Implemented:

- Added `composer test` for sSeo using shared demo PHPUnit runtime.
- Added `EvoUiCompatibilityMatrixContractTest`.
- Covered module shell routing, redirects table/list/modal CRUD, settings/config forms, analytics fields, custom server protocol field, robots editor, meta templates editor, resource SEO fields and legacy named routes.

Artifacts:

- `/Users/dmi3yy/PhpstormProjects/Extras/sSeo/tests/Unit/EvoUiCompatibilityMatrixContractTest.php`
- `/Users/dmi3yy/PhpstormProjects/Extras/sSeo/composer.json`
- `docs/tasks/evo-ui-016/REPORT.md`

Verification:

- `php -l tests/Unit/EvoUiCompatibilityMatrixContractTest.php`
- `../sArticles/demo/core/vendor/bin/phpunit --configuration ../sArticles/demo/core/phpunit.xml tests/Unit/EvoUiCompatibilityMatrixContractTest.php`
- `composer test`

Results:

- Matrix test: `OK (4 tests, 88 assertions)`
- Full sSeo unit suite: `OK (55 tests, 537 assertions)`

Self-review: `9/10`

Status: `ready_to_test`

## Wave 4: Release And Future Primitives

Goal: turn the test/doc work into an operational release gate and document the dDocs tree/viewer boundary before it becomes accidental evo-ui API.

### `evo-ui-017` — Create release checklist and smoke matrix

Group: docs / release gate

Original task:

- Describe exact commands for evo-ui tests, consumer tests, syntax checks, browser/manual smoke.
- Include shell loads, tab dirty-state, table/list state, modal flows, rich editor sync, image/file picker, dIssues kanban drag/drop, sLang inline save and sSeo resource SEO save.

Implemented:

- Rebuilt `docs/release-checklist.md`.
- Added exact package commands.
- Added consumer commands for sArticles, dIssues, sLang and sSeo.
- Added manual smoke sections for runtime shell, tab dirty-state, table/list state, modal/field flows, dIssues workspace, sLang dictionary/settings and sSeo resource/module flows.
- Added release gate rules tying docs, package tests and consumer tests together.

Artifacts:

- `docs/release-checklist.md`
- `docs/tasks/evo-ui-017/REPORT.md`

Verification:

- `composer test`
- Manual readback of release checklist.

Result:

- evo-ui package suite: `OK 31 tests`

Self-review: `9/10`

Status: `ready_to_test`

### `evo-ui-018` — Add dDocs tree/viewer primitive notes

Group: docs / future primitives

Original task:

- Since dDocs needs tree/sidebar and markdown viewer, add a design note defining what stays local in dDocs and what may become an evo-ui primitive later.

Implemented:

- Added `docs/ddocs-tree-viewer-notes.md`.
- Linked it from `docs/README.md`.
- Documented that dDocs owns discovery, tree payloads, Markdown rendering, link/image safety, search and viewer state for now.
- Documented future primitive candidates: workspace split, tree, viewer and markdown typography.
- Added promotion rules for moving any dDocs pattern into evo-ui.

Artifacts:

- `docs/ddocs-tree-viewer-notes.md`
- `docs/README.md`
- `docs/tasks/evo-ui-018/REPORT.md`

Verification:

- `composer test`
- Manual readback of dDocs design note.

Result:

- evo-ui package suite: `OK 31 tests`

Self-review: `9/10`

Status: `ready_to_test`

## Component-Level Summary

### evo-ui Package

Work performed:

- Canonical docs added or expanded.
- Package contract runner expanded to grouped suite.
- Shell/assets, design tokens, module table, forms and issue workspace are covered by package tests.
- Release checklist and smoke matrix created.
- dDocs future primitive boundary documented.

Important files:

- `docs/module-integration.md`
- `docs/consumers.md`
- `docs/module-table-contract.md`
- `docs/forms.md`
- `docs/issue-workspace-contract.md`
- `docs/testing.md`
- `docs/release-checklist.md`
- `docs/ddocs-tree-viewer-notes.md`
- `tests/run.php`
- `resources/css/evo-ui.css`

Final verification:

- `composer test` -> `OK 31 tests`
- `node --check resources/js/evo-ui.js` -> passed

### sArticles

Work performed:

- Added lightweight compatibility tests.
- Added `composer test`.
- Covered article table/list, settings config-map, article modal, builder and provider hooks.

Important files:

- `/Users/dmi3yy/PhpstormProjects/Extras/sArticles/tests/run.php`
- `/Users/dmi3yy/PhpstormProjects/Extras/sArticles/composer.json`

Final verification:

- `composer test` -> `OK 7 tests`

### dIssues

Work performed:

- Added compatibility scope document.
- Added delegation contract test that verifies generic evo-ui behavior is now covered in the evo-ui package suite.

Important files:

- `/Users/dmi3yy/PhpstormProjects/Extras/dIssues/docs/evo-ui-compatibility-scope.md`
- `/Users/dmi3yy/PhpstormProjects/Extras/dIssues/tests/Unit/EvoUIPackageDelegationContractTest.php`

Final verification:

- dIssues delegation test -> `OK (2 tests, 20 assertions)`
- evo-ui package suite -> `OK 31 tests`

### sLang

Work performed:

- Added repeatable static compatibility tests.
- Added `composer test`.
- Normalized composer `type` to `evolution-cms-module`.
- Covered dictionary inline editing, dynamic language columns, settings choices and legacy resource-tab boundary.

Important files:

- `/Users/dmi3yy/PhpstormProjects/Extras/sLang/tests/run.php`
- `/Users/dmi3yy/PhpstormProjects/Extras/sLang/composer.json`

Final verification:

- `composer test` -> `OK 7 tests`

### sSeo

Work performed:

- Added compatibility matrix PHPUnit test.
- Added `composer test`.
- Covered redirects, settings, analytics, server protocol, robots editor, meta templates, resource SEO fields and legacy routes.

Important files:

- `/Users/dmi3yy/PhpstormProjects/Extras/sSeo/tests/Unit/EvoUiCompatibilityMatrixContractTest.php`
- `/Users/dmi3yy/PhpstormProjects/Extras/sSeo/composer.json`

Final verification:

- `composer test` -> `OK (55 tests, 537 assertions)`

### dDocs

Work performed:

- Inspected dDocs tree/sidebar and Markdown viewer direction.
- Documented why the tree/viewer stays local for now.
- Documented possible future evo-ui primitives.

Important evo-ui file:

- `docs/ddocs-tree-viewer-notes.md`

Status:

- Notes only. No dDocs runtime changes were made for this task.

## Final Verification Matrix

| Area | Command | Result |
|---|---|---|
| evo-ui package | `composer test` | `OK 31 tests` |
| evo-ui JS | `node --check resources/js/evo-ui.js` | Passed |
| sArticles | `composer test` | `OK 7 tests` |
| dIssues delegation | `demo/core/vendor/bin/phpunit --configuration demo/core/phpunit.xml tests/Unit/EvoUIPackageDelegationContractTest.php` | `OK 2 tests, 20 assertions` |
| sLang | `composer test` | `OK 7 tests` |
| sSeo | `composer test` | `OK 55 tests, 537 assertions` |

## Remaining Manual Gate

Automated checks are green. Browser/manual smoke still needs to be run before release or merge. The exact checklist is in:

`/Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/release-checklist.md`

Manual smoke areas:

- manager shell loads;
- theme bridge;
- tab dirty-state;
- table/list state;
- modal CRUD;
- rich editor sync;
- image/file picker;
- dIssues kanban drag/drop;
- sLang inline save and auto-translate actions;
- sSeo resource SEO save and module screens.

## Main Outcome

evo-ui now has:

- a canonical documentation set;
- a package-level contract suite;
- consumer compatibility coverage across sArticles, dIssues, sLang and sSeo;
- a release checklist;
- a documented future boundary for dDocs tree/viewer primitives.

The platform is no longer relying only on consumer modules as informal examples. The intended flow is now:

`docs -> contracts -> package tests -> consumer compatibility -> release smoke`
