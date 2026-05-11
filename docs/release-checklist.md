# evo-ui Release Checklist And Smoke Matrix

Use this checklist before changing shared evo-ui behavior, tagging a release, or
updating a consumer module to a new evo-ui revision.

## 1. Package Contract Suite

Run from `/Users/dmi3yy/PhpstormProjects/Extras/evo-ui`:

```bash
php -l tests/run.php
composer test
node --check resources/js/evo-ui.js
find src config lang tests -name '*.php' -print0 | xargs -0 -n1 php -l
```

Required result:

- `composer test` passes all package groups: package, assets, design-tokens,
  state, module-table, issue-workspace, forms.
- JS syntax passes.
- PHP syntax passes.

## 2. Consumer Compatibility Suites

Run from each consumer root.

```bash
cd /Users/dmi3yy/PhpstormProjects/Extras/sArticles
php -l tests/run.php
composer test
```

```bash
cd /Users/dmi3yy/PhpstormProjects/Extras/dIssues
php -l tests/Unit/EvoUIPackageDelegationContractTest.php
demo/core/vendor/bin/phpunit --configuration demo/core/phpunit.xml tests/Unit/EvoUIPackageDelegationContractTest.php
```

```bash
cd /Users/dmi3yy/PhpstormProjects/Extras/sLang
php -l tests/run.php
composer test
```

```bash
cd /Users/dmi3yy/PhpstormProjects/Extras/sSeo
php -l tests/Unit/EvoUiCompatibilityMatrixContractTest.php
composer test
```

Required result:

- sArticles compatibility suite passes.
- dIssues delegation contract passes and evo-ui package suite remains green.
- sLang repeatable suite passes.
- sSeo full unit suite passes.

## 3. Runtime Shell Smoke

Open each module in the Evolution manager demo and verify:

- Module shell loads without a blank iframe.
- `data-evo-ui-root` exists on evo-ui-owned screens.
- Current theme is reflected through `data-theme` and `data-theme-mode`.
- `evo::partials.assets` loads only local `evo-ui.css` and `evo-ui.js`.
- No evo-ui-owned screen loads Bootstrap/CDN/legacy manager bundles directly.
- Browser console has no syntax/runtime errors during initial load.
- `composer drift` has been reviewed, and any strict-mode allowlist entries are
  linked to visible consumer cleanup tasks.

## 4. Tab And Dirty-State Smoke

Verify in sArticles, sLang and sSeo module shells:

- Switching tabs works without reloading the manager iframe.
- Editing a config form marks the form dirty.
- Attempting to switch tabs while dirty opens the unsaved changes prompt.
- Cancel keeps the current tab.
- Discard switches tabs and does not save.
- Save switches only after the `evo-ui:form.saved` flow completes.

## 5. Table/List Smoke

Verify with sArticles and sSeo redirects:

- Search filters rows and survives pagination.
- Sort controls update the active column/direction.
- Per-page selection works.
- Table/list switching keeps the same row data.
- Session state restores search, sort, page, per-page and view in the same manager session.
- Row actions render the expected icons and tones.
- Double-click edit works where `row_dblclick` is enabled.

## 6. Modal And Field Smoke

Verify in sArticles article modal and sSeo redirects modal:

- Create, edit, save and close flows complete.
- Delete confirmation opens and closes correctly.
- Provider duplicate/delete guards render shared evo-ui errors.
- `choices` fields can add/remove values and search options.
- Image fields open the manager image browser.
- File fields open the manager file browser.
- Rich editor fields sync content before save.
- Builder/repeater rows add, move and remove without layout shift.
- Color-picker/config-map fields stay styled in light and dark themes.

## 7. Issue Workspace Smoke

Verify in dIssues:

- Kanban and list displays both load.
- Category, status, phase, priority and assignee filters work.
- Archive toggle changes visible issues.
- Search filters list/kanban results.
- Issue preview opens from kanban and split list.
- Comments, reply-to-comment, reply-and-close, close and reopen flows work.
- Assign-to-me, assign and unassign actions work.
- Parent/child and subtask progress markers render.
- Kanban drag/drop sends a normalized lane payload and persists order.
- Workspace state restores within the same manager session.

## 8. sLang Smoke

Verify in sLang:

- Dictionary table renders dynamic language columns.
- Key and language values save through inline edit.
- Non-default languages show inline auto-translate and header auto-translate actions.
- Default language does not show auto-translate actions.
- Settings choices keep the default language locked.
- Resource tabs keep legacy manager payload names and submit sync behavior.

## 9. sSeo Smoke

Verify in sSeo:

- Dashboard loads.
- Redirects table/list/modal CRUD works.
- Configure form saves CSV, checkbox and select fields.
- Analytics form validates GTM and GA4 ids.
- Server protocol field renders as a static evo-ui badge.
- Robots editor loads CodeMirror fallback and saves the target file.
- Meta templates editor saves `sseo_*` system settings.
- Resource SEO partial saves existing `sseo[...]` payload fields.

## 10. Release Gate

For the current `evo-ui`, `sSeo`, `sLang` and `sSettings` release lane, run:

```bash
composer release-gate
```

The direct command is:

```bash
php tests/consumer-drift.php --release-gate
```

This gate must report `sSeo` green or only documented adapters. It reports
`sLang` green only after module inline UI is gone and the remaining resource
bridge is allowlisted with exact reasons. For the first `sSettings` release,
the visually accepted manager config bridge and dirty-field modal exclusions are
allowed with exact follow-up reasons; new module-local manager CSS/JS still
blocks release unless it is documented as a narrow adapter. See
[Four-Module Release Gate](four-module-release-gate.md).

Do not tag or merge shared evo-ui changes until:

- package suite is green;
- changed consumer suite is green;
- at least one unaffected consumer suite is green;
- manual smoke covers the touched surface;
- docs are updated before new shared patterns are used by consumers;
- generic behavior has package tests;
- module-specific behavior has consumer tests.
