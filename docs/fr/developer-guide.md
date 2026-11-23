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

## Dimensions des grands espaces de travail

À partir de 2048 pixels CSS de largeur du module, Evo UI agrandit ensemble le texte, les contrôles, les icônes, les onglets, les lignes de tableau et les espacements. Le texte atteint 18 px à 2560 pixels CSS et reste limité à 20 px ; les contrôles sont limités à 44 px de hauteur. Le Full HD (1920 pixels CSS) conserve ses dimensions. La mise à l’échelle du système, le zoom du navigateur et l’iframe déterminent la largeur effective. La barre classique du gestionnaire reste inchangée.

`--evo-ui-desktop-unit` est un jeton de longueur partagé, de 1 px à 1.333333 px. Avec `calc(320 * var(--evo-ui-desktop-unit, 1px))`, une barre latérale passe de 320 à environ 427 px. Gardez les seuils des media queries en pixels CSS ; ce jeton ne doit pas y être utilisé. N’ajoutez pas de zoom/transform supplémentaire dans le module.

## Section active

Les onglets internes (`.evo-ui-form-tab.is-active`) utilisent l’accent principal du thème pour le texte, l’icône et le soulignement. Indiquez la section courante avec `aria-current="page"` ; après la navigation, seul l’élément sélectionné doit conserver cet attribut.
