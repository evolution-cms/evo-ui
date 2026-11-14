# Table-Komponente

`Table` ist die kanonische EvoUI-Oberflaeche fuer Manager-Listen und CRUD. Der
vollstaendige Vertrag steht im Root-Dokument [Table Component](../../en/components/table/README.md).

## Standardstruktur

Jede EvoUI-Tabelle enthaelt:

- Toolbar mit Titel/Aktionen links und Filtern, View-Umschalter, Control
  Actions und Suche rechts;
- Tabellenansicht und optionale Listenansicht mit denselben Row-Daten;
- letzte Spalte fuer Row Actions wie Edit, Delete, Duplicate oder Domain
  Actions;
- optionales Double-click Edit ueber das gemeinsame Modal;
- gemeinsamen Pagination Footer;
- gemeinsame Create/Edit- und Delete-Modals.

## Nutzung

```blade
<x-evo::table.livewire
    preset="vendor.module.items"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

## Ownership

EvoUI besitzt Toolbar-Layout, Filter, Suche, Sortierung, Table/List-Chrome,
Row-Action-Visuals, Modals, Pagination und State Persistence. Der Consumer
Provider besitzt Queries, Filter-Mapping, Validierung, Save/Delete Guards,
Reorder Persistence und Business Actions.

## Nicht tun

- Keine module-lokale Table-CSS oder Pagination.
- Keine zweite Search/Filter-Toolbar.
- Actions nur in Toolbar oder letzter Row-Action-Spalte.
- Listenansicht und Tabellenansicht muessen denselben Business State zeigen.
- Modal/Delete/Double-click-Verhalten nicht in Consumer kopieren.


## Responsiver erster Render

Im aktuellen Entwicklungszweig kann die Elternkomponente die Containerbreite zusammen mit dem Tabwechsel senden. Deklarieren Sie `public int $tableWidth = 0`, setzen Sie `responsive-width-model="tableWidth"` auf `x-evo::module-tab-shell` und übergeben Sie `responsive_width` im Kontext der eingebetteten Tabelle.

Explizite URL-Werte und gespeicherte manuelle Ansichten haben Vorrang. `responsive_list` verwendet standardmäßig 1200 CSS-Pixel; 0 deaktiviert den automatischen Wechsel. Ohne Breitenhinweis und bei Größenänderungen bleibt der Fallback erhalten. Der erste Dokumentaufruf kann weiterhin eine zusätzliche Anfrage benötigen.

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
