# Гід розробника

Використовуйте evo-ui як shared declarative UI foundation. Consumer modules
дають config, providers і persistence; evo-ui дає shell, components, state
behavior, assets і visual contracts.

## Канонічний shell модуля

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        <livewire:evo-ui.module-table preset="vendor.module.items" />
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

## Тести

```bash
composer test
composer drift
```

