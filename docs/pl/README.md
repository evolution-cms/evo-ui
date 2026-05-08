# evo-ui

evo-ui to wspolna baza UI Livewire + DaisyUI dla nowoczesnych modulow managera
Evolution CMS.

Pakiet jest juz uzywany przez `sArticles` i `dIssues`, a nastepnie ma posluzyc
do migracji `sLang`, `sSeo` i kolejnych extras.

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

- [Module Integration](../module-integration.md)
- [Components](../components.md)
- [Module Table Contract](../module-table-contract.md)
- [Consumers](../consumers.md)
- [Release Checklist](../release-checklist.md)
- [Roadmap](../roadmap.md)

## Zasada

evo-ui przechowuje wspolny UI runtime. Logika domenowa, hooki i integracje zostaja
w module, ktory korzysta z evo-ui.
