# Action Buttons

Action buttons - це спільні EvoUI команди для форм, таблиць, рядків, модалок і
compact toolbars. Повний контракт лежить у
[Action Buttons](../../en/components/action-buttons.md).

## Стандартні типи

- Form Save: видима кнопка з текстом, `check`, `primary`, `filled`, disabled
  поки форма clean, після кожного успішного save міняє текст на `Збережено`.
- Form secondary: icon-only Reset або URL action у form toolbar.
- Table toolbar action: зазвичай icon-only велика квадратна кнопка над таблицею.
- Table control action: icon-only кнопка справа біля filters/view/search.
- Row action: icon-only inline кнопка в останній колонці або list/card action row.
- Modal footer action: видима текстова кнопка для Save, Cancel або Confirm.

## Правила

- Save має текст, не icon-only.
- Add використовує `plus` і `success`.
- Edit використовує `edit` і `primary`.
- Duplicate використовує `copy` або `copy-plus` і `info`.
- Delete використовує `trash` і `danger`.
- Icon-only actions мають `title` і `aria-label`.
- Не створювати module-local CSS для кнопок.
