# Access denied / Zugriff verweigert 

REDAXO-Artikel und Kategorien mit dem Status "offline" sind standardmäßig dennoch über das Frontend erreichbar. Mit diesem AddOn werden Kategorien und Artikel um einen weiteren Status "gesperrt" erweitert.

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/accessdenied/assets/screenshot.png)

## Funktionen

- Dieses Utility-AddOn ermöglicht das Sperren von Artikeln und Sharing per Preview-Link. 
- Der Linkparameter für den Sharing-Link kann frei gewählt werden. (Standard: preview)
- In den Artikeln wird bei gesperrtem Status ein Panel angezeigt, in dem ein Sharing-Link generiert wird. 
- Die Sperrung der Kategorien vererben sich optional auf die Unterkategorien und Artikel
- Gesperrte Seiten leiten automatisch auf den not found Artikel um, wenn sie nicht mit Preview-Parameter oder aus dem Backend heraus aufgerufen werden. 

## Einstellungen

Die Einstellungen befinden sich in den Systemeinstellungen (Menüpunkt: System)

- Im Tab "Access denied" lässt sich auswählen, ob neue Artikel und Kategorien standardmäßig offline, online oder gesperrt angelegt werden.
- Die Vererbung kann aktiviert / deaktiviert werden

## Hinweise zur Nutzung

- Es empfiehlt sich bei Verwendung von search_it den Index bei Sperrung eines Artikels / einer Kategorie neu zu generieren. 
- In Multi-Domain-Umgebungen muss der REDAXO-Benutzer unter der jeweiligen Domain eingeloggt sein, um den Artikel im gesperrten Zustand im Frontend ansehen zu können, siehe:  https://github.com/FriendsOfREDAXO/accessdenied/issues/22


## Deinstallation
Bei der Deinstallation werden alle gesperrten Artikel auf offline gesetzt. 

## Lizenz

[MIT Lizenz](LICENSE.md)

## Autoren

* REDAXO 4 Version: Koala (Sven Eichler)
* Portierung zu REDAXO 5: @Hirbod
* Default-Status: Alexander Walther @alxndr-w
* Vererbung und Sharing: @skerbis
