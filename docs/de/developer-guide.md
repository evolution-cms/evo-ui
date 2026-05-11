# Entwicklerhandbuch

Nutze evo-ui als deklarative UI-Grundlage. Consumer-Module liefern
Konfiguration, Provider und Persistenz; evo-ui liefert Shell, Komponenten,
State-Verhalten, Assets und visuelle Contracts.

## Modul-Shell

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        <livewire:evo-ui.module-table preset="vendor.module.items" />
    </x-evo::module-tab-shell>
</x-evo::layout>
```

Lade kein Bootstrap, jQuery, manager `main.js`, `tabpane.js`, Roboto, CDN UI
Assets oder legacy manager CSS in evo-ui Screens.

## Schichten

- evo-ui besitzt shared UI primitives, CSS tokens, runtime helpers und
  dirty-state behavior.
- Consumer besitzen routes, translations, permissions, queries, validation und
  business actions.
- Wenn zwei Module dasselbe UI pattern brauchen, gehoert es zuerst in evo-ui.

## Tests

```bash
composer test
composer drift
```

