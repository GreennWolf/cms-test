// cm/includes/tcf_middleware.php
<?php
declare(strict_types=1);

require_once(dirname(__DIR__) . '/config/tcf_config.php');

function checkTCFConsent(string $token): bool {
    try {
        $tcfManager = new \CM\Classes\TCFManager();
        $consent = $tcfManager->getConsentStatus($token);
        
        if (!$consent || empty($consent['tc_string'])) {
            return false;
        }
        
        // Verificar si el consentimiento está actualizado (menos de 6 meses)
        $updatedAt = strtotime($consent['updated_at']);
        $sixMonthsAgo = strtotime('-6 months');
        
        return $updatedAt > $sixMonthsAgo;
    } catch (\Exception $e) {
        error_log("TCF Middleware Error: " . $e->getMessage());
        return false;
    }
}

function requireTCFConsent(): void {
    $token = $_COOKIE['tcf_token'] ?? null;
    
    if (!$token || !checkTCFConsent($token)) {
        header('Location: /consent.php');
        exit;
    }
}