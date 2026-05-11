# Гід розробника

Використовуйте evo-ui як shared declarative UI foundation. Consumer modules
дають config, providers і persistence; evo-ui дає shell, components, state
behavior, assets і visual contracts.

## Канонічний shell модуля

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        @if($activeTab === 'items')
            <livewire:evo-ui.module-table preset="vendor.module.items" />
        @elseif($activeTab === 'settings')
            <livewire:evo-ui.form preset="vendor.module.settings" />
        @endif
    </x-evo::module-tab-shell>
</x-evo::layout>
```

Не підключайте Bootstrap, jQuery, manager `main.js`, `tabpane.js`, Roboto, CDN
UI assets або legacy manager CSS всередині evo-ui-owned screens.

## Правила шарів

- evo-ui owns shared UI primitives, CSS tokens, runtime helpers і dirty-state.
- Consumer modules owns routes, translations, permissions, queries, validation
  semantics і business actions.
- Якщо два модулі потребують однаковий UI pattern, спочатку промоутьте його в
  evo-ui, а не копіюйте локально.
- Тимчасовий consumer CSS або JS має бути scoped і мати видиму follow-up task.

## Declarative Surfaces

Використовуйте `evo-ui.module-table` для table/list CRUD, `evo-ui.form` для
settings/model forms і `evo-ui.issue-workspace` для provider-backed
list/kanban workspaces.

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'density' => 'compact',
    'layout' => 'settings',
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

## Тести

```bash
composer test
composer drift
```

Generic UI behavior тестується в evo-ui. Module-specific business behavior
тестується в consumer module.

