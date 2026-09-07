<?php
class Workflow {
    private $key = 'matrix_photo_workflow';

    public function __construct() {
        if (!isset($_SESSION[$this->key]) || !is_array($_SESSION[$this->key])) {
            $this->resetAll();
        } else {
            $this->ensureDefaults();
        }
    }

    private function ensureDefaults() {
        $defaults = array(
            'photoset_attempts' => array(),
            'active_photoset_attempt_id' => null,
            'approved_photoset_attempt_id' => null,
            'scene_batches' => array()
        );
        foreach ($defaults as $key => $value) {
            if (!array_key_exists($key, $_SESSION[$this->key])) {
                $_SESSION[$this->key][$key] = $value;
            }
        }
    }

    public function all() {
        return $_SESSION[$this->key];
    }

    public function get($key, $defaultValue) {
        return isset($_SESSION[$this->key][$key]) ? $_SESSION[$this->key][$key] : $defaultValue;
    }

    public function set($key, $value) {
        $_SESSION[$this->key][$key] = $value;
    }

    public function resetAll() {
        $_SESSION[$this->key] = array(
            'photoset_draft' => uuid_v4_compat(),
            'scene_draft' => uuid_v4_compat(),
            'uploads' => array(),
            'photoset_run' => null,
            'photoset_images' => array(),
            'photoset_approved' => false,
            'photoset_files' => array(),
            'photoset_attempts' => array(),
            'active_photoset_attempt_id' => null,
            'approved_photoset_attempt_id' => null,
            'scene_batches' => array(),
            'profile' => array(),
            'location' => array(),
            'scenes' => array(),
            'scene_runs' => array(),
            'scene_results' => array()
        );
    }

    public function restartPhotoset() {
        $_SESSION[$this->key]['photoset_draft'] = uuid_v4_compat();
        $_SESSION[$this->key]['scene_draft'] = uuid_v4_compat();
        $_SESSION[$this->key]['photoset_run'] = null;
        $_SESSION[$this->key]['photoset_images'] = array();
        $_SESSION[$this->key]['photoset_approved'] = false;
        $_SESSION[$this->key]['photoset_files'] = array();
        $_SESSION[$this->key]['active_photoset_attempt_id'] = null;
        // Bereits erzeugte FotoSetCards bleiben erhalten. Nur der aktuelle
        // Entwurf/Lauf wird verworfen, damit zwischen Versuchen gewechselt
        // werden kann.
        $_SESSION[$this->key]['scene_runs'] = array();
        $_SESSION[$this->key]['scene_results'] = array();
    }
}
