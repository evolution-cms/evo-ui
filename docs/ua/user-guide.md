# Гід користувача

evo-ui - це спільний UI-kit менеджера для Evolution CMS extras. Зазвичай ви
бачите його через модулі `sArticles`, `dIssues`, `sLang`, `sSeo`, `sSettings`
і `dDocs`.

## За що відповідає evo-ui

- Shell сторінки менеджера і кольори теми.
- Таби, toolbar, кнопки, badges, cards і модальні вікна.
- Таблиці, list view, фільтри, пагінація і дії рядка.
- Форми налаштувань і редакторів з dirty-state захистом.
- Save feedback через компактний auto-dismiss toast.
- Issue workspace: list, kanban, detail і comments.

## Стандартні дії

Кнопка Save має однаковий primary filled вигляд у всіх модулях. Add, edit,
duplicate і delete використовують спільні evo-ui icon/tone правила, тому одна
й та сама дія виглядає однаково всюди.

## Dirty Forms

Коли у формі є незбережені зміни, evo-ui тримає активним shared tab guard. Якщо
перейти в інший tab, з'явиться спільний unsaved-changes dialog. Після успішного
save форма стає clean, а top-right save toast автоматично зникає.

## Виняток dDocs

dDocs навмисно використовує documentation workspace з sidebar tree і viewer.
Там немає верхніх module tabs, але кнопки, inputs, cards, badges, кольори і
типографіка мають лишатися з evo-ui.

