<?php
class FieldCatalog {
    private $workbench;
    private $optionLists;
    private $dynamicFields;
    private $nodes = array();
    private $lists = array();
    private $resourceCandidates = array();
    private $resourceHints = array();

    public function __construct($workbenchResponse, $optionListsResponse, $dynamicFieldsResponse) {
        $this->workbench = $this->unwrap($workbenchResponse);
        $this->optionLists = $this->unwrap($optionListsResponse);
        $this->dynamicFields = $this->unwrap($dynamicFieldsResponse);
        $this->collectNodes($this->workbench, array());
        $this->collectNodes($this->dynamicFields, array());
        // Manche BKI-Versionen liefern binding_id/option_list_id direkt an
        // Optionslisten oder deren Eintraegen. Diese Knoten ebenfalls auswerten.
        $this->collectNodes($this->optionLists, array('option_lists'));
        $this->collectOptionLists($this->optionLists);
    }

    public function findField($terms) {
        $best = null;
        $bestScore = 0;
        foreach ($this->nodes as $node) {
            if (!is_array($node)) continue;
            $binding = $this->bindingId($node);
            if ($binding === null) continue;
            $text = $this->nodeText($node);
            $termScore = $this->termScore($text, $terms);
            if ($termScore <= 0) continue;

            // Semantik bleibt der wichtigste Faktor. Bei gleich gut passenden
            // Knoten wird aber ein echtes explizites Binding einem blossen
            // Masterprompt-Abschnitt mit UUID unter `id` vorgezogen.
            $score = $termScore * 100 + $this->bindingNodeQuality($node, $binding);
            if ($score > $bestScore) {
                $best = $node;
                $bestScore = $score;
            }
        }
        return $best;
    }

    public function bindingFor($terms) {
        $field = $this->findField($terms);
        return $field ? $this->bindingId($field) : null;
    }

    public function optionsFor($terms) {
        $field = $this->findField($terms);
        if ($field) {
            $inline = $this->extractOptions($field);
            if (count($inline)) return $inline;
            $listId = $this->firstValue($field, array('option_list_id', 'optionListId', 'options_id', 'list_id'));
            if ($listId !== null) {
                foreach ($this->lists as $list) {
                    $id = $this->firstValue($list, array('id', 'option_list_id', 'key'));
                    if ((string)$id === (string)$listId) {
                        $opts = $this->extractOptions($list);
                        if (count($opts)) return $opts;
                    }
                }
            }
        }
        $best = array();
        $bestScore = 0;
        foreach ($this->lists as $list) {
            $score = $this->termScore($this->nodeText($list), $terms);
            if ($score > $bestScore) {
                $opts = $this->extractOptions($list);
                if (count($opts)) {
                    $best = $opts;
                    $bestScore = $score;
                }
            }
        }
        return $best;
    }

    public function bindingDiagnostics() {
        $out = array();
        $seen = array();
        foreach ($this->nodes as $node) {
            if (!is_array($node)) continue;
            $binding = $this->bindingId($node);
            $id = $this->firstValue($node, array('id','uuid'));
            $text = $this->nodeText($node);
            // Nur potenziell relevante Workbench-Felder ausgeben; keine Prompttexte.
            if ($binding === null && !$this->looksLikeUuid((string)$id)) continue;
            $key = (string)$binding . '|' . $this->displayName($node);
            if (isset($seen[$key])) continue;
            $seen[$key] = true;
            $out[] = array(
                'binding_id' => $binding,
                'id' => $id,
                'label' => $this->displayName($node),
                'type' => (string)$this->firstValue($node, array('type','field_type','input_type','kind')),
                'option_list_id' => $this->firstValue($node, array('option_list_id','optionListId','options_id','list_id')),
                'text' => substr($text, 0, 220),
                'keys' => array_slice(array_keys($node), 0, 20)
            );
            if (count($out) >= 180) break;
        }
        return $out;
    }

    public function resourceFields() {
        // Die Workbench liefert Ressourcengruppen unter `resources.*` und die
        // tatsächlich uploadbaren Felder darunter als `resources.*.fields.*`.
        // Eine Gruppen-ID (z. B. resources.0.id) ist KEINE field_id und darf
        // niemals an /resources/upload gesendet werden.
        $rows = array();
        $leafRows = array();
        foreach ($this->resourceCandidates as $row) {
            if (!is_array($row) || !isset($row['field_id'])) continue;
            $path = isset($row['path']) ? (string)$row['path'] : '';
            if (preg_match('/^resources\.\d+\.fields\.\d+$/', $path)) {
                $leafRows[] = $row;
            }
        }

        // Wenn die Workbench ihre echten Ressourcenfelder explizit geliefert hat,
        // ist ausschließlich diese Liste autoritativ. Dynamic-Configuration und
        // Export werden dann nicht zur ID-Ermittlung herangezogen.
        $source = count($leafRows) ? $leafRows : $this->resourceCandidates;
        $byId = array();
        foreach ($source as $row) {
            if (!is_array($row) || !isset($row['field_id'])) continue;
            $path = isset($row['path']) ? (string)$row['path'] : '';
            // Sammlungs-/Gruppenknoten ausschließen. Diese haben zwar oft eine
            // numerische `id`, sind aber keine uploadbaren Ressourcenfelder.
            if (preg_match('/^(?:resources\.\d+|.*resource_groups\.\d+)$/', $path)) continue;
            $k = (string)$row['field_id'];
            if (!isset($byId[$k]) || intval($row['priority']) > intval($byId[$k]['priority'])) {
                $byId[$k] = $row;
            }
        }
        foreach ($byId as $row) $rows[] = $row;
        usort($rows, array($this, 'sortResourceCandidates'));
        return $rows;
    }

    public function resourceFieldsForUploadCount($count) {
        $count = intval($count);
        if ($count < 1) return array();
        $fields = $this->resourceFields();
        if (count($fields) < $count) {
            throw new Exception('Workbench liefert nur ' . count($fields) . ' uploadbare Ressourcenfelder, benötigt werden ' . $count . '.');
        }
        return array_slice($fields, 0, $count);
    }

    public function requiredResourceFields() {
        $out = array();
        foreach ($this->resourceFields() as $field) {
            if (!empty($field['is_required'])) $out[] = $field;
        }
        return $out;
    }

    public function resourceFieldDiagnostics() {
        $out = array();
        foreach ($this->resourceFields() as $row) {
            $out[] = array(
                'field_id' => $row['field_id'],
                'label' => isset($row['label']) ? $row['label'] : '',
                'binding_id' => isset($row['binding_id']) ? $row['binding_id'] : null,
                'source' => isset($row['source']) ? $row['source'] : '',
                'path' => isset($row['path']) ? $row['path'] : '',
                'priority' => isset($row['priority']) ? $row['priority'] : 0,
                'sort_order' => isset($row['sort_order']) ? $row['sort_order'] : null,
                'is_required' => !empty($row['is_required']),
                'accept' => isset($row['accept']) ? $row['accept'] : null,
                'max_mb' => isset($row['max_mb']) ? $row['max_mb'] : null
            );
        }
        return $out;
    }

    public function sortResourceCandidates($a, $b) {
        $pa = isset($a['priority']) ? intval($a['priority']) : 0;
        $pb = isset($b['priority']) ? intval($b['priority']) : 0;
        if ($pa !== $pb) return $pa > $pb ? -1 : 1;
        $sa = isset($a['sort_order']) && $a['sort_order'] !== null ? intval($a['sort_order']) : 999999;
        $sb = isset($b['sort_order']) && $b['sort_order'] !== null ? intval($b['sort_order']) : 999999;
        if ($sa !== $sb) return $sa < $sb ? -1 : 1;
        $ia = isset($a['field_id']) ? intval($a['field_id']) : 0;
        $ib = isset($b['field_id']) ? intval($b['field_id']) : 0;
        if ($ia === $ib) return 0;
        return $ia < $ib ? -1 : 1;
    }

    // Rückwärtskompatibel für alten Code/Diagnose. Uploads dürfen daraus aber
    // nicht mehr die binding_id verwenden; dafür ist resourceFields() zuständig.
    public function resourceBindings() {
        $out = array();
        foreach ($this->resourceFields() as $field) {
            if ($field['binding_id'] !== null) {
                $out[] = array('binding_id' => $field['binding_id'], 'label' => $field['label']);
            }
        }
        return $out;
    }

    public function primaryResourceFieldId() {
        $fields = $this->resourceFields();
        if (count($fields) === 0) return null;
        if (count($fields) === 1) return $fields[0]['field_id'];

        // Höchste Sicherheit zuerst: explizite field_id/resource_field_id aus einem
        // Ressourcen-/Upload-Knoten. Erst innerhalb derselben Priorität semantisch
        // nach Referenzfoto/Bild suchen. So wird niemals eine beliebige Knoten-ID
        // als Upload-field_id missverstanden.
        $highest = intval($fields[0]['priority']);
        $same = array();
        foreach ($fields as $field) {
            if (intval($field['priority']) === $highest) $same[] = $field;
        }
        if (count($same) === 1) return $same[0]['field_id'];

        $best = null;
        $bestScore = 0;
        $ties = 0;
        foreach ($same as $field) {
            $score = $this->termScore(strtolower($field['label'] . ' ' . $field['path']), array('referenz', 'reference', 'foto', 'photo', 'bild', 'image', 'upload'));
            if ($score > $bestScore) {
                $best = $field['field_id'];
                $bestScore = $score;
                $ties = 1;
            } else if ($score > 0 && $score === $bestScore) {
                $ties++;
            }
        }
        return ($bestScore > 0 && $ties === 1) ? $best : null;
    }

    public function sceneOptions() {
        return $this->optionsFor(array('bildszene', 'bild szene', 'szene', 'scene'));
    }

    /**
     * Ermittelt das echte Workbench-Binding eines Select-/Optionslistenfeldes.
     *
     * Wichtig bei BKI: Masterprompt-Abschnitte tragen ebenfalls UUID-IDs und koennen
     * semantisch genauso heissen wie ein dynamisches Eingabefeld (z. B. "SZENE").
     * Diese Abschnitts-UUID ist aber NICHT die Binding-ID des Selectfeldes.
     *
     * Die Workbench liefert fuer ausgewaehlte/aufgeloeste Optionswerte dagegen
     * `binding_id` + `option_list_id`. Diese Zuordnung ist fuer Selects autoritativ.
     */
    public function optionBindingFor($terms) {
        $list = $this->bestOptionListForTerms($terms);
        if (!$list) return null;

        $listId = $this->firstValue($list, array('id', 'option_list_id', 'optionListId', 'key'));
        $directListBinding = $this->bindingId($list);
        if ($directListBinding !== null && $directListBinding !== '') return $directListBinding;
        $options = $this->extractOptions($list);
        $optionTokens = array();
        foreach ($options as $opt) {
            if (!is_array($opt)) continue;
            foreach (array('value','label') as $k) {
                if (!isset($opt[$k])) continue;
                $t = strtolower(trim((string)$opt[$k]));
                if ($t !== '') $optionTokens[$t] = true;
            }
        }

        $scores = array();
        $meta = array();
        foreach ($this->nodes as $node) {
            if (!is_array($node)) continue;
            $binding = $this->bindingId($node);
            if ($binding === null || $binding === '') continue;

            $score = 0;
            $nodeListId = $this->firstValue($node, array('option_list_id', 'optionListId', 'options_id', 'list_id'));
            if ($listId !== null && $nodeListId !== null && (string)$nodeListId === (string)$listId) {
                $score += 1000;
            }

            // Zusaetzlicher robuster Fallback: ein aktueller Workbench-Wert traegt
            // oft das gleiche Label/Value wie ein Eintrag der passenden Optionsliste.
            $labels = array();
            foreach (array('value','template_value','templateValue','label','name','title','text') as $k) {
                if (isset($node[$k]) && !is_array($node[$k])) {
                    $t = strtolower(trim((string)$node[$k]));
                    if ($t !== '') $labels[$t] = true;
                }
            }
            foreach ($labels as $t => $unused) {
                if (isset($optionTokens[$t])) { $score += 200; break; }
            }

            if ($score <= 0) continue;
            // Numerische Bindings sind bei den BKI-Dynamic-Fields besonders stark:
            // z. B. option_list_id 410 -> binding_id 598 fuer "Bildszene".
            if ($this->numericFieldId($binding) !== null) $score += 50;

            $key = (string)$binding;
            if (!isset($scores[$key])) $scores[$key] = 0;
            $scores[$key] += $score;
            $meta[$key] = $binding;
        }

        if (!count($scores)) return null;
        arsort($scores, SORT_NUMERIC);
        $keys = array_keys($scores);
        $bestKey = $keys[0];
        $bestScore = $scores[$bestKey];
        if (isset($keys[1]) && $scores[$keys[1]] === $bestScore) return null;
        return isset($meta[$bestKey]) ? $meta[$bestKey] : $bestKey;
    }

    public function resolvedBindingFor($terms, $preferOptions) {
        if ($preferOptions) {
            $list = $this->bestOptionListForTerms($terms);
            $optionBinding = $this->optionBindingFor($terms);
            if ($optionBinding !== null && $optionBinding !== '') return $optionBinding;
            // Wenn fuer dieses semantische Feld eindeutig eine Optionsliste existiert,
            // niemals auf eine gleichnamige Masterprompt-Abschnitts-UUID zurueckfallen.
            // Lieber sauber "Binding fehlt" melden als einen falschen values-Key senden.
            if ($list && count($this->extractOptions($list))) return null;
        }
        return $this->bindingFor($terms);
    }

    public function bindingResolutionDiagnostics() {
        $defs = array(
            'height' => array(array('körpergröße', 'koerpergroesse', 'körpergröße cm', 'größe', 'groesse', 'height_cm', 'body height', 'height', 'cm'), false),
            'gender' => array(array('geschlecht', 'gender', 'sex', 'mann frau', 'mann', 'frau'), true),
            'clothing' => array(array('kleidungsstil', 'kleidung', 'outfit', 'clothing', 'wardrobe'), true),
            'image_style' => array(array('bildstil', 'fotostil', 'image_style', 'image style', 'photo style'), true),
            'location' => array(array('location-kategorie', 'location kategorie', 'location_category', 'ortskategorie', 'location'), true),
            'region' => array(array('region'), true),
            'scene' => array(array('bildszene', 'bild szene', 'scene', 'szene'), true)
        );
        $out = array();
        foreach ($defs as $name => $def) {
            $legacy = $this->bindingFor($def[0]);
            $option = $def[1] ? $this->optionBindingFor($def[0]) : null;
            $resolved = ($option !== null && $option !== '') ? $option : $legacy;
            $list = $def[1] ? $this->bestOptionListForTerms($def[0]) : null;
            $listId = $list ? $this->firstValue($list, array('id', 'option_list_id', 'optionListId', 'key')) : null;
            $out[$name] = array(
                'resolved' => $resolved,
                'option_binding' => $option,
                'legacy_binding' => $legacy,
                'option_list_id' => $listId,
                'source' => ($option !== null && $option !== '') ? 'option_list_binding' : 'semantic_workbench_binding'
            );
        }
        return $out;
    }

    public function filterScenesByLocation($options, $locationValue) {
        $hay = strtolower($locationValue);
        $prefix = '';
        if (strpos($hay, 'auß') !== false || strpos($hay, 'auss') !== false || strpos($hay, 'outdoor') !== false) $prefix = 'A';
        else if (strpos($hay, 'büro') !== false || strpos($hay, 'buero') !== false || strpos($hay, 'office') !== false) $prefix = 'B';
        else if (strpos($hay, 'kunde') !== false || strpos($hay, 'zuhause') !== false || strpos($hay, 'home') !== false) $prefix = 'C';
        else if (strpos($hay, 'objekt') !== false || strpos($hay, 'property') !== false || strpos($hay, 'immobil') !== false) $prefix = 'D';
        else if (strpos($hay, 'erweit') !== false || strpos($hay, 'advanced') !== false) $prefix = 'E';
        if (!$prefix) return $options;
        $filtered = array();
        foreach ($options as $opt) {
            $s = trim((string)$opt['label'] . ' ' . (string)$opt['value']);
            if (preg_match('/^' . preg_quote($prefix, '/') . '(?:[\s\-_.:0-9]|$)/i', $s)) {
                $filtered[] = $opt;
            }
        }
        return count($filtered) ? $filtered : $options;
    }

    public function snapshot() {
        return array(
            'bindings' => array(
                'height' => $this->resolvedBindingFor(array('körpergröße', 'koerpergroesse', 'körpergröße cm', 'größe', 'groesse', 'height_cm', 'body height', 'height', 'cm'), false),
                'gender' => $this->resolvedBindingFor(array('geschlecht', 'gender', 'sex', 'mann frau', 'mann', 'frau'), true),
                'clothing' => $this->resolvedBindingFor(array('kleidungsstil', 'kleidung', 'outfit', 'clothing', 'wardrobe'), true),
                'image_style' => $this->resolvedBindingFor(array('bildstil', 'fotostil', 'image_style', 'image style', 'photo style'), true),
                'location' => $this->resolvedBindingFor(array('location-kategorie', 'location kategorie', 'location_category', 'ortskategorie', 'location'), true),
                'region' => $this->resolvedBindingFor(array('region'), true),
                'scene' => $this->resolvedBindingFor(array('bildszene', 'bild szene', 'scene', 'szene'), true)
            ),
            'options' => array(
                'gender' => $this->optionsFor(array('geschlecht', 'gender', 'mann', 'frau')),
                'clothing' => $this->optionsFor(array('kleidung', 'kleidungsstil', 'outfit', 'clothing')),
                'image_style' => $this->optionsFor(array('bildstil', 'image style', 'fotostil')),
                'location' => $this->optionsFor(array('location-kategorie', 'location kategorie', 'location', 'ortskategorie')),
                'region' => $this->optionsFor(array('region')),
                'scene' => $this->sceneOptions()
            )
        );
    }

    private function unwrap($response) {
        if (is_array($response) && isset($response['data'])) return $response['data'];
        return is_array($response) ? $response : array();
    }

    private function collectNodes($value, $path) {
        if (!is_array($value)) return;
        if ($this->looksLikeNode($value)) $this->nodes[] = $value;
        $hint = $this->resourceHintFromNode($value, $path);
        if ($hint !== null) $this->resourceHints[] = $hint;
        $candidate = $this->resourceCandidateFromNode($value, $path);
        if ($candidate !== null) $this->resourceCandidates[] = $candidate;
        foreach ($value as $k => $v) {
            if (is_array($v)) {
                $nextPath = $path;
                $nextPath[] = (string)$k;
                $this->collectNodes($v, $nextPath);
            }
        }
    }

    private function bestOptionListForTerms($terms) {
        // Falls ein echtes Workbench-Feld bereits auf eine Optionsliste verweist,
        // diese Referenz zuerst verwenden.
        $field = $this->findField($terms);
        if ($field) {
            $listId = $this->firstValue($field, array('option_list_id', 'optionListId', 'options_id', 'list_id'));
            if ($listId !== null) {
                foreach ($this->lists as $list) {
                    $id = $this->firstValue($list, array('id', 'option_list_id', 'optionListId', 'key'));
                    if ($id !== null && (string)$id === (string)$listId) return $list;
                }
            }
        }

        // Sonst die semantisch passende Optionsliste nehmen (z. B. "Bildszene").
        $best = null;
        $bestScore = 0;
        foreach ($this->lists as $list) {
            $score = $this->termScore($this->nodeText($list), $terms);
            if ($score <= $bestScore) continue;
            $opts = $this->extractOptions($list);
            if (!count($opts)) continue;
            $best = $list;
            $bestScore = $score;
        }
        return $best;
    }

    private function collectOptionLists($value) {
        if (!is_array($value)) return;
        if ($this->looksLikeOptionList($value)) $this->lists[] = $value;
        foreach ($value as $v) {
            if (is_array($v)) $this->collectOptionLists($v);
        }
    }

    private function looksLikeNode($a) {
        return $this->bindingId($a) !== null ||
            $this->firstValue($a, array('field_id', 'fieldId', 'resource_field_id', 'resourceFieldId')) !== null ||
            isset($a['field']) || isset($a['resource_field']) || isset($a['resourceField']) ||
            isset($a['type']) || isset($a['field_type']) || isset($a['input_type']) || isset($a['resource_type']) ||
            isset($a['label']) || isset($a['name']) || isset($a['title']);
    }

    private function looksLikeOptionList($a) {
        return (isset($a['options']) || isset($a['items']) || isset($a['values'])) && (isset($a['name']) || isset($a['label']) || isset($a['id']) || isset($a['key']));
    }

    private function bindingNodeQuality($node, $binding) {
        $q = 0;
        foreach (array('binding_id', 'bindingId', 'field_binding_id', 'fieldBindingId', 'binding_uuid', 'bindingUuid') as $key) {
            if (isset($node[$key]) && !is_array($node[$key]) && $node[$key] !== '') { $q = 80; break; }
        }
        if ($q === 0) {
            foreach (array('binding', 'field_binding', 'fieldBinding') as $key) {
                if (isset($node[$key]) && is_array($node[$key])) { $q = 60; break; }
            }
        }
        if ($this->numericFieldId($binding) !== null) $q += 40;
        if ($this->firstValue($node, array('option_list_id','optionListId','options_id','list_id')) !== null) $q += 20;
        return $q;
    }

    private function bindingId($a) {
        // 1) Explizite skalare Binding-ID.
        $direct = $this->firstValue($a, array('binding_id', 'bindingId', 'field_binding_id', 'fieldBindingId', 'binding_uuid', 'bindingUuid'));
        if ($direct !== null) return $direct;

        // 2) Manche Workbench-Versionen kapseln das Binding als Objekt.
        foreach (array('binding', 'field_binding', 'fieldBinding') as $key) {
            if (!isset($a[$key]) || !is_array($a[$key])) continue;
            $nested = $a[$key];
            $v = $this->firstValue($nested, array('binding_id', 'bindingId', 'id', 'uuid', 'key', 'value'));
            if ($v !== null) return $v;
        }

        // 3) BKI kann dynamische Workbench-Felder selbst mit einer UUID unter `id`
        // ausliefern. Ressourcenfelder besitzen dagegen numerische IDs. Eine UUID-id
        // ist deshalb ein sicherer Fallback als Binding-ID für normale Eingabefelder.
        foreach (array('id', 'uuid', 'field_uuid', 'fieldUuid') as $key) {
            if (!isset($a[$key]) || is_array($a[$key])) continue;
            $v = trim((string)$a[$key]);
            if ($this->looksLikeUuid($v) && !$this->isResourceNode($a)) return $v;
        }
        return null;
    }

    private function looksLikeUuid($value) {
        return is_string($value) && preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', trim($value));
    }

    private function resourceFieldId($a) {
        // Alt-Kompatibilität: nur explizite Ressourcen-Feldschlüssel akzeptieren.
        foreach (array('field_id', 'fieldId', 'resource_field_id', 'resourceFieldId') as $key) {
            if (isset($a[$key]) && !is_array($a[$key])) {
                $id = $this->numericFieldId($a[$key]);
                if ($id !== null) return $id;
            }
        }
        return null;
    }

    private function resourceCandidateFromNode($node, $path) {
        if (!is_array($node)) return null;
        if ($this->resourceNodeUnavailable($node)) return null;

        $pathText = strtolower(implode('.', $path));
        $resourceContext = $this->isResourceNode($node) || $this->pathLooksLikeResourceField($pathText);
        if (!$resourceContext) return null;

        // 1) Sicherste Variante: die API liefert field_id/resource_field_id explizit.
        foreach (array('field_id', 'fieldId', 'resource_field_id', 'resourceFieldId') as $key) {
            if (!isset($node[$key]) || is_array($node[$key])) continue;
            $id = $this->numericFieldId($node[$key]);
            if ($id !== null) {
                return $this->makeResourceCandidate($id, $node, $pathText, $key, 100);
            }
        }

        // 2) Verschachtelte resource_field-Struktur. Eine normale field.id wird NICHT
        // mehr als Fallback verwendet, weil sie häufig eine andere Objekt-ID ist.
        foreach (array('resource_field', 'resourceField') as $key) {
            if (!isset($node[$key]) || !is_array($node[$key])) continue;
            $nested = $node[$key];
            foreach (array('field_id', 'fieldId', 'resource_field_id', 'resourceFieldId', 'id') as $nestedKey) {
                if (!isset($nested[$nestedKey]) || is_array($nested[$nestedKey])) continue;
                $id = $this->numericFieldId($nested[$nestedKey]);
                if ($id !== null) {
                    $merged = $node;
                    foreach ($nested as $nk => $nv) if (!isset($merged[$nk])) $merged[$nk] = $nv;
                    return $this->makeResourceCandidate($id, $merged, $pathText . '.' . $key, $key . '.' . $nestedKey, 95);
                }
            }
        }

        // 3) Viele BKI-Workbench-Versionen liefern ein Ressourcenfeld als normalen
        // Feldknoten mit numerischer `id`, z. B. {id: 123, type: "file", ...},
        // statt mit einem separaten `field_id`-Attribut. Eine solche generische id
        // ist nur zulässig, wenn der Knoten STRUKTURELL eindeutig ein Uploadfeld ist.
        // Damit bleibt z. B. ein Select-Feld "Bildstil" ausgeschlossen.
        if (!$this->looksLikeResourceInstance($node) && $this->isStrongResourceNode($node)) {
            if (isset($node['id']) && !is_array($node['id'])) {
                $id = $this->numericFieldId($node['id']);
                if ($id !== null) return $this->makeResourceCandidate($id, $node, $pathText, 'id@strong-resource-node', 92);
            }
            // Manche Antworten kapseln die eigentliche Felddefinition unter `field`.
            if (isset($node['field']) && is_array($node['field']) && isset($node['field']['id']) && !is_array($node['field']['id'])) {
                $id = $this->numericFieldId($node['field']['id']);
                if ($id !== null) {
                    $merged = $node;
                    foreach ($node['field'] as $nk => $nv) if (!isset($merged[$nk])) $merged[$nk] = $nv;
                    return $this->makeResourceCandidate($id, $merged, $pathText . '.field', 'field.id@strong-resource-node', 91);
                }
            }
        }

        // 4) Generische id innerhalb eindeutig benannter Ressourcen-Sammlungen.
        if ($this->pathLooksLikeResourceFieldCollection($pathText) && !$this->looksLikeResourceInstance($node)) {
            if (isset($node['id']) && !is_array($node['id'])) {
                $id = $this->numericFieldId($node['id']);
                if ($id !== null) return $this->makeResourceCandidate($id, $node, $pathText, 'id@resource-field-collection', 80);
            }
        }
        return null;
    }

    private function makeResourceCandidate($id, $node, $pathText, $source, $priority) {
        $required = false;
        foreach (array('is_required','required','isRequired') as $key) {
            if (isset($node[$key])) {
                $v = $node[$key];
                $required = ($v === true || $v === 1 || $v === '1' || strtolower((string)$v) === 'true');
                break;
            }
        }
        return array(
            'field_id' => $id,
            'binding_id' => $this->bindingId($node),
            'label' => $this->displayName($node),
            'source' => $source,
            'path' => $pathText,
            'priority' => $priority,
            'sort_order' => $this->numericFieldId($this->firstValue($node, array('sort_order','sortOrder','position','order'))),
            'is_required' => $required,
            'accept' => $this->firstValue($node, array('accept','allowed_mime','allowedMime','allowed_extensions','allowedExtensions')),
            'max_mb' => $this->firstValue($node, array('max_mb','maxMb','max_size_mb','maxSizeMb'))
        );
    }

    private function pathLooksLikeResourceField($pathText) {
        if ($pathText === '') return false;
        foreach (array('resource_field', 'resourcefield', 'upload_field', 'uploadfield', 'file_field', 'image_field', 'resource_input', 'resourceinput', 'upload_input', 'file_input') as $term) {
            if (strpos($pathText, $term) !== false) return true;
        }
        return false;
    }

    private function pathLooksLikeResourceFieldCollection($pathText) {
        foreach (array('resource_fields', 'resourcefields', 'upload_fields', 'uploadfields', 'file_fields', 'image_fields', 'resource_inputs', 'resourceinputs', 'upload_inputs', 'file_inputs', 'resources') as $term) {
            if (strpos($pathText, $term) !== false) return true;
        }
        return false;
    }

    private function looksLikeResourceInstance($node) {
        foreach (array('file_id','fileId','resource_id','resourceId','filename','file_name','mime_type','content_type','content_url','download_url') as $key) {
            if (isset($node[$key])) return true;
        }
        return false;
    }

    private function resourceNodeUnavailable($node) {
        foreach (array('available','enabled','writable','can_write','canWrite','editable','can_edit','canEdit') as $key) {
            if (isset($node[$key]) && ($node[$key] === false || $node[$key] === 0 || $node[$key] === '0')) return true;
        }
        foreach (array('read_only','readonly','readOnly','disabled') as $key) {
            if (isset($node[$key]) && ($node[$key] === true || $node[$key] === 1 || $node[$key] === '1')) return true;
        }
        return false;
    }

    private function numericFieldId($value) {
        if (is_int($value)) return $value > 0 ? $value : null;
        if (is_float($value) && floor($value) == $value && $value > 0) return intval($value);
        if (is_string($value)) {
            $value = trim($value);
            if ($value !== '' && preg_match('/^[0-9]+$/', $value)) {
                $id = intval($value);
                return $id > 0 ? $id : null;
            }
        }
        return null;
    }

    private function isStrongResourceNode($node) {
        if (!is_array($node)) return false;
        $type = strtolower(trim((string)$this->firstValue($node, array('type', 'field_type', 'kind', 'input_type', 'resource_type', 'widget', 'control_type'))));

        // Strukturell eindeutige Upload-/Dateitypen.
        foreach (array('resource', 'upload', 'file', 'attachment') as $term) {
            if ($type !== '' && strpos($type, $term) !== false) return true;
        }
        foreach (array('image_upload', 'image-upload', 'photo_upload', 'photo-upload', 'file_upload', 'file-upload', 'image_file', 'image-file') as $exact) {
            if ($type === $exact) return true;
        }
        // `image` allein kann in einer Workbench ebenfalls ein Upload-Control sein,
        // wird aber nur zusammen mit typischen Datei-Metadaten als stark gewertet.
        $hasUploadMeta = false;
        foreach (array('accept','max_files','maxFiles','multiple','allowed_mime','allowedMime','allowed_extensions','allowedExtensions','file_types','fileTypes','max_size','maxSize') as $key) {
            if (isset($node[$key])) { $hasUploadMeta = true; break; }
        }
        if ($hasUploadMeta) return true;
        if (($type === 'image' || $type === 'photo') && $hasUploadMeta) return true;
        return false;
    }

    private function resourceHintFromNode($node, $path) {
        if (!is_array($node) || $this->looksLikeResourceInstance($node)) return null;
        $pathText = strtolower(implode('.', $path));
        $strong = $this->isStrongResourceNode($node);
        $resourceish = $strong || $this->isResourceNode($node) || $this->pathLooksLikeResourceField($pathText) || $this->pathLooksLikeResourceFieldCollection($pathText);
        if (!$resourceish) return null;
        $id = null;
        foreach (array('field_id','fieldId','resource_field_id','resourceFieldId','id') as $k) {
            if (isset($node[$k]) && !is_array($node[$k])) {
                $id = $this->numericFieldId($node[$k]);
                if ($id !== null) break;
            }
        }
        return array(
            'id' => $id,
            'label' => $this->displayName($node),
            'type' => (string)$this->firstValue($node, array('type','field_type','kind','input_type','resource_type','widget','control_type')),
            'binding_id' => $this->bindingId($node),
            'path' => $pathText,
            'strong' => $strong ? true : false,
            'keys' => array_slice(array_keys($node), 0, 20)
        );
    }

    public function resourceFieldHints() {
        $out = array();
        $seen = array();
        foreach ($this->resourceHints as $row) {
            $key = (string)$row['id'] . '|' . $row['label'] . '|' . $row['path'];
            if (isset($seen[$key])) continue;
            $seen[$key] = true;
            $out[] = $row;
            if (count($out) >= 40) break;
        }
        return $out;
    }

    private function isResourceNode($node) {
        $type = strtolower((string)$this->firstValue($node, array('type', 'field_type', 'kind', 'input_type', 'resource_type')));
        $text = strtolower($this->nodeText($node));

        // Struktur/Typ ist deutlich zuverlässiger als Wörter wie "Bild". Ein normales
        // Select "Bildstil" darf niemals als Ressourcenfeld interpretiert werden.
        if (strpos($type, 'resource') !== false || strpos($type, 'upload') !== false || strpos($type, 'file') !== false || strpos($type, 'attachment') !== false) return true;
        if ($type === 'image' || $type === 'image_upload' || $type === 'image-upload' || $type === 'photo_upload') return true;

        foreach (array('accept','max_files','maxFiles','allowed_mime','allowedMime','allowed_extensions','allowedExtensions','file_types','fileTypes') as $key) {
            if (isset($node[$key])) return true;
        }

        // Semantischer Fallback nur mit starken Upload-/Referenz-Begriffen.
        foreach (array('referenzfoto','referenz foto','referenzbild','referenz bild','reference photo','reference image','datei upload','file upload','foto upload','photo upload','bild upload','image upload','ressourcenfeld','resource field') as $term) {
            if (strpos($text, $term) !== false) return true;
        }
        return false;
    }

    private function displayName($a) {
        $v = $this->firstValue($a, array('label', 'name', 'title', 'key'));
        return $v !== null ? (string)$v : 'Feld';
    }

    private function nodeText($a) {
        $parts = array();
        foreach (array('label', 'name', 'title', 'key', 'slug', 'description', 'placeholder', 'type', 'field_type', 'resource_type', 'variable', 'variable_name', 'variableName', 'field_name', 'fieldName', 'prompt_key', 'promptKey', 'binding_name', 'bindingName') as $k) {
            if (isset($a[$k]) && !is_array($a[$k])) $parts[] = (string)$a[$k];
        }
        return strtolower(implode(' ', $parts));
    }

    private function termScore($text, $terms) {
        $text = strtolower($text);
        $score = 0;
        foreach ($terms as $term) {
            $term = strtolower($term);
            if ($term !== '' && strpos($text, $term) !== false) $score += 10 + strlen($term);
        }
        return $score;
    }

    private function firstValue($a, $keys) {
        foreach ($keys as $k) {
            if (isset($a[$k]) && !is_array($a[$k]) && $a[$k] !== '') return $a[$k];
        }
        return null;
    }

    private function extractOptions($node) {
        foreach (array('options', 'items', 'values', 'choices') as $key) {
            if (isset($node[$key]) && is_array($node[$key])) {
                $out = $this->normalizeOptions($node[$key]);
                if (count($out)) return $out;
            }
        }
        return array();
    }

    private function normalizeOptions($items) {
        $out = array();
        foreach ($items as $k => $item) {
            if (is_array($item)) {
                $value = $this->firstValue($item, array('value', 'id', 'key', 'slug', 'code'));
                $label = $this->firstValue($item, array('label', 'name', 'title', 'text'));
                if ($value === null && $label === null) continue;
                if ($value === null) $value = $label;
                if ($label === null) $label = $value;
                $out[] = array('value' => (string)$value, 'label' => (string)$label);
            } else if (is_string($k) && !is_numeric($k)) {
                $out[] = array('value' => (string)$k, 'label' => (string)$item);
            } else if (is_scalar($item)) {
                $out[] = array('value' => (string)$item, 'label' => (string)$item);
            }
        }
        return $out;
    }
}
