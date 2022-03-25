# Access denied / Zugriff verweigert

REDAXO-Artikel und Kategorien mit dem Status "offline" sind standardmäßig dennoch über das Frontend erreichbar. Mit diesem AddOn werden Kategorien und Artikel um einen weiteren Status "gesperrt" erweitert.

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/accessdenied/assets/screenshot.png)

## Funktionen

* Es wird ein zusätzliches Statusfeld "gesperrt" registriert.
* Gesperrte Artikel leiten im Frontend automatisch auf den Fehler-Artikel weiter, mit dem Status-Code `307` (Temporäre Weiterleitung).
* Artikel bleiben für eingeloggte REDAXO-Benutzer sichtbar. 
* Der Status `gesperrt` kann für neue Artikel und Kategorien als Standard-Status eingestellt werden.

## Installation

* Voraussetzungen: REDAXO `>= 5.1.0`, PHP `>= 7`, `structure`-Addon
* Über den REDAXO-Installer herunterladen und installieren. Es sind keine weiteren Schritte nötig.

Anschließend lässt sich in der Struktur jeder Artikel und jede Kategorie der zusätzliche Status `gesperrt` festlegen.

## Einstellungen

Auf der AddOn-Einstellungsseite "Artikelsperre" lässt sich auswählen, ob neue Artikel und Kategorien standardmäßig offline, online oder gesperrt angelegt werden.

## Hinweise zur Nutzung

In Multi-Domain-Umgebungen muss der REDAXO-Benutzer unter der jeweiligen Domain eingeloggt sein, um den Artikel im gesperrten Zustand im Frontend ansehen zu können, siehe:  https://github.com/FriendsOfREDAXO/accessdenied/issues/22

## Lizenz

[MIT Lizenz](LICENSE.md)

## Autoren

* REDAXO 4 Version: Koala (Sven Eichler)
* Portierung zu REDAXO 5: @Hirbod
* Default-Status: Alexander Walther @alxndr-w
