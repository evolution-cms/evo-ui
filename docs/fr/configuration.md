# Configuration

evo-ui est configure par les service providers des packages. Les modules
consommateurs ajoutent des presets declaratifs dans les namespaces evo-ui; evo-ui
possede le rendering et le shared runtime behavior.

## Namespaces

| Namespace | But |
| --- | --- |
| `evo-ui.forms.*` | Presets de formulaires pour settings, model et resource-like forms. |
| `evo-ui.tables.*` | Presets table/list et provider-backed CRUD. |
| `evo-ui.issue-workspace` | Provider-backed issue workspace. |
| `evo-ui.module-tabs.*` | Module tabs et guarded navigation metadata. |

`EvoUIServiceProvider` enregistre Blade components, Livewire components, local
assets, aliases et foundation services: `EvoGate`, `Encrypter`, `Kernel`,
`TrimStrings`, `ConvertEmptyStringsToNull` et `AuthorizationException`.

Les locales de documentation sont `en`, `uk`, `pl`, `de` et `fr`. L'input
legacy `ua` est normalise vers `uk`; ne creez pas `docs/ua`.
