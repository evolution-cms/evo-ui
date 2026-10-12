# Entwicklerhandbuch

Nutze evo-ui als deklarative UI-Grundlage. Consumer-Module liefern
Konfiguration, Provider und Persistenz; evo-ui liefert Shell, Komponenten,
State-Verhalten, Assets und visuelle Contracts.

## Modul-Shell

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        <livewire:evo-ui.module-table preset="vendor.module.items" />
    </x-evo::module-tab-shell>
</x-evo::layout>
```

Lade kein Bootstrap, jQuery, manager `main.js`, `tabpane.js`, Roboto, CDN UI
Assets oder legacy manager CSS in evo-ui Screens.

## Schichten

- evo-ui besitzt shared UI primitives, CSS tokens, runtime helpers und
  dirty-state behavior.
- Consumer besitzen routes, translations, permissions, queries, validation und
  business actions.
- Wenn zwei Module dasselbe UI pattern brauchen, gehoert es zuerst in evo-ui.

## Tests

```bash
composer test
composer drift
```


## Navigationsergänzungen und Feldbeschreibungen

`module-tab-shell` bietet den optionalen Slot `navigationAside` für eine Statusanzeige oder andere Ergänzungen. EvoUI richtet ihn rechts und vertikal mittig aus; die Tabs behalten ihre eigene horizontale Scrollfläche. Consumer-Module dürfen den Slot nicht absolut positionieren.

```blade
<x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
    <x-slot:navigationAside>
        <x-evo::badge :label="$statusLabel" icon="activity" />
    </x-slot:navigationAside>
    <!-- Module content -->
</x-evo::module-tab-shell>
```

`EvoUI\Support\DescriptionHtml::render($description)` liefert bereinigtes Inline-HTML für administratorgepflegte Beschreibungen. Relative Links, HTTP(S), mailto und tel sowie einfache Hervorhebungen, Code und Zeilenumbrüche bleiben erhalten. Ausführbare Elemente und beliebige Attribute werden entfernt. Nur das bereinigte Ergebnis darf unescaped als HTML ausgegeben werden.

Die Typografie breiter Arbeitsbereiche wächst ab 2048 CSS-Pixeln Modulbreite schrittweise bis zu einer Obergrenze. Entscheidend ist die Breite des Modul-iframes, beeinflusst durch Systemskalierung und Browserzoom; die physische 4K-Auflösung ist kein Erkennungskriterium. Schmale Layouts behalten ihre bisherige Typografie.
