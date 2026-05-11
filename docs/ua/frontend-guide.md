# Frontend Guide

evo-ui не є публічним frontend API для сайту. Це manager UI foundation для
Evolution CMS extras.

## Assets

Manager screens мають підключати evo-ui assets через `x-evo::layout` або
transitional `evo::partials.assets`. Не додавайте CDN CSS, CDN JS, Bootstrap,
jQuery або локальні копії shared controls у consumer modules.

## Theme Bridge

```css
.my-module-local-exception {
    color: var(--evo-ui-text);
    background: var(--evo-ui-bg);
}
```

Local CSS допустимий тільки для module-specific layout, який ще не став shared
primitive.

