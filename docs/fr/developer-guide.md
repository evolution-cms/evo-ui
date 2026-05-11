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

