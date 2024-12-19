<?php
// gdpr-validator.php
ini_set('display_errors', FALSE);
session_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Configuración del servidor Node.js
$NODE_SERVER = 'http://localhost:3000/api/gdpr';

/**
 * Función para hacer peticiones al servidor Node
 */
function callNodeServer($endpoint, $data) {
    global $NODE_SERVER;
    
    $ch = curl_init($NODE_SERVER . $endpoint);
    
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json'
        ]
    ];
    
    curl_setopt_array($ch, $options);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        error_log('Error en llamada a Node: ' . curl_error($ch));
        return [
            'success' => false,
            'error' => curl_error($ch)
        ];
    }
    
    curl_close($ch);
    
    return [
        'success' => $httpCode === 200,
        'data' => json_decode($response, true)
    ];
}

// Obtener datos de la petición
$requestData = json_decode(file_get_contents('php://input'), true);

// Validar que tenemos los datos necesarios
if (!isset($requestData['tcString'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'TC string is required'
    ]);
    exit;
}

// Si hay un token, obtener datos del consent
if (isset($requestData['token'])) {
    try {
        $db = new SQLite3('db/consentsdb');
        $stmt = $db->prepare('SELECT * FROM consents WHERE token = :token');
        $stmt->bindValue(':token', $requestData['token'], SQLITE3_TEXT);
        $result = $stmt->execute();
        $consentData = $result->fetchArray(SQLITE3_ASSOC);
        $db->close();
    } catch (Exception $e) {
        error_log('Error accediendo a la base de datos: ' . $e->getMessage());
        $consentData = null;
    }
}

// Preparar datos para enviar al servidor Node.js
$validationData = [
    'tcString' => $requestData['tcString'],
    'token' => $requestData['token'] ?? null,
    'consentData' => $consentData ?? null
];

// Llamar al servidor Node.js para validar
$validation = callNodeServer('/validate', $validationData);

// Si la validación es exitosa y tenemos un token, actualizar la base de datos
if ($validation['success'] && isset($requestData['token']) && isset($validation['data'])) {
    try {
        $db = new SQLite3('db/consentsdb');
        
        $updateQuery = 'UPDATE consents SET 
            last_consent_string = :tcString,
            last_consent_timestamp = :timestamp
            WHERE token = :token';
            
        $stmt = $db->prepare($updateQuery);
        $stmt->bindValue(':tcString', $requestData['tcString'], SQLITE3_TEXT);
        $stmt->bindValue(':timestamp', date('Y-m-d H:i:s'), SQLITE3_TEXT);
        $stmt->bindValue(':token', $requestData['token'], SQLITE3_TEXT);
        
        if (!$stmt->execute()) {
            error_log('Error actualizando consent en DB: ' . $db->lastErrorMsg());
        }
        
        $db->close();
    } catch (Exception $e) {
        error_log('Error actualizando base de datos: ' . $e->getMessage());
    }
}

// Devolver el resultado
echo json_encode($validation);
?>