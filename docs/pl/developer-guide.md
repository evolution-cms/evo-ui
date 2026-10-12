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


## Dodatkowe elementy nawigacji i opisy pól

`module-tab-shell` udostępnia opcjonalny slot `navigationAside` dla znacznika stanu lub innego dodatkowego elementu. EvoUI umieszcza go po prawej stronie i wyśrodkowuje w pionie; karty zachowują własne przewijanie poziome. Moduły korzystające ze slotu nie powinny ustawiać jego pozycji bezwzględnej.

```blade
<x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
    <x-slot:navigationAside>
        <x-evo::badge :label="$statusLabel" icon="activity" />
    </x-slot:navigationAside>
    <!-- Module content -->
</x-evo::module-tab-shell>
```

`EvoUI\Support\DescriptionHtml::render($description)` zwraca oczyszczony HTML opisów wprowadzonych przez administratora. Zachowuje odnośniki względne, HTTP(S), mailto i tel, podstawowe wyróżnienia, kod i podziały wierszy. Elementy wykonujące skrypty i dowolne atrybuty są usuwane. Jako HTML bez kodowania należy wyświetlać wyłącznie oczyszczony wynik.

Typografia szerokiego obszaru roboczego zwiększa się stopniowo od szerokości modułu 2048 pikseli CSS i ma górny limit. Efektywną szerokość określają iframe modułu, skalowanie systemu i powiększenie przeglądarki; fizyczna rozdzielczość 4K nie jest kryterium wykrywania. Wąskie układy zachowują dotychczasową typografię.
