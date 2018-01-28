# criticalmass-wordpress

Dieses Plugin ermöglicht es dir, Informationen über Critical-Mass-Touren in deinem Blog anzuzeigen.

Bislang sind diese zwei Funktionen möglich:

1. Zeige in der Sidebar das Datum und den Treffpunkt für die nächste Critical Mass in deiner Stadt an.
2. Binde eine Liste mit Critical-Mass-Touren aus deiner Region oder deinem Land ein.

## Datenquelle

Die Daten erhält das Plugin von der Webseite [criticalmass.in](https://criticalmass.in/).  Es fragt die dortige Api nach aktuellen Tour- und Städtedaten ab. Der Zugriff auf die Api ist selbstverständlich kostenlos und unbeschränkt, du brauchst dafür keine speziellen Zugangsdaten. Um die Ladezeit deines Blogs zu verbessern, werden die abgefragten Daten gecachet, um unnötige Api-Anfragen zu vermeiden.
 
Es werden keine weiteren Daten mit criticalmass.in ausgetauscht und es werden keine Inhalte aus deinem Blog oder persönliche Daten deiner Besucher übertragen.

# Entwicklungszweige

Es gibt zwei Entwicklungszweige, `dev` und `legacy`, sowie einen `release`-Zweig. Entwickelt wurde bislang mit PHP 7.1 auf dem `dev`-Zweig, anschließend wurde der ganze PHP-7-spezifische Kram herausgelöscht und in den `legacy`-Zweig gemerget. Aus dem `legacy`-Zweig wird später das eigentliche Release gebaut.

Da viele Wordpress-Installationen immer noch mit PHP 5.5 und 5.6 betrieben werden, sollte die Kompatibilität zu diesen Versionen jedenfalls noch eine Weile gewährleistet bleiben.

| Zweig  | PHP-Version | WordPress-Version |
| ------ | ----------- | ----------------- |
| dev    | +7.1        | +4.6              |
| legacy | +5.5        | +4.6              |

# Systemvoraussetzungen

Das Plugin benötigt momentan mindestens PHP 5.6 und wurde mit Wordpress-Versionen ab 4.6 getestet.

# Installation

Du kannst das Plugin wie gewohnt über Wordpress installieren: [https://de.wordpress.org/plugins/maltehuebner-critical-mass/](https://de.wordpress.org/plugins/maltehuebner-critical-mass/)

# Benutzung

## Critical-Mass-Widget

Dieses Plugin bringt ein Widget mit, dass du in der Sidebar deines Weblogs einsetzen kannst, um Details zu der nächsten Tour anzuzeigen.

1. Logge dich in deinem Wordpress-Administrationsbereich ein.
2. Wähle den Menüpunkt `Design`, dort den Unterpunkt `Widgets`.
3. Ziehe dort das Widget `Critical Mass` in den gewünschten Widget-Bereich.

Für das Widget gibt es ein paar Einstellungsmöglichkeiten; du kannst den Titel, die Einleitung und die gewünschte Stadt angeben.

Wenn du möchtest, kannst du die Tourdaten auch auf einer kleinen Karte anzeigen lassen.

## Tourliste

Mit dem Shortcode `[criticalmass-ride-list]` kannst du eine tabellarische Tourliste in einem Beitrag oder einer Seite einbetten. Die Liste zeigt in drei Spalten jeweils den Namen der Stadt, sowie Datum und Uhrzeit und den Treffpunkt der aktuellen Tour.

### Parameter
Du kannst die Darstellung der Liste mit einer Reihe von zusätzlichen Parametern beeinflussen:

#### Datumsangaben

Mit diesen drei Parametern kannst du die Tabelleninhalte auf einen bestimmten Zeitraum beschränken.

- `year`: Jahresangabe.
- `month`: Monatsangabe. Kann nur in Kombination mit der Jahresangabe eingesetzt werden.
- `day`: Tagesangabe. Kann nur in Kombination mit Monats- und Jahresangabe eingesetzt werden.

#### Geografische Angaben

- `city`: Zeige lediglich Touren aus der angegebenen Stadt an.
- `region`: Zeige lediglich Touren aus der angegebenen Region an.

Bei den Werten für diese Parameter handelt es sich um so genannte Slugs, die du bei [criticalmass.in](https://criticalmass.in/) aus der URL einer Stadt oder aus dem [Verzeichnis](https://criticalmass.in/world) ablesen kannst.

Beispielsweise lautet der Slug für Hamburg `hamburg` und für München `muenchen`. Für Touren aus Deutschland kannst du die Region `germany` angeben, für Touren aus Schleswig-Holstein die Region `schleswig-holstein`.

#### Sortierreihenfolge

- `sort-col`: Gibt an, nach welchem Wert die Tabelle sortiert werden soll. Mögliche Werte sind `city`, `date` und `estimation`. (Standardwert: `city`)
- `sort-order`: Benennt die Sortierreihenfolge. Mögliche Werte sind `asc` und `desc`. (Standardwert: `asc`)

#### Datumsdarstellungen

- `timezone`: Angabe der Zeitzone. Ohne diesen Parameter wird die jeweilige Zeitzone deines Wordpress-Blogs verwendet.
- `date-format`: Steuert die Formatierung der Datumsangabe mit der [`date`](http://php.net/manual/de/function.date.php)-Funktion. (Standardwert: `d.m.Y H:i`)

#### anzuzeigende Spalten

Du kannst mit diesen vier Parametern die anzuzeigenden Spalten konfigurieren. Mögliche Werte sind jeweils `true` und `false`:
- `col-city`: Stadt (Standardwert: `true`)
- `col-location`: Treffpunkt (Standardwert: `true`)
- `col-datetime`: Datum und Uhrzeit (Standardwert: `true`)
- `col-estimation`: Teilnehmerzahlen (Standardwert: `false`)

### Beispiele

- `[criticalmass-ride-list city="hamburg" year="2017" col-city=false]`: Zeige alle Touren aus Hamburg aus dem Jahr 2017 und verstecke den Städtenamen.
- `[criticalmass-ride-list region="germany" year="2017" month="12" col-estimation="true"]`: Zeige alle deutschen Critical-Mass-Touren mitsamt der geschätzten Teilnehmerzahlen aus dem Dezember 2017.
- `[criticalmass-ride-list region="nordrhein-westfalen" year="2017" month="12" day="29"]`: Alle Touren in Nordrhein-Westfalen am 29. Dezember 2017.
- `[criticalmass-ride-list city="hamburg" col-city="false" sort-col="date"]`: Zeige alle bekannten Touren aus Hamburg an, sortiert nach Datum.
