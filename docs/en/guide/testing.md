# Testing Matrix

This matrix defines where `evo-ui` behavior is tested.

Rule of thumb:

- generic UI/runtime behavior is tested in the `evo-ui` package;
- module-specific business behavior is tested in the consumer module;
- smoke checks prove real manager integration after package and consumer tests
  pass.

## Package Tests

Run from the `evo-ui` package root:

```bash
composer test
```

Run PHP syntax checks before release or when PHP files changed:

```bash
find src config lang tests -name '*.php' -print0 | xargs -0 -n1 php -l
```

Run the consumer drift report when changing shared UI contracts:

```bash
composer drift
```

Run the four-module release gate before releasing `evo-ui`, `sSeo`, `sLang` or
`sSettings`:

```bash
composer release-gate
```

Use strict mode only after known consumer drift has been cleaned or explicitly
allowlisted:

```bash
php tests/consumer-drift.php --strict
```

Package tests should cover:

- composer identity and package type;
- service provider registration;
- Blade namespace and Livewire component registration;
- manager shell and asset markers;
- theme list and design tokens;
- no legacy manager asset leakage in evo-ui-owned screens;
- module table config/rendering contracts;
- form and field contracts;
- issue workspace provider/UI contracts;
- CSS token and JavaScript public API markers;
- existence of consumer CSS/JS drift guard tooling.

## Consumer Tests

Consumer modules test their own configuration, providers and business behavior.
Exact commands may differ per local demo checkout; release tasks should keep the
current commands in `docs/en/guide/release-checklist.md`.

### sArticles

Consumer-owned scope:

- table presets and article provider hooks;
- settings form and article type config-map;
- article modal config;
- builder block schema;
- relation options;
- publish, duplicate and delete semantics;
- sSeo and sLang integration boundaries.

Generic rendering, modal shell, choices, editor sync and file picker behavior
must still be covered by `evo-ui` package tests.

### dIssues

Consumer-owned scope:

- workflow schema and migrations;
- local issue providers;
- taxonomy persistence;
- board workflow rules;
- comments, transition history and assignment persistence;
- external provider settings and sync boundaries.

Generic workspace rendering, filters, state, drag/drop contract and issue UI
markers belong in `evo-ui` package tests.

Known local unit command shape:

```bash
cd /Users/dmi3yy/PhpstormProjects/Extras/sArticles/demo/core
./vendor/bin/phpunit /Users/dmi3yy/PhpstormProjects/Extras/dIssues/tests/Unit
```

### sLang

Consumer-owned scope:

- dictionary persistence;
- dynamic language columns;
- settings choices;
- translation sync/runtime rules;
- legacy-compatible resource tab boundary.

Generic inline editing and table mechanics belong in `evo-ui`.

### sSeo

Consumer-owned scope:

- redirects provider behavior;
- settings and analytics config;
- server protocol custom field;
- robots/meta template persistence;
- resource SEO save path;
- legacy route compatibility.

Generic form/table/custom-field rendering belongs in `evo-ui`.

## Smoke Matrix

Use smoke checks when a task touches runtime UI or release readiness.

| Surface | Owner | Expected proof |
| --- | --- | --- |
| Module shell loads with `data-evo-ui-root` | evo-ui + consumer | browser/manual note or smoke script |
| No legacy assets in evo-ui screen | evo-ui | package marker test plus browser source check |
| Tab dirty-state prompt | evo-ui + consumer panel | browser/manual note |
| Table/list state survives refresh | evo-ui | package state test plus manager smoke |
| Modal create/edit/delete | evo-ui + consumer provider | focused consumer smoke |
| Rich editor sync | evo-ui + consumer editor setting | browser/manual note |
| Image/file picker | evo-ui + consumer field | browser/manual note |
| dIssues Kanban drag/drop | dIssues | provider persistence smoke |
| sLang inline save | sLang | regression/unit or browser smoke |
| sSeo resource SEO save | sSeo | resource form smoke |

## Four-Module Release Gate

The release gate is documented in
[Four-Module Release Gate](../contracts/four-module-release-gate.md). It treats `sSeo` as
green when only documented site-content/editor adapters remain. It treats
`sLang` as green only when module inline UI is gone and the resource bridge has
exact allowlist reasons. For the first `sSettings` release, visually accepted
manager config and dirty-field modal bridge code may remain only with exact
allowlist reasons and follow-up cleanup tasks; new module-local manager drift
still blocks release.

## Blocking Rules

A task should not move to `ready_to_test` when:

- package tests fail for generic behavior touched by the task;
- a changed consumer contract has no consumer-side proof;
- a browser-only behavior is claimed green without a smoke note;
- a task moves business logic from a consumer module into `evo-ui`;
- new shared UI behavior is implemented without docs and package tests.

If an exact consumer command is unknown, document it as an owner/TODO slot
instead of inventing a command.
