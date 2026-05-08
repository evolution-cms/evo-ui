# evo-ui

evo-ui est la base UI commune Livewire + DaisyUI pour les modules manager
modernes d'Evolution CMS.

Le package est deja utilise par `sArticles` et `dIssues`, et servira de base aux
migrations de `sLang`, `sSeo` et d'autres extras.

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

- [Module Integration](../module-integration.md)
- [Components](../components.md)
- [Module Table Contract](../module-table-contract.md)
- [Consumers](../consumers.md)
- [Release Checklist](../release-checklist.md)
- [Roadmap](../roadmap.md)

## Regle

evo-ui contient le runtime UI partage. La logique metier, les hooks de domaine et
les integrations restent dans le module consommateur.
