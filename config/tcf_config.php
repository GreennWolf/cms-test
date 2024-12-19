<?php
declare(strict_types=1);

// Configuración básica
define('TCF_API_URL', 'http://localhost:3000/api/tcf');
define('TCF_ENABLED', true);
define('TCF_VERSION', 2);
define('TCF_CMP_ID', 12);
define('TCF_VENDOR_LIST_VERSION', '3');

// Configuración de directorios
define('TCF_LOG_DIR', dirname(__DIR__) . '/logs');
define('TCF_CACHE_DIR', dirname(__DIR__) . '/cache');

// Crear directorios si no existen
if (!file_exists(TCF_LOG_DIR)) {
    mkdir(TCF_LOG_DIR, 0755, true);
}
if (!file_exists(TCF_CACHE_DIR)) {
    mkdir(TCF_CACHE_DIR, 0755, true);
}

// Configuración de errores
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('error_log', TCF_LOG_DIR . '/tcf_errors.log');

// Configuración CORS
define('TCF_ALLOWED_ORIGINS', [
    'http://localhost:3000',
    'https://tu-dominio.com'
]);

// Función helper para CORS
function configureCORS() {
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '*';
    if ($origin !== '*' && !in_array($origin, TCF_ALLOWED_ORIGINS)) {
        $origin = '*';
    }
    
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
}

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'CM\\';
    $base_dir = dirname(__DIR__) . '/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});