# Przewodnik dewelopera

Uzywaj evo-ui jako deklaratywnej foundation UI. Moduly consumer dostarczaja
konfiguracje, providerow i persistence; evo-ui dostarcza shell, komponenty,
state behavior, assets i visual contracts.

## Shell modulu

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        <livewire:evo-ui.module-table preset="vendor.module.items" />
    </x-evo::module-tab-shell>
</x-evo::layout>
```

Nie laduj Bootstrap, jQuery, manager `main.js`, `tabpane.js`, Roboto, CDN UI
assets ani legacy manager CSS w ekranach evo-ui.

## Warstwy

- evo-ui posiada shared UI primitives, CSS tokens, runtime helpers i dirty-state
  behavior.
- Consumer posiada routes, translations, permissions, queries, validation i
  business actions.
- Jezeli dwa moduly potrzebuja tego samego UI pattern, najpierw przenies go do
  evo-ui.

## Testy

```bash
composer test
composer drift
```

