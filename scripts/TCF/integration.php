// cm/scripts/TCF/integration.php
<?php
declare(strict_types=1);

class TCFIntegration {
    private $tcfManager;
    private $db;
    
    public function __construct() {
        $this->db = new SQLite3('../db/consentsdb');
        $this->tcfManager = new TCFManager();
    }
    
    // Función para sincronizar el consentimiento existente con TCF
    public function syncConsent($token) {
        $currentConsent = $this->getConsentStatus($token);
        if (!$currentConsent) {
            return false;
        }

        return $this->tcfManager->updateTCFConsent([
            'token' => $token,
            'analytics_consent' => $currentConsent['analytics'] === 'checked',
            'marketing_consent' => $currentConsent['pubCookies'] === 'checked',
            'purposes' => $this->getPurposesFromConsent($currentConsent)
        ]);
    }

    private function getPurposesFromConsent($consent) {
        return [
            'essential' => true,
            'analytics' => $consent['analytics'] === 'checked',
            'marketing' => $consent['pubCookies'] === 'checked',
            'personalization' => $consent['persCookies'] === 'checked'
        ];
    }
}