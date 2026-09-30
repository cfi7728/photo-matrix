<?php
class PromptValidation {
    public static function payload($provider, $values, $draftKey) {
        return array(
            'provider' => $provider,
            'values' => count($values) ? (object)$values : new stdClass(),
            'section_texts' => new stdClass(),
            'draft_key' => $draftKey
        );
    }

    public static function assertValid($response, $context) {
        $prompt = isset($response['data']['prompt']) && is_array($response['data']['prompt'])
            ? $response['data']['prompt']
            : null;
        if ($prompt === null || !array_key_exists('valid', $prompt)) {
            throw new Exception($context . ': BKI-Promptprüfung lieferte kein eindeutiges data.prompt.valid.');
        }
        if ($prompt['valid'] !== false) return;

        $details = BkiClient::validationErrorDetails(isset($prompt['errors']) ? $prompt['errors'] : array());
        $message = $context . ': Prompt ist ungültig';
        if (count($details)) $message .= ' – ' . implode(' | ', $details);
        throw new Exception($message . '.');
    }
}
