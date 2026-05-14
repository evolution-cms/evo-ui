# Компонент Form

`Form` - канонічна EvoUI поверхня для налаштувань, config editors,
model-backed editors і resource-like manager screens.

Повний технічний контракт лежить у [Form Component](../../en/components/form.md);
ця сторінка українською описує, як цим користуватись у dDocs.

## Анатомія форми

Кожна стандартна форма має:

- form surface з класами `variant`, `density` і `layout`;
- опційний heading з icon, title, meta і description;
- спільний action toolbar із Save, Reset або URL actions;
- опційні внутрішні tabs;
- sections, які групують поля;
- field rows через `x-evo::form.field`;
- dirty-state markers: `data-evo-form` і `data-evo-form-dirty`;
- source service, який завантажує, валідовує, кастить і зберігає дані.

## Базове використання

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
                ['name' => 'enabled', 'type' => 'checkbox', 'label' => 'Увімкнено'],
            ],
        ],
    ],
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

## Типи source

- `config`: PHP config files і module settings.
- `model`: persistence через model, який належить consumer module.
- `resource`: Evolution resource fields, TVs або localized resource values.

## Словник полів

Використовуй спільні типи: `text`, `number`, `textarea`, `checkbox`, `select`,
`radio`, `multi-checkbox`, `choices`, `csv`, `datetime-local`, `color-picker`,
`alias`, `image`, `file`, `editor`, `display`, `resource-parent`, `config-map`,
`repeater`, `builder` і зареєстровані custom views.

Приклади окремих полів лежать у [Каталозі форм і полів](../../en/components/form-fields.md).

## Ownership

EvoUI відповідає за layout, labels, field chrome, buttons, dirty state,
editor/media bridges і validation rendering. Consumer відповідає за fields,
source config, permissions, persistence і business rules.

## Не робити

- Не створювати module-local Save buttons.
- Не додавати module-local CSS для labels, spacing або input widths.
- Не дублювати dirty-state logic.
- Не описувати modal shell behavior у form preset.
