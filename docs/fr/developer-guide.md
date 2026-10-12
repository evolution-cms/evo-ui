# Guide developpeur

Utilisez evo-ui comme fondation UI declarative. Les modules consommateurs
fournissent configuration, providers et persistance; evo-ui fournit shell,
composants, state behavior, assets et contracts visuels.

## Shell module

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        <livewire:evo-ui.module-table preset="vendor.module.items" />
    </x-evo::module-tab-shell>
</x-evo::layout>
```

Ne chargez pas Bootstrap, jQuery, manager `main.js`, `tabpane.js`, Roboto, CDN
UI assets ou legacy manager CSS dans les ecrans evo-ui.

## Couches

- evo-ui possede les shared UI primitives, CSS tokens, runtime helpers et
  dirty-state behavior.
- Les consumers possedent routes, translations, permissions, queries,
  validation et business actions.
- Si deux modules ont besoin du meme pattern UI, promouvez-le d'abord dans
  evo-ui.

## Tests

```bash
composer test
composer drift
```


## Éléments complémentaires de navigation et descriptions des champs

`module-tab-shell` accepte un emplacement facultatif `navigationAside` pour un badge d’état ou un autre élément complémentaire. EvoUI l’aligne à droite et le centre verticalement ; les onglets conservent leur propre défilement horizontal. Les modules consommateurs ne doivent pas positionner cet emplacement de manière absolue.

```blade
<x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
    <x-slot:navigationAside>
        <x-evo::badge :label="$statusLabel" icon="activity" />
    </x-slot:navigationAside>
    <!-- Module content -->
</x-evo::module-tab-shell>
```

`EvoUI\Support\DescriptionHtml::render($description)` renvoie du HTML en ligne assaini pour les descriptions rédigées par l’administrateur. Les liens relatifs, HTTP(S), mailto et tel, la mise en évidence simple, le code et les sauts de ligne sont conservés. Les éléments exécutables et les attributs arbitraires sont supprimés. Seul le résultat assaini doit être affiché comme HTML non échappé.

La typographie des grands espaces de travail augmente progressivement à partir d’une largeur de module de 2048 pixels CSS, jusqu’à une limite supérieure. La largeur de l’iframe, la mise à l’échelle du système et le zoom du navigateur déterminent la zone effective ; la résolution physique 4K n’est pas un critère de détection. Les dispositions étroites conservent leur typographie existante.
