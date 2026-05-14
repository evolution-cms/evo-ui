# Form-Komponente

`Form` ist die kanonische EvoUI-Oberflaeche fuer Einstellungen,
Konfigurationseditoren, model-basierte Editoren und resource-aehnliche Manager
Screens.

Der vollstaendige technische Vertrag steht in
[Form Component](../../en/components/form.md). Diese lokalisierte Seite beschreibt
den praktischen Einsatz in dDocs.

## Aufbau

Jedes Standardformular hat:

- eine Form Surface mit `variant`, `density` und `layout`;
- optionalen Heading mit Icon, Titel, Meta und Beschreibung;
- gemeinsame Action Toolbar mit Save, Reset oder URL Actions;
- optionale interne Tabs;
- Sections zur Gruppierung von Feldern;
- Field Rows ueber `x-evo::form.field`;
- Dirty-State Marker: `data-evo-form` und `data-evo-form-dirty`;
- eine Source, die Daten laedt, validiert, castet und speichert.

## Basisnutzung

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
                ['name' => 'enabled', 'type' => 'checkbox', 'label' => 'Aktiv'],
            ],
        ],
    ],
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

## Source Types

- `config`: PHP-Konfigurationsdateien und Moduleinstellungen.
- `model`: Speicherung ueber ein Model des Consumer-Moduls.
- `resource`: Evolution Resource-Felder, TVs oder lokalisierte Resource-Werte.

## Feldvokabular

Nutze die gemeinsamen Typen: `text`, `number`, `textarea`, `checkbox`, `select`,
`radio`, `multi-checkbox`, `choices`, `csv`, `datetime-local`, `color-picker`,
`alias`, `image`, `file`, `editor`, `display`, `resource-parent`, `config-map`,
`repeater`, `builder` und registrierte Custom Views.

Feldbeispiele stehen im [Form And Field Catalogue](../../en/components/form-fields.md).

## Ownership

EvoUI besitzt Layout, Labels, Field Chrome, Buttons, Dirty State,
Editor/Media-Bridges und Validation Rendering. Das Consumer-Modul besitzt
Fields, Source Config, Permissions, Persistence und Business Rules.

## Nicht Tun

- Keine module-lokalen Save Buttons bauen.
- Kein module-lokales CSS fuer Labels, Spacing oder Input Widths.
- Dirty-State Logic nicht duplizieren.
- Modal Shell Behavior nicht im Form Preset dokumentieren.
