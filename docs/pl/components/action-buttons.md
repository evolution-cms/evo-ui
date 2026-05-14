# Action Buttons

Action buttons to wspolne komendy EvoUI dla forms, tables, rows, modals i
kompaktowych toolbarow. Pelny kontrakt jest w
[Action Buttons](../../en/components/action-buttons.md).

## Standardowe Typy

- Form Save: widoczny przycisk z tekstem, `check`, `primary`, `filled`,
  disabled gdy formularz jest clean, zmienia label na Saved po kazdym udanym save.
- Form secondary: icon-only Reset albo URL action w form toolbar.
- Table toolbar action: zwykle icon-only duzy kwadrat nad tabela.
- Table control action: icon-only button po prawej obok filters/view/search.
- Row action: icon-only inline button w ostatniej kolumnie albo list/card row.
- Modal footer action: widoczny tekstowy button dla Save, Cancel albo Confirm.

## Reguly

- Save ma tekst i nie jest icon-only.
- Add uzywa `plus` i `success`.
- Edit uzywa `edit` i `primary`.
- Duplicate uzywa `copy` albo `copy-plus` i `info`.
- Delete uzywa `trash` i `danger`.
- Icon-only actions maja `title` i `aria-label`.
- Nie dodawac module-local button CSS.
