# Konfiguracja

evo-ui jest konfigurowany przez service provider pakietu. Moduly consumer
dodaja deklaratywne presets do namespace evo-ui, a evo-ui odpowiada za rendering
i wspolne runtime behavior.

## Namespaces

| Namespace | Cel |
| --- | --- |
| `evo-ui.forms.*` | Presets formularzy dla settings, model i resource-like forms. |
| `evo-ui.tables.*` | Presets table/list i provider-backed CRUD. |
| `evo-ui.issue-workspace` | Provider-backed issue workspace. |
| `evo-ui.module-tabs.*` | Module tabs i guarded navigation metadata. |

`EvoUIServiceProvider` rejestruje Blade components, Livewire components, local
assets, aliases oraz lightweight foundation services: `EvoGate`, `Encrypter`,
`Kernel`, `TrimStrings`, `ConvertEmptyStringsToNull` i `AuthorizationException`.

Dokumentacja uzywa `en`, `uk`, `pl`, `de` i `fr`. Legacy input `ua` mapuje sie
do `uk`; nie tworzymy `docs/ua`.
