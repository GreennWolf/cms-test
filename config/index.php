<?php
header('Content-Type: application/javascript');
include_once('../funciones.php');
require_once('tcf_config.php');
?>
// JavaScript Document
var cm21config = 'loaded';

<?php
    $db = new SQLite3('../db/consentsdb');
    $q = "SELECT * FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
    $resultado = $db->query($q);
    
    while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
        $fetch = $row;
    }
    
    if (!$fetch['token']) { exit(); }
    
    if ($fetch['gtag']) {
        $_REQUEST['GTM'] = $fetch['gtag'];
    }
    
    if ($fetch['analytics']) {
        $_REQUEST['analytics'] = $fetch['analytics'];
    }
    
    if (!$fetch['link']) {
        $fetch['link'] = 'https://cookie21.com';
    }
?>

// Configuración TCF
const TCF_CONFIG = {
    apiUrl: '<?php echo TCF_API_URL; ?>',
    enabled: <?php echo TCF_API_ENABLED ? 'true' : 'false'; ?>,
    cmpId: <?php echo defined('TCF_CMP_ID') ? TCF_CMP_ID : 12; ?>
};

// Funciones TCF
async function processTCFConsent(consentData) {
    if (!TCF_CONFIG.enabled) return { success: true, tcString: 'MOCK_TC_STRING' };

    try {
        // Validar consentimiento
        const validationResponse = await fetch(`${TCF_CONFIG.apiUrl}/validate`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(consentData)
        });
        const validation = await validationResponse.json();
        
        if (!validation.success || !validation.isValid) {
            console.error('TCF validation failed:', validation.errors);
            return { success: false };
        }

        // Generar TC string
        const tcStringResponse = await fetch(`${TCF_CONFIG.apiUrl}/generate`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(consentData)
        });
        const tcString = await tcStringResponse.json();

        return tcString;
    } catch (error) {
        console.error('TCF processing error:', error);
        return { success: false };
    }
}

// Función original modificada para incluir TCF
async function aceptarCM21(modo) {
    if (!modo) modo = calculacookies();
    if (!modo) modo = getCookie("c21cm_cookie_consent");
    if (!modo) modo = '3';

    // Preparar datos para TCF
    const consentData = {
        domain: window.location.hostname,
        purpose1_consent: true,
        purpose2_consent: modo >= 1,
        purpose3_consent: modo >= 2,
        user_ip: '<?php echo $_SERVER['REMOTE_ADDR']; ?>',
        consent_timestamp: new Date().toISOString()
    };

    // Procesar con TCF
    const tcfResult = await processTCFConsent(consentData);
    if (tcfResult.success) {
        saveCookieCM21('tc_string', tcfResult.tcString);
    }

    // Resto del código original de aceptarCM21...
}

// Cargar scripts necesarios
if (typeof cm21funciones !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {
    document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/funciones.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
}

if (typeof cm21idiomas !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {
    document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/idiomas.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
}

// Funciones de cookies y utilidades
if (!window.getCookie) {
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
}

function changeLanguage(idioma) {
    saveCookieCM21('c21_idioma', idioma);
}

function infoCookiesCM21F() {
    var infoCookiesCM21 = '<?php echo borraSaltos(file_get_contents('../inner/info.cookies.html')); ?>';
    
    infoCookiesCM21 = infoCookiesCM21.replace('{idioma_utilizamos_cookies}',cadenaTrad('idioma_utilizamos_cookies'));
    infoCookiesCM21 = infoCookiesCM21.replace('{idioma_puede_aceptar_o_rechazar}',cadenaTrad('idioma_puede_aceptar_o_rechazar'));
    infoCookiesCM21 = infoCookiesCM21.replace('{idioma_una_cookie_es}',cadenaTrad('idioma_una_cookie_es'));
    infoCookiesCM21 = infoCookiesCM21.replace('{idioma_cookie_y_propositos}',cadenaTrad('idioma_cookie_y_propositos'));
    
    return infoCookiesCM21;
}

function montac21cmconfig() {
    var c21cmconfig = {
        gaid: '<?php echo $_REQUEST['analytics']; ?>',
        tcfEnabled: TCF_CONFIG.enabled
    }
    return c21cmconfig;
}

var c21cmconfig = montac21cmconfig();