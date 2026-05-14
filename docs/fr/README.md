# evo-ui

evo-ui est la base UI commune Livewire + DaisyUI pour les modules manager
modernes d'Evolution CMS.

Le package est utilise par `sArticles`, `dIssues`, `sLang`, `sSeo` et `dDocs`
comme couche UI canonique du manager. Les modules consommateurs decrivent
declarativement tabs, tables, forms, workspaces, fields, providers et regles de
sauvegarde; evo-ui possede le shell, les composants, le state behavior, le
theme bridge et les assets locaux.

## Quand l'utiliser

Utilisez evo-ui pour un manager screen, un settings form, un table/list CRUD, un
editeur de type resource, un issue workspace ou des primitives visuelles
partagees. Les regles metier, la propriete des donnees, la semantique provider
et les workflows specifiques restent dans le package consommateur.

## Fonctionnalites

- Layout iframe manager avec assets locaux.
- Synchronisation des themes du manager Evolution.
- Bridge Livewire 4 pour les routes manager, CSRF et sessions.
- Tables configurees avec filtres, recherche, tri, pagination, vue table/liste,
  inline edit, modal edit, actions de ligne et reorder.
- Formulaires configures pour les reglages et les editeurs de ressources.
- Workspace base sur provider pour les workflows kanban/liste.
- Composants partages: boutons, icones, tabs, modals, badges, cards, choices,
  champs image/fichier et rich editors.
- Persistance de l'etat UI courant dans la session manager.

## Workflows courants

- Construire le shell du module avec `x-evo::layout`, `evo::partials.assets`,
  module tabs et Livewire components.
- Definir les surfaces table/list avec les presets `evo-ui.module-table`.
- Definir les settings/model forms avec les presets `evo-ui.form`.
- Reutiliser l'issue workspace contract pour les workflows provider-backed
  list/kanban.
- Documenter tout nouveau shared UI pattern comme contract, ajouter les package
  tests, puis seulement ensuite l'utiliser dans les modules consommateurs.

## Exemple

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tabs :items="$tabs" :active="$activeTab" />

    <livewire:evo-ui.module-table
        preset="vendor.module.items"
        :context="['moduleUrl' => $moduleUrl]"
    />
</x-evo::layout>
```

## Documentation

- [Guide utilisateur](user-guide.md)
- [Guide developpeur](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Configuration](configuration.md)
- [Reference](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Standards de documentation](documentation-standards.md)
- [Module Integration](../en/guide/module-integration.md)
- [Components](../en/components/README.md)
- [Action Buttons](components/action-buttons.md)
- [DnD et reorder](components/dnd.md)
- [Composant Table](components/table.md)
- [Composant Form](components/form.md)
- [Form And Field Catalogue](../en/components/form-fields.md)
- [Module Table Contract](../en/components/module-table-contract.md)
- [Issue Workspace Contract](../en/components/issue-workspace-contract.md)
- [Testing Matrix](../en/guide/testing.md)
- [Consumers](../en/guide/consumers.md)
- [Release Checklist](../en/guide/release-checklist.md)
- [dDocs Tree/Viewer Notes](../en/guide/ddocs-tree-viewer-notes.md)
- [Roadmap](../en/guide/roadmap.md)

## Regles dDocs

- Les liens de cette page restent volontairement dans le package `docs/` tree.
- Les README localises sont des entrypoints; les contrats techniques canoniques
  restent dans les root docs et sont lies ci-dessus.
- Les exemples de code doivent utiliser des fenced language identifiers afin que
  dDocs puisse appliquer une coloration stable.

## Regle

evo-ui contient le runtime UI partage. La logique metier, les hooks de domaine et
les integrations restent dans le module consommateur.
