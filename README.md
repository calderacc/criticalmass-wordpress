# criticalmass-wp

Dieses Plugin ermöglicht es dir, Informationen über Critical-Mass-Touren in deinem Blog anzuzeigen.

Bislang sind diese drei Funktionen möglich:

1. Zeige in der Sidebar das Datum und den Treffpunkt für die nächste Critical Mass in deiner Stadt an.
2. Binde eine Liste mit Critical-Mass-Touren aus deiner Region oder deinem Land ein.
3. Lade deine Besucher ein, Teilnehmerzahlen für Critical-Mass-Touren zu schätzen.

# Systemvoraussetzungen

Das Plugin benötigt momentan mindestens PHP 7.1 und wurde mit Wordpress-Versionen ab 4.6 getestet.

# Installation

1. Lade dieses Plugin als Zip-Datei herunter.
2. Logge dich in deinem Wordpress-Administrationsbereich ein.
3. Klicke auf den Menüpunkt `Plugins`.
4. Wähle ganz oben neben der Überschrift `Plugin hochladen`.
5. Lade die Zip-Datei hoch.
6. Aktiviere das Plugin in der Liste.

# Deinstallation

Genug vom Radfahren? Kein Problem: Du kannst das Plugin ganz einfach über den Wordpress-Administrationsbereich löschen:

1. Logge dich in deinem Wordpress-Administrationsbereich ein.
2. Wähle den Menüpunkt `Plugins`.
3. Deaktiviere das Critical-Mass-Plugin.
4. Klicke direkt darunter auf `Löschen`.

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
 
Du kannst die Darstellung der Liste mit einer Reihe von zusätzlichen Parametern beeinflussen:

- `year`
- `month`
- `day`
- `city`
- `region`
- `sort`
- `timezone`
