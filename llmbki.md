# BKI API – persönliche LLM-Anleitung

Diese Datei erklärt einem LLM, wie es die BKI API im Namen von **Christian Fiacco** verwendet.

## Verbindung

- API-Basis: `http://bki.immonia.intern/api/v1`
- OpenAPI: `http://bki.immonia.intern/api/v1/openapi.json`
- Benutzer: `chris`
- Rolle: `admin`
- Generiert: `2026-09-30T08:06:21Z`
- API-Limit: `3650` Anfragen je Projekt innerhalb von 24 Stunden

## Authentifizierung

Verwende bei jeder geschützten Anfrage exakt diesen Header:

```http
Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs
Accept: application/json
```

Setze `Content-Type: application/json` nur bei JSON-Bodies. Bei Datei-Uploads mit
`multipart/form-data` darf der Client den Header einschließlich Boundary selbst erzeugen
(`curl -F`); setze dort keinen JSON-Content-Type.

Der Schlüssel ist geheim. Gib ihn niemals in Antworten, Logs oder Fehlermeldungen aus. Verwende ihn nur gegenüber `http://bki.immonia.intern/api/v1`. Wenn eine Anfrage mit `401 AUTH_REQUIRED` antwortet, wurde der Schlüssel möglicherweise rotiert oder gesperrt; lade dann eine neue `llm.md` aus BKI herunter.

## Verfügbare Scopes

- `profile:read`
- `profile:write`
- `projects:read`
- `projects:write`
- `workbench:read`
- `workbench:write`
- `runs:read`
- `runs:start`
- `runs:cancel`
- `runs:retry`
- `runs:delete`
- `resources:read`
- `resources:write`
- `files:read`
- `files:write`
- `tags:read`
- `tags:write`
- `assignments:write`
- `master_prompts:read`
- `master_prompts:write`
- `master_prompts:activate`
- `options:read`
- `options:write`
- `dynamic_fields:read`
- `dynamic_fields:write`
- `results:read`
- `results:import`
- `users:read`
- `users:write`
- `api_keys:rotate`
- `settings:read`
- `settings:write`
- `support:write`
- `browsercloud:manage`
- `system:read`
- `audit:read`

## Arbeitsablauf

1. Rufe `GET /me` auf und prüfe Identität sowie Scopes.
2. Rufe `GET /projects?limit=50&offset=0` auf. Erfinde niemals Projekt-IDs.
3. Erzeuge eine frische UUIDv4 und lade `GET /projects/{project_id}/workbench?draft_key={uuid_v4}`. Nutze ausschließlich die gelieferten Binding-IDs oder `api_alias`-Namen, Optionswerte, Bedingungen, Ressourcenfelder und Provider.
4. Prüfe Eingaben mit `POST /projects/{project_id}/prompt/resolve`.
   - Sende `Content-Type: application/json`. Body, `values` und `section_texts` müssen JSON-Objekte sein: leer `{}`, niemals `[]` oder `null`. Arrays als einzelne Feldwerte innerhalb von `values` sind für Mehrfachauswahl erlaubt. Fehlende `values`/`section_texts` verwenden den Standard `{}`.
   - HTTP `422 ACTION_REJECTED`: Lies `error.errors`. Jeder Eintrag nennt `parameter` (`body`, `values`, `section_texts`), `code`, `expected_type`, `actual_type` und `message`. Beispiel: `parameter=values`, `code=INVALID_TYPE`, `expected_type=object`, `actual_type=array`: korrigiere `values` von `[]` zu `{}` beziehungsweise einem Objekt mit Binding-IDs oder gelieferten API-Aliasnamen.
   - `INVALID_JSON` bedeutet ungültiges JSON oder falschen Content-Type. Mehrere falsche Parameter werden gemeinsam gemeldet. Gib niemals API-Key oder vollständige Eingabeinhalte zum Debuggen aus.
   - HTTP `200` heißt nicht automatisch fachlich gültig: Prüfe `data.prompt.valid`. Feldfehler stehen unter `data.prompt.errors` mit `binding_id`, `label`, `code` und `message`. Starte keinen Test bei `valid=false`.
5. Lade benötigte Dateien über `POST /resources/upload` hoch oder wähle sie mit `POST /resources/select` aus.
6. Starte Tests mit `POST /projects/{project_id}/runs` und einem neuen `Idempotency-Key`.
7. Lies die Lauf-ID aus `data.run.id` der `202`-Antwort. Die Startantwort besitzt bewusst
   kein Feld `run_id` auf der obersten Ebene. Frage danach `GET /runs/{run_id}` ab und
   lies den Zustand aus `data.status`, bis er `succeeded` oder `failed` ist. Bei einem
   Multitest oder Mehrfachstart stehen alle Lauf-IDs zusätzlich in `data.runs[].id`; verfolge
   dann jeden Eintrag einzeln. Aktive Läufe können über `POST /runs/{run_id}/cancel`
   beendet werden.
8. Wenn OpenAPI für eine Operation `Idempotency-Key` als Pflichtparameter markiert oder
   `/capabilities` `idempotency_required: true` meldet, wiederhole sie nur mit demselben
   Schlüssel und unverändertem Body. Derselbe Schlüssel mit geändertem Body ergibt HTTP 409.
   Bei `IDEMPOTENCY_IN_PROGRESS` beachte `Retry-After`, sofern vorhanden. Teststarts speichern
   Auftrag und wiederholbare Antwort gemeinsam. Offene Reservierungen werden nicht automatisch
   freigegeben: Nach fünf Minuten kann der Ausgang unklar sein; dann fehlen `Retry-After` und
   eine Freigabe zur Wiederholung. Prüfe vorhandene Aufträge oder kontaktiere den Support mit
   der `request_id`; verwende keinen neuen Schlüssel zum blinden Wiederholen. Andere
   Operationen erhalten keinen unnötigen Schlüssel.

## Ergebnisbilder lesen und herunterladen

Ein erfolgreicher `GET /runs/{run_id}` liefert Ergebnisbilder in `data.result_images` als
stabile, authentifizierte URLs. Die URL endet mit dem konfigurierten Anzeigenamen und wird
mit demselben Bearer-Token und dem Scope `runs:read` geladen. BKI liefert echte Bilddateien statt Base64 im JSON.

```bash
curl -k --fail-with-body   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Accept: image/*'   -o ergebnisbild.webp   'http://bki.immonia.intern/api/v1/result-images/REPLACE_WITH_IMAGE_ID/content/REPLACE_WITH_DISPLAY_NAME'
```

Verwende ausschließlich die vom Lauf gelieferte URL. Erfinde weder Bild-ID noch Dateiname:
Das globale Dateinamensschema kann pro Projekt überschrieben werden. Mehrere Bilder eines
Laufs erhalten auch ohne `image_index` im Schema eindeutige Namen.

## Projektfelder abfragen und verstehen

Wenn der Nutzer nach den **Feldern**, **Eingaben**, **Formularfeldern**, **Pflichtfeldern**,
**Auswahlmöglichkeiten** oder danach fragt, was er in einem Projekt ausfüllen kann, rufe
immer `GET /projects/{project_id}/workbench?draft_key={uuid_v4}` auf. Verwende dafür eine
frisch erzeugte gültige UUIDv4 als `draft_key`. Fehlende, leere, syntaktisch ungültige UUIDs
und UUIDs anderer Versionen (zum Beispiel UUIDv1) führen zu `422 ACTION_REJECTED`. Verwende
denselben `draft_key` für alle Ressourcenaktionen und den anschließenden Teststart, die zu
diesem Entwurf gehören. Für diesen lesenden Aufruf ist kein
`Idempotency-Key` nötig. Verwende nicht `/dynamic-fields` als Ersatz: Die Workbench ist die
maßgebliche, für den jeweiligen API-Nutzer ausführbare Projektkonfiguration.

Die erfolgreiche Antwort liegt unter `data` und enthält insbesondere:

- `bindings`: normale dynamische Eingabefelder. `id` ist die Binding-ID, die später als
  Schlüssel in `values` verwendet wird. Optional kann stattdessen der gelieferte stabile `api_alias` verwendet werden. Beachte `label`, `field_type`, Pflicht-/Toggle-
  Konfiguration und die Zuordnung zu Abschnitten.
- `option_lists`: erlaubte Auswahlwerte für Bindings mit Optionsliste. Erfinde keine Werte,
  sondern verwende ausschließlich die gelieferten Einträge.
- `option_conditions`: Bedingungen, durch die Felder oder Werte abhängig von anderen
  Eingaben verfügbar werden.
- `resources`: Ressourcen-Gruppen und Bild-/Dateifelder. `resources[].fields[]` liefert
  `id` und optional `api_alias`. Bei `/resources/upload` oder `/resources/select`
  verwende `field_id=id` oder `project_id` zusammen mit `field_alias=api_alias`.
- `providers`: die für dieses Projekt aktuell verfügbaren Ausführungsprovider.

Beantworte Fragen wie „Welche Felder hat Projekt 18?“ nicht nur mit dem Endpunkt: Führe den
Workbench-Aufruf aus beziehungsweise gib ihn ausführbar aus und fasse danach die tatsächlich
gelieferten `bindings` und `resources` mit ID, Bezeichnung, Typ, Pflichtstatus und erlaubten
Optionen zusammen. Behaupte keine Felder, die nicht in dieser konkreten Antwort vorkommen.

```bash
curl -k --fail-with-body   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Accept: application/json'   'http://bki.immonia.intern/api/v1/projects/18/workbench?draft_key=8f6f4c45-8f67-4e0f-90ca-a591f4fe3a31'
```

## Test starten

```bash
curl --fail-with-body \
  -X POST \
  -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs' \
  -H 'Content-Type: application/json' \
  -H 'Idempotency-Key: REPLACE-WITH-A-NEW-UNIQUE-ID' \
  -d '{"provider":"vehabi","values":{}}' \
  'http://bki.immonia.intern/api/v1/projects/REPLACE_WITH_PROJECT_ID/runs'
```

Eine erfolgreiche Einzelstart-Antwort hat diese Struktur (gekürzt):

```json
{
  "ok": true,
  "request_id": "3d358e45-2579-4d18-bc77-e09b7bd3fb9d",
  "data": {
    "run": {
      "id": "b34a89fe-3495-4d52-9e41-4790f83a4b1d",
      "project_id": 18,
      "provider": "vehabi",
      "status": "queued"
    },
    "runs": [
      {"id": "b34a89fe-3495-4d52-9e41-4790f83a4b1d", "status": "queued"}
    ],
    "multitest": false,
    "message": "…"
  }
}
```

Verbindliche Ausleseregel:

- Einzelstart: `run_id = response.data.run.id`.
- Multitest/Mehrfachstart: `run_ids = response.data.runs.map(run => run.id)`.
- Verwende niemals `response.run_id`, `response.data.run_id` oder einen HTTP-Header als
  Lauf-ID; diese Felder existieren nicht.
- Falls HTTP 202 vorliegt, aber `data.run.id` fehlt oder keine nichtleere `data.runs[].id`
  vorhanden ist, behandle die Antwort als unerwarteten Vertragsfehler. Bewahre
  `request_id` und den unveränderten `Idempotency-Key` zur Diagnose auf. Starte nicht blind
  mit einem neuen Schlüssel erneut.

Beispiel in JavaScript:

```javascript
const payload = await response.json();
if (!response.ok || !payload.ok) throw new Error(payload.error?.message || `HTTP ${response.status}`);
const runIds = (payload.data?.runs || []).map(run => run?.id).filter(Boolean);
if (!runIds.length && payload.data?.run?.id) runIds.push(payload.data.run.id);
if (!runIds.length) throw new Error(`BKI-Startantwort ohne Lauf-ID; request_id=${payload.request_id || "unbekannt"}`);
```

Statusabfrage für jede gelieferte ID:

```bash
curl -k --fail-with-body   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Accept: application/json'   'http://bki.immonia.intern/api/v1/runs/REPLACE_WITH_RUN_ID'
```

Die Antwort auf die Statusabfrage enthält den Zustand unter `data.status`, das Ergebnis je
nach Provider unter `data.result_text`, `data.result_images` und `data.result_image_files`
sowie einen Fehler unter `data.error_text`. `queued` und `running` sind nicht final;
`succeeded` und `failed` sind final. Nutze für die Statusabfrage ausschließlich
`GET /runs/{run_id}`, nicht `/projects/{project_id}/runs/{run_id}`.

`values` enthält die Workbench-Feldwerte, indiziert nach Binding-ID oder dem gelieferten `api_alias`. Aliase werden beim Übernehmen bestehender Felder mitgeführt. Unbekannte Aliase und widersprüchliche Werte über Alias und ID sind Fehler; Antworten behalten numerische IDs. Je nach Projekt können zusätzlich `section_texts`, `multitest`, `random_fields`, `aspect_ratio` und `draft_key` verwendet werden. Lade Projektinformationen zuerst und übermittle keine erfundenen Felder.

## Stabile API-Aliase statt wechselnder Feld-IDs

Lade zuerst die Workbench. Jedes Binding liefert `id` und optional `api_alias`.
Verwende einen vorhandenen Alias als Schlüssel in `values`; bei `api_alias=null`
verwendest du weiterhin die numerische ID als Text. Erfinde keine Aliasnamen.

Beispiel (nur verwenden, wenn `farben` und `stil` tatsächlich geliefert werden):

```json
{
  "values": {
    "farben": "#111111\n#e84b13",
    "stil": "traditionelle, handgemalte Plein-Air"
  },
  "section_texts": {}
}
```

- Gilt für `POST /projects/{project_id}/prompt/resolve`, Teststart über
  `POST /projects/{project_id}/runs` und `workbench.save`/`workbench.dispatch`.
- Aliase und numerische IDs dürfen für verschiedene Felder gemischt werden.
  Bestehende ID-Aufrufe bleiben gültig. Antworten und gespeicherte Werte bleiben numerisch.
- Für dasselbe Feld sind ID und Alias nur mit identischen Werten erlaubt.
  Unterschiedliche Werte ergeben `CONFLICTING_API_ALIAS`; unbekannte oder mehrdeutige
  Aliase ergeben `INVALID_API_ALIAS`. Bei Promptauflösung stehen diese Fehler unter
  `data.prompt.errors` und `data.prompt.valid=false` (HTTP 200). Nicht als JSON-Typfehler behandeln.
- Konditionsreferenzen und `random_fields` bleiben numerisch. Uploadfelder unterstützen
  eigene `field_alias`-Parameter; siehe Ressourcenabschnitt.
- Admins vergeben Aliase im Formfeldeditor oder über `dynamic_fields.save` mit
  `api_alias`. Namen: 1–64 Zeichen, Muster `[a-z][a-z0-9_]*`; `constructor` und
  `prototype` sind reserviert. Eindeutig je Projekt und Masterpromptstand.
  Fehlender Parameter erhält den bisherigen Alias; `null` oder leerer Text entfernt ihn.
  Verknüpfungspartner verwenden den Alias des globalen Ausgangsfelds.
- Beim Übernehmen vorhandener Felder auf einen neuen Masterprompt, bei Verfeinerungen
  und Snapshotkopie/-wiederherstellung wird der Alias mitgeführt, auch bei neuer Feld-ID.
  Aliase gelten im aktiven Projektstand. Komplett neue Felder benötigen eine ausdrückliche
  Aliaszuordnung; ältere Snapshots ohne Aliase erhalten keine automatisch erratenen Namen.

## Dateien und Ressourcen einem Test zuordnen

Ressourcen sind immer projektbezogen. `/resources/upload` (multipart) und
`/resources/select` (JSON) akzeptieren entweder die aktuelle `field_id` oder
`project_id` zusammen mit `field_alias`, beispielsweise `makler_logo`.
Die Workbench liefert den optionalen `api_alias` je Ressourcenfeld. Der Alias wird
gegen aktive Uploadfelder des angegebenen Projekts aufgelöst; unbekannte Aliase
oder widersprüchliche Angaben von ID und Alias werden mit HTTP 400 abgewiesen.
Projektberechtigungen, Dateitypen und Quotas gelten unverändert.

Aliase: 1–64 Zeichen, `[a-z][a-z0-9_]*`, keine reservierten Namen `constructor` oder
`prototype`; eindeutig über alle aktiven Uploadgruppen eines Projekts. Eingabefelder
und Uploadfelder besitzen getrennte Alias-Namensräume. Im Admin-Uploadfeld oder über
`dynamic_fields.resource_save` kann `fields[].api_alias` gesetzt werden. Ein fehlender
Alias erhält den bisherigen Wert bei mitgesendeter Feld-ID (alternativ eindeutig
identischer Bezeichnung); leerer Text oder null entfernt ihn. Snapshots und
Projektexport/-import übernehmen die Namen; alte Stände erhalten keine erfundenen Aliase.

Uploadbeispiel: `project_id=18`, `field_alias=makler_logo`, `draft_key=<UUID>` und
`file=<Binärdatei>` als multipart senden. Numerische IDs weiterhin nur aus der
aktuellen Workbench übernehmen; nach einem Snapshotwechsel können sie sich ändern.

Vollständiger Ablauf:

1. Wähle ein Projekt aus `GET /projects`; für Projekt 34 ist `project_id=34`.
2. Erzeuge für den geplanten Test eine neue UUIDv4 als `draft_key`.
3. Rufe `GET /projects/{project_id}/workbench?draft_key={draft_key}` auf. Lies daraus die Ressourcenfelder einschließlich `id`, optionalem `api_alias`, Bezeichnung, Pflichtstatus, erlaubten Dateitypen, Größenlimit und bereits ausgewählter Datei. Gibt es keine Ressourcenfelder, kann diesem Projekt keine Testressource zugeordnet werden; erfinde dann keine ID.
4. Lade für jedes gewünschte Feld genau eine Datei mit `POST /resources/upload` als echtes `multipart/form-data` hoch. Sende `draft_key`, den binären Dateiinhalt `file` und entweder `field_id` oder `project_id` plus `field_alias`. Die Antwort enthält unter anderem Auswahl- und Asset-ID sowie die bestätigte `field_id`.
5. Alternativ: Lade eigene vorhandene Dateien mit `GET /files` und weise eine zulässige Datei mit `POST /resources/select` sowie `asset_id`, demselben `draft_key` und entweder `field_id` oder `project_id` plus `field_alias` zu.
6. Rufe die Workbench erneut mit demselben `draft_key` auf und prüfe, dass alle Pflichtressourcen ausgewählt sind.
7. Starte `POST /projects/{project_id}/runs` mit exakt demselben `draft_key`. Erst dadurch werden die Entwurfsressourcen dauerhaft dem neuen Testlauf zugeordnet.
8. Historische Testressourcen stehen beim Lauf und können über `GET /runs/{run_id}/resources/{file_id}/content` binär abgerufen werden. Verwende dafür die vom Lauf gelieferten Ressourcen-/Datei-IDs.

Beispiel für einen Upload zu Projekt 34 (ersetze `FIELD_ID_FROM_WORKBENCH` durch eine ID aus der Workbench-Antwort von Projekt 34):

```bash
PROJECT_ID=34
DRAFT_KEY="$(uuidgen | tr '[:upper:]' '[:lower:]')"

curl --fail-with-body   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   'http://bki.immonia.intern/api/v1/projects/'"$PROJECT_ID"'/workbench?draft_key='"$DRAFT_KEY"

curl --fail-with-body   -X POST   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -F 'draft_key='"$DRAFT_KEY"   -F 'field_id=FIELD_ID_FROM_WORKBENCH'   -F 'file=@/absolute/path/to/image.jpg'   'http://bki.immonia.intern/api/v1/resources/upload'

curl --fail-with-body   -X POST   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Content-Type: application/json'   -H 'Idempotency-Key: REPLACE-WITH-A-NEW-UNIQUE-ID'   -d '{"provider":"browsercloud","values":{},"section_texts":{},"draft_key":"'"$DRAFT_KEY"'"}'   'http://bki.immonia.intern/api/v1/projects/'"$PROJECT_ID"'/runs'
```

### Upload und Dateiauswahl mit stabilem Alias

Verwende `makler_logo` nur, wenn `resources[].fields[].api_alias` diesen Namen
im gewünschten Projekt liefert. `api_alias` heißt in den Upload-/Select-Requests
`field_alias`; es ist kein Schlüssel in `values`. Bei `api_alias=null` verwende die
aktuelle Feld-ID. Beide Varianten behalten denselben `draft_key` bis zum Teststart.

Alias-Upload (statt des numerischen Upload-Aufrufs oben):

```bash
curl --fail-with-body \
  -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs' \
  -F 'project_id='"$PROJECT_ID" \
  -F 'field_alias=makler_logo' \
  -F 'draft_key='"$DRAFT_KEY" \
  -F 'file=@/absolute/path/to/logo.png' \
  'http://bki.immonia.intern/api/v1/resources/upload'
```

Alternativ eine vorhandene eigene Datei auswählen, ohne sie erneut hochzuladen
(ersetze `123` durch eine passende `asset_id` aus `GET /files`; Projekt und UUID
müssen zu deinem aktuellen Entwurf passen):

```http
POST /resources/select
Content-Type: application/json
```

```json
{
  "project_id": 34,
  "field_alias": "makler_logo",
  "asset_id": 123,
  "draft_key": "f971a777-b279-4d4a-a567-8aeb39966417"
}
```

Beide Endpunkte benötigen `resources:write`. Ein nicht vorhandener/mehrdeutiger
Alias, eine fehlende `project_id` zum Alias oder ein widersprüchliches Paar aus
`field_id` und `field_alias` ergibt HTTP 400 mit `error.code=FILE_ACTION_REJECTED`.
Die Erklärung steht in `error.message`. Das unterscheidet sich von Aliasfehlern
normaler Eingabefelder bei `/prompt/resolve`, die als Fachfehler in HTTP 200 kommen.
Antworten enthalten weiterhin die aufgelöste numerische `data.file.field_id`.
Nach Snapshotwechsel die Workbench erneut laden: Erhaltene Aliase werden auf die
aktuell gültige Feld-ID aufgelöst; gelöschte Aliase niemals durch erfundene IDs ersetzen.

Mehrere Bilder für verschiedene Ressourcenfelder werden mit mehreren Upload-Aufrufen,
aber demselben `draft_key`, hochgeladen. Ein erneuter Upload auf dasselbe Feld ersetzt die
Auswahl dieses Feldes im Entwurf. `POST /files` speichert eine Datei nur in der persönlichen
Projektdateibibliothek; erst `/resources/upload` oder `/resources/select` weist sie einem
Ressourcenfeld des Testentwurfs zu.

## Tags bei Testläufen verwenden

Ein Testlauf übernimmt automatisch den **aktuell aktiven persönlichen Tag** des API-Nutzers.
Sende deshalb **weder `tag_id` noch `tag` oder `tag_name` im Body von**
`POST /projects/{project_id}/runs`; diese Felder gehören nicht zum Run-Request und werden
dort nicht ausgewertet. Der beim Start aktive Tag wird mit ID und Name als unveränderlicher
Snapshot am Testlauf gespeichert. Ohne aktiven Tag wird der Testlauf ohne Tag angelegt.

Wenn ein bestimmter Tag verwendet werden soll, führe unmittelbar vor dem Teststart diesen
Workflow aus:

1. `GET /tags` aufrufen und ausschließlich eine dort gelieferte `id` verwenden.
2. Falls der Tag noch nicht existiert: `POST /tags` mit
   `{"name":"Kampagne September","active":true}` aufrufen. Neue Tags sind standardmäßig aktiv.
3. Falls der Tag existiert, aber nicht aktiv ist: `PATCH /tags/{tag_id}` mit
   `{"active":true}` aufrufen. Dadurch werden alle anderen persönlichen Tags automatisch deaktiviert.
4. Erst danach `POST /projects/{project_id}/runs` aufrufen. Für mehrere direkt nacheinander
   gestartete Läufe genügt dieselbe aktive Auswahl, bis sie geändert oder deaktiviert wird.

Zum bewussten Start ohne Tag deaktiviere den aktiven Tag vorher mit
`PATCH /tags/{tag_id}` und `{"active":false}`. Tag-Änderungen und Teststarts sind getrennte
API-Anfragen. Verwende für jede schreibende Anfrage den jeweils erforderlichen eigenen
`Idempotency-Key`.

```bash
# Vorhandenen persönlichen Tag für den nächsten Test aktivieren
curl --fail-with-body   -X PATCH   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Content-Type: application/json'   -H 'Idempotency-Key: REPLACE-WITH-A-NEW-UNIQUE-ID'   -d '{"active":true}'   'http://bki.immonia.intern/api/v1/tags/'"$TAG_ID"

# Danach den Test wie üblich starten; kein tag_id-Feld mitsenden
curl --fail-with-body   -X POST   -H 'Authorization: Bearer bki_KJXrI-CD4VOkXN2777tyyXSjtWeQTpfAUbhXOaW2ahs'   -H 'Content-Type: application/json'   -H 'Idempotency-Key: REPLACE-WITH-ANOTHER-NEW-UNIQUE-ID'   -d '{"provider":"browsercloud","values":{},"section_texts":{}}'   'http://bki.immonia.intern/api/v1/projects/'"$PROJECT_ID"'/runs'
```

## API-Projekt-Tags zur Gruppierung

Verwechsle diese Ressource niemals mit `/tags`: **`/tags` sind persönliche Tags für
Testläufe**, während **`/project-tags` eigenständige, globale Gruppierungsmerkmale für
Projekte** sind. Projekt-Tags sind ausschließlich über die API verfügbar und verändern
weder den aktiven persönlichen Tag noch den Tag-Snapshot eines Testlaufs.

- `GET /project-tags` listet die sichtbaren API-Projekt-Tags.
- `POST /project-tags` mit `{"name":"Immobilien"}` erstellt einen Projekt-Tag (Admin/System).
- `PATCH /project-tags/{project_tag_id}` benennt ihn um (Admin/System).
- `DELETE /project-tags/{project_tag_id}` löscht ihn samt Zuordnungen (Admin/System).
- `GET /projects/{project_id}/project-tags` listet die Tags eines sichtbaren Projekts.
- `PUT /projects/{project_id}/project-tags/{project_tag_id}` ordnet ihn idempotent zu (Admin/System).
- `DELETE /projects/{project_id}/project-tags/{project_tag_id}` entfernt nur die Zuordnung (Admin/System).
- `GET /projects?project_tag_id={project_tag_id}` filtert sichtbare Projekte nach diesem Tag.

Lies IDs immer über `/project-tags`; verwende für diese Endpunkte `project_tag_id` und
niemals die `tag_id` eines persönlichen Testlauf-Tags.

## Lesen und Verwalten

- `GET /me` – eigenes Konto und effektive Scopes
- `GET /projects` – sichtbare Projekte, paginiert
- `GET /projects/{project_id}` – Projektdetails
- `GET /projects/{project_id}/workbench?draft_key={uuid_v4}` – vollständiger Feld-, Provider-, Ressourcen- und Versionskatalog; eine frische UUIDv4 ist Pflicht
- `POST /projects/{project_id}/prompt/resolve` – Eingaben validieren und finalen Prompt anzeigen
- `GET /projects/{project_id}/runs` – Testläufe eines Projekts
- `GET /runs/{run_id}` – Status und Ergebnis eines Testlaufs
- `POST /runs/{run_id}/cancel`, `POST /runs/{run_id}/retry` – Lauf steuern
- `DELETE /runs/{run_id}` – eigenen bzw. berechtigten abgeschlossenen Lauf löschen
- `GET/POST/PATCH/DELETE /files` und `POST /resources/*` – Dateien und Testressourcen verwalten
- `GET/POST /projects/{project_id}/master-prompts` und `POST /projects/{project_id}/master-prompts/{version_id}/activate` – Masterprompts verwalten
- `GET /projects/{project_id}/option-lists`, `GET /projects/{project_id}/dynamic-fields` – Projektkonfiguration laden
- `GET /capabilities` – alle für das Konto freigegebenen erweiterten Aktionen lesen
- `POST /actions/{event}` – eine in `/capabilities` aufgeführte Aktion mit den dort genannten Eingabefeldern ausführen; bei `idempotency_required: true` einen neuen `Idempotency-Key` mitsenden
- `GET /projects/{project_id}/runs/{run_id}/import-preview` und `POST .../import` – Testergebnis prüfen und als neue Masterprompt-Revision übernehmen
- `GET /tags`, `POST /tags`, `PATCH /tags/{tag_id}`, `DELETE /tags/{tag_id}` – persönlichen aktiven Tag verwalten; der aktive Tag wird beim anschließenden Teststart automatisch übernommen
- `GET/POST/PATCH/DELETE /project-tags` und `/projects/{project_id}/project-tags` – getrennte API-only Projektgruppierung; Schreibzugriffe nur für Admin/System
- Admin: Projektanlage/-änderung, Zuweisungen, Nutzerliste und Audit-Logs gemäß Scopes
- Komfort v1.3: Projekte duplizieren/exportieren/importieren, Masterprompt-Versionen archivieren, Optionslisten gesammelt übertragen und dynamische Konfiguration kopieren
- `GET /projects/{project_id}/tester-versions`, `/saved-result-searches`, `/notifications`, `/work-together` und `/profiles/{user_id}` – vollständige REST-Ressourcen
- `GET /runs/{run_id}/events`, `/dashboard/statistics`, `/system/status` – Diagnose, Aktivität und Betriebszustand
- `POST /projects/bulk`, `/results/bulk` – begrenzte Bulkoperationen mit maximal 200 IDs
- `POST /sandbox/validate` – Request schreibfrei prüfen; `GET /meta`, `/changelog`, `/errors` – stabilen API-Vertrag lesen
- `GET /examples?method=...&path=...` – für jede Route cURL-, Python-, JavaScript- und PHP-Grundcode erzeugen; `/developer-assets/...` stellt Collections und SDKs bereit

Bei Cursor-Listen sende den gelieferten `meta.next_cursor` unverändert als `?cursor=...` weiter. Erfinde oder dekodiere Cursor nicht. `limit/offset` bleibt nur für ältere v1-Routen erhalten.

## Antwortformat

Erfolg:

```json
{"ok":true,"request_id":"uuid","data":{},"meta":{"total":0,"limit":50,"offset":0}}
```

Fehler:

```json
{"ok":false,"request_id":"uuid","error":{"code":"ERROR_CODE","message":"Beschreibung"}}
```

Bewahre `request_id` bei Fehlern für die Diagnose auf. Behandle `400` als ungültige Eingabe, `401` als ungültigen Zugang, `403` als fehlenden Scope, `404` als nicht sichtbare Ressource, `409` als Konflikt und `422` als abgelehnten Teststart.

`429 PROJECT_RATE_LIMIT_EXCEEDED` bedeutet, dass das persönliche Kontingent für das
betroffene Projekt im aktuellen 24-Stunden-Fenster verbraucht ist. Lies `project_id`,
`limit`, `remaining`, `reset_at` und `retry_after` aus `error.details`. Warte mindestens
die im `Retry-After`-Header angegebenen Sekunden und sende bis dahin keine automatischen
Wiederholungen für dieses Projekt. Die Antwort enthält außerdem `X-RateLimit-Limit`,
`X-RateLimit-Remaining` und `X-RateLimit-Reset`. Das Limit wird für jedes Projekt separat
gezählt und kann ausschließlich durch einen Administrator geändert werden.

## Sicherheitsregeln

- Niemals den API-Key anzeigen, weitergeben, in Quellcode schreiben oder an fremde Hosts senden.
- Keine destruktive Anfrage ohne ausdrückliche Anweisung des Benutzers ausführen.
- IDs und erlaubte Werte immer aus der API lesen, nicht raten.
- TLS-Zertifikatsfehler dürfen in dieser internen Umgebung ignoriert werden, wenn der verwendete Client dies verlangt.
- Die vollständige maschinenlesbare Vertragsbeschreibung steht unter `http://bki.immonia.intern/api/v1/openapi.json`.

## Vollständiger Routenkatalog

Alle Pfade sind relativ zur API-Basis. Ein `Idempotency-Key` ist genau dann Pflicht, wenn er bei der Operation als Pflichtparameter markiert ist.

### `GET /`

API-Einstieg und Dokumentationslinks

- Scope: `public`
- Operation-ID: `get_api_v1`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1"
```

### `POST /actions/{event}`

Freigegebene BKI-Aktion ausführen

- Scope: `action-specific`
- Operation-ID: `post_actions_by_event`
- Parameter: `event` (path, pflicht), `Idempotency-Key` (header, optional)
- Beispiel-Body: `{"project_id": 1}`
- Fehler: `ACTION_REJECTED, AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"project_id":1}' \
  "http://bki.immonia.intern/api/v1/actions/profile.get"
```

### `GET /admin/audit-logs`

API-Audit-Logs lesen

- Scope: `audit:read`
- Operation-ID: `get_admin_audit_logs`
- Parameter: `limit` (query, optional), `cursor` (query, optional), `offset` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/admin/audit-logs"
```

### `GET /admin/settings`

Provider- und Bildverarbeitungseinstellungen lesen

- Scope: `settings:read`
- Operation-ID: `get_admin_settings`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/admin/settings"
```

### `GET /admin/users`

Nutzer auflisten

- Scope: `users:read`
- Operation-ID: `get_admin_users`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/admin/users"
```

### `GET /capabilities`

Verfügbare API-Aktionen und Scopes lesen

- Scope: `profile:read`
- Operation-ID: `get_capabilities`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/capabilities"
```

### `GET /changelog`

API-Changelog lesen

- Scope: `public`
- Operation-ID: `get_changelog`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/changelog"
```

### `GET /dashboard/statistics`

Dashboard-Kennzahlen und Aktivitäten lesen

- Scope: `system:read`
- Operation-ID: `get_dashboard_statistics`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/dashboard/statistics"
```

### `GET /developer-assets/{asset}`

Collections und SDKs herunterladen

- Scope: `public`
- Operation-ID: `get_developer_assets_by_asset`
- Parameter: `asset` (path, pflicht)
- Fehler: `ASSET_NOT_FOUND, AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/developer-assets/postman"
```

### `GET /errors`

Stabile Fehlercodes lesen

- Scope: `public`
- Operation-ID: `get_errors`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/errors"
```

### `GET /examples`

cURL-, Python-, JavaScript- und PHP-Beispiel für jede Route erzeugen

- Scope: `public`
- Operation-ID: `get_examples`
- Parameter: `method` (query, optional), `path` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/examples"
```

### `GET /files`

Eigene Projektdateien laden

- Scope: `files:read`
- Operation-ID: `get_files`
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/files"
```

### `POST /files`

Projektdatei hochladen

- Scope: `files:write`
- Operation-ID: `post_files`
- Beispiel-Body: `{"file": "@/path/to/file.png", "project_id": 1}`
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -F "project_id=1" \
  -F "file=@/path/to/file.png" \
  "http://bki.immonia.intern/api/v1/files"
```

### `DELETE /files/{file_id}`

Projektdatei archivieren

- Scope: `files:write`
- Operation-ID: `delete_files_by_file_id`
- Parameter: `file_id` (path, pflicht)
- Beispiel-Body: `{"archived": true}`
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"archived":true}' \
  "http://bki.immonia.intern/api/v1/files/1"
```

### `PATCH /files/{file_id}`

Projektdatei umbenennen

- Scope: `files:write`
- Operation-ID: `patch_files_by_file_id`
- Parameter: `file_id` (path, pflicht)
- Beispiel-Body: `{"name": "briefing.png"}`
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"briefing.png"}' \
  "http://bki.immonia.intern/api/v1/files/1"
```

### `GET /files/{file_id}/content`

Dateiinhalt herunterladen oder anzeigen

- Scope: `files:read`
- Operation-ID: `get_files_by_file_id_content`
- Parameter: `file_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, FILE_NOT_FOUND, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/files/1/content"
```

### `GET /me`

Eigenes Konto und Scopes lesen

- Scope: `profile:read`
- Operation-ID: `get_me`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/me"
```

### `PATCH /me/avatar`

Eigenen Avatar verwalten

- Scope: `profile:write`
- Operation-ID: `patch_me_avatar`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"preset": "avatar-1"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"preset":"avatar-1"}' \
  "http://bki.immonia.intern/api/v1/me/avatar"
```

### `GET /meta`

Versionierungs- und Deprecation-Regeln lesen

- Scope: `public`
- Operation-ID: `get_meta`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/meta"
```

### `GET /notifications`

Benachrichtigungen mit Cursor lesen

- Scope: `profile:read`
- Operation-ID: `get_notifications`
- Parameter: `cursor` (query, optional), `limit` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/notifications"
```

### `POST /notifications/read`

Benachrichtigungen als gelesen markieren

- Scope: `profile:write`
- Operation-ID: `post_notifications_read`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"ids": [1]}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"ids":[1]}' \
  "http://bki.immonia.intern/api/v1/notifications/read"
```

### `GET /openapi.json`

OpenAPI-Vertrag laden

- Scope: `public`
- Operation-ID: `get_openapi_json`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/openapi.json"
```

### `GET /profiles/{user_id}`

Öffentliches internes Profil lesen

- Scope: `profile:read`
- Operation-ID: `get_profiles_by_user_id`
- Parameter: `user_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, PROFILE_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/profiles/1"
```

### `GET /project-tags`

API-Projekt-Tags auflisten

- Scope: `project_tags:read`
- Operation-ID: `get_project_tags`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/project-tags"
```

### `POST /project-tags`

API-Projekt-Tag erstellen

- Scope: `project_tags:write`
- Operation-ID: `post_project_tags`
- Beispiel-Body: `{"name": "Kampagne"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Kampagne"}' \
  "http://bki.immonia.intern/api/v1/project-tags"
```

### `DELETE /project-tags/{project_tag_id}`

API-Projekt-Tag löschen

- Scope: `project_tags:write`
- Operation-ID: `delete_project_tags_by_project_tag_id`
- Parameter: `project_tag_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/project-tags/1"
```

### `PATCH /project-tags/{project_tag_id}`

API-Projekt-Tag umbenennen

- Scope: `project_tags:write`
- Operation-ID: `patch_project_tags_by_project_tag_id`
- Parameter: `project_tag_id` (path, pflicht)
- Beispiel-Body: `{"name": "Kampagne 2026"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Kampagne 2026"}' \
  "http://bki.immonia.intern/api/v1/project-tags/1"
```

### `GET /projects`

Sichtbare Projekte auflisten

- Scope: `projects:read`
- Operation-ID: `get_projects`
- Parameter: `limit` (query, optional), `cursor` (query, optional), `offset` (query, optional), `project_tag_id` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects"
```

### `POST /projects`

Projekt erstellen

- Scope: `projects:write`
- Operation-ID: `post_projects`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"active": true, "description": "example", "lead_user_id": 1, "name": "API-Beispiel", "result_filename_pattern": "example"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"name":"API-Beispiel","lead_user_id":1,"description":"example","active":true,"result_filename_pattern":"example"}' \
  "http://bki.immonia.intern/api/v1/projects"
```

### `POST /projects/bulk`

Projekte gesammelt aktivieren/deaktivieren

- Scope: `projects:write`
- Operation-ID: `post_projects_bulk`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"ids": [1, 2], "operation": "activate"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"ids":[1,2],"operation":"activate"}' \
  "http://bki.immonia.intern/api/v1/projects/bulk"
```

### `POST /projects/import`

Projekt-Snapshot sicher importieren

- Scope: `projects:write`
- Operation-ID: `post_projects_import`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"lead_user_id": 1, "name": "Importiertes Projekt", "snapshot": {"project": {"name": "Projekt"}}}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"name":"Importiertes Projekt","lead_user_id":1,"snapshot":{"project":{"name":"Projekt"}}}' \
  "http://bki.immonia.intern/api/v1/projects/import"
```

### `GET /projects/{project_id}`

Projekt lesen

- Scope: `projects:read`
- Operation-ID: `get_projects_by_project_id`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1"
```

### `PATCH /projects/{project_id}`

Projekt ändern

- Scope: `projects:write`
- Operation-ID: `patch_projects_by_project_id`
- Parameter: `project_id` (path, pflicht)
- Beispiel-Body: `{"active": true, "description": "Beschreibung", "lead_user_id": 1, "name": "Projektname"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Projektname","description":"Beschreibung","active":true,"lead_user_id":1}' \
  "http://bki.immonia.intern/api/v1/projects/1"
```

### `GET /projects/{project_id}/assignments`

Projektzuweisungen lesen

- Scope: `projects:read`
- Operation-ID: `get_projects_by_project_id_assignments`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/assignments"
```

### `POST /projects/{project_id}/assignments`

Tester zuweisen

- Scope: `assignments:write`
- Operation-ID: `post_projects_by_project_id_assignments`
- Parameter: `project_id` (path, pflicht)
- Beispiel-Body: `{"user_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"user_id":1}' \
  "http://bki.immonia.intern/api/v1/projects/1/assignments"
```

### `DELETE /projects/{project_id}/assignments/{user_id}`

Testerzuweisung entfernen

- Scope: `assignments:write`
- Operation-ID: `delete_projects_by_project_id_assignments_by_user_id`
- Parameter: `project_id` (path, pflicht), `user_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/assignments/1"
```

### `POST /projects/{project_id}/duplicate`

Projekt samt Konfiguration duplizieren

- Scope: `projects:write`
- Operation-ID: `post_projects_by_project_id_duplicate`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht)
- Beispiel-Body: `{"active": false, "lead_user_id": 1, "name": "Projekt - Kopie"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"name":"Projekt - Kopie","active":false,"lead_user_id":1}' \
  "http://bki.immonia.intern/api/v1/projects/1/duplicate"
```

### `GET /projects/{project_id}/dynamic-configuration`

Vollständige dynamische Konfiguration exportieren

- Scope: `dynamic_fields:read`
- Operation-ID: `get_projects_by_project_id_dynamic_configuration`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/dynamic-configuration"
```

### `POST /projects/{project_id}/dynamic-configuration/copy`

Dynamische Konfiguration aus Projekt kopieren

- Scope: `dynamic_fields:write`
- Operation-ID: `post_projects_by_project_id_dynamic_configuration_copy`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht)
- Beispiel-Body: `{"source_project_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"source_project_id":1}' \
  "http://bki.immonia.intern/api/v1/projects/1/dynamic-configuration/copy"
```

### `GET /projects/{project_id}/dynamic-fields`

Dynamische Felder und Bedingungen laden

- Scope: `dynamic_fields:read`
- Operation-ID: `get_projects_by_project_id_dynamic_fields`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/dynamic-fields"
```

### `GET /projects/{project_id}/export`

Vollständigen Projekt-Snapshot exportieren

- Scope: `projects:read`
- Operation-ID: `get_projects_by_project_id_export`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/export"
```

### `GET /projects/{project_id}/image`

Projektbild herunterladen

- Scope: `projects:read`
- Operation-ID: `get_projects_by_project_id_image`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/image"
```

### `POST /projects/{project_id}/image`

Projektbild hochladen oder entfernen

- Scope: `projects:write`
- Operation-ID: `post_projects_by_project_id_image`
- Parameter: `project_id` (path, pflicht)
- Beispiel-Body: `{"image": "@/path/to/file.png", "remove": true}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -F "image=@/path/to/file.png" \
  -F "remove=True" \
  "http://bki.immonia.intern/api/v1/projects/1/image"
```

### `GET /projects/{project_id}/master-prompt-versions`

Masterprompt-Versionen als Ressourcen lesen

- Scope: `master_prompts:read`
- Operation-ID: `get_projects_by_project_id_master_prompt_versions`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VERSION_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/master-prompt-versions"
```

### `PATCH /projects/{project_id}/master-prompt-versions/{version_id}`

Masterprompt-Version archivieren oder wiederherstellen

- Scope: `master_prompts:write`
- Operation-ID: `patch_projects_by_project_id_master_prompt_versions_by_version_id`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht), `version_id` (path, pflicht)
- Beispiel-Body: `{"archived": true}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR, VERSION_NOT_FOUND`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"archived":true}' \
  "http://bki.immonia.intern/api/v1/projects/1/master-prompt-versions/1"
```

### `GET /projects/{project_id}/master-prompts`

Masterprompt-Versionen laden

- Scope: `master_prompts:read`
- Operation-ID: `get_projects_by_project_id_master_prompts`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VERSION_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/master-prompts"
```

### `POST /projects/{project_id}/master-prompts`

Masterprompt prüfen und importieren

- Scope: `master_prompts:write`
- Operation-ID: `post_projects_by_project_id_master_prompts`
- Parameter: `project_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"prompt": "# Masterprompt\n..."}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR, VERSION_NOT_FOUND`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"prompt":"# Masterprompt\n..."}' \
  "http://bki.immonia.intern/api/v1/projects/1/master-prompts"
```

### `POST /projects/{project_id}/master-prompts/{version_id}/activate`

Masterprompt-Version aktivieren

- Scope: `master_prompts:activate`
- Operation-ID: `post_projects_by_project_id_master_prompts_by_version_id_activate`
- Parameter: `project_id` (path, pflicht), `version_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR, VERSION_NOT_FOUND`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  "http://bki.immonia.intern/api/v1/projects/1/master-prompts/1/activate"
```

### `GET /projects/{project_id}/option-lists`

Optionslisten laden

- Scope: `options:read`
- Operation-ID: `get_projects_by_project_id_option_lists`
- Parameter: `project_id` (path, pflicht), `master_version_id` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/option-lists"
```

### `GET /projects/{project_id}/option-lists/export`

Alle Optionslisten als JSON exportieren

- Scope: `options:read`
- Operation-ID: `get_projects_by_project_id_option_lists_export`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/option-lists/export"
```

### `POST /projects/{project_id}/option-lists/import`

Mehrere Optionslisten importieren

- Scope: `options:write`
- Operation-ID: `post_projects_by_project_id_option_lists_import`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht)
- Beispiel-Body: `{"items": [{"list_type": "simple", "name": "Zielgruppe", "values": [{"value_text": "B2B"}]}]}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"items":[{"name":"Zielgruppe","list_type":"simple","values":[{"value_text":"B2B"}]}]}' \
  "http://bki.immonia.intern/api/v1/projects/1/option-lists/import"
```

### `GET /projects/{project_id}/project-tags`

API-Projekt-Tags eines Projekts lesen

- Scope: `project_tags:read`
- Operation-ID: `get_projects_by_project_id_project_tags`
- Parameter: `project_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/project-tags"
```

### `DELETE /projects/{project_id}/project-tags/{project_tag_id}`

API-Projekt-Tag-Zuordnung entfernen

- Scope: `project_tags:write`
- Operation-ID: `delete_projects_by_project_id_project_tags_by_project_tag_id`
- Parameter: `project_id` (path, pflicht), `project_tag_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/project-tags/1"
```

### `PUT /projects/{project_id}/project-tags/{project_tag_id}`

API-Projekt-Tag zuordnen

- Scope: `project_tags:write`
- Operation-ID: `put_projects_by_project_id_project_tags_by_project_tag_id`
- Parameter: `project_id` (path, pflicht), `project_tag_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, PROJECT_TAG_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PUT -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/project-tags/1"
```

### `POST /projects/{project_id}/prompt/resolve`

Prompt prüfen und vollständig auflösen

- Scope: `workbench:read`
- Operation-ID: `post_projects_by_project_id_prompt_resolve`
- Parameter: `project_id` (path, pflicht)
- Beispiel-Body: `{"section_texts": {}, "values": {"104": "Beispielwert"}}`
- Fehler: `ACTION_REJECTED, AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"values":{"104":"Beispielwert"},"section_texts":{}}' \
  "http://bki.immonia.intern/api/v1/projects/1/prompt/resolve"
```

### `GET /projects/{project_id}/runs`

Testläufe eines Projekts auflisten

- Scope: `runs:read`
- Operation-ID: `get_projects_by_project_id_runs`
- Parameter: `project_id` (path, pflicht), `limit` (query, optional), `cursor` (query, optional), `offset` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/runs"
```

### `POST /projects/{project_id}/runs`

Test starten

- Scope: `runs:start`
- Operation-ID: `post_projects_by_project_id_runs`
- Parameter: `project_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"draft_key": "00000000-0000-4000-8000-000000000001", "provider": "browsercloud", "section_texts": {}, "values": {}}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"provider":"browsercloud","values":{},"section_texts":{},"draft_key":"00000000-0000-4000-8000-000000000001"}' \
  "http://bki.immonia.intern/api/v1/projects/1/runs"
```

### `GET /projects/{project_id}/runs/{run_id}/analysis`

Ergebnis mit Variablen und Masterprompt-Diff analysieren

- Scope: `results:read`
- Operation-ID: `get_projects_by_project_id_runs_by_run_id_analysis`
- Parameter: `project_id` (path, pflicht), `run_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/runs/00000000-0000-4000-8000-000000000001/analysis"
```

### `POST /projects/{project_id}/runs/{run_id}/import`

Testergebnis in eine neue Masterprompt-Revision importieren

- Scope: `results:import`
- Operation-ID: `post_projects_by_project_id_runs_by_run_id_import`
- Parameter: `project_id` (path, pflicht), `run_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  "http://bki.immonia.intern/api/v1/projects/1/runs/00000000-0000-4000-8000-000000000001/import"
```

### `GET /projects/{project_id}/runs/{run_id}/import-preview`

Ergebnisimport vollständig vorprüfen

- Scope: `results:import`
- Operation-ID: `get_projects_by_project_id_runs_by_run_id_import_preview`
- Parameter: `project_id` (path, pflicht), `run_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/runs/00000000-0000-4000-8000-000000000001/import-preview"
```

### `GET /projects/{project_id}/saved-result-searches`

Gespeicherte Ergebnissuchen als JSON verwalten

- Scope: `results:read`
- Operation-ID: `get_projects_by_project_id_saved_result_searches`
- Parameter: `project_id` (path, pflicht), `cursor` (query, optional), `limit` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/saved-result-searches"
```

### `POST /projects/{project_id}/saved-result-searches`

Gespeicherte Ergebnissuchen als JSON verwalten

- Scope: `results:read`
- Operation-ID: `post_projects_by_project_id_saved_result_searches`
- Parameter: `Idempotency-Key` (header, pflicht), `project_id` (path, pflicht)
- Beispiel-Body: `{"criteria": {"status": "succeeded"}, "name": "Erfolgreiche Tests"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"name":"Erfolgreiche Tests","criteria":{"status":"succeeded"}}' \
  "http://bki.immonia.intern/api/v1/projects/1/saved-result-searches"
```

### `GET /projects/{project_id}/tester-versions`

Tester-Versionen mit Cursor auflisten

- Scope: `workbench:read`
- Operation-ID: `get_projects_by_project_id_tester_versions`
- Parameter: `project_id` (path, pflicht), `cursor` (query, optional), `limit` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VERSION_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/tester-versions"
```

### `GET /projects/{project_id}/workbench`

Vollständige Workbench-Konfiguration laden

- Scope: `workbench:read`
- Operation-ID: `get_projects_by_project_id_workbench`
- Parameter: `project_id` (path, pflicht), `draft_key` (query, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_NOT_FOUND, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/projects/1/workbench?draft_key=8f6f4c45-8f67-4e0f-90ca-a591f4fe3a31"
```

### `POST /resources/delete`

Datei aus einem Testentwurf entfernen

- Scope: `resources:write`
- Operation-ID: `post_resources_delete`
- Beispiel-Body: `{"selection_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"selection_id":1}' \
  "http://bki.immonia.intern/api/v1/resources/delete"
```

### `POST /resources/reset-draft`

Alle Ressourcen eines Entwurfs zurücksetzen

- Scope: `resources:write`
- Operation-ID: `post_resources_reset_draft`
- Beispiel-Body: `{"draft_key": "00000000-0000-4000-8000-000000000001"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"draft_key":"00000000-0000-4000-8000-000000000001"}' \
  "http://bki.immonia.intern/api/v1/resources/reset-draft"
```

### `POST /resources/restore-version`

Ressourcen einer Testversion wiederherstellen

- Scope: `resources:write`
- Operation-ID: `post_resources_restore_version`
- Beispiel-Body: `{"draft_key": "00000000-0000-4000-8000-000000000002", "run_id": "00000000-0000-4000-8000-000000000001"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"run_id":"00000000-0000-4000-8000-000000000001","draft_key":"00000000-0000-4000-8000-000000000002"}' \
  "http://bki.immonia.intern/api/v1/resources/restore-version"
```

### `POST /resources/select`

Vorhandene Datei einem Ressourcenfeld zuweisen

- Scope: `resources:write`
- Operation-ID: `post_resources_select`
- Beispiel-Body: `{"asset_id": 1, "draft_key": "00000000-0000-4000-8000-000000000001", "field_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"asset_id":1,"field_id":1,"draft_key":"00000000-0000-4000-8000-000000000001"}' \
  "http://bki.immonia.intern/api/v1/resources/select"
```

### `POST /resources/upload`

Datei hochladen und einem Ressourcenfeld zuweisen

- Scope: `resources:write`
- Operation-ID: `post_resources_upload`
- Beispiel-Body: `{"draft_key": "8f6f4c45-8f67-4e0f-90ca-a591f4fe3a31", "field_id": 1, "file": "@/path/to/file.png"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -F "draft_key=8f6f4c45-8f67-4e0f-90ca-a591f4fe3a31" \
  -F "file=@/path/to/file.png" \
  -F "field_id=1" \
  "http://bki.immonia.intern/api/v1/resources/upload"
```

### `GET /result-images/{image_id}/content`

Ergebnisbild als Originaldatei laden

- Scope: `runs:read`
- Operation-ID: `get_result_images_by_image_id_content`
- Parameter: `image_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/result-images/1/content"
```

### `GET /result-images/{image_id}/content/{filename}`

Ergebnisbild als Originaldatei laden

- Scope: `runs:read`
- Operation-ID: `get_result_images_by_image_id_content_by_filename`
- Parameter: `image_id` (path, pflicht), `filename` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/result-images/1/content/1"
```

### `POST /results/bulk`

Ergebnisse gesammelt bearbeiten

- Scope: `runs:delete`
- Operation-ID: `post_results_bulk`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"operation": "delete", "project_id": 1, "run_ids": ["00000000-0000-4000-8000-000000000001"]}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"project_id":1,"run_ids":["00000000-0000-4000-8000-000000000001"],"operation":"delete"}' \
  "http://bki.immonia.intern/api/v1/results/bulk"
```

### `DELETE /runs/{run_id}`

Abgeschlossenen Testlauf löschen

- Scope: `runs:delete`
- Operation-ID: `delete_runs_by_run_id`
- Parameter: `run_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/runs/00000000-0000-4000-8000-000000000001"
```

### `GET /runs/{run_id}`

Teststatus und Ergebnis lesen

- Scope: `runs:read`
- Operation-ID: `get_runs_by_run_id`
- Parameter: `run_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/runs/00000000-0000-4000-8000-000000000001"
```

### `POST /runs/{run_id}/cancel`

Aktiven Testlauf abbrechen

- Scope: `runs:cancel`
- Operation-ID: `post_runs_by_run_id_cancel`
- Parameter: `run_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"draft_key": "00000000-0000-4000-8000-000000000001", "project_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"project_id":1,"draft_key":"00000000-0000-4000-8000-000000000001"}' \
  "http://bki.immonia.intern/api/v1/runs/00000000-0000-4000-8000-000000000001/cancel"
```

### `GET /runs/{run_id}/events`

Sanitisierte Run-Diagnoseereignisse lesen

- Scope: `runs:read`
- Operation-ID: `get_runs_by_run_id_events`
- Parameter: `run_id` (path, pflicht), `cursor` (query, optional), `limit` (query, optional)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/runs/00000000-0000-4000-8000-000000000001/events"
```

### `GET /runs/{run_id}/resources/{file_id}/content`

Historische Testressource herunterladen

- Scope: `resources:read`
- Operation-ID: `get_runs_by_run_id_resources_by_file_id_content`
- Parameter: `run_id` (path, pflicht), `file_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/runs/00000000-0000-4000-8000-000000000001/resources/1/content"
```

### `POST /runs/{run_id}/retry`

Fehlgeschlagenen Ergebnisabruf wiederholen

- Scope: `runs:retry`
- Operation-ID: `post_runs_by_run_id_retry`
- Parameter: `run_id` (path, pflicht), `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"project_id": 1}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, PROJECT_RATE_LIMIT_EXCEEDED, RUN_NOT_FOUND, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"project_id":1}' \
  "http://bki.immonia.intern/api/v1/runs/00000000-0000-4000-8000-000000000001/retry"
```

### `POST /sandbox/validate`

Request schreibfrei im Testmodus validieren

- Scope: `profile:read`
- Operation-ID: `post_sandbox_validate`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"body": {"name": "Vorschau"}, "method": "POST", "path": "/projects"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"method":"POST","path":"/projects","body":{"name":"Vorschau"}}' \
  "http://bki.immonia.intern/api/v1/sandbox/validate"
```

### `GET /system/status`

Queue-, Worker-, Bridge- und Gatewaystatus lesen

- Scope: `system:read`
- Operation-ID: `get_system_status`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/system/status"
```

### `GET /tags`

Persönliche Tags auflisten

- Scope: `tags:read`
- Operation-ID: `get_tags`
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, TAG_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/tags"
```

### `POST /tags`

Persönlichen Tag erstellen

- Scope: `tags:write`
- Operation-ID: `post_tags`
- Beispiel-Body: `{"active": true, "name": "Favorit"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, TAG_NOT_FOUND, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Favorit","active":true}' \
  "http://bki.immonia.intern/api/v1/tags"
```

### `DELETE /tags/{tag_id}`

Persönlichen Tag löschen

- Scope: `tags:write`
- Operation-ID: `delete_tags_by_tag_id`
- Parameter: `tag_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, TAG_NOT_FOUND, VALIDATION_ERROR`

```bash
curl -k -X DELETE -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/tags/1"
```

### `PATCH /tags/{tag_id}`

Persönlichen Tag ändern

- Scope: `tags:write`
- Operation-ID: `patch_tags_by_tag_id`
- Parameter: `tag_id` (path, pflicht)
- Beispiel-Body: `{"active": true, "name": "Wichtig"}`
- Fehler: `AUTH_REQUIRED, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, TAG_NOT_FOUND, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Wichtig","active":true}' \
  "http://bki.immonia.intern/api/v1/tags/1"
```

### `GET /tester-versions/{version_id}`

Tester-Version vollständig lesen

- Scope: `workbench:read`
- Operation-ID: `get_tester_versions_by_version_id`
- Parameter: `version_id` (path, pflicht)
- Fehler: `AUTH_REQUIRED, INTERNAL_ERROR, INVALID_CURSOR, PROJECT_RATE_LIMIT_EXCEEDED, SCOPE_FORBIDDEN, VERSION_NOT_FOUND`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/tester-versions/1"
```

### `GET /work-together`

Work-together-Anfragen lesen und erstellen

- Scope: `projects:read`
- Operation-ID: `get_work_together`
- Fehler: `AUTH_REQUIRED, COLLABORATION_NOT_FOUND, INTERNAL_ERROR, SCOPE_FORBIDDEN`

```bash
curl -k -X GET -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  "http://bki.immonia.intern/api/v1/work-together"
```

### `POST /work-together`

Work-together-Anfragen lesen und erstellen

- Scope: `projects:read`
- Operation-ID: `post_work_together`
- Parameter: `Idempotency-Key` (header, pflicht)
- Beispiel-Body: `{"project_id": 1, "user_id": 2}`
- Fehler: `AUTH_REQUIRED, COLLABORATION_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X POST -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"project_id":1,"user_id":2}' \
  "http://bki.immonia.intern/api/v1/work-together"
```

### `PATCH /work-together/{collaboration_id}`

Work-together-Anfrage beantworten

- Scope: `projects:write`
- Operation-ID: `patch_work_together_by_collaboration_id`
- Parameter: `Idempotency-Key` (header, pflicht), `collaboration_id` (path, pflicht)
- Beispiel-Body: `{"status": "accepted"}`
- Fehler: `AUTH_REQUIRED, COLLABORATION_NOT_FOUND, IDEMPOTENCY_CONFLICT, IDEMPOTENCY_IN_PROGRESS, IDEMPOTENCY_REQUIRED, INTERNAL_ERROR, SCOPE_FORBIDDEN, VALIDATION_ERROR`

```bash
curl -k -X PATCH -H "Authorization: Bearer <BKI-API-KEY>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-001" \
  -d '{"status":"accepted"}' \
  "http://bki.immonia.intern/api/v1/work-together/1"
```
