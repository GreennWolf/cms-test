<?php
// NO iniciamos sesión aquí ya que se inicia en los archivos que incluyen este
if (!isset($_SESSION['idioma'])) { 
    $_SESSION['idioma'] = 'es'; 
}

/**
 * Obtiene información de un proveedor IAB
 */
function iabInfoProvider($id) {
    if (!$id) {
        return false;
    }

    try {
        if (@file_exists('db/proveedoresiabdb')) {
            $db = new SQLite3('db/proveedoresiabdb');
        } else if (@file_exists('../db/proveedoresiabdb')) {
            $db = new SQLite3('../db/proveedoresiabdb');
        } else {
            $db = new SQLite3('../../db/proveedoresiabdb');
        }
            
        $q = "SELECT * FROM proveedoresiab WHERE id LIKE '".$id."'";
        
        $resultado = $db->query($q);
        
        $fetchn = false;
        while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
            $fetchn = $row;
        }
        return $fetchn;
    
    } catch (Exception $e) {
        error_log("Error en iabInfoProvider: " . $e->getMessage());
        return false;
    }
}

/**
 * Obtiene información de un proveedor Google
 */
function googleInfoProvider($id) {
    if (!$id) {
        return false;
    }

    try {
        if (@file_exists('db/proveedoresgoogledb')) {
            $db = new SQLite3('db/proveedoresgoogledb');
        } else if (@file_exists('../db/proveedoresgoogledb')) {
            $db = new SQLite3('../db/proveedoresgoogledb');
        } else {
            $db = new SQLite3('../../db/proveedoresgoogledb');
        }
            
        $q = "SELECT * FROM proveedoresgoogle WHERE id LIKE '".$id."'";
        
        $resultado = $db->query($q);
        
        $fetchn = false;
        while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
            $fetchn = $row;
        }
        return $fetchn;
    
    } catch (Exception $e) {
        error_log("Error en googleInfoProvider: " . $e->getMessage());
        return false;
    }
}

/**
 * Extrae información de una cookie
 */
function extraeinfocookie($id, $idioma=false) {
    if (!$id) { 
        return 'error db cookie id'; 
    }
    if (!$idioma) { 
        $idioma = $_SESSION['idioma']; 
    }

    try {
        if(file_exists('db/cookiesdb')) { 
            $db = new SQLite3('db/cookiesdb'); 
        } else { 
            $db = new SQLite3('../db/cookiesdb'); 
        }
        
        $q = "SELECT info FROM cookies WHERE nombre LIKE '".$id."' AND idioma LIKE '".$idioma."' ";
                
        $cookieinfo = false;
        if($resultado = $db->query($q)) {
            while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
                $cookieinfo[] = $row;
            }
        }
        
        return $cookieinfo[0]['info'];
    } catch (Exception $e) {
        error_log("Error en extraeinfocookie: " . $e->getMessage());
        return 'error al obtener información de cookie';
    }
}

/**
 * Extrae valor de idioma
 */
function extraevaloridioma($id, $idioma=false) {
    if (!$id) { 
        return 'error db idioma'; 
    }
    if (!$idioma) { 
        $idioma = $_SESSION['idioma']; 
    }

    try {
        if(file_exists('db/idiomadb')) { 
            $db = new SQLite3('db/idiomadb'); 
        } else { 
            $db = new SQLite3('../db/idiomadb'); 
        }
        
        $q = "SELECT valor FROM idioma WHERE id LIKE '".$id."' AND idioma LIKE '".$idioma."' ";
                
        $idiomadb = false;
        if($resultado = $db->query($q)) {
            while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
                $idiomadb[] = $row;
            }
        }
        
        if ( $idiomadb[0]['valor'] || TRUE ) {
            return $idiomadb[0]['valor'];
        }
        
        return $id;
    } catch (Exception $e) {
        error_log("Error en extraevaloridioma: " . $e->getMessage());
        return $id;
    }
}

/**
 * Funciones de compatibilidad para versiones antiguas de PHP
 */
if(!function_exists('ereg')) { 
    function ereg($pattern, $subject, &$matches = array()) { 
        return preg_match('/'.$pattern.'/', $subject, $matches); 
    } 
}
if(!function_exists('eregi')) { 
    function eregi($pattern, $subject, &$matches = array()) { 
        return preg_match('/'.$pattern.'/i', $subject, $matches); 
    } 
}
if(!function_exists('ereg_replace')) { 
    function ereg_replace($pattern, $replacement, $string) { 
        return preg_replace('/'.$pattern.'/', $replacement, $string); 
    } 
}
if(!function_exists('eregi_replace')) { 
    function eregi_replace($pattern, $replacement, $string) { 
        return preg_replace('/'.$pattern.'/i', $replacement, $string); 
    } 
}
if(!function_exists('split')) { 
    function split($pattern, $subject, $limit = -1) { 
        return preg_split('/'.$pattern.'/', $subject, $limit); 
    } 
}
if(!function_exists('spliti')) { 
    function spliti($pattern, $subject, $limit = -1) { 
        return preg_split('/'.$pattern.'/i', $subject, $limit); 
    } 
}

/**
 * Limpieza de strings
 */
function borraSaltos($str) {
    $str = str_replace("\n", ' ', $str);
    $str = str_replace("\r", ' ', $str);
    $str = str_replace("\n", ' ', $str);
    $str = str_replace("\r", ' ', $str);
    
    return $str;
}

function limpia($str) {
    $str = borraSaltos($str);
    $str = str_replace("'", "\'", $str);
    $str = str_replace("`", "'", $str);
    
    return $str;
}

// Agregar a funciones.php
function getTCString($token) {
    $db = new SQLite3('db/consentsdb');
    $stmt = $db->prepare('SELECT tc_string FROM consents WHERE token = ?');
    $stmt->bindValue(1, $token);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    return $row ? $row['tc_string'] : null;
}

function validateTCFConsent($consentData) {
    if (!TCF_API_ENABLED) return true;
    
    try {
        return processTCFConsent($consentData) !== false;
    } catch (Exception $e) {
        error_log("TCF validation error: " . $e->getMessage());
        return false;
    }
}
?>