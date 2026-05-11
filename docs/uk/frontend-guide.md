# Frontend Guide

evo-ui не є публічним frontend API для сайту. Це manager UI foundation для
Evolution CMS extras.

## Де мають жити assets

Manager screens мають підключати evo-ui assets через `x-evo::layout` або
transitional `evo::partials.assets`. Не додавайте CDN CSS, CDN JS, Bootstrap,
jQuery або локальні копії shared controls у consumer modules.

## Theme Bridge

Manager shell exposes theme markers і design tokens. Consumer modules мають
використовувати evo-ui classes і tokens замість hard-coded colors.

```css
.my-module-local-exception {
    color: var(--evo-ui-text);
    background: var(--evo-ui-bg);
}
```

Local CSS допустимий тільки для module-specific layout, який ще не став shared
primitive. Якщо pattern з'являється в двох модулях, переносимо його в evo-ui і
документуємо.

## Resource Tabs

Embedded resource tabs - це exception boundary. Вони можуть монтуватися
всередині legacy Evolution document form, але shared buttons, fields і
dirty-state behavior мають по можливості слідувати evo-ui contracts.

