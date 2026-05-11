# evo-ui

evo-ui ist die gemeinsame Livewire + DaisyUI UI-Grundlage fuer moderne
Evolution-CMS-Manager-Module.

Das Paket wird von `sArticles`, `dIssues`, `sLang`, `sSeo` und `dDocs` als
kanonische Manager-UI-Schicht genutzt. Consumer-Module beschreiben tabs,
tables, forms, workspaces, fields, providers und Speicherregeln deklarativ;
evo-ui besitzt Shell, Komponenten, State-Verhalten, Theme-Bridge und lokale
Assets.

## Wann verwenden

Verwende evo-ui fuer Manager-Screens, Settings-Formulare, Table/List CRUD,
resource-aehnliche Editoren, Issue Workspaces oder gemeinsame visuelle
Primitives. Business-Regeln, Datenhoheit, Provider-Semantik und modulbezogene
Workflows bleiben im jeweiligen Consumer-Paket.

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

## Typische Workflows

- Modul-Shell mit `x-evo::layout`, `evo::partials.assets`, module tabs und
  Livewire components aufbauen.
- Table/List-Oberflaechen ueber `evo-ui.module-table` presets definieren.
- Settings/model forms ueber `evo-ui.form` presets definieren.
- Issue workspace contract fuer provider-backed list/kanban workflows nutzen.
- Neue shared UI patterns zuerst als Contract dokumentieren, dann mit package
  tests absichern und erst danach in Consumer-Modulen verwenden.

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

- [Benutzerhandbuch](user-guide.md)
- [Entwicklerhandbuch](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Module Integration](../module-integration.md)
- [Components](../components.md)
- [Form And Field Catalogue](../forms.md)
- [Module Table Contract](../module-table-contract.md)
- [Issue Workspace Contract](../issue-workspace-contract.md)
- [Testing Matrix](../testing.md)
- [Consumers](../consumers.md)
- [Release Checklist](../release-checklist.md)
- [dDocs Tree/Viewer Notes](../ddocs-tree-viewer-notes.md)
- [Roadmap](../roadmap.md)

## dDocs-Regeln

- Diese Links bleiben bewusst innerhalb des package `docs/` tree.
- Lokalisierte README-Dateien sind Einstiegspunkte; kanonische technische
  Contracts liegen in den root docs und sind oben verlinkt.
- Codebeispiele muessen fenced language identifiers verwenden, damit dDocs die
  Syntax stabil hervorheben kann.

## Regel

evo-ui enthaelt nur den gemeinsamen UI-Runtime. Fachlogik und Integrationen
bleiben im jeweiligen Modul.
