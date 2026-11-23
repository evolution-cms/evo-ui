# Гід розробника

Використовуйте evo-ui як shared declarative UI foundation. Consumer modules
дають config, providers і persistence; evo-ui дає shell, components, state
behavior, assets і visual contracts.

## Канонічний shell модуля

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        @if($activeTab === 'items')
            <livewire:evo-ui.module-table preset="vendor.module.items" />
        @elseif($activeTab === 'settings')
            <livewire:evo-ui.form preset="vendor.module.settings" />
        @endif
    </x-evo::module-tab-shell>
</x-evo::layout>
```

Не підключайте Bootstrap, jQuery, manager `main.js`, `tabpane.js`, Roboto, CDN
UI assets або legacy manager CSS всередині evo-ui-owned screens.

## Правила шарів

- evo-ui owns shared UI primitives, CSS tokens, runtime helpers і dirty-state.
- Consumer modules owns routes, translations, permissions, queries, validation
  semantics і business actions.
- Якщо два модулі потребують однаковий UI pattern, спочатку промоутьте його в
  evo-ui, а не копіюйте локально.
- Тимчасовий consumer CSS або JS має бути scoped і мати видиму follow-up task.

## Declarative Surfaces

Використовуйте `evo-ui.module-table` для table/list CRUD, `evo-ui.form` для
settings/model forms і `evo-ui.issue-workspace` для provider-backed
list/kanban workspaces.

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'density' => 'compact',
    'layout' => 'settings',
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

## Тести

```bash
composer test
composer drift
```

Generic UI behavior тестується в evo-ui. Module-specific business behavior
тестується в consumer module.


## Додаткові елементи навігації та описи полів

`module-tab-shell` приймає необов'язковий слот `navigationAside` для мітки стану або іншого елемента. EvoUI розміщує його справа й по центру висоти; вкладки зберігають власну горизонтальну прокрутку. Модуль не повинен задавати слоту абсолютні координати.

```blade
<x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
    <x-slot:navigationAside>
        <x-evo::badge :label="$statusLabel" icon="activity" />
    </x-slot:navigationAside>
    <!-- Module content -->
</x-evo::module-tab-shell>
```

`EvoUI\Support\DescriptionHtml::render($description)` повертає очищений HTML опису, заданого адміністратором. Підтримуються відносні посилання, HTTP(S), mailto, tel, базове виділення, код і перенесення рядків. Елементи, що виконують скрипти, та довільні атрибути видаляються. Виводьте як HTML лише результат очищення.

На широких екранах типографіка поступово збільшується від ширини робочої області модуля 2048 CSS-пікселів і має верхню межу. Враховується ширина iframe, масштаб системи та браузера; фізична роздільність 4K не є критерієм. Вузькі екрани зберігають наявні розміри тексту.

## Розміри широкої робочої області

Від ширини області модуля 2048 CSS-пікселів Evo UI разом збільшує текст, елементи керування, іконки, вкладки, рядки таблиць і відступи. При 2560 CSS-пікселях основний текст має 18 px, верхня межа — 20 px; висота елементів керування обмежена 44 px. Full HD (1920 CSS-пікселів) зберігає наявні розміри. Ефективну ширину визначають масштаб ОС, браузера й iframe модуля. Цей режим не змінює стару верхню панель менеджера.

`--evo-ui-desktop-unit` — спільний токен довжини від 1 px до 1.333333 px. Модуль може використати `calc(320 * var(--evo-ui-desktop-unit, 1px))` для бічної панелі, яка зростає з 320 до приблизно 427 px. Умови медіазапитів залишайте в CSS-пікселях; цей токен у них не застосовується. Не додавайте повторний zoom/transform у модулі.

## Активний розділ

Внутрішні вкладки форми (`.evo-ui-form-tab.is-active`) використовують основний акцент теми для тексту, іконки та лінії під пунктом. Поточний розділ навігації позначайте `aria-current="page"`; після переходу позначка має залишатися лише на вибраному пункті.
