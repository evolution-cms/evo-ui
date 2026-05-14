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

