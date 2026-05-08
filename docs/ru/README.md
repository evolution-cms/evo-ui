# evo-ui

evo-ui - общая Livewire + DaisyUI основа для современных manager-модулей
Evolution CMS.

Пакет уже используется в `sArticles` и `dIssues`, а дальше должен стать базой
для переноса `sLang`, `sSeo` и других extras.

## Возможности

- Собственный manager iframe layout с локальными assets.
- Синхронизация тем Evolution manager.
- Livewire 4 bridge для manager routes, CSRF и session.
- Конфигурируемые таблицы с фильтрами, поиском, сортировкой, пагинацией,
  table/list режимами, inline edit, modal edit, действиями строки и reorder.
- Конфигурируемые формы для настроек и resource-like редакторов.
- Provider-backed workspace для kanban/list сценариев.
- Общие компоненты: кнопки, иконки, табы, модалки, бейджи, карточки, choices,
  image/file поля и rich editors.
- Сохранение текущего UI state в manager session.

## Пример

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tabs :items="$tabs" :active="$activeTab" />

    <livewire:evo-ui.module-table
        preset="vendor.module.items"
        :context="['moduleUrl' => $moduleUrl]"
    />
</x-evo::layout>
```

## Документы

- [Интеграция модуля](../module-integration.md)
- [Компоненты](../components.md)
- [Контракт таблицы](../module-table-contract.md)
- [Consumers](../consumers.md)
- [Release checklist](../release-checklist.md)
- [Roadmap](../roadmap.md)

## Правило

В evo-ui живет общий UI runtime. Бизнес-логика, доменные хуки и интеграции должны
оставаться в конкретном модуле.
