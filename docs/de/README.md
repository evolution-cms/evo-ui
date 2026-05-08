# evo-ui

evo-ui ist die gemeinsame Livewire + DaisyUI UI-Grundlage fuer moderne
Evolution-CMS-Manager-Module.

Das Paket wird bereits von `sArticles` und `dIssues` genutzt und ist fuer die
spaetere Migration von `sLang`, `sSeo` und weiteren Extras vorgesehen.

## Funktionen

- Eigener Manager-Iframe-Layout mit lokalen Assets.
- Synchronisierung der Evolution-Manager-Themes.
- Livewire-4-Bridge fuer Manager-Routes, CSRF und Sessions.
- Konfigurationsgesteuerte Tabellen mit Filtern, Suche, Sortierung,
  Pagination, Tabellen-/Listenansicht, Inline-Edit, Modal-Edit, Row Actions und
  Reorder.
- Konfigurationsgesteuerte Formulare fuer Einstellungen und Resource-Editoren.
- Provider-basiertes Workspace fuer Kanban-/Listen-Workflows.
- Gemeinsame Komponenten fuer Buttons, Icons, Tabs, Modals, Badges, Cards,
  Choices, Image/File-Felder und Rich Editors.
- Speicherung des aktuellen UI-Zustands in der Manager-Session.

## Beispiel

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tabs :items="$tabs" :active="$activeTab" />

    <livewire:evo-ui.module-table
        preset="vendor.module.items"
        :context="['moduleUrl' => $moduleUrl]"
    />
</x-evo::layout>
```

## Dokumente

- [Module Integration](../module-integration.md)
- [Components](../components.md)
- [Module Table Contract](../module-table-contract.md)
- [Consumers](../consumers.md)
- [Release Checklist](../release-checklist.md)
- [Roadmap](../roadmap.md)

## Regel

evo-ui enthaelt nur den gemeinsamen UI-Runtime. Fachlogik und Integrationen
bleiben im jeweiligen Modul.
