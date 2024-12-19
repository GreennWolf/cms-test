<?php
declare(strict_types=1);

require_once('../config/tcf_config.php');

header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

// Verificar método de solicitud
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

try {
    $tcfManager = new \CM\Classes\TCFManager();
    
    // Obtener y validar datos de entrada
    $input = json_decode(file_get_contents('php://input'), true);
    $token = $_REQUEST['token'] ?? null;
    
    if (!$token || !isset($input['tc_string'])) {
        throw new \InvalidArgumentException('Missing required data');
    }
    
    // Procesar el consentimiento
    if ($tcfManager->validateAndStoreTCString($token, $input['tc_string'])) {
        echo json_encode([
            'success' => true,
            'data' => [
                'token' => $token,
                'timestamp' => date('c')
            ]
        ]);
    } else {
        throw new \RuntimeException('Failed to process consent');
    }

} catch (\Exception $e) {
    error_log("TCF Handler Error: {$e->getMessage()}");
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}