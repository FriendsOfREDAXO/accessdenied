# Access denied / Zugriff verweigert
## Artikel im Frontend sperren

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/accessdenied/assets/screenshot.png)

Mit diesem AddOn werden Kategorien und Artikel um einen weiteren Status erweitert (kein Patch der Struktur, sauber über einen EP).
Es wird ein zusätzliches Statusfeld "gesperrt" registriert. Damit kann der Artikel nicht mehr Frontend aufgerufen werden, auch wenn der Link bekannt ist. 

Hinweis: eingeloggte Backenduser (keine Permission oder Einstellung notwendig) sind von der Weiterleitung nicht betroffen und können weiterhin den Artikel im Frontend aufrufen. Wichtig ist, dass man hierzu über die selbe Domain im Backend eingeloggt ist.

Es wird automatisch auf den Notfound-Artikel geleitet. Der Headerstatus wird auf *302* gesetzt (temporäre Weiterleitung).

How-To
------------
Einfach ein weiterer Klick bei online/offline. (bzw. in neueren REDAXO Versionen erscheint ein Dropdown) 
Statusfarbe und Icon sind analog zu "offline".

Sprachen
------------
Siehe hier: https://github.com/FriendsOfREDAXO/accessdenied/tree/master/lang

Settingspage
------------
Dieses AddOn hat keine Konfigurationsparameter.

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
* PHP 7.*
* structure Addon

Known issues
------------
https://github.com/FriendsOfREDAXO/accessdenied/issues/22
Artikel in einer Multidomainumgebung sind unter Umständen auch für eingeloggte User nicht aufrufbar, da sich die URL unterscheidet. Ich arbeite an einer Lösung

Credits
-----
* Koala (Sven Eichler) für die REDAXO 4 Version
* REX 5 Port by @Hirbod
