# Four-Module Release Gate

This gate is the release-readiness contract for:

- `evo-ui`
- `sSeo`
- `sLang`
- `sSettings`

It exists so agents do not hide real manager UI drift behind broad allowlists.
The gate separates release blockers from documented compatibility adapters.

## Command

Run from `/Users/dmi3yy/PhpstormProjects/Extras/evo-ui`:

```bash
composer release-gate
```

Equivalent direct command:

```bash
php tests/consumer-drift.php --release-gate
```

The command prints one grouped release summary. It exits with a non-zero status
while `sSeo`, `sLang`, or `sSettings` still have active CSS/JS drift blockers
that have not been accepted as documented first-release adapters.

Use JSON output when a dashboard or agent needs machine-readable status:

```bash
php tests/consumer-drift.php --release-gate --json
```

## What Blocks Release

These findings are blockers unless a task explicitly turns them into shared
evo-ui primitives or a documented adapter:

- inline `<style>` blocks in evo-ui-owned manager screens;
- inline `<script>` blocks that implement generic manager behavior;
- remote CDN UI assets;
- legacy manager asset markers such as Bootstrap, jQuery, `main.js`,
  `tabpane.js`, `styles.min.css`, or Roboto;
- consumer CSS that restyles common evo-ui atoms such as buttons, tabs, fields,
  tables, modals, badges, chips, row actions, DnD rows, or save controls.

## Allowed Adapter Boundary

Allowed adapters must stay narrow and task-owned in
`tests/consumer-drift-allowlist.php`.

Allowed examples:

- site-content output, such as `sSeo` analytics snippets rendered for the public
  site rather than the manager UI;
- temporary editor bridges covered by the
  [Editor Media Adapter Contract](editor-media-adapter-contract.md);
- Evolution resource-form bridges covered by the
  [Embedded Resource Contract](embedded-resource-contract.md).

Not allowed:

- module-local styling for shared Save buttons, tabs, panels, fields, tables,
  modals, cards, chips, badges, DnD rows, or row actions;
- broad file-level allowlists with no exact reason;
- moving consumer business rules into evo-ui just to make the drift report pass.

## Current Release Interpretation

The May 2026 release lane uses this interpretation:

- `evo-ui`: package gate is `composer test`, `composer validate --strict
  --no-check-publish`, and `node --check resources/js/evo-ui.js`.
- `sSeo`: green for manager UI drift; remaining allowed scripts are site-content
  analytics output or documented editor/shell bridges.
- `sSettings`: green for the first release after visual QA. The remaining
  manager config bridge and dirty-field modal exclusions are documented
  temporary adapters; cleanup stays tracked in the next sSettings WebUI pass.
- `sLang`: green only when module inline UI is removed and the remaining
  resource tab bridge is isolated under the embedded resource contract with
  exact allowlist reasons.

## Release Workflow

1. Run package checks in `evo-ui`.
2. Run `composer release-gate`.
3. Fix active blockers in the owning consumer project.
4. Add allowlist entries only for exact compatibility adapters with a reason.
5. Re-run the consumer tests and smoke scripts listed in
   [Testing Matrix](testing.md).
6. Re-run `composer release-gate` before tagging.
