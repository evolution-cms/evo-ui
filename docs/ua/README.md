# evo-ui

evo-ui - це спільна Livewire + DaisyUI база для сучасних manager-модулів
Evolution CMS.

Пакет уже використовується в `sArticles` і `dIssues`, а далі має стати основою
для перенесення `sLang`, `sSeo` та інших extras.

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

- [Інтеграція модуля](../module-integration.md)
- [Компоненти](../components.md)
- [Контракт таблиці](../module-table-contract.md)
- [Реальні consumers](../consumers.md)
- [Release checklist](../release-checklist.md)
- [Roadmap](../roadmap.md)

## Правило

У evo-ui має жити тільки спільний UI runtime. Бізнес-логіка, доменні хуки,
збереження сутностей і інтеграції залишаються в конкретному модулі.
