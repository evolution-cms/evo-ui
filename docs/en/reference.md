# Reference

This page lists stable EvoUI package signals that modules and agents may rely
on when reading docs or running release checks.

## Core Classes

| Signal | Meaning |
| --- | --- |
| `EvoUIServiceProvider` | Registers Blade components, Livewire components, config, assets, and foundation bindings. |
| `EvoGate` | Lightweight manager authorization bridge used by Livewire screens. |
| `AuthorizationException` | Exception raised when a form/table action is not allowed. |
| `Encrypter` | Compatibility binding for Livewire encrypted payload expectations. |
| `Kernel` | Minimal HTTP kernel binding for manager Livewire requests. |
| `TrimStrings` | Foundation middleware alias used by the Livewire bridge. |
| `ConvertEmptyStringsToNull` | Foundation middleware alias used by the Livewire bridge. |
| `Foundation\Auth\Access\AuthorizationException` | Namespaced compatibility class for Laravel-style access failures. |
| `Foundation\Auth\Access\AuthorizesRequests` | Controller authorization trait shim for package compatibility. |
| `Foundation\Encryption\Encrypter` | Namespaced compatibility encryption shim. |
| `Foundation\Http\Kernel` | Namespaced compatibility kernel shim. |
| `Foundation\Http\Events\RequestHandled` | Request lifecycle signal used by the bridge layer. |
| `Foundation\Http\Middleware\TrimStrings` | Namespaced trim middleware shim. |
| `Foundation\Http\Middleware\ConvertEmptyStringsToNull` | Namespaced empty-string normalization shim. |
| `Foundation\LivewireAssetShim` | Asset bridge used when Livewire expects Laravel-style asset hooks. |
| `Foundation\bootstrap` | Bootstrap file that wires the foundation compatibility aliases. |
| `LivewireAssetShim` | Public signal for Livewire asset compatibility behavior. |
| `ResourceFormService` | Service for resource-like form value loading, casting, and save behavior. |
| `ResourceLayoutResolver` | Resolver for resource form layout and embedded resource boundaries. |
| `TvValueRepository` | Repository bridge for Evolution template variable/resource values used by resource-like forms. |

## Blade And Livewire

| Signal | Meaning |
| --- | --- |
| `x-evo::layout` | Full manager shell. |
| `evo::partials.assets` | Local CSS/JS asset partial. |
| `livewire:evo-ui.form` | Declarative form renderer. |
| `livewire:evo-ui.module-table` | Declarative table/list renderer. |
| `livewire:evo-ui.issue-workspace` | Provider-backed issue workspace. |

## Config Keys

| Key | Meaning |
| --- | --- |
| `evo-ui.forms.*` | Form presets. |
| `evo-ui.tables.*` | Table/list presets. |
| `evo-ui.module-tabs.*` | Module tabs. |
| `evo-ui.issue-workspace` | Issue workspace provider state and display configuration. |

Consumer modules own their providers, persistence, permissions, and business
rules. evo-ui owns shared UI primitives, state behavior, local assets, and
visual contracts.
