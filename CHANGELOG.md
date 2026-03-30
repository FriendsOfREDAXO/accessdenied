# Changelog

## 4.0.0 (2026-03-30)

### Breaking Changes
- Mindestanforderung: PHP `>=8.4` (zuvor `>=7.4`)
- Das `yrewrite`-AddOn ist keine Pflichtabhängigkeit mehr — es wird automatisch genutzt, wenn verfügbar, sonst Fallback auf `rex::getServer()` + `rex_getUrl()`

### Neu
- **IP-Positivliste**: IP-Adressen unter Einstellungen → IP-Positivliste können gesperrte Artikel und Kategorien immer aufrufen (z.B. für Büronetz oder Staging-Umgebungen)
- Die aktuelle IP des Nutzers wird auf der Einstellungsseite angezeigt und kann per Klick zur Liste hinzugefügt werden
- Bei Artikeln, die per Kategorie-Vererbung gesperrt sind, erscheint im Sidebar-Panel ein Link zur spsrrenden Kategorie — so kann der Redakteur direkt navigieren und entsperren
- Das Gesperrt-Panel erscheint jetzt oben in der Sidebar, nicht mehr am Ende

### Fehlerbehebungen
- `use rex_redirect` war ein Klassen-Import statt `use function rex_redirect` — die Weiterleitung funktionierte dadurch nicht korrekt
- `getCategory()` kann bei Artikeln auf oberster Ebene `null` zurückgeben und verursachte einen fatalen Fehler in der Search-It-Integration
- Artikel-ID im Teilen-Link wurde aus `rex_article::getCurrent()` statt aus den Seitenparametern gelesen — führte zu falschen Links
- Der Warn-Icon-Farbwert war als Inline-Style `color: red` gesetzt — jetzt CSS-Klasse mit Dark-Mode-Unterstützung
- Fehlermeldung für den Linkparameter behauptete fälschlich, nur `a–z` seien erlaubt; das Regex erlaubt `A-Z`, `0-9`, `_`, `.` und `-`
- CSS- und JS-Datei wurden nur geladen, wenn das `quick_navigation`-AddOn aktiv war

## 3.0.2
- Initiales Release
