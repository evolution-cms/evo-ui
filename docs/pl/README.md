# evo-ui

evo-ui to wspolna baza UI Livewire + DaisyUI dla nowoczesnych modulow managera
Evolution CMS.

Pakiet jest uzywany przez `sArticles`, `dIssues`, `sLang`, `sSeo` i `dDocs`
jako kanoniczna warstwa UI managera. Moduly consumer deklaratywnie opisuja
tabs, tables, forms, workspaces, fields, providers i zasady zapisu, a evo-ui
odpowiada za shell, komponenty, state behavior, theme bridge i lokalne assets.

## Kiedy uzywac

Uzywaj evo-ui dla manager screen, settings form, table/list CRUD,
resource-like editor, issue workspace albo wspolnych primitives wizualnych.
Reguly biznesowe, ownership danych, provider semantics i workflow konkretnego
modulu zostaja w consumer package.

## Funkcje

- Wlasny manager iframe layout z lokalnymi assetami.
- Synchronizacja motywow Evolution managera.
- Livewire 4 bridge dla manager routes, CSRF i sesji.
- Tabele konfiguracyjne z filtrami, wyszukiwaniem, sortowaniem, paginacja,
  widokiem table/list, inline edit, modal edit, row actions i reorder.
- Formularze konfiguracyjne dla ustawien i edytorow zasobow.
- Provider-backed workspace dla scenariuszy kanban/list.
- Wspolne komponenty: przyciski, ikony, taby, modale, badge, karty, choices,
  pola image/file i rich editors.
- Zapamietywanie aktualnego stanu UI w sesji managera.

## Typowe workflow

- Zbuduj shell modulu przez `x-evo::layout`, `evo::partials.assets`, module
  tabs i Livewire components.
- Opisz powierzchnie table/list przez `evo-ui.module-table` presets.
- Opisz settings/model forms przez `evo-ui.form` presets.
- Uzyj issue workspace contract dla provider-backed list/kanban workflows.
- Nowy shared UI pattern najpierw dokumentuj jako contract, potem pokryj package
  tests, a dopiero potem konsumuj w modulach.

## Przyklad

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tabs :items="$tabs" :active="$activeTab" />

    <livewire:evo-ui.module-table
        preset="vendor.module.items"
        :context="['moduleUrl' => $moduleUrl]"
    />
</x-evo::layout>
```

## Dokumentacja

- [Przewodnik uzytkownika](user-guide.md)
- [Przewodnik dewelopera](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Konfiguracja](configuration.md)
- [Reference](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Standardy dokumentacji](documentation-standards.md)
- [Module Integration](../en/guide/module-integration.md)
- [Components](../en/components/README.md)
- [Action Buttons](components/action-buttons.md)
- [DnD i reorder](components/dnd.md)
- [Komponent Table](components/table.md)
- [Komponent Form](components/form.md)
- [Form And Field Catalogue](../en/components/form-fields.md)
- [Module Table Contract](../en/components/module-table-contract.md)
- [Issue Workspace Contract](../en/components/issue-workspace-contract.md)
- [Testing Matrix](../en/guide/testing.md)
- [Consumers](../en/guide/consumers.md)
- [Release Checklist](../en/guide/release-checklist.md)
- [dDocs Tree/Viewer Notes](../en/guide/ddocs-tree-viewer-notes.md)
- [Roadmap](../en/guide/roadmap.md)

## Reguly dDocs

- Linki na tej stronie celowo zostaja wewnatrz package `docs/` tree.
- Lokalne README sa entrypointami; kanoniczne kontrakty techniczne sa w root docs
  i sa dostepne przez linki powyzej.
- Przyklady kodu musza miec fenced language identifiers, aby dDocs mogl
  stabilnie podswietlac skladnie.

## Zasada

evo-ui przechowuje wspolny UI runtime. Logika domenowa, hooki i integracje zostaja
w module, ktory korzysta z evo-ui.
