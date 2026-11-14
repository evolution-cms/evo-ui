# Довідник

Ця сторінка фіксує стабільні EvoUI package signals для людей, агентів і
release checks.

## Core Classes

| Signal | Значення |
| --- | --- |
| `EvoUIServiceProvider` | Реєструє Blade, Livewire, config, assets і foundation bindings. |
| `EvoUI::registerComponent()` | Оголошує реактивний компонент без залежності пакета-споживача від внутрішнього runtime. |
| `EvoUI\Components\Component` | Runtime-neutral базовий клас для реактивних компонентів пакетів-споживачів. |
| `EvoGate` | Lightweight manager authorization bridge. |
| `AuthorizationException` | Помилка, коли form/table action недоступна. |
| `Encrypter` | Compatibility binding для Livewire payload expectations. |
| `Kernel` | Minimal HTTP kernel binding для manager Livewire requests. |
| `TrimStrings` | Foundation middleware alias. |
| `ConvertEmptyStringsToNull` | Foundation middleware alias для empty-string normalization. |
| `Foundation\Auth\Access\AuthorizationException` | Compatibility class для access failures. |
| `Foundation\Auth\Access\AuthorizesRequests` | Controller authorization trait shim. |
| `Foundation\Encryption\Encrypter` | Namespaced encryption shim. |
| `Foundation\Http\Kernel` | Namespaced kernel shim. |
| `Foundation\Http\Events\RequestHandled` | Request lifecycle signal. |
| `Foundation\Http\Middleware\TrimStrings` | Namespaced trim middleware shim. |
| `Foundation\Http\Middleware\ConvertEmptyStringsToNull` | Namespaced empty-string middleware shim. |
| `Foundation\LivewireAssetShim` | Asset bridge для Livewire compatibility. |
| `Foundation\bootstrap` | Bootstrap file для foundation aliases. |
| `LivewireAssetShim` | Public signal для Livewire asset compatibility. |
| `ResourceFormService` | Service для resource-like form values і save behavior. |
| `ResourceLayoutResolver` | Resolver для resource form layout і embedded boundaries. |
| `TvValueRepository` | Repository bridge для Evolution template variable/resource values. |

## Blade And Livewire

| Signal | Значення |
| --- | --- |
| `x-evo::layout` | Full manager shell. |
| `evo::partials.assets` | Local CSS/JS asset partial. |
| `livewire:evo-ui.form` | Declarative form renderer. |
| `livewire:evo-ui.module-table` | Declarative table/list renderer. |
| `livewire:evo-ui.issue-workspace` | Provider-backed issue workspace. |

## Config Keys

`evo-ui.forms.*`, `evo-ui.tables.*`, `evo-ui.module-tabs.*` і
`evo-ui.issue-workspace` є shared integration namespaces. Business rules і
persistence лишаються в consumer modules.
