# Access denied / Zugriff verweigert

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/accessdenied/assets/screenshot.png)

Mit diesem AddOn werden Kategorien und Artikel um einen weiteren Status erweitert (kein Patch, sauber über EP).
Es steht ein zusätzlicher Status "gesperrt" zur Verfügung. Damit kann der Artikel nicht im Frontend aufgerufen werden. (eines der häufigsten Kundenanfragen)

Hinweis: eingeloggte Backenduser (keine Permission notwendig) sind von der Weiterleitung nicht betroffen.
Es wird automatisch auf den Notfound-Artikel geleitet. Header-Status 302! (temporäre Weiterleitung)

How-To
------------
Einfach ein weiterer Klick bei online/offline. Statusfarbe und Icon entsprechen des Status offline.
Text: gesperrt / blocked

Sprachen
------------
Deutsch und Englisch (PRs välkommen ;))

Settingspage
------------
Dieses AddOn hat keine Konfigurationsparameter. Es muss nichts gemacht werden, alles läuft vollautomatisch.

Installation
------------
Hinweis: dies ist kein Plugin!

* Release herunterladen und entpacken.
* Ordner umbenennen in `accessdenied`.
* In den Addons-Ordner legen: `/redaxo/src/addons`.

Oder den REDAXO-Installer / ZIP-Upload AddOn nutzen!

Voraussetzungen
------------

* REDAXO >= 5.1.0
* structure Addon


Credits
-----
* Koala (Sven Eichler) für die REDAXO 4 Version
* REX 5 Port by @Hirbod
