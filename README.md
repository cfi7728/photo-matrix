# Photo Matrix Workflow (PHP 5.6 kompatibel)

Mehrstufige, asynchrone Weboberfläche für den beschriebenen BKI-Workflow:

1. 1–4 Referenzbilder hochladen.
2. Projekt **23** mit Provider **`browsercloud`** starten und FotoSet-Ergebnisse pollen.
3. FotoSet lokal je Session zwischenspeichern und vom Benutzer freigeben lassen.
4. Bei Ablehnung Ausgangsfotos einzeln ersetzen und mit neuem `draft_key` erneut starten.
5. Größe, Geschlecht, Kleidung und Bildstil erfassen; Optionswerte werden zur Laufzeit aus Projekt **18** geladen.
6. Location-Kategorie laden, bei Außen zusätzlich Region anzeigen.
7. Szenen aus Projekt **18** laden und anhand A/B/C/D/E filtern; genau drei auswählen.
8. Drei Projekt-18-Runs mit Provider **`vehabi`** starten und asynchron pollen.
9. Drei Ergebnisbilder anzeigen.

## Anforderungen

- PHP 5.6+ mit cURL, JSON, fileinfo und Sessions
- Schreibrechte auf `storage/`
- Netzwerkzugriff auf `http://bki.immonia.intern`
- BKI API-Key **nur als Server-Umgebungsvariable**

## Installation

DocumentRoot auf `public/` setzen oder den Inhalt hinter einem internen VirtualHost ausliefern.

```bash
export BKI_API_KEY='...'
export BKI_API_BASE='http://bki.immonia.intern/api/v1'
```

Apache-Beispiel:

```apache
<VirtualHost *:80>
    ServerName photo-matrix.immonia.intern
    DocumentRoot /var/www/photo-matrix/public
    SetEnv BKI_API_KEY "YOUR_SECRET_FROM_SERVER_CONFIG"
    <Directory /var/www/photo-matrix/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Den API-Key niemals in `config.php`, JavaScript, HTML, Git oder Logs speichern.**

## Wichtige Laufzeit-Erkennung

Die App hardcodiert keine BKI-Binding-IDs. `FieldCatalog.php` liest Workbench, Optionslisten und Dynamic Fields aus Projekt 18/23 und versucht die benötigten Felder semantisch anhand ihrer API-Metadaten zuzuordnen.

Falls die tatsächliche Workbench-Bezeichnung stark von `Größe`, `Geschlecht`, `Kleidung`, `Bildstil`, `Location`, `Region`, `Bildszene` abweicht, sollte die Termliste in `FieldCatalog::snapshot()` einmal an die realen Feldnamen angepasst werden. Das ist absichtlich zentralisiert.

## BKI Ressourcen-Upload

Die Ressourcen-Zuordnung läuft über die **projektweit eindeutige `field_id`** aus der Workbench. `BkiClient::uploadResource()` sendet deshalb `multipart/form-data` an `/resources/upload` mit genau den fachlich relevanten Feldern:

- `draft_key` – eine neue UUID pro Workflow-Draft
- `field_id` – aus `GET /projects/{project_id}/workbench?draft_key=...`
- `file` – die Bilddatei

`project_id` und `binding_id` werden **nicht** in den Ressourcen-Upload geschrieben. **Wichtig:** Jedes Ressourcenfeld nimmt genau eine Datei auf. Mehrere Bilder werden daher mit demselben `draft_key`, aber mit **verschiedenen `field_id`-Werten** aus `resources[*].fields[*]` hochgeladen. Ein zweiter Upload auf dieselbe `field_id` würde nur die vorherige Auswahl ersetzen.

Direkt danach wird der Run mit **demselben `draft_key`** gestartet. Ein leerer FotoSet-Run wird dabei als JSON-Objekt gesendet, nicht als Array:

```json
{
  "provider": "browsercloud",
  "values": {},
  "section_texts": {},
  "draft_key": "DIESELBE-UUID-WIE-BEIM-UPLOAD"
}
```

Für Projekt 18 gilt dasselbe Prinzip; Provider ist dort `vehabi`, während `values` die anhand der Workbench-Binding-IDs gesetzten Profil-, Location- und Szenenwerte enthält.

## Sicherheit

- API-Key bleibt serverseitig.
- Uploads sind auf JPEG/PNG/WebP, 12 MB pro Datei und max. 4 Dateien begrenzt.
- Ergebnis-Bilder mit BKI `file_id` werden serverseitig proxied.
- Externe `https://`-Ergebnis-URLs werden direkt im Browser angezeigt; beim FotoSet-Zwischenspeichern werden nur BKI-interne vertrauenswürdige URLs serverseitig geladen.
- Es werden keine destruktiven BKI-Löschaktionen benötigt.

## Verzeichnisstruktur

```text
app/
  bootstrap.php
  config.php
  lib/BkiClient.php
  lib/FieldCatalog.php
  lib/Workflow.php
public/
  index.php
  api.php
  upload-preview.php
  assets/app.css
  assets/app.js
storage/
  uploads/
  photosets/   (wird bei Bedarf angelegt)
  logs/
```
## UTF-8 / Umlaute

Die Anwendung erzwingt UTF-8 sowohl im PHP-HTML-Response als auch per `public/.htaccess` für statische Textdateien. Damit werden Zeichen wie `ä`, `ö`, `ü`, `ß`, `–`, `→` und `＋` auch auf älteren PHP-5-/Apache-Installationen korrekt ausgeliefert.

Falls Nginx statt Apache eingesetzt wird, im Server-/Location-Block zusätzlich `charset utf-8;` setzen.


## Fix: numerische `field_id` bei `/resources/upload`

`POST /resources/upload` erwartet im Multipart-Formular eine **numerische** `field_id`. UUIDs aus `binding_id`, Workbench-Knoten-IDs oder anderen internen IDs dürfen nicht als `field_id` gesendet werden.

Die Anwendung akzeptiert deshalb für Ressourcen-Uploads nur numerische Feld-IDs. Sie sucht die ID in `field_id` / `resource_field_id`, in verschachtelten `field` / `resource_field`-Objekten und verwendet eine generische `id` nur dann als Fallback, wenn der Knoten eindeutig ein Ressourcenfeld ist **und** die ID numerisch ist. Nichtnumerische UUIDs werden vor dem API-Aufruf abgewiesen.

Der Upload bleibt:

```text
POST /resources/upload
multipart/form-data:
  draft_key=<UUID>
  field_id=<NUMERISCHE_FIELD_ID>
  file=@bild.jpg
```

Danach wird derselbe `draft_key` an `POST /projects/{project_id}/runs` übergeben.

Zusätzlich werden nicht mehr vorhandene lokale Upload-Dateien automatisch aus der PHP-Session entfernt, damit verwaiste Vorschaueinträge nicht als belegte Bild-Slots zählen.

## Ressourcenfeld-Diagnose (wichtig bei HTTP 403)

Die Anwendung nimmt **keine beliebige numerische `id`** mehr als Upload-Feld. Eine `field_id` wird nur akzeptiert, wenn sie in der Workbench als echtes Ressourcen-/Upload-Feld erkennbar ist. Insbesondere normale Felder wie **Bildstil** (Select) werden nicht mehr mit einem Bild-Upload verwechselt.

Zur Diagnose im internen Netz:

```text
/api.php?action=diagnose_resource_fields&project=23
/api.php?action=diagnose_resource_fields&project=18
```

Die Antwort zeigt ausschließlich die aus der jeweiligen Workbench erkannten Ressourcenfeld-Kandidaten (`field_id`, Label, Quelle und Pfad) und die automatisch gewählte ID. Der API-Key wird dabei nicht ausgegeben.

Falls die Feldreihenfolge explizit vorgegeben werden soll, können mehrere IDs kommasepariert gesetzt werden:

```bash
export BKI_PHOTOSET_FIELD_IDS="83,84,85,86"
export BKI_SCENE_FIELD_IDS="101,102,103,104"
```

Die alten Einzelwerte `BKI_PHOTOSET_FIELD_ID` / `BKI_SCENE_FIELD_ID` bleiben nur für Projekte mit genau einem Ressourcenfeld kompatibel. Ohne Overrides wird strikt die Reihenfolge der von der jeweiligen Workbench gelieferten `resources[*].fields[*]` verwendet.

## Fix: Workbench liefert Ressourcenfeld als generische `id`

Einige BKI-Workbench-Versionen liefern Uploadfelder nicht als `field_id`, sondern als normalen Feldknoten, zum Beispiel sinngemäß:

```json
{"id":123,"type":"file","label":"Referenzfotos"}
```

Die Anwendung akzeptiert deshalb jetzt eine numerische `id`, **wenn der Knoten strukturell eindeutig ein Ressourcen-/Datei-/Uploadfeld ist** (`type=file`, `type=upload`, `type=resource`, Upload-Metadaten wie `accept`, `max_files` usw.). Ein normales Select wie `Bildstil` wird dadurch weiterhin nicht als Uploadfeld akzeptiert.

Wenn die Workbench keinen eindeutigen Treffer enthält, werden zusätzlich ausschließlich lesend folgende Projektquellen geprüft:

- `GET /projects/{project_id}/dynamic-configuration`
- `GET /projects/{project_id}/export`

Die Diagnose

```text
/api.php?action=diagnose_resource_fields&project=23
```

liefert nun zusätzlich `hints` (ressourcenähnliche Knoten mit Pfad, Typ und verfügbaren Schlüsseln) und `sources`. Dadurch lässt sich eine abweichende BKI-Struktur erkennen, ohne API-Key oder Dateiinhalte auszugeben.


## Projekt 23: tatsächliche Ressourcenfelder

Die Diagnose der aktuellen Projekt-23-Workbench zeigt die Ressourcengruppe **„Referenzfotos“** mit vier echten Uploadfeldern. Die Gruppen-ID `30` ist **keine** Upload-`field_id`. Uploadbar sind die Kindfelder:

1. `83` – Porträt - Frontalansicht
2. `84` – Ganzkörper - Frontalansicht
3. `85` – Porträt - Profilansicht
4. `86` – Porträt - lächelnd

Bei 1–4 lokalen Referenzbildern ordnet die App Bild 1..N diesen Feldern in Workbench-Reihenfolge zu. Alle Uploads verwenden denselben `photoset_draft`. Danach wird die Workbench mit demselben Draft erneut geladen und erst anschließend Projekt 23 mit `provider=browsercloud` gestartet.

Der Diagnose-Endpunkt liefert jetzt zusätzlich `selected_field_ids` und `upload_plan`. Bei mehreren Ressourcenfeldern ist `selected_field_id: null` normal; maßgeblich ist die Liste `selected_field_ids`.

## Ergebnisbilder aus BKI-Runs

Die Anwendung wertet nach einem erfolgreichen `GET /runs/{run_id}` mehrere mögliche Ergebnisstrukturen aus (u. a. `results`, `output`, `images`, `generated_files`, `assets`, `files`, Provider-JSON-Strings sowie interne Bild-URLs). Ergebnis-URLs werden immer serverseitig über `api.php?action=image...` an den Browser weitergereicht, damit der benötigte BKI-Authorization-Header nicht im Browser liegen muss.

Ein Run mit Status `succeeded`, aus dessen Antwort kein Bild extrahiert werden kann, wird nicht mehr als freigabefertiges FotoSet dargestellt. Stattdessen erscheint eine Fehlermeldung. Zur Diagnose kann in derselben Session aufgerufen werden:

```text
/api.php?action=diagnose_photoset_run
```

Die Antwort enthält `detected_images` und eine sanitisierte `run_shape`-Struktur. API-Key, Prompttexte und Base64-Bilddaten werden dabei nicht ausgegeben.

## FotoSetCard-Verlauf / Zwischenspeicher

Erfolgreiche Projekt-23-Läufe werden jetzt als eigenständige **FotoSetCards** gespeichert. Jede Card enthält:

- eine eindeutige Attempt-ID,
- die zugehörige BKI `run_id`,
- den damaligen `draft_key`,
- Erstellungszeitpunkt,
- die erkannten Ergebnisreferenzen,
- sowie – soweit abrufbar – eine lokale Kopie der Ergebnisbilder unter `storage/photosets/<PHP-Session>/<Attempt-ID>/`.

Run-Status und Run-Ressourcen werden mit der lokalen Attempt-ID als Cache-Key
abgerufen. Das ist wichtig, falls BKI eine `run_id` erneut vergibt: Ein Reverse
Proxy kann dadurch nicht versehentlich die Ergebnisantwort eines älteren Versuchs
für die neue FotoSetCard ausliefern.

Wird ein FotoSet abgelehnt und ein neuer Versuch gestartet, bleiben ältere Cards erhalten. In Schritt **FotoSet** kann zwischen den Versuchen über die Pfeile oder die Card-Leiste gewechselt werden. Auch in Schritt **Fotos** erscheint ein Link zurück zum FotoSetCard-Archiv.

Das Auswählen einer alten Card ist zunächst nur eine Vorschau. Erst **„Ja, FotoSet verwenden“** bindet die gewählte Card wieder an die nachfolgenden Projekt-18-/Vehabi-Läufe. Dadurch wird verhindert, dass versehentlich Szenen mit einer anderen Card als der aktuell sichtbaren erzeugt werden.

**Neuen Durchlauf starten** löscht den Workflow-Zustand und den lokalen FotoSetCard-Zwischenspeicher der aktuellen PHP-Session.

## Projekt 18: Binding-Diagnose

Falls der Szenenstart meldet, dass ein Binding (z. B. `height`) nicht gefunden wurde, kann die Workbench-Zuordnung geprüft werden:

```text
/api.php?action=diagnose_bindings&project=18
```

Die aktuelle Version erkennt neben `binding_id` auch verschachtelte Binding-Objekte sowie UUID-Feld-IDs als Binding-ID, sofern es sich nicht um Ressourcenfelder handelt. Optional können abweichende Installationen über `BKI_BINDING_HEIGHT`, `BKI_BINDING_GENDER`, `BKI_BINDING_CLOTHING`, `BKI_BINDING_IMAGE_STYLE`, `BKI_BINDING_LOCATION`, `BKI_BINDING_REGION` und `BKI_BINDING_SCENE` überschrieben werden.

## Fix: Projekt 18 / „Bildszene“ (2026-09-04)

BKI kann im Workbench-JSON zwei verschiedene Arten von IDs mit ähnlichen Bezeichnungen liefern:

- UUIDs von Masterprompt-Abschnitten, z. B. ein Abschnitt `SZENE`.
- echte Dynamic-Field-Bindings von Optionslisten, z. B. `binding_id` zusammen mit `option_list_id`.

Für Selectfelder (`Geschlecht`, `Stil der Kleidung`, `Bildstil`, `Location`, `Region`, `Bildszene`) verwendet der Workflow jetzt **bevorzugt das Binding der passenden Optionsliste**. Dadurch wird nicht mehr versehentlich die UUID des Masterprompt-Abschnitts als `values`-Key gesendet.

Die Diagnose

```text
/api.php?action=diagnose_bindings&project=18
```

liefert zusätzlich `binding_resolution`. Dort sind `resolved`, `option_binding`, `legacy_binding`, `option_list_id` und `source` sichtbar. Bei einem Optionslistenfeld sollte `source` normalerweise `option_list_binding` sein.

## Bestehende FotoSets wiederverwenden

Auf Schritt **01 Fotos** gibt es zusätzlich **„Bestehendes FotoSet wählen“**. Die Anwendung führt dafür eine dauerhafte lokale FotoSet-Bibliothek unter:

```text
storage/photoset-library/<photoset-id>/
```

Neue erfolgreiche FotoSet-Generierungen werden automatisch zusätzlich in diese Bibliothek kopiert. Die Bibliothek bleibt bei **„Neuen Durchlauf starten“** erhalten. FotoSetCards aus älteren Versionen unter `storage/photosets/<session>/<attempt>/` werden beim Öffnen des Archivs ebenfalls erkannt, solange die Dateien noch vorhanden sind.

Ablauf bei Wiederverwendung:

1. Auf Schritt 01 **Bestehendes FotoSet wählen** öffnen.
2. Eine FotoSetCard aus dem Storage anklicken.
3. Die Bilder werden in die aktuelle Workflow-Session übernommen.
4. Schritt 02 zeigt das Set zur Kontrolle an.
5. Mit **Ja, FotoSet verwenden** geht es ohne neue Projekt-23-Generierung mit Look, Location und Szenen weiter.

Die Vorschaubilder erhalten weiterhin versionsabhängige `?v=`-Parameter und werden mit No-Cache-Headern ausgeliefert, damit geänderte Dateien nicht aus dem Browsercache stammen.


### Decrypt-Reveal
Nach einem erfolgreichen FotoSet- oder Szenen-Run werden die echten Bilder gestaffelt aus einer Matrix-Code-Maske entschlüsselt. Die Warteansicht wechselt kurz auf die verschlüsselten Ergebnis-Slots (`DECRYPTING` → `READY`), anschließend erscheinen die tatsächlichen Bilder mit Scanline-/Decrypt-Animation. Beim normalen Neuladen oder beim Öffnen älterer FotoSets wird die Animation nicht erneut erzwungen.


### 14 Warte-Visualisierungen bei FotoSet-Erstellung
Die ca. vierminütige FotoSet-Generierung rotiert automatisch etwa alle 16 Sekunden durch 14 unterschiedliche Visualisierungen: References, Identity, Biometric Radar, Identity Helix, Landmark Constellation, Pixel Forge, Vector Lock, Memory Lattice, Entropy Filter, Identity Shards, Consistency Checksum, Synthesis Vault, Matrix und Terminal. Mit Pfeiltasten links/rechts kann man während des Wartens manuell wechseln.
