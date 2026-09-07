<?php
require_once dirname(__DIR__) . '/app/bootstrap.php';

$client = new BkiClient(app_config('api_base', ''), app_config('api_key', ''), app_config('verify_tls', false));
$flow = new Workflow();
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'status';

try {
    if ($action === 'status') {
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'reset_all') {
        purge_photoset_storage();
        purge_scene_storage();
        $flow->resetAll();
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'bootstrap') {
        require_api($client);
        $catalog = load_scene_catalog($client, $flow);
        $snapshot = $catalog->snapshot();
        $state = public_state($flow);
        if (isset($state['location']['value']) && $state['location']['value'] !== '') {
            $snapshot['options']['scene'] = $catalog->filterScenesByLocation($snapshot['options']['scene'], $state['location']['value']);
        }
        json_response(array('ok' => true, 'ui' => $snapshot, 'state' => $state), 200);
    }

    if ($action === 'diagnose_resource_fields') {
        require_api($client);
        $project = isset($_GET['project']) ? intval($_GET['project']) : app_config('project_photoset', 23);
        if ($project !== intval(app_config('project_photoset', 23)) && $project !== intval(app_config('project_scene', 18))) {
            throw new Exception('Diagnose ist nur für die konfigurierten Workflow-Projekte erlaubt.');
        }
        $draft = ($project === intval(app_config('project_photoset', 23))) ? $flow->get('photoset_draft', uuid_v4_compat()) : $flow->get('scene_draft', uuid_v4_compat());
        $diagInfo = load_resource_catalog($client, $project, $draft);
        $diagCatalog = $diagInfo['catalog'];
        $diagFields = $diagCatalog->resourceFields();
        $diagIds = array();
        $diagPlan = array();
        foreach ($diagFields as $i => $field) {
            $diagIds[] = $field['field_id'];
            $diagPlan[] = array(
                'slot' => $i + 1,
                'field_id' => $field['field_id'],
                'label' => $field['label'],
                'is_required' => !empty($field['is_required']),
                'sort_order' => isset($field['sort_order']) ? $field['sort_order'] : null
            );
        }
        json_response(array(
            'ok' => true,
            'project_id' => $project,
            'draft_key' => $draft,
            'selected_field_id' => count($diagIds) === 1 ? $diagIds[0] : null,
            'selected_field_ids' => $diagIds,
            'upload_plan' => $diagPlan,
            'candidates' => $diagCatalog->resourceFieldDiagnostics(),
            'hints' => $diagCatalog->resourceFieldHints(),
            'sources' => $diagInfo['sources']
        ), 200);
    }

    if ($action === 'diagnose_bindings') {
        require_api($client);
        $project = isset($_GET['project']) ? intval($_GET['project']) : intval(app_config('project_scene', 18));
        if ($project !== intval(app_config('project_scene', 18))) throw new Exception('Binding-Diagnose ist nur für Projekt 18 vorgesehen.');
        $catalog = load_scene_catalog($client, $flow);
        $snap = $catalog->snapshot();
        json_response(array(
            'ok' => true,
            'project_id' => $project,
            'bindings' => $snap['bindings'],
            'binding_resolution' => $catalog->bindingResolutionDiagnostics(),
            'binding_candidates' => $catalog->bindingDiagnostics()
        ), 200);
    }

    if ($action === 'list_saved_photosets') {
        $entries = photoset_library_entries();
        json_response(array('ok' => true, 'photosets' => public_photoset_library_entries($entries)), 200);
    }

    if ($action === 'select_saved_photoset') {
        $libraryId = isset($_POST['library_id']) ? trim((string)$_POST['library_id']) : '';
        if ($libraryId === '') throw new Exception('Bitte ein gespeichertes FotoSet auswählen.');
        $entry = find_photoset_library_entry($libraryId);
        if (!$entry) throw new Exception('Das gespeicherte FotoSet wurde nicht gefunden.');
        $attempt = import_library_photoset_into_workflow($flow, $entry);
        $flow->set('active_photoset_attempt_id', $attempt['id']);
        $flow->set('photoset_run', isset($attempt['run_id']) ? $attempt['run_id'] : null);
        $flow->set('photoset_images', array());
        $flow->set('photoset_approved', false);
        $flow->set('photoset_files', array());
        $flow->set('scene_draft', uuid_v4_compat());
        $flow->set('scene_runs', array());
        $flow->set('scene_results', array());
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'upload') {
        handle_upload($flow);
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'remove_upload') {
        $index = isset($_POST['index']) ? intval($_POST['index']) : -1;
        $uploads = $flow->get('uploads', array());
        if (isset($uploads[$index])) {
            if (isset($uploads[$index]['path']) && is_file($uploads[$index]['path'])) @unlink($uploads[$index]['path']);
            array_splice($uploads, $index, 1);
            $flow->set('uploads', $uploads);
            $flow->restartPhotoset();
        }
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'restart_photoset') {
        $flow->restartPhotoset();
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'start_photoset') {
        require_api($client);
        $uploads = clean_uploads($flow);
        if (count($uploads) < 1 || count($uploads) > app_config('max_uploads', 4)) {
            throw new Exception('Bitte mindestens 1 und höchstens 4 Bilder hochladen.');
        }
        $draft = $flow->get('photoset_draft', uuid_v4_compat());
        $resourceInfo = load_resource_catalog($client, app_config('project_photoset', 23), $draft);
        $catalog = $resourceInfo['catalog'];
        $uploadFields = resolve_upload_fields($catalog, count($uploads), 'photoset_resource_field_ids', 'photoset_resource_field_id', 'Projekt 23');

        // BKI: pro Ressourcenfeld genau eine Datei. Mehrere Referenzbilder werden
        // deshalb auf verschiedene field_id-Werte verteilt, aber mit demselben
        // draft_key. Ein erneuter Upload auf dieselbe field_id würde die Auswahl
        // lediglich ersetzen.
        foreach ($uploads as $i => $upload) {
            $field = $uploadFields[$i];
            try {
                $client->uploadResource($draft, $field['field_id'], $upload['path']);
            } catch (Exception $e) {
                throw new Exception('Projekt 23 / Slot ' . ($i + 1) . ' / Ressourcenfeld #' . $field['field_id'] . ' "' . $field['label'] . '": ' . $e->getMessage() . ' | Felder: ' . resource_diagnostic_text($catalog));
            }
        }
        // Laut API-Vertrag denselben Draft danach erneut aus der Workbench lesen,
        // bevor der Run gestartet wird.
        $client->workbench(app_config('project_photoset', 23), $draft);
        $photosetUploadPlan = public_upload_plan($uploadFields);
        $run = $client->startRun(
            app_config('project_photoset', 23),
            app_config('provider_photoset', 'chatgpt'),
            array(),
            $draft,
            array('section_texts' => array())
        );
        $runId = find_run_id($run);
        if (!$runId) throw new Exception('BKI hat keine run_id für Projekt 23 zurückgegeben.');
        $flow->set('photoset_run', $runId);
        $flow->set('photoset_images', array());
        $flow->set('active_photoset_attempt_id', null);
        $flow->set('photoset_approved', false);
        json_response(array('ok' => true, 'run_id' => $runId, 'upload_plan' => $photosetUploadPlan, 'state' => public_state($flow)), 202);
    }

    if ($action === 'poll_photoset') {
        require_api($client);
        $runId = $flow->get('photoset_run', null);
        if (!$runId) throw new Exception('Kein aktiver FotoSet-Lauf.');
        $run = $client->getRun($runId);
        $status = run_status($run);
        if ($status === 'succeeded' || $status === 'success' || $status === 'completed' || $status === 'done') {
            $images = extract_image_refs($run);
            if (count($images) > 4) $images = array_slice($images, 0, 4);
            if (count($images) < 1) {
                // Ein erfolgreicher Run ohne erkannte Ergebnisbilder darf die UI nicht
                // in die Freigabeansicht weiterschalten. BKI kann Provider-Ergebnisse
                // in mehreren Strukturen ausliefern; diagnose_photoset_run zeigt die
                // sanitisierte Struktur, falls ein neues Format ergänzt werden muss.
                json_response(array(
                    'ok' => false,
                    'status' => 'succeeded_no_images',
                    'message' => 'Projekt 23 ist erfolgreich abgeschlossen, aber die Ergebnisbilder konnten aus der Run-Antwort noch nicht erkannt werden. Bitte /api.php?action=diagnose_photoset_run aufrufen.',
                    'run_id' => $runId
                ), 200);
            }
            $flow->set('photoset_images', $images);
            $attempt = store_photoset_attempt($client, $flow, $runId, $images);
            $flow->set('active_photoset_attempt_id', $attempt['id']);
            if (count(valid_saved_files(isset($attempt['saved_files']) ? $attempt['saved_files'] : array())) < 1 || empty($attempt['library_id'])) {
                $message = 'Das FotoSet wurde erzeugt, konnte aber nicht im lokalen Storage gespeichert werden. Bitte die Speicherung wiederholen.';
                if (!empty($attempt['storage_errors'])) {
                    $lastError = $attempt['storage_errors'][count($attempt['storage_errors']) - 1];
                    if (isset($lastError['message']) && $lastError['message'] !== '') $message .= ' Ursache: ' . $lastError['message'];
                }
                json_response(array('ok' => false, 'status' => 'succeeded_storage_failed', 'message' => $message, 'attempt_id' => $attempt['id'], 'state' => public_state($flow)), 200);
            }
            json_response(array('ok' => true, 'status' => 'succeeded', 'attempt_id' => $attempt['id'], 'images' => public_photoset_attempt_images($attempt), 'state' => public_state($flow)), 200);
        }
        if ($status === 'failed' || $status === 'error' || $status === 'cancelled' || $status === 'canceled') {
            json_response(array('ok' => false, 'status' => $status, 'message' => run_error_message($run)), 200);
        }
        json_response(array('ok' => true, 'status' => $status ? $status : 'running'), 200);
    }

    if ($action === 'diagnose_photoset_run') {
        require_api($client);
        $runId = $flow->get('photoset_run', null);
        if (!$runId) throw new Exception('Kein FotoSet-Lauf in der aktuellen Session.');
        $run = $client->getRun($runId);
        $refs = extract_image_refs($run);
        json_response(array(
            'ok' => true,
            'run_id' => $runId,
            'status' => run_status($run),
            'detected_images' => sanitize_image_refs($refs),
            'run_shape' => diagnostic_shape($run, '', 0)
        ), 200);
    }

    if ($action === 'select_photoset_attempt') {
        $attemptId = isset($_POST['attempt_id']) ? trim((string)$_POST['attempt_id']) : '';
        if ($attemptId === '') throw new Exception('FotoSetCard fehlt.');
        $attempt = find_photoset_attempt($flow, $attemptId);
        if (!$attempt) throw new Exception('FotoSetCard wurde nicht gefunden.');
        $flow->set('active_photoset_attempt_id', $attemptId);
        $flow->set('photoset_run', isset($attempt['run_id']) ? $attempt['run_id'] : null);
        $flow->set('photoset_images', isset($attempt['refs']) && is_array($attempt['refs']) ? $attempt['refs'] : array());
        // Das Auswählen ist zunächst nur eine Vorschau. Erst "FotoSet verwenden"
        // bindet diese Card wieder an die nachfolgenden Szenenläufe.
        $flow->set('photoset_approved', false);
        $flow->set('photoset_files', array());
        $flow->set('scene_draft', uuid_v4_compat());
        $flow->set('scene_runs', array());
        $flow->set('scene_results', array());
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'approve_photoset') {
        $attemptId = $flow->get('active_photoset_attempt_id', null);
        $attempt = $attemptId ? find_photoset_attempt($flow, $attemptId) : null;
        $images = $flow->get('photoset_images', array());
        if (!$attempt && count($images) < 1) throw new Exception('Noch kein FotoSet vorhanden.');
        $saved = $attempt ? valid_saved_files(isset($attempt['saved_files']) ? $attempt['saved_files'] : array()) : array();
        if (count($saved) < 1) {
            require_api($client);
            $runId = $attempt && isset($attempt['run_id']) ? $attempt['run_id'] : $flow->get('photoset_run', null);
            $refs = $attempt && isset($attempt['refs']) ? $attempt['refs'] : $images;
            $targetId = $attempt ? $attempt['id'] : uuid_v4_compat();
            $saved = materialize_photoset_attempt($client, $runId, $refs, $targetId);
            if ($attempt) {
                $libraryId = archive_photoset_files($saved, array(
                    'run_id' => $runId,
                    'created_at' => isset($attempt['created_at']) ? $attempt['created_at'] : date('c'),
                    'source_attempt_id' => $attempt['id']
                ));
                update_photoset_attempt_files($flow, $attempt['id'], $saved, $libraryId);
            }
        }
        if (count($saved) < 1) throw new Exception('FotoSetCard ist nicht lokal verfügbar.');
        $flow->set('photoset_files', $saved);
        $flow->set('photoset_approved', true);
        if ($attemptId) $flow->set('approved_photoset_attempt_id', $attemptId);
        $flow->set('scene_draft', uuid_v4_compat());
        $flow->set('scene_runs', array());
        $flow->set('scene_results', array());
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'save_profile') {
        $height = isset($_POST['height']) ? trim($_POST['height']) : '';
        $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
        $clothing = isset($_POST['clothing']) ? trim($_POST['clothing']) : '';
        $imageStyle = isset($_POST['image_style']) ? trim($_POST['image_style']) : '';
        if (!preg_match('/^\d{2,3}$/', $height) || intval($height) < 100 || intval($height) > 230) throw new Exception('Größe bitte in cm zwischen 100 und 230 eingeben.');
        if ($gender === '' || $clothing === '' || $imageStyle === '') throw new Exception('Bitte alle Angaben auswählen.');
        $flow->set('profile', array('height' => $height, 'gender' => $gender, 'clothing' => $clothing, 'image_style' => $imageStyle));
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'save_location') {
        require_api($client);
        $location = isset($_POST['location']) ? trim($_POST['location']) : '';
        $region = isset($_POST['region']) ? trim($_POST['region']) : '';
        if ($location === '') throw new Exception('Bitte eine Location-Kategorie wählen.');
        $catalog = load_scene_catalog($client, $flow);
        $locationLabel = option_label($catalog->optionsFor(array('location-kategorie', 'location kategorie', 'location', 'ortskategorie')), $location);
        $locationText = strtolower($locationLabel . ' ' . $location);
        $isOutside = strpos($locationText, 'auß') !== false || strpos($locationText, 'auss') !== false || strpos($locationText, 'outdoor') !== false || preg_match('/^a(?:[\s\-_.:0-9]|$)/i', trim($locationLabel . ' ' . $location));
        if ($isOutside && $region === '') throw new Exception('Für Außenaufnahmen bitte eine Region wählen.');
        $flow->set('location', array('value' => $location, 'label' => $locationLabel, 'region' => $region));
        $scenes = $catalog->filterScenesByLocation($catalog->sceneOptions(), $locationLabel . ' ' . $location);
        json_response(array('ok' => true, 'scenes' => $scenes, 'state' => public_state($flow)), 200);
    }

    if ($action === 'save_scenes') {
        $scenes = isset($_POST['scenes']) ? $_POST['scenes'] : array();
        if (!is_array($scenes)) $scenes = array($scenes);
        $clean = array();
        foreach ($scenes as $scene) {
            $scene = trim((string)$scene);
            if ($scene !== '' && !in_array($scene, $clean, true)) $clean[] = $scene;
        }
        if (count($clean) !== 3) throw new Exception('Bitte genau 3 Szenen auswählen.');
        $flow->set('scenes', $clean);
        json_response(array('ok' => true, 'state' => public_state($flow)), 200);
    }

    if ($action === 'start_scenes') {
        require_api($client);
        if (!$flow->get('photoset_approved', false)) throw new Exception('FotoSet muss zuerst freigegeben werden.');
        $profile = $flow->get('profile', array());
        $location = $flow->get('location', array());
        $scenes = $flow->get('scenes', array());
        if (count($profile) < 4 || !isset($location['value']) || count($scenes) !== 3) throw new Exception('Workflow-Angaben sind noch nicht vollständig.');

        $draft = $flow->get('scene_draft', uuid_v4_compat());
        $catalog = load_scene_catalog($client, $flow);
        $snap = $catalog->snapshot();
        $bindings = $snap['bindings'];
        // Optional explizite Overrides, ansonsten ausschließlich Workbench-Werte.
        foreach (array('height','gender','clothing','image_style','location','region','scene') as $bindingName) {
            $override = app_config('binding_' . $bindingName, '');
            if ($override !== '') $bindings[$bindingName] = $override;
        }
        foreach (array('height','gender','clothing','image_style','location','scene') as $required) {
            if (!isset($bindings[$required]) || $bindings[$required] === null || $bindings[$required] === '') {
                throw new Exception('Projekt 18: Binding für ' . $required . ' konnte nicht aus der Workbench ermittelt werden. Diagnose: /api.php?action=diagnose_bindings&project=18');
            }
        }

        $resourceInfo = load_resource_catalog($client, app_config('project_scene', 18), $draft);
        $resourceCatalog = $resourceInfo['catalog'];
        $photosetFiles = array_values(array_filter($flow->get('photoset_files', array()), 'is_file'));
        if (count($photosetFiles) < 1) {
            throw new Exception('Das freigegebene FotoSet ist lokal nicht verfügbar.');
        }
        $sceneUploadFields = resolve_upload_fields($resourceCatalog, count($photosetFiles), 'scene_resource_field_ids', 'scene_resource_field_id', 'Projekt 18');

        // Auch Projekt 18 erhält jedes FotoSet-Bild auf ein eigenes Ressourcenfeld.
        // Alle Uploads verwenden denselben scene_draft; danach starten die drei
        // Vehabi-Runs mit exakt diesem Draft.
        foreach ($photosetFiles as $i => $filePath) {
            $field = $sceneUploadFields[$i];
            try {
                $client->uploadResource($draft, $field['field_id'], $filePath);
            } catch (Exception $e) {
                throw new Exception('Projekt 18 / FotoSet-Slot ' . ($i + 1) . ' / Ressourcenfeld #' . $field['field_id'] . ' "' . $field['label'] . '": ' . $e->getMessage() . ' | Felder: ' . resource_diagnostic_text($resourceCatalog));
            }
        }
        $client->workbench(app_config('project_scene', 18), $draft);
        $sceneResourceUploadPlan = public_upload_plan($sceneUploadFields);

        $baseValues = array();
        $baseValues[(string)$bindings['height']] = $profile['height'];
        $baseValues[(string)$bindings['gender']] = $profile['gender'];
        $baseValues[(string)$bindings['clothing']] = $profile['clothing'];
        $baseValues[(string)$bindings['image_style']] = $profile['image_style'];
        $baseValues[(string)$bindings['location']] = $location['value'];
        if (isset($bindings['region']) && $bindings['region'] !== null && isset($location['region']) && $location['region'] !== '') {
            $baseValues[(string)$bindings['region']] = $location['region'];
        }

        $runs = array();
        foreach ($scenes as $scene) {
            $values = $baseValues;
            $values[(string)$bindings['scene']] = $scene;
            $run = $client->startRun(
                app_config('project_scene', 18),
                app_config('provider_scene', 'vehabi'),
                $values,
                $draft,
                array('section_texts' => array())
            );
            $runId = find_run_id($run);
            if (!$runId) throw new Exception('Für eine Szene wurde keine run_id zurückgegeben.');
            $runs[] = array('scene' => $scene, 'run_id' => $runId, 'status' => 'queued');
        }
        $flow->set('scene_runs', $runs);
        $flow->set('scene_results', array());
        json_response(array('ok' => true, 'runs' => $runs, 'upload_plan' => $sceneResourceUploadPlan, 'state' => public_state($flow)), 202);
    }

    if ($action === 'poll_scenes') {
        require_api($client);
        $runs = $flow->get('scene_runs', array());
        if (count($runs) !== 3) throw new Exception('Es sind nicht genau drei Szenenläufe aktiv.');
        $allDone = true;
        $anyFailed = false;
        $results = array();
        foreach ($runs as $i => $item) {
            $run = $client->getRun($item['run_id']);
            $status = run_status($run);
            $runs[$i]['status'] = $status ? $status : 'running';
            if ($status === 'succeeded' || $status === 'success' || $status === 'completed' || $status === 'done') {
                $refs = extract_image_refs($run);
                if (count($refs)) {
                    $results[$i] = array('scene' => $item['scene'], 'run_id' => $item['run_id'], 'image' => $refs[0]);
                }
            } else if ($status === 'failed' || $status === 'error' || $status === 'cancelled' || $status === 'canceled') {
                $anyFailed = true;
            } else {
                $allDone = false;
            }
        }
        $flow->set('scene_runs', $runs);
        if ($anyFailed) json_response(array('ok' => false, 'status' => 'failed', 'runs' => $runs, 'message' => 'Mindestens ein Szenenlauf ist fehlgeschlagen.'), 200);
        if ($allDone) {
            ksort($results);
            $results = array_values($results);
            $results = materialize_scene_batch($client, $flow, $results);
            $flow->set('scene_results', $results);
            json_response(array('ok' => true, 'status' => 'succeeded', 'results' => public_scene_results($results), 'state' => public_state($flow)), 200);
        }
        json_response(array('ok' => true, 'status' => 'running', 'runs' => $runs), 200);
    }

    if ($action === 'image') {
        serve_image($client, $flow);
    }

    throw new Exception('Unbekannte Aktion.');
} catch (Exception $e) {
    json_response(array('ok' => false, 'message' => $e->getMessage()), 400);
}


function load_resource_catalog($client, $projectId, $draftKey) {
    $sources = array();
    $workbench = $client->workbench($projectId, $draftKey);
    $sources['workbench'] = 'ok';

    // Zusätzliche read-only Konfigurationsquellen helfen bei Installationen, deren
    // Workbench die Ressourcenfeld-ID nur als generische Feld-`id` oder in einer
    // separaten Projektkonfiguration ausliefert.
    $extra = array();
    try {
        $extra['dynamic_configuration'] = $client->dynamicConfiguration($projectId);
        $sources['dynamic_configuration'] = 'ok';
    } catch (Exception $e) {
        $sources['dynamic_configuration'] = 'nicht verfügbar';
    }
    try {
        $extra['project_export'] = $client->projectExport($projectId);
        $sources['project_export'] = 'ok';
    } catch (Exception $e) {
        $sources['project_export'] = 'nicht verfügbar';
    }

    return array(
        'catalog' => new FieldCatalog($workbench, array(), $extra),
        'sources' => $sources
    );
}

function configured_resource_field_ids($pluralKey, $legacyKey) {
    $raw = trim((string)app_config($pluralKey, ''));
    if ($raw === '') $raw = trim((string)app_config($legacyKey, ''));
    if ($raw === '') return array();
    $parts = preg_split('/[\s,;]+/', $raw);
    $ids = array();
    foreach ($parts as $part) {
        $part = trim($part);
        if ($part === '') continue;
        if (!preg_match('/^[0-9]+$/', $part) || intval($part) < 1) {
            throw new Exception($pluralKey . ' enthält eine ungültige BKI-field_id: ' . $part);
        }
        $id = intval($part);
        if (!in_array($id, $ids, true)) $ids[] = $id;
    }
    return $ids;
}

function resolve_upload_fields($catalog, $count, $pluralConfigKey, $legacyConfigKey, $projectLabel) {
    if (!($catalog instanceof FieldCatalog)) throw new Exception($projectLabel . ': Ressourcen-Katalog fehlt.');
    $count = intval($count);
    if ($count < 1) return array();

    $available = $catalog->resourceFields();
    $byId = array();
    foreach ($available as $field) $byId[(string)$field['field_id']] = $field;

    $configured = configured_resource_field_ids($pluralConfigKey, $legacyConfigKey);
    if (count($configured)) {
        if (count($configured) < $count) {
            throw new Exception($projectLabel . ': ' . $pluralConfigKey . ' enthält nur ' . count($configured) . ' IDs, benötigt werden ' . $count . '.');
        }
        $out = array();
        for ($i = 0; $i < $count; $i++) {
            $id = $configured[$i];
            if (!isset($byId[(string)$id])) {
                throw new Exception($projectLabel . ': konfigurierte field_id #' . $id . ' wurde nicht von der aktuellen Workbench geliefert.');
            }
            $out[] = $byId[(string)$id];
        }
        return $out;
    }

    if (count($available) < $count) {
        throw new Exception($projectLabel . ': Workbench liefert nur ' . count($available) . ' uploadbare Ressourcenfelder für ' . $count . ' Bilder. Felder: ' . resource_diagnostic_text($catalog));
    }
    return array_slice($available, 0, $count);
}

function public_upload_plan($fields) {
    $out = array();
    foreach ($fields as $i => $field) {
        $out[] = array(
            'slot' => $i + 1,
            'field_id' => isset($field['field_id']) ? $field['field_id'] : null,
            'label' => isset($field['label']) ? $field['label'] : '',
            'is_required' => !empty($field['is_required'])
        );
    }
    return $out;
}

function resource_diagnostic_text($catalog) {
    if (!($catalog instanceof FieldCatalog)) return 'keine Kandidaten';
    $rows = $catalog->resourceFieldDiagnostics();
    if (!count($rows)) {
        $hints = $catalog->resourceFieldHints();
        if (!count($hints)) return 'keine Ressourcen-/Upload-Hinweise in Workbench/Projektkonfiguration gefunden';
        $hintParts = array();
        foreach ($hints as $hint) {
            $hintParts[] = ($hint['id'] ? '#' . $hint['id'] : 'ohne numerische id') . ' "' . $hint['label'] . '" type=' . $hint['type'] . ' [' . $hint['path'] . ']';
            if (count($hintParts) >= 6) break;
        }
        return 'keine sicheren Kandidaten; Hinweise: ' . implode(', ', $hintParts);
    }
    $parts = array();
    foreach ($rows as $row) {
        $parts[] = '#' . $row['field_id'] . ' "' . $row['label'] . '" [' . $row['source'] . '; ' . $row['path'] . ']';
        if (count($parts) >= 8) break;
    }
    return implode(', ', $parts);
}

function require_api($client) {
    if (!$client->isConfigured()) throw new Exception('Server nicht konfiguriert: BKI_API_KEY fehlt.');
}

function load_scene_catalog($client, $flow) {
    $project = app_config('project_scene', 18);
    $draft = $flow->get('scene_draft', uuid_v4_compat());
    return new FieldCatalog($client->workbench($project, $draft), $client->optionLists($project), $client->dynamicFields($project));
}

function handle_upload($flow) {
    if (!isset($_FILES['photos'])) throw new Exception('Keine Bilder empfangen.');
    $files = normalize_files_array($_FILES['photos']);
    if (count($files) < 1) throw new Exception('Keine Bilder empfangen.');
    $uploads = clean_uploads($flow);
    $replaceIndex = isset($_POST['replace_index']) && $_POST['replace_index'] !== '' ? intval($_POST['replace_index']) : null;
    if ($replaceIndex === null && count($uploads) + count($files) > app_config('max_uploads', 4)) throw new Exception('Maximal 4 Bilder erlaubt.');
    $dir = app_config('storage', dirname(__DIR__) . '/storage') . '/uploads/' . session_id();
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) throw new Exception('Upload-Verzeichnis konnte nicht angelegt werden.');
    foreach ($files as $file) {
        if ($file['error'] !== UPLOAD_ERR_OK) throw new Exception('Upload-Fehler ' . $file['error'] . '.');
        if ($file['size'] > app_config('max_file_bytes', 12582912)) throw new Exception('Ein Bild ist zu groß.');
        $mime = detect_mime($file['tmp_name']);
        if (!in_array($mime, app_config('allowed_mime', array()), true)) throw new Exception('Nur JPEG, PNG und WebP sind erlaubt.');
        $ext = mime_extension($mime);
        $path = $dir . '/' . uuid_v4_compat() . '.' . $ext;
        if (!move_uploaded_file($file['tmp_name'], $path)) throw new Exception('Bild konnte nicht gespeichert werden.');
        $entry = array('path' => $path, 'name' => basename($file['name']), 'mime' => $mime, 'size' => $file['size']);
        if ($replaceIndex !== null) {
            if (!isset($uploads[$replaceIndex])) throw new Exception('Zu ersetzender Bildslot existiert nicht.');
            if (isset($uploads[$replaceIndex]['path']) && is_file($uploads[$replaceIndex]['path'])) @unlink($uploads[$replaceIndex]['path']);
            $uploads[$replaceIndex] = $entry;
            $replaceIndex = null;
        } else {
            $uploads[] = $entry;
        }
    }
    $flow->set('uploads', array_values($uploads));
    $flow->restartPhotoset();
}

function normalize_files_array($fileField) {
    $out = array();
    if (is_array($fileField['name'])) {
        foreach ($fileField['name'] as $i => $name) {
            $out[] = array('name' => $name, 'type' => $fileField['type'][$i], 'tmp_name' => $fileField['tmp_name'][$i], 'error' => $fileField['error'][$i], 'size' => $fileField['size'][$i]);
        }
    } else {
        $out[] = $fileField;
    }
    return $out;
}

function detect_mime($path) {
    if (function_exists('finfo_open')) {
        $f = finfo_open(FILEINFO_MIME_TYPE);
        $m = finfo_file($f, $path);
        finfo_close($f);
        return $m;
    }
    return function_exists('mime_content_type') ? mime_content_type($path) : '';
}

function mime_extension($mime) {
    if ($mime === 'image/png') return 'png';
    if ($mime === 'image/webp') return 'webp';
    return 'jpg';
}

function clean_uploads($flow) {
    $uploads = $flow->get('uploads', array());
    $valid = array();
    foreach ($uploads as $upload) {
        if (!is_array($upload) || !isset($upload['path']) || !is_file($upload['path'])) continue;
        $valid[] = $upload;
    }
    if (count($valid) !== count($uploads)) {
        $flow->set('uploads', array_values($valid));
        $flow->restartPhotoset();
    }
    return array_values($valid);
}

function public_state($flow) {
    clean_uploads($flow);
    $s = $flow->all();
    $uploads = array();
    foreach ($s['uploads'] as $i => $u) {
        $uploads[] = array('index' => $i, 'name' => $u['name'], 'size' => $u['size'], 'url' => 'upload-preview.php?index=' . $i . '&v=' . rawurlencode((string)@filemtime($u['path'])));
    }

    $attempts = public_photoset_attempts($flow);
    $photos = array();
    $activeAttemptId = isset($s['active_photoset_attempt_id']) ? $s['active_photoset_attempt_id'] : null;
    if ($activeAttemptId) {
        $activeAttempt = find_photoset_attempt($flow, $activeAttemptId);
        if ($activeAttempt) $photos = public_photoset_attempt_images($activeAttempt);
    }
    if (!count($photos)) $photos = public_image_urls('photoset', isset($s['photoset_images']) ? $s['photoset_images'] : array(), isset($s['photoset_run']) ? $s['photoset_run'] : '');

    $sceneResults = public_scene_results(isset($s['scene_results']) ? $s['scene_results'] : array());
    return array(
        'uploads' => $uploads,
        'photoset_run' => $s['photoset_run'],
        'photoset_images' => $photos,
        'photoset_attempts' => $attempts,
        'active_photoset_attempt_id' => $activeAttemptId,
        'approved_photoset_attempt_id' => isset($s['approved_photoset_attempt_id']) ? $s['approved_photoset_attempt_id'] : null,
        'photoset_approved' => $s['photoset_approved'],
        'profile' => $s['profile'],
        'location' => $s['location'],
        'scenes' => $s['scenes'],
        'scene_runs' => $s['scene_runs'],
        'scene_results' => $sceneResults
    );
}

function find_run_id($value) {
    if (!is_array($value)) return null;
    foreach (array('run_id', 'runId') as $k) if (isset($value[$k]) && is_scalar($value[$k])) return (string)$value[$k];
    if (isset($value['data']) && is_array($value['data'])) {
        $v = find_run_id($value['data']); if ($v) return $v;
    }
    foreach ($value as $v) if (is_array($v)) { $id = find_run_id($v); if ($id) return $id; }
    return null;
}

function run_status($run) {
    $data = isset($run['data']) && is_array($run['data']) ? $run['data'] : $run;
    foreach (array('status', 'state') as $k) if (isset($data[$k]) && is_scalar($data[$k])) return strtolower((string)$data[$k]);
    return '';
}

function run_error_message($run) {
    $data = isset($run['data']) && is_array($run['data']) ? $run['data'] : $run;
    if (isset($data['error']['message'])) return (string)$data['error']['message'];
    if (isset($data['message'])) return (string)$data['message'];
    return 'Generierung fehlgeschlagen.';
}

function extract_image_refs($root) {
    $out = array();
    $seen = array();
    $data = isset($root['data']) && is_array($root['data']) ? $root['data'] : $root;

    // Zuerst nur typische Ergebniscontainer durchsuchen. Dadurch werden die
    // hochgeladenen Eingangsressourcen nicht versehentlich als Ergebnisbilder
    // interpretiert.
    $preferred = array(
        'results','result','output','outputs','images','image','artifacts','artifact',
        'generated_images','generated_files','result_images','result_files','media',
        'attachments','assets','files','provider_result','provider_response','response'
    );
    foreach ($preferred as $key) {
        if (is_array($data) && array_key_exists($key, $data)) {
            walk_image_refs($data[$key], $out, $seen, 'result.' . $key, true);
        }
    }

    // Manche Provider legen die eigentliche Antwort als JSON-String ab.
    if (!count($out)) {
        walk_image_refs($data, $out, $seen, 'run', false);
    }
    return $out;
}

function walk_image_refs($node, &$out, &$seen, $path, $resultContext) {
    if (is_string($node)) {
        walk_image_string($node, $out, $seen, $path, $resultContext);
        return;
    }
    if (!is_array($node)) return;

    $pathLower = strtolower((string)$path);
    $isInputResourcePath = preg_match('/(^|\.)(resources?|inputs?|uploads?)(\.|$)/', $pathLower) && !preg_match('/result|output|generated|artifact/', $pathLower);
    $context = $resultContext || preg_match('/result|output|generated|artifact|provider_response|provider_result/', $pathLower);

    $mime = '';
    foreach (array('mime_type','content_type','mimetype','mime') as $mk) {
        if (isset($node[$mk]) && is_scalar($node[$mk])) { $mime = strtolower((string)$node[$mk]); break; }
    }
    $name = '';
    foreach (array('filename','file_name','name','label','title') as $nk) {
        if (isset($node[$nk]) && is_scalar($node[$nk])) { $name = strtolower((string)$node[$nk]); break; }
    }
    $imageish = strpos($mime, 'image/') === 0 || preg_match('/\.(png|jpe?g|webp|gif)(\?|$)/i', $name) || preg_match('/image|photo|bild|render/', $pathLower . ' ' . $name);

    // Explizite Datei-/Ressourcen-IDs sind am zuverlässigsten. Im kompletten
    // Run-Fallback werden Eingangsressourcen ausgeschlossen.
    $fileId = null;
    foreach (array('file_id','fileId','resource_id','resourceId') as $k) {
        if (isset($node[$k]) && is_scalar($node[$k])) { $fileId = (string)$node[$k]; break; }
    }
    if ($fileId !== null && !$isInputResourcePath && ($context || $imageish || $mime === '')) {
        add_image_ref($out, $seen, array('type' => 'file', 'file_id' => $fileId, 'source_path' => $path));
    }

    // Einige BKI-/Provider-Antworten verwenden asset_id bzw. nur id innerhalb
    // eines klaren Ergebnis-/Bildknotens.
    $assetId = null;
    foreach (array('asset_id','assetId','attachment_id','attachmentId') as $k) {
        if (isset($node[$k]) && is_scalar($node[$k])) { $assetId = (string)$node[$k]; break; }
    }
    if ($assetId !== null && !$isInputResourcePath && ($context || $imageish)) {
        add_image_ref($out, $seen, array('type' => 'file', 'file_id' => $assetId, 'source_path' => $path . '.asset_id'));
    }
    if (isset($node['id']) && is_scalar($node['id']) && !$isInputResourcePath && $context && $imageish) {
        $genericId = (string)$node['id'];
        if ($genericId !== '') add_image_ref($out, $seen, array('type' => 'file', 'file_id' => $genericId, 'source_path' => $path . '.id'));
    }

    foreach (array('image_url','imageUrl','url','download_url','downloadUrl','content_url','contentUrl','preview_url','previewUrl','src','href') as $k) {
        if (isset($node[$k]) && is_string($node[$k])) {
            add_url_or_data_ref($node[$k], $out, $seen, $path . '.' . $k, $mime);
        }
    }
    foreach (array('b64_json','base64','image_base64','imageBase64','data_base64') as $k) {
        if (isset($node[$k]) && is_string($node[$k]) && strlen($node[$k]) > 100) {
            add_image_ref($out, $seen, array('type' => 'base64', 'data' => $node[$k], 'mime' => $mime ? $mime : 'image/png', 'source_path' => $path . '.' . $k));
        }
    }

    foreach ($node as $k => $v) {
        if (is_array($v) || is_string($v)) {
            $childPath = $path . '.' . (is_int($k) ? $k : (string)$k);
            $childContext = $context || preg_match('/result|output|generated|artifact|image|media|attachment/', strtolower((string)$k));
            walk_image_refs($v, $out, $seen, $childPath, $childContext ? true : false);
        }
    }
}

function walk_image_string($value, &$out, &$seen, $path, $resultContext) {
    $text = trim((string)$value);
    if ($text === '') return;

    if (stripos($text, 'data:image/') === 0 || preg_match('#^https?://#i', $text) || ($resultContext && strpos($text, '/') === 0)) {
        add_url_or_data_ref($text, $out, $seen, $path, '');
        return;
    }

    // JSON, das als String in provider_response/result steckt.
    $first = substr($text, 0, 1);
    if (($first === '{' || $first === '[') && strlen($text) < 5000000) {
        $decoded = json_decode($text, true);
        if (is_array($decoded)) {
            walk_image_refs($decoded, $out, $seen, $path . '.json', $resultContext);
            return;
        }
    }

    // Markdown/Provider-Text kann Bild-URLs enthalten.
    if ($resultContext && preg_match_all('#https?://[^\s\)\]\}"\']+#i', $text, $m)) {
        foreach ($m[0] as $u) {
            if (preg_match('/\.(png|jpe?g|webp|gif)(\?|$)/i', $u) || stripos($u, '/files/') !== false || stripos($u, '/content') !== false) {
                add_url_or_data_ref($u, $out, $seen, $path . '.embedded_url', '');
            }
        }
    }
}

function add_url_or_data_ref($url, &$out, &$seen, $path, $mime) {
    $u = trim((string)$url);
    if ($u === '') return;
    if (preg_match('#^data:(image/[^;]+);base64,(.+)$#is', $u, $m)) {
        add_image_ref($out, $seen, array('type' => 'base64', 'data' => preg_replace('/\s+/', '', $m[2]), 'mime' => strtolower($m[1]), 'source_path' => $path));
        return;
    }
    if (preg_match('#^https?://#i', $u) || strpos($u, '/') === 0) {
        add_image_ref($out, $seen, array('type' => 'url', 'url' => $u, 'mime' => $mime, 'source_path' => $path));
    }
}

function add_image_ref(&$out, &$seen, $ref) {
    $key = isset($ref['file_id']) ? 'f:' . $ref['file_id'] : (isset($ref['url']) ? 'u:' . $ref['url'] : 'b:' . substr(sha1($ref['data']),0,20));
    if (!isset($seen[$key])) { $seen[$key] = true; $out[] = $ref; }
}

function sanitize_image_refs($refs) {
    $out = array();
    foreach ($refs as $ref) {
        $row = array('type' => isset($ref['type']) ? $ref['type'] : '');
        if (isset($ref['file_id'])) $row['file_id'] = $ref['file_id'];
        if (isset($ref['url'])) $row['url'] = $ref['url'];
        if (isset($ref['mime'])) $row['mime'] = $ref['mime'];
        if (isset($ref['source_path'])) $row['source_path'] = $ref['source_path'];
        if (isset($ref['data'])) $row['base64_length'] = strlen($ref['data']);
        $out[] = $row;
    }
    return $out;
}

function diagnostic_shape($value, $path, $depth) {
    if ($depth > 7) return '[depth-limit]';
    if (is_array($value)) {
        $out = array(); $count = 0;
        foreach ($value as $k => $v) {
            if ($count++ >= 80) { $out['__truncated__'] = true; break; }
            $key = (string)$k;
            $lower = strtolower($key);
            if (preg_match('/authorization|api[_-]?key|token|secret|prompt|base64|b64/', $lower)) {
                $out[$key] = '[redacted]';
                continue;
            }
            $out[$key] = diagnostic_shape($v, $path === '' ? $key : $path . '.' . $key, $depth + 1);
        }
        return $out;
    }
    if (is_string($value)) {
        if (stripos($value, 'data:image/') === 0) return '[data-image ' . strlen($value) . ' chars]';
        if (strlen($value) > 500) return substr($value, 0, 500) . '… [' . strlen($value) . ' chars]';
        return $value;
    }
    if (is_object($value)) return diagnostic_shape((array)$value, $path, $depth + 1);
    return $value;
}

function public_scene_results($results) {
    $out = array();
    foreach ((array)$results as $i => $r) {
        if (!is_array($r)) continue;
        $out[] = array(
            'scene' => isset($r['scene']) ? $r['scene'] : ('Szene ' . ($i + 1)),
            'url' => image_url_for_ref('scene', $i, isset($r['image']) ? $r['image'] : null, (isset($r['saved_file']) && is_file($r['saved_file'])) ? @filemtime($r['saved_file']) : (isset($r['run_id']) ? $r['run_id'] : ''))
        );
    }
    return $out;
}

function storage_session_dir($subdir) {
    $base = rtrim(app_config('storage', dirname(__DIR__) . '/storage'), '/');
    $dir = $base . '/' . trim($subdir, '/') . '/' . session_id();
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) throw new Exception('Storage-Verzeichnis konnte nicht angelegt werden.');
    return $dir;
}

function materialize_ref_to_file($client, $runId, $ref, $pathBase) {
    $bytes = null; $type = 'image/png';
    if (!is_array($ref) || !isset($ref['type'])) return null;
    if ($ref['type'] === 'file' && isset($ref['file_id'])) {
        try { $r = $runId ? $client->downloadRunResource($runId, $ref['file_id']) : $client->downloadFile($ref['file_id']); }
        catch (Exception $e) { $r = $client->downloadFile($ref['file_id']); }
        $bytes = $r['bytes']; $type = $r['content_type'];
    } else if ($ref['type'] === 'base64' && isset($ref['data'])) {
        $bytes = base64_decode($ref['data']); $type = isset($ref['mime']) ? $ref['mime'] : 'image/png';
    } else if ($ref['type'] === 'url' && isset($ref['url'])) {
        $r = $client->proxyTrustedUrl($ref['url']); $bytes = $r['bytes']; $type = $r['content_type'];
    }
    if ($bytes === null || $bytes === false || strlen($bytes) < 100) return null;
    $ext = strpos(strtolower($type), 'webp') !== false ? 'webp' : (strpos(strtolower($type), 'jpeg') !== false || strpos(strtolower($type), 'jpg') !== false ? 'jpg' : 'png');
    $path = $pathBase . '.' . $ext;
    if (file_put_contents($path, $bytes) === false) {
        throw new Exception('Bilddatei konnte nicht geschrieben werden: ' . $path);
    }
    return $path;
}

function materialize_scene_batch($client, $flow, $results) {
    $batchId = uuid_v4_compat();
    $dir = storage_session_dir('scenes') . '/' . preg_replace('/[^a-zA-Z0-9_-]/', '', $batchId);
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) throw new Exception('Szenen-Verzeichnis konnte nicht angelegt werden.');
    $out = array();
    foreach ((array)$results as $i => $result) {
        if (!is_array($result) || !isset($result['image'])) continue;
        $saved = materialize_ref_to_file($client, isset($result['run_id']) ? $result['run_id'] : null, $result['image'], $dir . '/scene-' . ($i + 1));
        if ($saved) $result['saved_file'] = $saved;
        $result['batch_id'] = $batchId;
        $out[] = $result;
    }
    $batches = $flow->get('scene_batches', array());
    $batches[] = array(
        'id' => $batchId,
        'created_at' => date('c'),
        'results' => $out
    );
    $flow->set('scene_batches', $batches);
    return $out;
}

function public_image_urls($scope, $refs, $extraVersionSeed) {
    $out = array();
    foreach ($refs as $i => $ref) $out[] = image_url_for_ref($scope, $i, $ref, $extraVersionSeed);
    return $out;
}

function ref_cache_token($ref, $extraVersionSeed) {
    $parts = array();
    if ($extraVersionSeed !== null && $extraVersionSeed !== '') $parts[] = (string)$extraVersionSeed;
    if (is_array($ref)) {
        if (isset($ref['saved_file']) && is_string($ref['saved_file']) && is_file($ref['saved_file'])) {
            $parts[] = (string)@filemtime($ref['saved_file']);
            $parts[] = basename($ref['saved_file']);
        }
        foreach (array('file_id', 'resource_id', 'asset_id', 'url', 'mime') as $key) {
            if (isset($ref[$key]) && is_scalar($ref[$key])) $parts[] = (string)$ref[$key];
        }
        if (isset($ref['data']) && is_string($ref['data'])) $parts[] = substr(sha1($ref['data']), 0, 12);
    } else if ($ref !== null && $ref !== '') {
        $parts[] = (string)$ref;
    }
    if (!count($parts)) $parts[] = microtime(true);
    return substr(sha1(implode('|', $parts)), 0, 16);
}

function image_url_for_ref($scope, $index, $ref, $extraVersionSeed) {
    // Ergebnis-URLs werden immer über unseren Server ausgeliefert. Auch eine
    // HTTPS-URL von BKI kann den Authorization-Header benötigen, den ein <img>
    // im Browser nicht mitsendet. Zusätzlich hängen wir einen Cache-Buster an,
    // damit Browser nach neuen Runs keine alten Vorschaubilder wiederverwenden.
    return 'api.php?action=image&scope=' . rawurlencode($scope) . '&index=' . intval($index) . '&v=' . rawurlencode(ref_cache_token($ref, $extraVersionSeed));
}

function store_photoset_attempt($client, $flow, $runId, $images) {
    $attempts = $flow->get('photoset_attempts', array());
    $existingIndex = null;
    foreach ($attempts as $index => $existingAttempt) {
        if (isset($existingAttempt['run_id']) && (string)$existingAttempt['run_id'] === (string)$runId) {
            if (count(valid_saved_files(isset($existingAttempt['saved_files']) ? $existingAttempt['saved_files'] : array())) > 0 && !empty($existingAttempt['library_id'])) return $existingAttempt;
            $existingIndex = $index;
            break;
        }
    }

    $id = $existingIndex === null ? uuid_v4_compat() : $attempts[$existingIndex]['id'];
    $saved = array();
    $storageErrors = $existingIndex === null || empty($attempts[$existingIndex]['storage_errors']) ? array() : $attempts[$existingIndex]['storage_errors'];
    try {
        $saved = materialize_photoset_attempt($client, $runId, $images, $id);
    } catch (Exception $e) {
        $storageErrors[] = photoset_storage_error('materialize', $e);
        error_log('FotoSet-Storage ' . json_encode(array('phase' => 'materialize', 'run_id' => (string)$runId, 'attempt_id' => $id, 'error' => $e->getMessage())));
        $saved = array();
    }
    $createdAt = date('c');
    $libraryId = null;
    if (count($saved) > 0) {
        try {
            $libraryId = archive_photoset_files($saved, array(
                'run_id' => $runId,
                'created_at' => $createdAt,
                'source_attempt_id' => $id
            ));
        } catch (Exception $e) {
            $storageErrors[] = photoset_storage_error('archive', $e);
            error_log('FotoSet-Storage ' . json_encode(array('phase' => 'archive', 'run_id' => (string)$runId, 'attempt_id' => $id, 'error' => $e->getMessage())));
        }
    } else if (!count($storageErrors)) {
        $e = new Exception('Keines der Ergebnisbilder konnte materialisiert werden.');
        $storageErrors[] = photoset_storage_error('materialize', $e);
        error_log('FotoSet-Storage ' . json_encode(array('phase' => 'materialize', 'run_id' => (string)$runId, 'attempt_id' => $id, 'error' => $e->getMessage())));
    }
    $attempt = array(
        'id' => $id,
        'run_id' => $runId,
        'draft_key' => $flow->get('photoset_draft', null),
        'created_at' => $createdAt,
        'refs' => $images,
        'saved_files' => $saved,
        'library_id' => $libraryId,
        'storage_errors' => $storageErrors
    );
    if ($existingIndex === null) $attempts[] = $attempt;
    else $attempts[$existingIndex] = $attempt;
    $flow->set('photoset_attempts', array_values($attempts));
    return $attempt;
}

function photoset_storage_error($phase, $exception) {
    return array('phase' => $phase, 'message' => $exception->getMessage(), 'occurred_at' => date('c'));
}

function find_photoset_attempt($flow, $attemptId) {
    $attempts = $flow->get('photoset_attempts', array());
    foreach ($attempts as $attempt) {
        if (isset($attempt['id']) && (string)$attempt['id'] === (string)$attemptId) return $attempt;
    }
    return null;
}

function update_photoset_attempt_files($flow, $attemptId, $files, $libraryId) {
    $attempts = $flow->get('photoset_attempts', array());
    foreach ($attempts as $i => $attempt) {
        if (isset($attempt['id']) && (string)$attempt['id'] === (string)$attemptId) {
            $attempts[$i]['saved_files'] = array_values($files);
            if ($libraryId) $attempts[$i]['library_id'] = $libraryId;
            break;
        }
    }
    $flow->set('photoset_attempts', $attempts);
}

function valid_saved_files($files) {
    $out = array();
    foreach ((array)$files as $file) if (is_string($file) && is_file($file)) $out[] = $file;
    return $out;
}

function photoset_library_base() {
    $dir = rtrim(app_config('storage', dirname(__DIR__) . '/storage'), '/') . '/photoset-library';
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) throw new Exception('FotoSet-Bibliothek konnte nicht angelegt werden.');
    return $dir;
}

function photoset_image_files_in_dir($dir) {
    $out = array();
    if (!is_dir($dir)) return $out;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..' || $file === 'meta.json') continue;
        $path = $dir . '/' . $file;
        if (!is_file($path)) continue;
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($ext, array('jpg','jpeg','png','webp'), true)) continue;
        $out[] = $path;
    }
    natsort($out);
    return array_values($out);
}

function archive_photoset_files($files, $meta) {
    $files = valid_saved_files($files);
    if (count($files) < 1) return null;
    $runId = isset($meta['run_id']) && $meta['run_id'] ? (string)$meta['run_id'] : '';
    if ($runId !== '') $libraryId = 'ps-' . substr(sha1('run|' . $runId), 0, 24);
    else $libraryId = 'ps-' . substr(sha1(implode('|', $files) . '|' . microtime(true)), 0, 24);
    $dir = photoset_library_base() . '/' . $libraryId;
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) throw new Exception('FotoSet konnte nicht in der Bibliothek gespeichert werden.');
    $copied = array();
    foreach ($files as $i => $source) {
        $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
        if (!in_array($ext, array('jpg','jpeg','png','webp'), true)) $ext = 'jpg';
        $target = $dir . '/photoset-' . ($i + 1) . '.' . $ext;
        if (!is_file($target) || @filesize($target) !== @filesize($source)) {
            if (!copy($source, $target)) throw new Exception('FotoSet-Datei konnte nicht archiviert werden: ' . $source . ' -> ' . $target);
        }
        $copied[] = $target;
    }
    if (count($copied) < 1) return null;
    $payload = array(
        'id' => $libraryId,
        'run_id' => $runId !== '' ? $runId : null,
        'created_at' => isset($meta['created_at']) && $meta['created_at'] ? $meta['created_at'] : date('c'),
        'source_attempt_id' => isset($meta['source_attempt_id']) ? $meta['source_attempt_id'] : null,
        'image_count' => count($copied)
    );
    $metaPath = $dir . '/meta.json';
    if (file_put_contents($metaPath, json_encode($payload)) === false) {
        throw new Exception('FotoSet-Metadaten konnten nicht geschrieben werden: ' . $metaPath);
    }
    return $libraryId;
}

function photoset_library_entries() {
    $entries = array();
    $seen = array();
    $archivedAttemptIds = array();
    $base = photoset_library_base();
    $dirs = glob($base . '/*', GLOB_ONLYDIR);
    if (is_array($dirs)) {
        foreach ($dirs as $dir) {
            $id = basename($dir);
            $files = photoset_image_files_in_dir($dir);
            if (count($files) < 1) continue;
            $meta = array();
            $metaPath = $dir . '/meta.json';
            if (is_file($metaPath)) {
                $decoded = json_decode(@file_get_contents($metaPath), true);
                if (is_array($decoded)) $meta = $decoded;
            }
            if (isset($meta['source_attempt_id']) && $meta['source_attempt_id']) $archivedAttemptIds[(string)$meta['source_attempt_id']] = true;
            $entries[] = array(
                'id' => $id,
                'dir' => $dir,
                'files' => $files,
                'created_at' => isset($meta['created_at']) ? $meta['created_at'] : date('c', @filemtime($dir)),
                'run_id' => isset($meta['run_id']) ? $meta['run_id'] : null,
                'legacy' => false
            );
            $seen[$id] = true;
        }
    }

    // Legacy-FotoSetCards aus Versionen vor der globalen Bibliothek ebenfalls anbieten.
    $legacyRoot = rtrim(app_config('storage', dirname(__DIR__) . '/storage'), '/') . '/photosets';
    $sessionDirs = glob($legacyRoot . '/*', GLOB_ONLYDIR);
    if (is_array($sessionDirs)) {
        foreach ($sessionDirs as $sessionDir) {
            $attemptDirs = glob($sessionDir . '/*', GLOB_ONLYDIR);
            if (!is_array($attemptDirs)) continue;
            foreach ($attemptDirs as $dir) {
                if (isset($archivedAttemptIds[(string)basename($dir)])) continue;
                $files = photoset_image_files_in_dir($dir);
                if (count($files) < 1) continue;
                $legacyId = 'legacy-' . substr(sha1(realpath($dir) ? realpath($dir) : $dir), 0, 24);
                if (isset($seen[$legacyId])) continue;
                $entries[] = array(
                    'id' => $legacyId,
                    'dir' => $dir,
                    'files' => $files,
                    'created_at' => date('c', @filemtime($dir)),
                    'run_id' => null,
                    'legacy' => true
                );
                $seen[$legacyId] = true;
            }
        }
    }
    usort($entries, 'compare_photoset_library_entries');
    return $entries;
}

function compare_photoset_library_entries($a, $b) {
    $ta = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
    $tb = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
    if ($ta === $tb) return 0;
    return ($ta > $tb) ? -1 : 1;
}

function find_photoset_library_entry($libraryId) {
    foreach (photoset_library_entries() as $entry) {
        if ((string)$entry['id'] === (string)$libraryId) return $entry;
    }
    return null;
}

function public_photoset_library_entries($entries) {
    $out = array();
    foreach ((array)$entries as $entry) {
        $images = array();
        foreach ($entry['files'] as $i => $path) {
            $images[] = 'api.php?action=image&scope=photoset_library&library_id=' . rawurlencode($entry['id']) . '&index=' . intval($i) . '&v=' . rawurlencode((string)@filemtime($path));
        }
        $out[] = array(
            'id' => $entry['id'],
            'created_at' => isset($entry['created_at']) ? $entry['created_at'] : '',
            'image_count' => count($entry['files']),
            'images' => $images,
            'legacy' => !empty($entry['legacy'])
        );
    }
    return $out;
}

function import_library_photoset_into_workflow($flow, $entry) {
    $attempts = $flow->get('photoset_attempts', array());
    foreach ($attempts as $attempt) {
        if (isset($attempt['source_library_id']) && (string)$attempt['source_library_id'] === (string)$entry['id'] && count(valid_saved_files(isset($attempt['saved_files']) ? $attempt['saved_files'] : array()))) {
            return $attempt;
        }
    }
    $id = uuid_v4_compat();
    $dir = storage_session_dir('photosets') . '/' . preg_replace('/[^a-zA-Z0-9_-]/', '', $id);
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) throw new Exception('FotoSetCard konnte nicht in die aktuelle Session übernommen werden.');
    $saved = array();
    foreach ($entry['files'] as $i => $source) {
        $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
        if (!in_array($ext, array('jpg','jpeg','png','webp'), true)) $ext = 'jpg';
        $target = $dir . '/photoset-' . ($i + 1) . '.' . $ext;
        if (@copy($source, $target)) $saved[] = $target;
    }
    if (count($saved) < 1) throw new Exception('Die gespeicherten FotoSet-Bilder konnten nicht geladen werden.');
    $attempt = array(
        'id' => $id,
        'run_id' => isset($entry['run_id']) ? $entry['run_id'] : null,
        'draft_key' => null,
        'created_at' => date('c'),
        'refs' => array(),
        'saved_files' => $saved,
        'library_id' => !empty($entry['legacy']) ? null : $entry['id'],
        'source_library_id' => $entry['id']
    );
    $attempts[] = $attempt;
    $flow->set('photoset_attempts', array_values($attempts));
    return $attempt;
}

function public_photoset_attempts($flow) {
    $attempts = $flow->get('photoset_attempts', array());
    $active = $flow->get('active_photoset_attempt_id', null);
    $approved = $flow->get('approved_photoset_attempt_id', null);
    $out = array();
    foreach ($attempts as $i => $attempt) {
        if (!isset($attempt['id'])) continue;
        $out[] = array(
            'id' => $attempt['id'],
            'number' => $i + 1,
            'created_at' => isset($attempt['created_at']) ? $attempt['created_at'] : '',
            'image_count' => max(count(isset($attempt['saved_files']) ? valid_saved_files($attempt['saved_files']) : array()), count(isset($attempt['refs']) && is_array($attempt['refs']) ? $attempt['refs'] : array())),
            'images' => public_photoset_attempt_images($attempt),
            'active' => ((string)$active === (string)$attempt['id']),
            'approved' => ((string)$approved === (string)$attempt['id'])
        );
    }
    return $out;
}

function public_photoset_attempt_images($attempt) {
    $out = array();
    if (!isset($attempt['id'])) return $out;
    $saved = isset($attempt['saved_files']) ? valid_saved_files($attempt['saved_files']) : array();
    $count = count($saved);
    if ($count < 1 && isset($attempt['refs']) && is_array($attempt['refs'])) $count = count($attempt['refs']);
    for ($i = 0; $i < $count; $i++) {
        $v = ($i < count($saved)) ? @filemtime($saved[$i]) : (isset($attempt['run_id']) ? $attempt['run_id'] : '1');
        $out[] = 'api.php?action=image&scope=photoset_attempt&attempt_id=' . rawurlencode($attempt['id']) . '&index=' . intval($i) . '&v=' . rawurlencode((string)$v);
    }
    return $out;
}

function materialize_photoset_attempt($client, $runId, $images, $attemptId) {
    $safeAttempt = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$attemptId);
    if ($safeAttempt === '') $safeAttempt = uuid_v4_compat();
    $dir = storage_session_dir('photosets') . '/' . $safeAttempt;
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) throw new Exception('FotoSet-Verzeichnis konnte nicht angelegt werden.');
    $saved = array();
    foreach ((array)$images as $i => $ref) {
        $path = materialize_ref_to_file($client, $runId, $ref, $dir . '/photoset-' . ($i + 1));
        if ($path) $saved[] = $path;
    }
    return $saved;
}

function purge_photoset_storage() {
    $dir = rtrim(app_config('storage', dirname(__DIR__) . '/storage'), '/') . '/photosets/' . session_id();
    if (!is_dir($dir)) return;
    remove_tree($dir);
}

function purge_scene_storage() {
    $dir = rtrim(app_config('storage', dirname(__DIR__) . '/storage'), '/') . '/scenes/' . session_id();
    if (!is_dir($dir)) return;
    remove_tree($dir);
}

function remove_tree($path) {
    if (!is_dir($path)) { if (is_file($path)) @unlink($path); return; }
    $items = scandir($path);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $child = $path . '/' . $item;
        if (is_dir($child)) remove_tree($child); else @unlink($child);
    }
    @rmdir($path);
}

function option_label($options, $value) {
    foreach ($options as $option) {
        if (isset($option['value']) && (string)$option['value'] === (string)$value) return isset($option['label']) ? (string)$option['label'] : (string)$value;
    }
    return (string)$value;
}

function serve_image($client, $flow) {
    $scope = isset($_GET['scope']) ? $_GET['scope'] : '';
    $index = isset($_GET['index']) ? intval($_GET['index']) : -1;
    $ref = null; $runId = null;
    if ($scope === 'photoset_library') {
        $libraryId = isset($_GET['library_id']) ? (string)$_GET['library_id'] : '';
        $entry = find_photoset_library_entry($libraryId);
        if (!$entry) throw new Exception('Gespeichertes FotoSet nicht gefunden.');
        if (!isset($entry['files'][$index]) || !is_file($entry['files'][$index])) throw new Exception('FotoSet-Bild nicht gefunden.');
        $path = $entry['files'][$index];
        $type = detect_mime($path);
        if (!$type) $type = 'image/jpeg';
        header('Content-Type: ' . $type);
        header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');
        readfile($path);
        exit;
    } else if ($scope === 'photoset_attempt') {
        $attemptId = isset($_GET['attempt_id']) ? (string)$_GET['attempt_id'] : '';
        $attempt = find_photoset_attempt($flow, $attemptId);
        if (!$attempt) throw new Exception('FotoSetCard nicht gefunden.');
        $saved = isset($attempt['saved_files']) ? valid_saved_files($attempt['saved_files']) : array();
        if (isset($saved[$index])) {
            $path = $saved[$index];
            $type = detect_mime($path);
            if (!$type) $type = 'image/jpeg';
            header('Content-Type: ' . $type); header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0'); header('Pragma: no-cache'); header('Expires: 0'); readfile($path); exit;
        }
        $refs = isset($attempt['refs']) && is_array($attempt['refs']) ? $attempt['refs'] : array();
        $runId = isset($attempt['run_id']) ? $attempt['run_id'] : null;
        if (isset($refs[$index])) $ref = $refs[$index];
    } else if ($scope === 'photoset') {
        $refs = $flow->get('photoset_images', array());
        $runId = $flow->get('photoset_run', null);
        if (isset($refs[$index])) $ref = $refs[$index];
    } else if ($scope === 'scene') {
        $results = $flow->get('scene_results', array());
        if (isset($results[$index])) {
            if (isset($results[$index]['saved_file']) && is_file($results[$index]['saved_file'])) {
                $path = $results[$index]['saved_file'];
                $type = detect_mime($path);
                if (!$type) $type = 'image/jpeg';
                header('Content-Type: ' . $type); header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0'); header('Pragma: no-cache'); header('Expires: 0'); readfile($path); exit;
            }
            $ref = $results[$index]['image']; $runId = $results[$index]['run_id'];
        }
    }
    if (!$ref) throw new Exception('Bild nicht gefunden.');
    if ($ref['type'] === 'base64') {
        $bytes = base64_decode($ref['data']); $type = isset($ref['mime']) ? $ref['mime'] : 'image/png';
    } else if ($ref['type'] === 'file') {
        require_api($client);
        try { $r = $runId ? $client->downloadRunResource($runId, $ref['file_id']) : $client->downloadFile($ref['file_id']); }
        catch (Exception $e) { $r = $client->downloadFile($ref['file_id']); }
        $bytes = $r['bytes']; $type = $r['content_type'];
    } else if ($ref['type'] === 'url') {
        require_api($client);
        $r = $client->proxyTrustedUrl($ref['url']); $bytes = $r['bytes']; $type = $r['content_type'];
    } else throw new Exception('Unbekanntes Bildformat.');
    header('Content-Type: ' . $type); header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0'); header('Pragma: no-cache'); header('Expires: 0'); echo $bytes; exit;
}
