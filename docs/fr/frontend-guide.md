# Frontend Guide

evo-ui ne fournit pas d'API frontend publique pour le site. C'est une foundation
UI manager pour les extras Evolution CMS.

## Assets

Les ecrans manager chargent les assets evo-ui via `x-evo::layout` ou
`evo::partials.assets`. Pas de CDN CSS/JS, pas de Bootstrap, pas de jQuery et
pas de copies locales des controls communs.

```css
.my-module-local-exception {
    color: var(--evo-ui-text);
    background: var(--evo-ui-bg);
}
```

Le CSS local doit rester reserve aux exceptions de layout propres au module.

