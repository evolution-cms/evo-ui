# Referenz

| Signal | Bedeutung |
| --- | --- |
| `EvoUIServiceProvider` | Registriert Komponenten, config, assets und foundation bindings. |
| `EvoUI::registerComponent()` | Registriert eine reaktive Komponente, ohne den internen Runtime fuer Consumer offenzulegen. |
| `EvoUI\Components\Component` | Runtime-neutrale Basisklasse fuer reaktive Komponenten von Consumer-Paketen. |
| `EvoGate` | Manager authorization bridge. |
| `AuthorizationException` | Fehlende Berechtigung fuer form/table action. |
| `Encrypter` | Compatibility binding fuer Livewire payloads. |
| `Kernel` | Minimaler HTTP kernel fuer manager Livewire requests. |
| `TrimStrings` | Foundation middleware alias. |
| `ConvertEmptyStringsToNull` | Empty-string normalization middleware alias. |
| `Foundation\Auth\Access\AuthorizationException` | Namespaced access exception shim. |
| `Foundation\Auth\Access\AuthorizesRequests` | Controller authorization trait shim. |
| `Foundation\Encryption\Encrypter` | Namespaced encryption shim. |
| `Foundation\Http\Kernel` | Namespaced kernel shim. |
| `Foundation\Http\Events\RequestHandled` | Request lifecycle signal. |
| `Foundation\Http\Middleware\TrimStrings` | Namespaced trim middleware shim. |
| `Foundation\Http\Middleware\ConvertEmptyStringsToNull` | Namespaced empty-string middleware shim. |
| `Foundation\LivewireAssetShim` | Asset bridge fuer Livewire compatibility. |
| `Foundation\bootstrap` | Bootstrap file fuer foundation aliases. |
| `LivewireAssetShim` | Public signal fuer Livewire asset compatibility. |
| `ResourceFormService` | Service fuer resource-like forms. |
| `ResourceLayoutResolver` | Resolver fuer resource form layout. |
| `TvValueRepository` | Repository bridge fuer Evolution template variable/resource values. |

Wichtige Integration: `x-evo::layout`, `evo::partials.assets`,
`livewire:evo-ui.form`, `livewire:evo-ui.module-table`,
`livewire:evo-ui.issue-workspace`, `evo-ui.forms.*`, `evo-ui.tables.*`,
`evo-ui.module-tabs.*`, `evo-ui.issue-workspace`.
