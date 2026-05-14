# Action Buttons

Action Buttons sind gemeinsame EvoUI-Kommandos fuer Forms, Tables, Rows, Modals
und kompakte Toolbars. Der vollstaendige Vertrag steht in
[Action Buttons](../../en/components/action-buttons.md).

## Standardtypen

- Form Save: sichtbarer Textbutton, `check`, `primary`, `filled`, disabled wenn
  clean, wechselt nach jedem erfolgreichen Save kurz zum Saved Label.
- Form secondary: icon-only Reset oder URL Action in der Form Toolbar.
- Table toolbar action: meist icon-only grosser Quadratbutton ueber der Tabelle.
- Table control action: icon-only Button rechts bei Filters/View/Search.
- Row action: icon-only Inline-Button in letzter Spalte oder List/Card Action Row.
- Modal footer action: sichtbarer Textbutton fuer Save, Cancel oder Confirm.

## Regeln

- Save hat Text und ist nicht icon-only.
- Add nutzt `plus` und `success`.
- Edit nutzt `edit` und `primary`.
- Duplicate nutzt `copy` oder `copy-plus` und `info`.
- Delete nutzt `trash` und `danger`.
- Icon-only Actions brauchen `title` und `aria-label`.
- Kein module-lokales Button CSS.
