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

## Reguly dDocs

- Linki na tej stronie celowo zostaja wewnatrz package `docs/` tree.
- Lokalne README sa entrypointami; kanoniczne kontrakty techniczne sa w root docs
  i sa dostepne przez linki powyzej.
- Przyklady kodu musza miec fenced language identifiers, aby dDocs mogl
  stabilnie podswietlac skladnie.

## Zasada

evo-ui przechowuje wspolny UI runtime. Logika domenowa, hooki i integracje zostaja
w module, ktory korzysta z evo-ui.
