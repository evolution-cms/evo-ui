# evo-ui

evo-ui is the Livewire + DaisyUI foundation for modern Evolution CMS manager
modules. It is a technical package, not a standalone manager module.

The package lets modules such as `sArticles` and `dIssues` render modern manager
screens without pulling legacy manager CSS, jQuery, Bootstrap, `main.js`,
`tabpane.js`, Roboto, or CDN assets into the iframe.

## What It Provides

- `x-evo::layout` manager iframe shell with local CSS/JS assets.
- Evolution manager theme sync for `evolight`, `evolightness`, `evodark`, and
  `evodarkness`.
- Livewire 4 bridge for Evolution manager routes, sessions, CSRF, assets, and
  minimal Laravel-style services.
- Config-driven module tables with table/list views, filters, sorting,
  pagination, inline edit, modal edit, row actions, drag reorder, and session
  state persistence.
- Config-driven forms for manager settings and resource-like forms.
- Provider-backed issue/workspace surface used by `dIssues`.
- Shared Blade components for buttons, icons, tabs, modals, cards, badges,
  choices, image fields, rich editors, and table cells.

## Consumers

- `sArticles`: publications, dictionaries, settings, article editor, sSeo and
  sLang integration surfaces.
- `dIssues`: issue tables, settings forms, kanban/list issue workspace and
  conversation preview.
- Planned next consumers: `sLang`, `sSeo`, and other manager modules that need
  the same Livewire runtime.

## Install In A Module

```json
{
  "require": {
    "evolution-cms/evo-ui": "^1.0"
  }
}
```

Render an evo-ui-owned manager document:

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tabs :items="$tabs" :active="$activeTab" />

    <livewire:evo-ui.module-table
        preset="vendor.module.items"
        :context="['moduleUrl' => $moduleUrl]"
    />
</x-evo::layout>
```

## Documentation

Start from [`docs/`](docs/README.md).

- [`docs/module-integration.md`](docs/module-integration.md): module shell,
  assets, provider registration and examples.
- [`docs/module-table-contract.md`](docs/module-table-contract.md): table,
  list, filters, modal and provider contracts.
- [`docs/components.md`](docs/components.md): component catalogue and usage.
- [`docs/consumers.md`](docs/consumers.md): how `sArticles` and `dIssues`
  currently consume evo-ui.
- [`docs/release-checklist.md`](docs/release-checklist.md): first-release
  readiness checklist.
- [`docs/roadmap.md`](docs/roadmap.md): useful base components to add before
  migrating `sLang` and `sSeo`.

Localized entrypoints:

- [`docs/en/`](docs/en/README.md)
- [`docs/ua/`](docs/ua/README.md)
- [`docs/ru/`](docs/ru/README.md)
- [`docs/de/`](docs/de/README.md)
- [`docs/fr/`](docs/fr/README.md)
- [`docs/pl/`](docs/pl/README.md)

## Tests

Run the package smoke/contract suite from the package root:

```bash
composer test
```

Run a PHP syntax pass before release:

```bash
find src config lang tests -name '*.php' -print0 | xargs -0 -n1 php -l
```

## Release Notes

This package is release-ready when:

- all consumer modules use evo-ui-owned iframe documents;
- no new screen mixes evo-ui with legacy manager UI bundles;
- session state persistence works for table/workspace filters and views;
- docs, translations, assets and smoke tests are updated together.
