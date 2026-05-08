# evo-ui + sArticles Migration Tasks

## Ціль

Зробити `evo-ui` технічним пакетом для Evolution CMS manager UI: Livewire + DaisyUI + Evo themes + спільні компоненти для модулів. Перший реальний споживач - `sArticles`, але пакет не має бути автономним manager module і не має додавати власний пункт меню.

## Аналіз поточного стану

### sArticles

- `module/sArticlesModule.php` - великий legacy dispatcher на `get=...`; він одночасно готує дані, зберігає форми, перемикає views і робить частину CRUD.
- `views/index.blade.php` - legacy shell модуля, ручне ajax-перемикання, підключення `admin.css`, `admin.js`, Select2, jQuery UI, Alertify, manager Bootstrap/date picker scripts; tabs і theme layer поступово виносимо в `evo-ui`.
- `assets/js/admin.js` - legacy центр поведінки: ajax navigation, dirty state, confirm delete, Select2 reinit, sortable reinit, publish/comment ajax actions; theme sync і platform scrollbar layer винесені в `evo-ui`.
- Основні legacy залежності: jQuery, Select2, jQuery UI sortable, Alertify, manager datepicker, TinyMCE, ручний `documentDirty`.
- Найскладніша зона - article/content editor і builder blocks, бо там TinyMCE + drag/sort + dynamic block templates.
- Найбезпечніша зона для першої Livewire міграції - списки/table surfaces: articles, comments, authors, tags, topics, features, polls.

### dEvoUI

- Має корисний фундамент: Livewire 4 bridge для Evo manager, Blade namespace `x-evo::`, layout, table/form components, theme sync, Windows-only custom scrollbar detection, Tabler icon wrapper.
- Початково був зроблений як demo module з власними routes/tabs/settings; для `evo-ui` це зайве і винесено.
- Table component вже має URL state, pagination, filters, search, row actions, view modes.
- Form component вже має config/model source, tabs, actions, fields, resource parent picker, multilingual bridge.
- Для `sArticles` треба доробити relationship filters/search hooks, бо articles працюють через translations, tags, topics, features і resource sections.

## Шар 1. evo-ui Core Package

- [x] Оформити Composer package `evolution-cms/evo-ui` з типом `library`.
- [x] Перенести корисний код з `dEvoUI` у namespace `EvoUI`.
- [x] Прибрати автономну реєстрацію manager module, demo routes і demo shell.
- [x] Залишити сервіс-провайдер, Blade namespace `x-evo::`, Livewire bridge, Livewire components, manager layout і assets.
- [x] Нормалізувати config key до `evo-ui`.
- [x] Публікувати assets у `assets/modules/evo-ui`.
- [x] Залишити теми `evolight`, `evolightness`, `evodark`, `evodarkness`; не повертати старі/видалені теми.

## Шар 2. UI Components

- [x] Table shell: toolbar, search, filters, segmented controls, pagination, action buttons.
- [x] Module table primitive: `x-evo::table.module` for module-owned business rows with evo-ui-owned toolbar, filters, table markup, cells, row actions and pagination.
- [ ] Form shell: action bar, dirty state, tabs, field rows, checkbox/select/text/date/media primitives.
- [x] Tabs shell: проста локальна реалізація без WebFX, зі стабільними стрілками і URL state.
- [ ] Icons: Tabler через blade-icons, без Font Awesome для нового UI.
- [x] Theme sync: підхоплювати тему manager frame live, без дублювання перемикачів тем.
- [x] Scrollbars: custom only for Windows; на macOS залишати native scroll.

## Шар 3. Data Contracts для sArticles

- [ ] Описати table presets для articles, authors, tags, comments, polls, topics, features.
- [x] Описати перший table preset для articles у `sArticles/config/articles/table.php`.
- [x] Додати provider contract для module-owned data: `evo-ui` володіє Livewire/table shell, а модуль віддає rows, totals, filters і row actions через data provider.
- [x] Додати hooks для relationship filters: resource section, topics, tags, features, visibility.
- [x] Додати case-insensitive search contract для різних SQL драйверів на першому provider-і `sArticles`.
- [x] Додати row action contract: publish/hide, edit, delete для першої articles table.
- [x] Додати support для double-click edit rows.

## Шар 4. sArticles Demo Integration

- [x] Підключити `evo-ui` у `sArticles/demo` через local path repository.
- [x] Публікувати або symlink-нути `evo-ui` assets у demo.
- [x] Не ламати поточний legacy sArticles UI під час першого підключення.
- [x] Переконатися, що package discovery бачить `EvoUI\EvoUIServiceProvider`.

## Шар 5. sArticles Livewire Migration

- [x] Почати з articles table як першої Livewire surface.
  - Livewire-компонент перенесено у `evo-ui`: `EvoUI\Livewire\ModuleTable`.
  - `views/articlesTab.blade.php` став тонким `x-evo::table.livewire` entrypoint.
  - У `sArticles` залишено тільки `config/articles/table.php` і `Seiger\sArticles\Tables\ArticlesTableData` як бізнес/data provider.
  - Збережено legacy edit/delete URLs, щоб editor/builder поки не чіпати.
  - Фільтри, пошук, видимість, publish toggle і пагінація тепер керуються `evo-ui` shell з даними з provider-а.
- [ ] Потім перенести comments list, бо там потрібні ajax actions і compact action buttons.
- [ ] Потім authors/tags/topics/features/polls як прості CRUD таблиці.
- [ ] Останнім переносити article editor і builder, бо там найбільше legacy jQuery/TinyMCE/jQuery UI.
- [ ] Поступово прибирати `admin.js`, `admin.css`, Select2, jQuery UI і inline scripts тільки після заміни відповідної surface.

## Шар 6. Release Path

- [ ] Після стабілізації локальної інтеграції зафіксувати мінімальний API `evo-ui`.
- [ ] Зарелізити `evolution-cms/evo-ui`.
- [ ] Перевести `sArticles` з path repository на version constraint.
- [ ] Підготувати окремий план інтеграції `evo-ui` у майбутні версії Evolution CMS core.

## Поточне рішення

Починаємо з `evo-ui` як окремого technical dependency. Це швидше і чистіше, ніж писати компоненти прямо всередині `sArticles`, бо одразу формується стабільний UI foundation. При цьому `sArticles` лишається першим полігоном: усе, що виявиться специфічним тільки для публікацій, має залишатися у `sArticles`, а все універсальне йде в `evo-ui`.
