# Przewodnik uzytkownika

evo-ui to wspolny UI kit managera dla extras Evolution CMS. Uzytkownicy widza
go w modulach `sArticles`, `dIssues`, `sLang`, `sSeo`, `sSettings` i `dDocs`.

## Co kontroluje evo-ui

- Shell managera i kolory motywu.
- Taby, toolbary, przyciski, badges, cards i modale.
- Tabele, listy, filtry, paginacje i akcje wiersza.
- Formularze z ochrona dirty-state.
- Feedback zapisu wewnatrz przycisku Save.
- Issue workspaces: lista, kanban, detail i komentarze.

## Standardowe akcje

Przyciski Save maja wszedzie ten sam primary filled styl. Add, edit, duplicate
i delete uzywaja wspolnych regul ikon i tone evo-ui.

## Wyjatek dDocs

dDocs celowo uzywa workspace dokumentacji z sidebar tree i viewer. Nie uzywa
gornych module tabs, ale powinien nadal korzystac z przyciskow, inputs, cards,
badges, kolorow i typografii evo-ui.

## Rozmiary szerokiego obszaru roboczego

Od szerokości modułu 2048 pikseli CSS Evo UI powiększa razem tekst, kontrolki, ikony, karty, wiersze tabel i odstępy. Przy 2560 pikselach CSS tekst ma 18 px, maksymalnie 20 px; wysokość kontrolek jest ograniczona do 44 px. Full HD (1920 pikseli CSS) zachowuje obecne rozmiary. Skalowanie systemu, powiększenie przeglądarki i iframe określają efektywną szerokość. Klasyczny górny pasek menedżera pozostaje bez zmian.
