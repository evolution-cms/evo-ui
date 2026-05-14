# Konfiguration

evo-ui wird ueber Package-Service-Provider konfiguriert. Consumer-Module mergen
deklarative Presets in evo-ui Namespaces; evo-ui besitzt Rendering und shared
runtime behavior.

## Namespaces

| Namespace | Zweck |
| --- | --- |
| `evo-ui.forms.*` | Form-Presets fuer settings, model und resource-like forms. |
| `evo-ui.tables.*` | Table/List-Presets und provider-backed CRUD. |
| `evo-ui.issue-workspace` | Provider-backed issue workspace. |
| `evo-ui.module-tabs.*` | Module tabs und guarded navigation metadata. |

`EvoUIServiceProvider` registriert Blade components, Livewire components, local
assets, aliases und foundation services: `EvoGate`, `Encrypter`, `Kernel`,
`TrimStrings`, `ConvertEmptyStringsToNull` und `AuthorizationException`.

Dokumentations-Lokalen sind `en`, `uk`, `pl`, `de` und `fr`. Legacy input `ua`
wird zu `uk` normalisiert; `docs/ua` wird nicht erstellt.
