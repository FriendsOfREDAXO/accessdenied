# Access denied – Zugriff verweigert

REDAXO-Artikel und Kategorien mit dem Status „offline" sind standardmäßig dennoch über das Frontend erreichbar. Mit diesem AddOn wird ein dritter Status **„gesperrt"** eingeführt, der den Zugriff im Frontend aktiv unterbindet.

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/accessdenied/assets/screenshot.png)

## Funktionen

- Artikel und Kategorien lassen sich auf **gesperrt** setzen – gesperrte Seiten leiten automatisch auf den „Nicht gefunden"-Artikel um
- **Sharing-Link**: Im Artikel-Panel wird ein kopierbarer Vorschau-Link generiert, der auch ohne Login im Backend zugänglich ist
- Der **Linkparameter** für den Sharing-Link ist frei wählbar (Standard: `preview`)
- **Vererbung**: Die Sperrung einer Kategorie kann optional auf alle Unterkategorien und Artikel vererbt werden
- Bei geerbt gesperrten Artikeln erscheint im Backend-Panel ein **Link zur sperrenden Kategorie**, um direkt dorthin zu navigieren und zu entsperren
- **IP-Positivliste**: IP-Adressen (z.B. Büronetz, Staging-Umgebung) können gesperrte Inhalte immer aufrufen – ohne Preview-Link oder Backend-Login
- Die eigene IP-Adresse lässt sich auf der Einstellungsseite per Klick zur Positivliste hinzufügen
- **Search-it-Integration**: Gesperrte Artikel werden nicht indexiert
- Das **Warn-Icon** im Backend-Panel pulsiert, um gesperrte Artikel deutlich zu kennzeichnen

## Voraussetzungen

- REDAXO `>= 5.10`
- PHP `>= 8.4`
- AddOn `structure/content >= 2.1`

## Einstellungen

Die Einstellungen befinden sich unter **System → Access denied**:

| Einstellung | Beschreibung |
|---|---|
| Standard-Status | Welchen Status erhalten neue Artikel/Kategorien? (offline, online, gesperrt) |
| Vererbung | Sperrung auf Unterkategorien und Artikel vererben (ja/nein) |
| Linkparameter | Name des URL-Parameters für den Sharing-Link (Standard: `preview`) |
| IP-Positivliste | Eine IP-Adresse pro Zeile – diese IPs können gesperrte Inhalte immer abrufen |

## Hinweise

- Bei Verwendung von **search_it** empfiehlt es sich, den Index nach dem Sperren eines Artikels oder einer Kategorie neu zu generieren
- In **Multi-Domain-Umgebungen** muss der REDAXO-Nutzer unter der jeweiligen Domain eingeloggt sein, um gesperrte Inhalte im Frontend ansehen zu können (siehe [Issue #22](https://github.com/FriendsOfREDAXO/accessdenied/issues/22))
- Das AddOn **yrewrite** wird automatisch für die URL-Generierung genutzt, wenn es verfügbar ist – es ist keine Pflichtabhängigkeit

## Deinstallation

Bei der Deinstallation werden alle gesperrten Artikel auf **offline** gesetzt.

## Lizenz

[MIT Lizenz](LICENSE)

## Autor(en)

**Friends Of REDAXO**

- https://www.redaxo.org
- https://github.com/FriendsOfREDAXO

**Leads**

- [Thomas Skerbis](https://github.com/skerbis)
- Alexander Walther (@alxndr-w)

## Credits

- REDAXO 4 Version: Koala (Sven Eichler)
- Portierung zu REDAXO 5: @Hirbod
- Standard-Status: Alexander Walther (@alxndr-w)
- Vererbung und Sharing: @skerbis
