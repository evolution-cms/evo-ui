# Frontend Guide

evo-ui nie udostepnia publicznego frontend API dla strony. To manager UI
foundation dla extras Evolution CMS.

## Assets

Ekrany managera laduja assets evo-ui przez `x-evo::layout` albo
`evo::partials.assets`. Bez CDN CSS/JS, Bootstrap, jQuery i lokalnych kopii
wspolnych controls.

```css
.my-module-local-exception {
    color: var(--evo-ui-text);
    background: var(--evo-ui-bg);
}
```

Lokalny CSS powinien zostac tylko dla modulowych wyjatkow layoutu.

