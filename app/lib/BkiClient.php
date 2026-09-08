<?php
class BkiClient {
    private $base;
    private $key;
    private $verifyTls;

    public function __construct($base, $key, $verifyTls) {
        $this->base = rtrim($base, '/');
        $this->key = $key;
        $this->verifyTls = $verifyTls ? true : false;
    }

    public function isConfigured() {
        return strlen($this->key) > 0;
    }

    public function get($path) {
        return $this->request('GET', $path, null, array(), false);
    }

    public function post($path, $body, $idempotencyKey) {
        $headers = array();
        if ($idempotencyKey) {
            $headers[] = 'Idempotency-Key: ' . $idempotencyKey;
        }
        return $this->request('POST', $path, $body, $headers, false);
    }

    public function workbench($projectId, $draftKey) {
        $path = '/projects/' . intval($projectId) . '/workbench';
        if ($draftKey) {
            $path .= '?draft_key=' . rawurlencode($draftKey);
        }
        return $this->get($path);
    }

    public function optionLists($projectId) {
        return $this->get('/projects/' . intval($projectId) . '/option-lists');
    }

    public function dynamicFields($projectId) {
        return $this->get('/projects/' . intval($projectId) . '/dynamic-fields');
    }

    public function dynamicConfiguration($projectId) {
        return $this->get('/projects/' . intval($projectId) . '/dynamic-configuration');
    }

    public function projectExport($projectId) {
        return $this->get('/projects/' . intval($projectId) . '/export');
    }

    public function resolvePrompt($projectId, $payload) {
        return $this->post('/projects/' . intval($projectId) . '/prompt/resolve', $payload, uuid_v4_compat());
    }

    public function startRun($projectId, $provider, $values, $draftKey, $extra) {
        // BKI erwartet für leere Maps JSON-Objekte ({}) und keine JSON-Arrays ([]).
        // Außerdem gehört derselbe draft_key in den Run, der zuvor für die
        // Ressourcen-Uploads verwendet wurde.
        $body = array(
            'provider' => $provider,
            'values' => $this->jsonMap($values),
            'section_texts' => new stdClass()
        );
        if ($draftKey) {
            $body['draft_key'] = $draftKey;
        }
        if (is_array($extra)) {
            foreach ($extra as $key => $value) {
                if (($key === 'values' || $key === 'section_texts') && is_array($value)) {
                    $body[$key] = $this->jsonMap($value);
                } else {
                    $body[$key] = $value;
                }
            }
        }
        return $this->post('/projects/' . intval($projectId) . '/runs', $body, uuid_v4_compat());
    }

    public function getRun($runId, $generationKey = null) {
        $path = '/runs/' . rawurlencode($runId);
        if ($generationKey !== null && $generationKey !== '') {
            // BKI kann eine run_id erneut vergeben. Ein eindeutiger Query-Parameter
            // verhindert dann, dass ein Proxy die Antwort des alten Laufs liefert.
            $path .= '?cache_key=' . rawurlencode((string)$generationKey);
        }
        return $this->get($path);
    }

    public function resetDraft($projectId, $draftKey) {
        return $this->post('/resources/reset-draft', array(
            'project_id' => intval($projectId),
            'draft_key' => $draftKey
        ), uuid_v4_compat());
    }

    public function uploadResource($draftKey, $fieldId, $filePath) {
        if (!is_file($filePath)) {
            throw new Exception('Lokale Upload-Datei fehlt.');
        }
        if (!$draftKey) {
            throw new Exception('Ressourcen-Upload ohne draft_key ist nicht erlaubt.');
        }
        if ($fieldId === null || $fieldId === '') {
            throw new Exception('Ressourcen-Upload ohne field_id ist nicht erlaubt.');
        }
        $fieldIdText = trim((string)$fieldId);
        if (!preg_match('/^[0-9]+$/', $fieldIdText) || intval($fieldIdText) < 1) {
            throw new Exception('Ungültige Ressourcen-field_id: BKI erwartet eine numerische Feld-ID, keine UUID/Binding-ID.');
        }

        // Wichtig: /resources/upload ordnet die Datei über die projektweit eindeutige
        // numerische field_id zu. project_id und binding_id gehören NICHT in diesen Multipart-Upload.
        $fields = array(
            'draft_key' => (string)$draftKey,
            'field_id' => $fieldIdText
        );
        if (class_exists('CURLFile')) {
            $mime = function_exists('mime_content_type') ? mime_content_type($filePath) : 'application/octet-stream';
            $fields['file'] = new CURLFile($filePath, $mime ? $mime : 'application/octet-stream', basename($filePath));
        } else {
            $fields['file'] = '@' . $filePath;
        }
        return $this->request('POST', '/resources/upload', $fields, array('Idempotency-Key: ' . uuid_v4_compat()), true);
    }

    public function selectResource($draftKey, $fieldId, $assetId) {
        return $this->post('/resources/select', array(
            'draft_key' => $draftKey,
            'field_id' => $fieldId,
            'asset_id' => $assetId
        ), uuid_v4_compat());
    }

    public function downloadRunResource($runId, $fileId, $generationKey = null) {
        $path = '/runs/' . rawurlencode($runId) . '/resources/' . rawurlencode($fileId) . '/content';
        if ($generationKey !== null && $generationKey !== '') {
            $path .= '?cache_key=' . rawurlencode((string)$generationKey);
        }
        return $this->requestBinary($path);
    }

    public function downloadFile($fileId, $generationKey = null) {
        $path = '/files/' . rawurlencode($fileId) . '/content';
        if ($generationKey !== null && $generationKey !== '') {
            $path .= '?cache_key=' . rawurlencode((string)$generationKey);
        }
        return $this->requestBinary($path);
    }

    public function proxyTrustedUrl($url) {
        $baseParts = parse_url($this->base);
        if (!is_array($baseParts) || !isset($baseParts['host'])) {
            throw new Exception('BKI_API_BASE ist ungültig.');
        }
        $url = trim((string)$url);
        if ($url === '') throw new Exception('Leere Ergebnis-URL.');

        // BKI kann in Run-Ergebnissen auch relative interne Content-URLs liefern.
        if (strpos($url, '/') === 0) {
            $scheme = isset($baseParts['scheme']) ? $baseParts['scheme'] : 'http';
            $port = isset($baseParts['port']) ? ':' . intval($baseParts['port']) : '';
            $url = $scheme . '://' . $baseParts['host'] . $port . $url;
        }

        $urlParts = parse_url($url);
        if (!is_array($urlParts) || !isset($urlParts['host']) || strtolower($urlParts['host']) !== strtolower($baseParts['host'])) {
            throw new Exception('Externe Ergebnis-URL wird nicht proxied.');
        }
        return $this->requestAbsoluteBinary($url);
    }

    private function jsonMap($value) {
        if ($value instanceof stdClass) return $value;
        if (!is_array($value)) return $value;
        // values und section_texts sind laut API Maps. Als Objekt erzwingen,
        // damit auch numerische Binding-IDs nie versehentlich als JSON-Array enden.
        return (object)$value;
    }

    private function request($method, $path, $body, $extraHeaders, $multipart) {
        if (!$this->isConfigured()) {
            throw new Exception('BKI_API_KEY ist nicht gesetzt.');
        }
        $url = $this->base . $path;
        $ch = curl_init($url);
        $headers = array('Authorization: Bearer ' . $this->key, 'Accept: application/json', 'Cache-Control: no-cache, no-store', 'Pragma: no-cache');
        if (!$multipart && $body !== null) {
            $headers[] = 'Content-Type: application/json';
        }
        foreach ($extraHeaders as $h) {
            $headers[] = $h;
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifyTls);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->verifyTls ? 2 : 0);
        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $multipart ? $body : json_encode($body));
        }
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($raw === false || $err) {
            throw new Exception('BKI-Verbindung fehlgeschlagen: ' . $err);
        }
        $decoded = json_decode($raw, true);
        if ($status < 200 || $status >= 300) {
            $msg = 'BKI HTTP ' . $status;
            if (is_array($decoded) && isset($decoded['error']['message'])) {
                $msg .= ': ' . $decoded['error']['message'];
            }
            if (is_array($decoded) && isset($decoded['request_id'])) {
                $msg .= ' [request_id ' . $decoded['request_id'] . ']';
            }
            throw new Exception($msg);
        }
        if (!is_array($decoded)) {
            throw new Exception('BKI lieferte kein gültiges JSON.');
        }
        return $decoded;
    }

    private function requestBinary($path) {
        return $this->requestAbsoluteBinary($this->base . $path);
    }

    private function requestAbsoluteBinary($url) {
        if (!$this->isConfigured()) {
            throw new Exception('BKI_API_KEY ist nicht gesetzt.');
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->key, 'Accept: */*', 'Cache-Control: no-cache, no-store', 'Pragma: no-cache'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifyTls);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->verifyTls ? 2 : 0);
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($raw === false || $err || $status < 200 || $status >= 300) {
            throw new Exception('Bildabruf fehlgeschlagen (HTTP ' . $status . ').');
        }
        return array('bytes' => $raw, 'content_type' => $type ? $type : 'application/octet-stream');
    }
}
