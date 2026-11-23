# Benutzerhandbuch

evo-ui ist das gemeinsame Manager-UI-Kit fuer Evolution CMS Extras. Benutzer
sehen es in Modulen wie `sArticles`, `dIssues`, `sLang`, `sSeo`, `sSettings`
und `dDocs`.

## Was evo-ui steuert

- Manager-Shell und Theme-Farben.
- Tabs, Toolbars, Buttons, Badges, Cards und Modals.
- Tabellen, Listen, Filter, Pagination und Row Actions.
- Formulare mit Dirty-State-Schutz.
- Save feedback im Save Button selbst.
- Issue Workspaces mit Liste, Kanban, Detail und Kommentaren.

## Standardaktionen

Save-Buttons verwenden ueberall denselben primary filled Stil. Add, edit,
duplicate und delete verwenden die gemeinsamen evo-ui Icon- und Tone-Regeln.

## dDocs-Ausnahme

dDocs nutzt bewusst eine Dokumentationsoberflaeche mit Sidebar-Tree und Viewer.
Es verwendet keine oberen Module-Tabs, soll aber Buttons, Inputs, Cards, Badges,
Farben und Typografie aus evo-ui wiederverwenden.

## Große Arbeitsbereiche

Ab 2048 CSS-Pixeln Modulbreite vergrößert Evo UI Text, Bedienelemente, Symbole, Tabs, Tabellenzeilen und Abstände gemeinsam. Bei 2560 CSS-Pixeln beträgt die Textgröße 18 px, maximal 20 px; Bedienelemente sind auf 44 px Höhe begrenzt. Full HD (1920 CSS-Pixel) behält die bisherigen Größen. Betriebssystemskalierung, Browserzoom und Modul-iframe bestimmen die effektive Breite. Die klassische Manager-Kopfleiste bleibt unverändert.
