# evo-ui First Release Checklist

Use this checklist before tagging the first evo-ui release.

## Runtime

- `x-evo::layout` owns the manager iframe document.
- Livewire update and script routes are registered behind manager middleware.
- Local package CSS/JS assets are published to `assets/modules/evo-ui`.
- Theme sync works for `evolight`, `evolightness`, `evodark`, `evodarkness`.
- Runtime code uses `EVO_*` constants for Evolution paths and URLs.

## Components

- `evo-ui.module-table` renders table and list views.
- `evo-ui.form` renders resource/config forms.
- `evo-ui.issue-workspace` renders dIssues kanban/list workspace.
- Modal forms support text, textarea, number, select, checkbox, choices, image,
  file, editor, repeater and builder fields.
- Rich editor fields can hide the per-field selector when a module-level editor
  setting is used.
- Choices support single/multiple values, optional search, clear controls and
  compact selected chips.

## State

- Table state persists in manager session.
- Issue workspace state persists in manager session.
- URL query state has priority over restored session state.
- Cross-session/user preference persistence is postponed intentionally.

## Consumers

- `sArticles` works with evo-ui tables, settings, article modal, content builder,
  sSeo and sLang surfaces.
- `dIssues` works with evo-ui tables, settings and issue workspace.

## Verification

```bash
composer test
find src config lang tests -name '*.php' -print0 | xargs -0 -n1 php -l
```

Then verify in the manager:

- switching module tabs does not reload legacy iframe screens;
- table/list mode survives tab switching;
- filters, sorting, search and pagination survive refresh inside the same
  manager session;
- modals save and close cleanly;
- rich editors initialize in every visible editor field;
- dIssues kanban/list switching and drag/drop still work.
