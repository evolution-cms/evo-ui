# Configuration

evo-ui is configured by package service providers. Consumer modules merge their
own declarative presets into evo-ui namespaces; evo-ui owns rendering and shared
runtime behavior.

## Namespaces

| Namespace | Purpose |
| --- | --- |
| `evo-ui.forms.*` | Form presets for settings, model, and resource-like forms. |
| `evo-ui.tables.*` | Module table/list presets and provider-backed CRUD surfaces. |
| `evo-ui.issue-workspace` | Provider-backed issue workspace surface. |
| `evo-ui.module-tabs.*` | Module tab definitions and guarded navigation metadata. |

## Service Provider

Register `EvoUIServiceProvider` through Composer/package discovery or the
Evolution package provider list. The provider registers Blade components,
Livewire components, local assets, aliases, and lightweight Livewire foundation
services.

```php
$this->mergeConfigFrom(
    __DIR__ . '/../config/settings/form.php',
    'evo-ui.forms.vendor.module.settings'
);
```

## Runtime Boundaries

evo-ui provides the manager shell, `EvoGate`, `Encrypter`, `Kernel`,
`TrimStrings`, `ConvertEmptyStringsToNull`, and `AuthorizationException`
compatibility shims required by manager Livewire screens. Consumer modules must
not replace those shims or add Bootstrap, jQuery, CDN, or legacy manager assets
to evo-ui-owned screens.

## Locale Policy

Documentation uses `en`, `uk`, `pl`, `de`, and `fr`. Legacy Evolution manager
input `ua` is normalized to `uk`; do not create `docs/ua`.
