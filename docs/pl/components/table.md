# Komponent Table

`Table` to kanoniczna powierzchnia EvoUI dla list managera i CRUD. Pelny
kontrakt znajduje sie w [Table Component](../../en/components/table/README.md).

## Standardowa Struktura

Kazda tabela EvoUI ma:

- toolbar z tytulem/akcjami po lewej oraz filtrami, przelacznikiem widoku,
  control actions i wyszukiwaniem po prawej;
- widok table oraz opcjonalny widok list oparty o te same row data;
- ostatnia kolumne row actions dla edit, delete, duplicate lub akcji domenowych;
- opcjonalne double-click edit przez wspolny modal;
- wspolny pagination footer;
- wspolne modale create/edit i delete.

## Uzycie

```blade
<x-evo::table.livewire
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

## Ownership

EvoUI odpowiada za toolbar layout, filters, search, sorting, table/list chrome,
row action visuals, modals, pagination i state persistence. Consumer provider
odpowiada za queries, filter mapping, validation, save, delete guards, reorder
persistence i business actions.

## Nie Robic

- Nie dodawac module-local CSS ani pagination dla tabel.
- Nie dodawac drugiej search/filter toolbar.
- Actions maja byc w toolbar albo ostatniej kolumnie row actions.
- List view i table view maja pokazywac ten sam business state.
- Nie kopiowac modal/delete/double-click behavior do consumer.


## Pierwsze renderowanie responsywne

W bieżącej gałęzi rozwojowej komponent nadrzędny może wysłać szerokość kontenera wraz ze zmianą karty. Zadeklaruj `public int $tableWidth = 0`, dodaj `responsive-width-model="tableWidth"` do `x-evo::module-tab-shell` i przekaż `responsive_width` w kontekście zagnieżdżonej tabeli.

Jawne parametry URL i zapisany ręczny wybór widoku mają pierwszeństwo. Próg `responsive_list` wynosi domyślnie 1200 pikseli CSS; 0 wyłącza automatyczne przełączanie. Bez wskazówki szerokości oraz przy zmianie rozmiaru działa dotychczasowy mechanizm. Początkowe ładowanie dokumentu nadal może wymagać dodatkowego żądania.

```blade
<x-evo::module-tab-shell model="activeTab" responsive-width-model="tableWidth">
    <x-evo::table.livewire
        :preset="$activePreset"
        :context="['tab' => $activeTab, 'responsive_width' => $tableWidth]"
        :wire-key="$activePreset"
    />
</x-evo::module-tab-shell>
```

[Responsive first render](../../en/components/module-table-contract.md#responsive-first-render).
