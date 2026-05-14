# Composant Form

`Form` est la surface EvoUI canonique pour les settings, les editeurs de
configuration, les editeurs bases sur un modele et les ecrans manager de type
resource.

Le contrat technique complet est dans [Form Component](../../en/components/form.md).
Cette page localisee decrit le chemin d'implementation dans dDocs.

## Anatomie

Chaque formulaire standard contient:

- une surface de formulaire avec `variant`, `density` et `layout`;
- un heading optionnel avec icone, titre, meta et description;
- la toolbar d'actions commune avec Save, Reset ou URL actions;
- des tabs internes optionnels;
- des sections qui groupent les champs;
- des field rows rendues par `x-evo::form.field`;
- les marqueurs dirty state: `data-evo-form` et `data-evo-form-dirty`;
- une source qui charge, valide, caste et sauvegarde les donnees.

## Usage de base

```blade
<livewire:evo-ui.form
    preset="vendor.module.settings"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'source' => ['type' => 'config', 'file' => 'vendor/module/settings.php'],
    'density' => 'compact',
    'layout' => 'settings',
    'sections' => [
        [
            'key' => 'general',
            'fields' => [
                ['name' => 'enabled', 'type' => 'checkbox', 'label' => 'Actif'],
            ],
        ],
    ],
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

## Source Types

- `config`: fichiers PHP de configuration et settings du module.
- `model`: persistance via un modele du consumer module.
- `resource`: champs Evolution resource, TVs ou valeurs resource localisees.

## Vocabulaire des champs

Utilisez les types communs: `text`, `number`, `textarea`, `checkbox`, `select`,
`radio`, `multi-checkbox`, `choices`, `csv`, `datetime-local`, `color-picker`,
`alias`, `image`, `file`, `editor`, `display`, `resource-parent`, `config-map`,
`repeater`, `builder` et custom views enregistrees.

Les exemples de champs sont dans [Form And Field Catalogue](../../en/components/form-fields.md).

## Ownership

EvoUI possede layout, labels, field chrome, buttons, dirty state,
editor/media bridges et validation rendering. Le consumer possede fields,
source config, permissions, persistence et business rules.

## A Eviter

- Ne pas creer de Save buttons locaux au module.
- Ne pas ajouter de CSS local pour labels, spacing ou input widths.
- Ne pas dupliquer la dirty-state logic.
- Ne pas documenter le modal shell behavior dans le form preset.
