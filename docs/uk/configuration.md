# Конфігурація

evo-ui конфігурується через service provider-и пакетів. Consumer-модулі
додають декларативні presets у простори імен evo-ui, а evo-ui відповідає за
rendering і спільну runtime-поведінку.

## Простори імен

| Namespace | Призначення |
| --- | --- |
| `evo-ui.forms.*` | Presets форм для settings, model і resource-like форм. |
| `evo-ui.tables.*` | Presets table/list і provider-backed CRUD surfaces. |
| `evo-ui.issue-workspace` | Provider-backed issue workspace. |
| `evo-ui.module-tabs.*` | Module tabs і guarded navigation metadata. |

## Provider

`EvoUIServiceProvider` реєструє Blade components, Livewire components, локальні
assets, aliases і lightweight Livewire foundation services.

```php
$this->mergeConfigFrom(
    __DIR__ . '/../config/settings/form.php',
    'evo-ui.forms.vendor.module.settings'
);
```

## Runtime Boundaries

evo-ui надає manager shell, `EvoGate`, `Encrypter`, `Kernel`, `TrimStrings`,
`ConvertEmptyStringsToNull` і `AuthorizationException` compatibility shims.
Consumer-модулі не мають підміняти ці shims або додавати Bootstrap, jQuery, CDN
чи legacy manager assets на evo-ui-owned screens.

## Locale Policy

Документація використовує `en`, `uk`, `pl`, `de` і `fr`. Legacy manager input
`ua` нормалізується до `uk`; папку `docs/ua` створювати не можна.
