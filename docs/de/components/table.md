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

