# Composant Table

`Table` est la surface EvoUI canonique pour les listes manager et le CRUD. Le
contrat complet est dans [Table Component](../../en/components/table/README.md).

## Structure Standard

Chaque table EvoUI contient:

- une toolbar avec titre/actions a gauche, filtres, switch de vue, control
  actions et recherche a droite;
- une vue table et une vue liste optionnelle basees sur les memes row data;
- une derniere colonne pour les row actions: edit, delete, duplicate ou actions
  metier;
- un double-click optionnel vers la modal d'edition partagee;
- le footer de pagination partage;
- les modales partagees create/edit et delete.

## Utilisation

```blade
<x-evo::table.livewire
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

## Ownership

EvoUI possede le layout de toolbar, les filtres, la recherche, le tri, le chrome
table/list, les visuels de row actions, les modales, la pagination et la
persistance d'etat. Le provider consommateur possede les queries, le mapping
des filtres, la validation, les sauvegardes, les delete guards, la persistance
du reorder et les actions metier.

## A Eviter

- Pas de CSS table ou pagination locale au module.
- Pas de deuxieme toolbar search/filter.
- Les actions vont dans la toolbar ou la derniere colonne row actions.
- La vue liste et la vue table doivent montrer le meme etat metier.
- Ne pas copier modal/delete/double-click dans le consumer.


## Premier rendu adaptatif

Dans la branche de développement actuelle, le composant parent peut envoyer la largeur du conteneur avec le changement d’onglet. Déclarez `public int $tableWidth = 0`, ajoutez `responsive-width-model="tableWidth"` à `x-evo::module-tab-shell` et transmettez `responsive_width` dans le contexte du tableau imbriqué.

Les valeurs explicites de l’URL et les vues choisies manuellement en session sont prioritaires. Le seuil `responsive_list` vaut 1200 pixels CSS par défaut ; 0 désactive le changement automatique. Le mécanisme de secours reste actif sans indication de largeur et lors du redimensionnement. Le premier chargement du document peut encore nécessiter une requête supplémentaire.

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
