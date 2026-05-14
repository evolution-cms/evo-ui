# evo-ui

evo-ui - це спільна Livewire + DaisyUI база для сучасних manager-модулів
Evolution CMS.

Цей `uk` entrypoint є єдиною українською документаційною локаллю. Legacy
значення Evolution manager `ua` нормалізується до `uk` і не має окремої папки
документації.

Пакет використовується в `sArticles`, `dIssues`, `sLang`, `sSeo` і `dDocs` як
канонічний UI-шар менеджера. Consumer-модулі декларативно описують tabs,
tables, forms, workspaces, fields, providers і правила збереження, а evo-ui
відповідає за shell, компоненти, state behavior, theme bridge і локальні assets.

## Коли використовувати

Використовуйте evo-ui для manager screen, settings form, table/list CRUD,
resource-like editor, issue workspace або спільних візуальних primitives.
Бізнес-правила, ownership даних, provider semantics і workflow конкретного
модуля залишаються в consumer package.

## Основні можливості

- Власний manager iframe layout з локальними assets.
- Синхронізація тем Evolution manager.
- Livewire 4 bridge для manager routes, CSRF і session.
- Конфіговані таблиці з фільтрами, пошуком, сортуванням, пагінацією,
  table/list режимами, inline edit, modal edit, діями рядка і reorder.
- Конфіговані форми для налаштувань і resource-like редакторів.
- Provider-backed workspace для kanban/list сценаріїв, як у `dIssues`.
- Спільні компоненти: кнопки, іконки, таби, модалки, бейджі, картки, choices,
  image/file поля і rich editors.
- Збереження поточного UI state в manager session.

## Типові workflow

- Зібрати shell модуля через `x-evo::layout`, `evo::partials.assets`, module
  tabs і Livewire components.
- Описати table/list поверхні через `evo-ui.module-table` presets.
- Описати settings/model forms через `evo-ui.form` presets.
- Використати issue workspace contract для provider-backed list/kanban
  сценаріїв.
- Новий shared UI pattern спочатку документувати як contract, потім покривати
  package tests, і лише після цього підключати в consumer modules.

## Приклад

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tabs :items="$tabs" :active="$activeTab" />

    <livewire:evo-ui.module-table
        preset="vendor.module.items"
        :context="['moduleUrl' => $moduleUrl]"
    />
</x-evo::layout>
```

## Документи для розробника

- [Гід користувача](user-guide.md)
- [Гід розробника](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Конфігурація](configuration.md)
- [Довідник](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Стандарти документації](documentation-standards.md)
- [Інтеграція модуля](../en/guide/module-integration.md)
- [Компоненти](../en/components/README.md)
- [Action Buttons](components/action-buttons.md)
- [DnD і порядок рядків](components/dnd.md)
- [Компонент Table](components/table.md)
- [Компонент Form](components/form.md)
- [Каталог форм і полів](../en/components/form-fields.md)
- [Контракт таблиці](../en/components/module-table-contract.md)
- [Контракт issue workspace](../en/components/issue-workspace-contract.md)
- [Testing matrix](../en/guide/testing.md)
- [Реальні consumers](../en/guide/consumers.md)
- [Release checklist](../en/guide/release-checklist.md)
- [dDocs tree/viewer notes](../en/guide/ddocs-tree-viewer-notes.md)
- [Roadmap](../en/guide/roadmap.md)

## Правила для dDocs

- Усі посилання тут навмисно лишаються всередині package `docs/` tree.
- Локалізовані README - це entrypoints; канонічні технічні contracts лежать у
  root docs і відкриваються через посилання вище.
- Code examples мають fenced language identifiers, щоб dDocs стабільно
  підсвічував код.

## Правило

У evo-ui має жити тільки спільний UI runtime. Бізнес-логіка, доменні хуки,
збереження сутностей і інтеграції залишаються в конкретному модулі.
