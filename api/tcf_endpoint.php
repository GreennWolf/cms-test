<?php
declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once('../config/tcf_config.php');

class TCFEndpoint {
    private $db;
    
    public function __construct() {
        $this->db = new SQLite3('../db/consentsdb');
        $this->setupDatabase();
    }

    private function setupDatabase() {
        // Asegurarse de que las nuevas columnas existen
        $columns = [
            'tc_string' => 'TEXT',
            'consent_data' => 'TEXT',
            'updated_at' => 'TEXT',
            'purposes' => 'TEXT'
        ];
        
        foreach ($columns as $column => $type) {
            try {
                $this->db->exec("ALTER TABLE consents ADD COLUMN IF NOT EXISTS $column $type");
            } catch (Exception $e) {
                // La columna probablemente ya existe
            }
        }
    }

    public function handleRequest() {
        try {
            configureCORS();
            
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    return $this->handlePost();
                case 'GET':
                    return $this->handleGet();
                case 'OPTIONS':
                    return ['success' => true];
                default:
                    throw new Exception('Method not allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function handlePost() {
        $input = json_decode(file_get_contents('php://input'), true);
        $token = $_REQUEST['token'] ?? null;

        if (!$token) {
            throw new Exception('Token is required', 400);
        }

        if (empty($input)) {
            throw new Exception('Invalid request body', 400);
        }

        if (!$this->validateConsent($input)) {
            throw new Exception('Invalid consent data', 400);
        }

        if ($this->updateExistingConsent($token, $input)) {
            return [
                'success' => true,
                'message' => 'Consent saved successfully'
            ];
        }

        throw new Exception('Failed to save consent', 500);
    }

    private function handleGet() {
        $token = $_REQUEST['token'] ?? null;
        
        if (!$token) {
            throw new Exception('Token is required', 400);
        }

        $stmt = $this->db->prepare('
            SELECT tc_string, consent_data, purposes, updated_at
            FROM consents 
            WHERE token = :token
        ');
        $stmt->bindValue(':token', $token, SQLITE3_TEXT);
        $result = $stmt->execute();
        
        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            return [
                'success' => true,
                'data' => [
                    'tc_string' => $row['tc_string'],
                    'purposes' => json_decode($row['purposes'], true),
                    'consent_data' => json_decode($row['consent_data'], true),
                    'updated_at' => $row['updated_at']
                ]
            ];
        }

        return [
            'success' => false,
            'error' => 'No consent found for token'
        ];
    }

    private function updateExistingConsent($token, $consentData) {
        $stmt = $this->db->prepare('
            UPDATE consents 
            SET analytics = :analytics,
                gads = :gads,
                gtag = :gtag,
                tc_string = :tc_string,
                consent_data = :consent_data,
                purposes = :purposes,
                updated_at = CURRENT_TIMESTAMP
            WHERE token = :token
        ');

        $analytics = $consentData['purposes'][2] ?? false ? 'checked' : '';
        $marketing = $consentData['purposes'][3] ?? false ? 'checked' : '';
        
        $stmt->bindValue(':analytics', $analytics, SQLITE3_TEXT);
        $stmt->bindValue(':gads', $marketing, SQLITE3_TEXT);
        $stmt->bindValue(':gtag', $marketing, SQLITE3_TEXT);
        $stmt->bindValue(':tc_string', $consentData['tc_string'] ?? '', SQLITE3_TEXT);
        $stmt->bindValue(':consent_data', json_encode($consentData), SQLITE3_TEXT);
        $stmt->bindValue(':purposes', json_encode($consentData['purposes'] ?? []), SQLITE3_TEXT);
        $stmt->bindValue(':token', $token, SQLITE3_TEXT);
        
        return $stmt->execute();
    }

    private function validateConsent($consentData) {
        // Validar propósitos requeridos
        if (!isset($consentData['purposes']) || !is_array($consentData['purposes'])) {
            return false;
        }

        $requiredPurposes = [1]; // Propósito 1 es obligatorio
        foreach ($requiredPurposes as $purpose) {
            if (!isset($consentData['purposes'][$purpose]) || 
                !$consentData['purposes'][$purpose]) {
                return false;
            }
        }

        return true;
    }
}

$endpoint = new TCFEndpoint();
echo json_encode($endpoint->handleRequest());