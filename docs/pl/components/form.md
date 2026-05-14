# Komponent Form

`Form` to kanoniczna powierzchnia EvoUI dla ustawien, edytorow konfiguracji,
edytorow opartych o model i ekranow managera podobnych do resource.

Pelny kontrakt techniczny jest w [Form Component](../../en/components/form.md). Ta
lokalizowana strona opisuje praktyczna implementacje w dDocs.

## Anatomia

Kazdy standardowy formularz ma:

- form surface z `variant`, `density` i `layout`;
- opcjonalny heading z ikona, tytulem, meta i opisem;
- wspolny action toolbar z Save, Reset lub URL actions;
- opcjonalne wewnetrzne tabs;
- sections grupujace pola;
- field rows renderowane przez `x-evo::form.field`;
- markery dirty state: `data-evo-form` i `data-evo-form-dirty`;
- source, ktory laduje, waliduje, castuje i zapisuje dane.

## Podstawowe uzycie

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
                ['name' => 'enabled', 'type' => 'checkbox', 'label' => 'Wlaczone'],
            ],
        ],
    ],
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

## Source Types

- `config`: pliki PHP config i ustawienia modulu.
- `model`: persistence przez model nalezacy do consumer module.
- `resource`: Evolution resource fields, TVs lub lokalizowane wartosci resource.

## Slownik pol

Uzywaj wspolnych typow: `text`, `number`, `textarea`, `checkbox`, `select`,
`radio`, `multi-checkbox`, `choices`, `csv`, `datetime-local`, `color-picker`,
`alias`, `image`, `file`, `editor`, `display`, `resource-parent`, `config-map`,
`repeater`, `builder` i zarejestrowanych custom views.

Przyklady pol sa w [Form And Field Catalogue](../../en/components/form-fields.md).

## Ownership

EvoUI posiada layout, labels, field chrome, buttons, dirty state,
editor/media bridges i validation rendering. Consumer posiada fields, source
config, permissions, persistence i business rules.

## Nie Robic

- Nie tworzyc module-local Save buttons.
- Nie dodawac module-local CSS dla labels, spacing albo input widths.
- Nie duplikowac dirty-state logic.
- Nie dokumentowac modal shell behavior w form preset.
