# wordpress-graduate-plugin

Jak korzystać z REST API?
- Zainstaluj i włącz plugin
- Przejdź do widoku listy absolwentów
- Nad tabelą zobaczysz informację o wygenerowanym kluczu
- Skopiuj klucz i użyj przy wywołaniach w następujący sposób
?rest_route=/graduates/v1/list/<liczba rekordów do pobrania>&token=<Wygenerowany token>
Na przykład
?rest_route=/graduates/v1/list/50&token=4f1ecee53b8928332c6dc755c2514b49c02501bd
