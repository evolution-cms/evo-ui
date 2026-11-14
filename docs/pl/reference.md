# Reference

| Signal | Znaczenie |
| --- | --- |
| `EvoUIServiceProvider` | Rejestruje komponenty, config, assets i foundation bindings. |
| `EvoUI::registerComponent()` | Rejestruje komponent reaktywny bez ujawniania wewnetrznego runtime pakietom klienckim. |
| `EvoUI\Components\Component` | Neutralna wzgledem runtime klasa bazowa dla komponentow pakietow klienckich. |
| `EvoGate` | Manager authorization bridge. |
| `AuthorizationException` | Brak uprawnien do akcji form/table. |
| `Encrypter` | Compatibility binding dla Livewire payloads. |
| `Kernel` | Minimalny HTTP kernel dla manager Livewire requests. |
| `TrimStrings` | Foundation middleware alias. |
| `ConvertEmptyStringsToNull` | Empty-string normalization middleware alias. |
| `Foundation\Auth\Access\AuthorizationException` | Namespaced access exception shim. |
| `Foundation\Auth\Access\AuthorizesRequests` | Controller authorization trait shim. |
| `Foundation\Encryption\Encrypter` | Namespaced encryption shim. |
| `Foundation\Http\Kernel` | Namespaced kernel shim. |
| `Foundation\Http\Events\RequestHandled` | Request lifecycle signal. |
| `Foundation\Http\Middleware\TrimStrings` | Namespaced trim middleware shim. |
| `Foundation\Http\Middleware\ConvertEmptyStringsToNull` | Namespaced empty-string middleware shim. |
| `Foundation\LivewireAssetShim` | Asset bridge dla Livewire compatibility. |
| `Foundation\bootstrap` | Bootstrap file dla foundation aliases. |
| `LivewireAssetShim` | Public signal dla Livewire asset compatibility. |
| `ResourceFormService` | Service dla resource-like forms. |
| `ResourceLayoutResolver` | Resolver dla resource form layout. |
| `TvValueRepository` | Repository bridge dla Evolution template variable/resource values. |

Key integration signals: `x-evo::layout`, `evo::partials.assets`,
`livewire:evo-ui.form`, `livewire:evo-ui.module-table`,
`livewire:evo-ui.issue-workspace`, `evo-ui.forms.*`, `evo-ui.tables.*`,
`evo-ui.module-tabs.*`, `evo-ui.issue-workspace`.
