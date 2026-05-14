# Action Buttons

Les action buttons sont les commandes EvoUI communes pour forms, tables, rows,
modals et toolbars compactes. Le contrat complet est dans
[Action Buttons](../../en/components/action-buttons.md).

## Types Standards

- Form Save: bouton texte visible, `check`, `primary`, `filled`, disabled quand
  le formulaire est clean, change son label en Saved apres chaque save reussi.
- Form secondary: Reset ou URL action icon-only dans la form toolbar.
- Table toolbar action: grand bouton carre icon-only au-dessus de la table.
- Table control action: bouton icon-only a droite pres des filters/view/search.
- Row action: bouton inline icon-only dans la derniere colonne ou list/card row.
- Modal footer action: bouton texte visible pour Save, Cancel ou Confirm.

## Regles

- Save a du texte et n'est pas icon-only.
- Add utilise `plus` et `success`.
- Edit utilise `edit` et `primary`.
- Duplicate utilise `copy` ou `copy-plus` et `info`.
- Delete utilise `trash` et `danger`.
- Les actions icon-only ont `title` et `aria-label`.
- Pas de CSS bouton local au module.
