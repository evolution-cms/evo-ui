# Guide utilisateur

evo-ui est le UI kit commun du manager pour les extras Evolution CMS. Les
utilisateurs le voient dans `sArticles`, `dIssues`, `sLang`, `sSeo`,
`sSettings` et `dDocs`.

## Ce que gere evo-ui

- Le shell manager et les couleurs de theme.
- Tabs, toolbars, boutons, badges, cards et modals.
- Tables, listes, filtres, pagination et actions de ligne.
- Formulaires avec protection dirty-state.
- Feedback de sauvegarde dans le bouton Save.
- Workspaces issue avec liste, kanban, detail et commentaires.

## Actions standard

Les boutons Save utilisent le meme style primary filled partout. Add, edit,
duplicate et delete suivent les memes regles d'icone et de tone evo-ui.

## Exception dDocs

dDocs utilise volontairement un workspace documentation avec sidebar tree et
viewer. Il n'utilise pas les tabs superieurs, mais doit reutiliser boutons,
inputs, cards, badges, couleurs et typographie evo-ui.

## Dimensions des grands espaces de travail

À partir de 2048 pixels CSS de largeur du module, Evo UI agrandit ensemble le texte, les contrôles, les icônes, les onglets, les lignes de tableau et les espacements. Le texte atteint 18 px à 2560 pixels CSS et reste limité à 20 px ; les contrôles sont limités à 44 px de hauteur. Le Full HD (1920 pixels CSS) conserve ses dimensions. La mise à l’échelle du système, le zoom du navigateur et l’iframe déterminent la largeur effective. La barre classique du gestionnaire reste inchangée.
