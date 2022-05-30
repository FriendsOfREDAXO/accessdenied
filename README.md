# Access denied / Zugriff verweigert 

REDAXO-Artikel und Kategorien mit dem Status "offline" sind standardmäßig dennoch über das Frontend erreichbar. Mit diesem AddOn werden Kategorien und Artikel um einen weiteren Status "gesperrt" erweitert.

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/accessdenied/assets/screenshot.png)

## Features

- Dieses Utility-AddOn ermöglicht das Sperren von Artikeln und Sharing per Preview-Link. 
- In den Artikeln wird bei gesperrtem Status ein Panel angezeigt, in dem ein Sharing-Link generiert wird. 
- Die Sperrung der Kategorien vererben sich optional auf die Unterkategorien und Artikel
- Gesperrte Seiten leiten automatisch auf den not found Artikel um, wenn sie nicht mit Preview-Parameter oder aus dem Backend heraus aufgerufen werden. 

## Einstellungen

- Auf der AddOn-Einstellungsseite "Artikelsperre" lässt sich auswählen, ob neue Artikel und Kategorien standardmäßig offline, online oder gesperrt angelegt werden.
- Die Vererbung kann aktiviert / deaktiviert werden

## Hinweise zur Nutzung

In Multi-Domain-Umgebungen muss der REDAXO-Benutzer unter der jeweiligen Domain eingeloggt sein, um den Artikel im gesperrten Zustand im Frontend ansehen zu können, siehe:  https://github.com/FriendsOfREDAXO/accessdenied/issues/22

## Lizenz

[MIT Lizenz](LICENSE.md)

## Autoren

* REDAXO 4 Version: Koala (Sven Eichler)
* Portierung zu REDAXO 5: @Hirbod
* Default-Status: Alexander Walther @alxndr-w
* Vererbung und Sharing: @skerbis
