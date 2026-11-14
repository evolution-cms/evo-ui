# Reference

| Signal | Sens |
| --- | --- |
| `EvoUIServiceProvider` | Enregistre composants, config, assets et foundation bindings. |
| `EvoUI::registerComponent()` | Declare un composant reactif sans exposer le runtime interne aux packages consommateurs. |
| `EvoUI\Components\Component` | Classe de base neutre vis-a-vis du runtime pour les composants consommateurs. |
| `EvoGate` | Manager authorization bridge. |
| `AuthorizationException` | Action form/table non autorisee. |
| `Encrypter` | Compatibility binding pour Livewire payloads. |
| `Kernel` | Minimal HTTP kernel pour manager Livewire requests. |
| `TrimStrings` | Foundation middleware alias. |
| `ConvertEmptyStringsToNull` | Empty-string normalization middleware alias. |
| `Foundation\Auth\Access\AuthorizationException` | Namespaced access exception shim. |
| `Foundation\Auth\Access\AuthorizesRequests` | Controller authorization trait shim. |
| `Foundation\Encryption\Encrypter` | Namespaced encryption shim. |
| `Foundation\Http\Kernel` | Namespaced kernel shim. |
| `Foundation\Http\Events\RequestHandled` | Request lifecycle signal. |
| `Foundation\Http\Middleware\TrimStrings` | Namespaced trim middleware shim. |
| `Foundation\Http\Middleware\ConvertEmptyStringsToNull` | Namespaced empty-string middleware shim. |
| `Foundation\LivewireAssetShim` | Asset bridge pour Livewire compatibility. |
| `Foundation\bootstrap` | Bootstrap file pour foundation aliases. |
| `LivewireAssetShim` | Public signal pour Livewire asset compatibility. |
| `ResourceFormService` | Service pour resource-like forms. |
| `ResourceLayoutResolver` | Resolver pour resource form layout. |
| `TvValueRepository` | Repository bridge pour Evolution template variable/resource values. |

Signaux d'integration: `x-evo::layout`, `evo::partials.assets`,
`livewire:evo-ui.form`, `livewire:evo-ui.module-table`,
`livewire:evo-ui.issue-workspace`, `evo-ui.forms.*`, `evo-ui.tables.*`,
`evo-ui.module-tabs.*`, `evo-ui.issue-workspace`.
