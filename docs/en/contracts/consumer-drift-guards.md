# Consumer Drift Guards

`evo-ui` owns shared manager UI primitives. Consumer modules should not quietly
move common styling or runtime behavior back into package-local CSS/JS.

Run the drift report from the evo-ui package:

```bash
composer drift
```

Strict mode is available for release gates after current consumer cleanup work
has either removed or allowlisted known drift:

```bash
php tests/consumer-drift.php --strict
```

The four-module release gate focuses on `evo-ui`, `sSeo`, `sLang` and
`sSettings`:

```bash
composer release-gate
```

Equivalent direct command:

```bash
php tests/consumer-drift.php --release-gate
```

JSON output is available for dashboards or CI annotations:

```bash
php tests/consumer-drift.php --json
```

## What It Flags

The checker scans sibling Extras consumers when they exist:

- `sArticles`
- `dIssues`
- `sLang`
- `sSeo`
- `sSettings`
- `dDocs`

It reports:

- inline `<style>` blocks;
- inline `<script>` blocks;
- remote CDN asset markers such as `unpkg`, `jsdelivr`, `cdnjs`, `googleapis`
  and `gstatic`;
- legacy manager asset markers such as `styles.min.css`, `tabpane.js`,
  `main.js`, `jquery`, `bootstrap` and `roboto`;
- consumer CSS that targets common evo-ui atoms such as buttons, forms, fields,
  modals, tables, badges, chips and row actions.

## Allowlist

Known transitional exceptions live in:

```text
tests/consumer-drift-allowlist.php
```

Allowlist entries must be task-owned and temporary. Prefer removing drift over
adding broad exceptions.

Release-gate metadata also lives in this file under `_releaseGate`. It names the
four release modules, package-level evo-ui checks, and exact allowed adapter
reasons. Do not add a release exception without naming why the code is an
adapter instead of shared manager UI.

Example:

```php
return [
    'sLang' => [
        'views/tabs.blade.php' => ['inline-style', 'inline-script'],
    ],
];
```

## Rules

- Report mode may be used while consumer migration tasks are still open.
- Strict mode should be enabled for a consumer after its drift cleanup task is
  complete.
- Release gate mode must stay non-zero while a release consumer has active
  module-local manager UI drift that has not been accepted with an exact
  temporary adapter reason and follow-up cleanup task.
- Do not allowlist new module-local styling for standard Save buttons, tabs,
  fields, modals, tables or row actions.
- Embedded resource tabs may keep scoped bridge code only when the
  [Embedded Resource Contract](embedded-resource.md) allows it.
- Specialized editor workspaces may keep scoped code only when the
  [Editor Media Adapter Contract](editor-media-adapter.md) allows it.
