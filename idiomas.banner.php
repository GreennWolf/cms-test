<?php
echo "Banner 1: Inicio del archivo<br>";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "Banner 2: Después de session<br>";

ini_set('display_errors', TRUE);
error_reporting(E_ALL);
echo "Banner 3: Después de configurar errores<br>";

include_once('funciones.php');
echo "Banner 4: Después de funciones<br>";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
echo "Banner 5: Después de headers<br>";

if (!isset($_SESSION['idioma'])) { 
    $_SESSION['idioma'] = 'es'; 
}
echo "Banner 6: Después de check idioma<br>";

// Obtener idiomas disponibles de la base de datos
try {
    echo "Banner 7: Antes de SQLite<br>";
    
    // Verificar la existencia de la base de datos
    $dbPath = 'db/idiomasdb';
    if (!file_exists($dbPath)) {
        throw new Exception("Base de datos no encontrada en: " . $dbPath);
    }

    $idiomas = new SQLite3($dbPath);
    echo "Banner 8: Después de conexión SQLite<br>";
    
    // Verificar que la tabla existe
    $checkTable = $idiomas->querySingle("SELECT count(*) FROM sqlite_master WHERE type='table' AND name='idiomas'");
    if (!$checkTable) {
        throw new Exception("La tabla 'idiomas' no existe en la base de datos");
    }

    // Preparar y ejecutar la consulta
    echo "Banner 9: Antes de query<br>";
    $stmt = $idiomas->prepare("SELECT * FROM idiomas WHERE estado = :estado");
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $idiomas->lastErrorMsg());
    }
    
    $stmt->bindValue(':estado', 'on', SQLITE3_TEXT);
    $resultado = $stmt->execute();
    echo "Banner 10: Después de query<br>";
    
    if (!$resultado) {
        throw new Exception("Error ejecutando la consulta: " . $idiomas->lastErrorMsg());
    }
    
    $idiomasDisponibles = [];
    while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
        $idiomasDisponibles[] = $row;
    }
    echo "Banner 11: Después de fetch<br>";
    
    $idiomas->close();
} catch (Exception $e) {
    echo "Error en Banner: " . $e->getMessage() . "<br>";
    error_log("Error en idiomas.banner.php: " . $e->getMessage());
    $idiomasDisponibles = [];
}

// Selector de idiomas
echo "Banner 12: Antes del HTML<br>";
?>
<div id="idiomas-selector">
    <iframe src="blank.html" style="display:none;" id="jajasIdiomas" name="jajasIdiomas"></iframe>
    
    <img src="idiomas.png" 
         style="position:fixed;top:5px;right:10px;z-index:999999;cursor:help;height:20px;"
         onclick="window.open('idiomas.ajax.php','jajasIdiomas');"
         alt="Selector de idiomas">
</div>

<?php echo "Banner 13: Antes del script<br>"; ?>
<script>
// Funciones de manejo de cookies
function saveCookieCM21(nombre, valor) {
    document.cookie = `${nombre}=${valor}; expires=Thu, 18 Dec 2999 12:00:00 UTC; path=/`;
}

function getCookie(cname) {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// Función de validación de idioma
function idiomavalidocm21(idioma) {
    let devolucion;
    <?php 
    echo "Banner 14: Dentro de idiomavalidocm21<br>";
    if (!empty($idiomasDisponibles)): 
        foreach ($idiomasDisponibles as $idiomaInfo): 
            if (!empty($idiomaInfo['cabeceras'])):
                $cabeceras = explode(',', $idiomaInfo['cabeceras']);
                foreach ($cabeceras as $cabecera): 
                    if (trim($cabecera)): ?>
                    if (idioma === '<?php echo addslashes(trim($cabecera)); ?>') {
                        devolucion = '<?php echo addslashes($idiomaInfo['idioma']); ?>';
                    }
                    <?php endif; 
                endforeach;
            endif; ?>
            
            if (idioma === '<?php echo addslashes($idiomaInfo['idioma']); ?>') {
                devolucion = idioma;
            }
        <?php endforeach;
    endif; ?>
    
    return devolucion || false;
}

// Función de comprobación de idioma
function c21_comprueba_idioma_final() {
    let browserLang = getCookie('c21_idioma');
    
    if (!browserLang) {
        browserLang = window.navigator.userLanguage || window.navigator.language;
        browserLang = idiomavalidocm21(browserLang);
        
        if (!browserLang) {
            browserLang = '<?php echo $_SESSION['idioma']; ?>' || 'es';
        }
        
        if (browserLang !== '<?php echo $_SESSION['idioma']; ?>' && !getCookie('c21_idioma_auto_detected')) {
            saveCookieCM21('c21_idioma_auto_detected', browserLang);
            saveCookieCM21('c21_idioma', browserLang);
            
            const iframe = document.getElementById('jajasIdiomas');
            if (iframe) {
                iframe.src = `idiomas.ajax.php?auto=${Date.now()}&cambia=${browserLang}`;
            }
            
            const loadingImg = document.createElement('img');
            loadingImg.src = 'ajax-loader.gif';
            document.body.insertBefore(loadingImg, document.body.firstChild);
        }
    }
}

// Inicializar comprobación de idioma cuando la página cargue
window.addEventListener("load", function() {
    if (!getCookie('c21_idioma_auto_detected')) {
        c21_comprueba_idioma_final();
    }
}, false);
</script>
<?php echo "Banner 15: Final del archivo<br>"; ?>