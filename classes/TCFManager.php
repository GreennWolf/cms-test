<?php
// cm/classes/TCFManager.php
declare(strict_types=1);

namespace CM\Classes;

class TCFManager {
    private $db;
    private $apiUrl;
    private $cacheDir;
    
    public function __construct() {
        $this->initializeDirectories();
        $this->db = $this->initializeDatabase();
        $this->apiUrl = defined('TCF_API_URL') ? TCF_API_URL : 'http://localhost:3000/api/tcf';
    }
    
    private function initializeDirectories(): void {
        $dirs = ['../cache', '../logs'];
        foreach ($dirs as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
        }
        $this->cacheDir = realpath('../cache');
    }
    
    private function initializeDatabase() {
        try {
            $dbPath = '../db/consentsdb';
            if (!file_exists(dirname($dbPath))) {
                mkdir(dirname($dbPath), 0755, true);
            }
            
            $db = new \SQLite3($dbPath);
            
            // Crear tabla si no existe
            $db->exec('
                CREATE TABLE IF NOT EXISTS consents (
                    token VARCHAR(255) PRIMARY KEY,
                    tc_string TEXT,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ');
            
            return $db;
        } catch (\Exception $e) {
            error_log("Database initialization error: " . $e->getMessage());
            throw new \RuntimeException("Could not initialize database");
        }
    }

    public function validateAndStoreTCString(string $token, string $tcString): bool {
        try {
            // Validar con la API de Node
            $validation = $this->validateTCString($tcString);
            if (!$validation['success']) {
                return false;
            }
            
            // Actualizar en la base de datos
            $stmt = $this->db->prepare('
                INSERT OR REPLACE INTO consents (token, tc_string, updated_at) 
                VALUES (:token, :tc_string, CURRENT_TIMESTAMP)
            ');
            $stmt->bindValue(':token', $token, SQLITE3_TEXT);
            $stmt->bindValue(':tc_string', $tcString, SQLITE3_TEXT);
            return $stmt->execute() !== false;
        } catch (\Exception $e) {
            error_log("TCF Validation Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getConsentStatus(string $token): ?array {
        try {
            $stmt = $this->db->prepare('
                SELECT tc_string, created_at, updated_at 
                FROM consents 
                WHERE token = :token
            ');
            $stmt->bindValue(':token', $token, SQLITE3_TEXT);
            $result = $stmt->execute();
            $row = $result->fetchArray(SQLITE3_ASSOC);
            return $row ?: null;
        } catch (\Exception $e) {
            error_log("Error getting consent status: " . $e->getMessage());
            return null;
        }
    }
    
    private function validateTCString(string $tcString): array {
        try {
            $ch = curl_init($this->apiUrl . '/validate');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode(['tc_string' => $tcString]),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_TIMEOUT => 5
            ]);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($error || $httpCode !== 200) {
                throw new \RuntimeException("API request failed: $error");
            }
            
            return json_decode($response, true) ?: ['success' => false];
        } catch (\Exception $e) {
            error_log("TCF API Error: " . $e->getMessage());
            return ['success' => false];
        }
    }
    
    public function cacheVendorList(int $ttl = 86400): ?array {
        try {
            $cacheFile = $this->cacheDir . '/vendor_list.json';
            
            if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
                return json_decode(file_get_contents($cacheFile), true);
            }
            
            $ch = curl_init($this->apiUrl . '/vendor-list');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5
            ]);
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            if ($response) {
                file_put_contents($cacheFile, $response);
                return json_decode($response, true);
            }
            
            return null;
        } catch (\Exception $e) {
            error_log("Vendor list cache error: " . $e->getMessage());
            return null;
        }
    }
}