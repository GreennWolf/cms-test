<?php
@header('Content-Type: application/javascript; charset=utf-8');
date_default_timezone_set('Europe/Madrid');
session_start();

if (!$_SESSION['idioma']) {
    $_SESSION['idioma'] = 'es';
}

include_once('../funciones.php');

$db = new SQLite3('../db/consentsdb');
$q = "SELECT * FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
$resultado = $db->query($q);

while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
    $fetch = $row;
}
?>

//JavaScript document
var cm21funciones = 'loaded';

// Configuración TCF
const TCF_CONFIG = {
    API_URL: 'http://localhost:3000/api/tcf',
    VERSION: 2,
    CMP_ID: 12,
    CMP_VERSION: 1,
    VENDOR_LIST_VERSION: '1',
    RETRY_ATTEMPTS: 3,
    RETRY_DELAY: 1000
};

// Clase TCF Manager
class TCFManager {
    constructor() {
        this.config = TCF_CONFIG;
        this.initialized = false;
        this.initializePromise = this.initialize();
    }

    async initialize() {
        if (this.initialized) return;
        
        try {
            const gdprApplies = await this.checkGDPRApplies();
            if (gdprApplies) {
                await this.validateCurrentConsent();
            }
            this.initialized = true;
        } catch (error) {
            console.error('TCF initialization failed:', error);
            throw error;
        }
    }

    async updateTCFConsent(consentData) {
        try {
            const response = await fetch(`${this.config.API_URL}/validate`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(consentData)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            return result;
        } catch (error) {
            console.error('Error updating TCF consent:', error);
            return { success: false, error: error.message };
        }
    }

    async checkGDPRApplies() {
        try {
            const response = await fetch(`${this.config.API_URL}/gdpr-check`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    domain: window.location.hostname
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            return result.applies;
        } catch (error) {
            console.error('Error checking GDPR:', error);
            return true;
        }
    }
}

// Instancia global
const tcfManager = new TCFManager();

// Función principal de aceptación de consentimiento
async function aceptarCM21(modo) {
    if (!modo) modo = calculacookies();
    if (!modo) modo = getCookie("c21cm_cookie_consent");
    if (!modo) modo = '3';

    try {
        // Preparar datos para TCF
        const tcfConsent = {
            token: '<?php echo $_REQUEST['token']; ?>',
            analytics_consent: modo >= 1,
            marketing_consent: modo >= 2,
            purposes: {
                1: true, // Essential siempre true
                2: modo >= 1, // Analytics
                3: modo >= 2, // Marketing
                4: modo >= 2  // Personalización
            },
            vendors: {}
        };

        // Configurar UI basado en modo
        if (modo == 1) {
            document.getElementById("statsCookies").checked = 'checked';
            if (document.getElementById("provider_analytics")) {
                document.getElementById("provider_analytics").checked = 'checked';
            }
            document.getElementById("pubCookies").checked = '';
            document.getElementById("persCookies").checked = '';
            
            if (document.getElementById("provider_analytics")) {
                tcfConsent.vendors['google_analytics'] = true;
            }
        }
        else if (modo == 2) {
            eliminaCookie('cm21_pers');
            cm21_ejecutaCola_TODO();
            
            document.getElementById("statsCookies").checked = 'checked';
            if (document.getElementById("provider_analytics")) {
                document.getElementById("provider_analytics").checked = 'checked';
                tcfConsent.vendors['google_analytics'] = true;
            }
            document.getElementById("marcaTodasCM21").checked = 'checked';
            document.getElementById("pubCookies").checked = 'checked';
            document.getElementById("persCookies").checked = 'checked';
            
            // Guardar propósitos específicos
            const cookiesToSave = [
                'propositoCookies1', 'propositoCookies2', 'propositoCookies3',
                'propositoCookies4', 'propositoCookies5', 'propositoCookies6',
                'propositoCookies7', 'propositoCookies8', 'propositoCookies9',
                'propositoCookies10', 'propositoEspecialCookies1', 'propositoEspecialCookies2',
                'funcionCookies1', 'funcionCookies2', 'funcionCookies3',
                'funcionEspecialCookies1', 'funcionEspecialCookies2'
            ];
            
            cookiesToSave.forEach(cookie => saveCookieCM21(cookie, 'checked'));
        }
        else if (modo == 3) {
            document.getElementById("statsCookies").checked = '';
            if (document.getElementById("provider_analytics")) {
                document.getElementById("provider_analytics").checked = '';
                tcfConsent.vendors['google_analytics'] = false;
            }
            document.getElementById("marcaTodasCM21").checked = '';
            document.getElementById("pubCookies").checked = '';
            document.getElementById("persCookies").checked = '';

            const cookiesToRemove = [
                'propositoCookies1', 'propositoCookies2', 'propositoCookies3',
                'propositoCookies4', 'propositoCookies5', 'propositoCookies6',
                'propositoCookies7', 'propositoCookies8', 'propositoCookies9',
                'propositoCookies10', 'propositoEspecialCookies1', 'propositoEspecialCookies2',
                'funcionCookies1', 'funcionCookies2', 'funcionCookies3',
                'funcionEspecialCookies1', 'funcionEspecialCookies2'
            ];
            
            cookiesToRemove.forEach(cookie => eliminaCookie(cookie));
        }

        // Actualizar TCF
        const tcfResult = await tcfManager.updateTCFConsent(tcfConsent);
        if (!tcfResult.success) {
            console.error('Failed to update TCF consent:', tcfResult.error);
        }

        // Guardar estado de cookies
        saveCookieStatus('marcaTodasCM21');
        saveCookieStatus('statsCookies');
        if (document.getElementById("provider_analytics")) {
            saveCookieStatus('provider_analytics');
        }
        saveCookieStatus('pubCookies');
        saveCookieStatus('persCookies');

        // Actualizar UI
        if (document.getElementById("closeams")) {
            document.getElementById("closeams").style.display = "block";
        }

        // Actualizar mensajes de estado
        if (modo == 4) document.getElementById("c21cm_state").innerHTML = cadenaTrad('idioma_aceptado_algunas_cookies');
        if (modo == 3) document.getElementById("c21cm_state").innerHTML = cadenaTrad('idioma_aceptado_cookies_necesarias');
        if (modo == 1) document.getElementById("c21cm_state").innerHTML = cadenaTrad('idioma_aceptado_stats');
        if (modo == 2) document.getElementById("c21cm_state").innerHTML = cadenaTrad('idioma_todas_aceptadas');

        // Guardar consentimiento principal
        saveCookieCM21('c21cm_cookie_consent', modo);

        // Actualizar Google Analytics
        if (document.getElementById("provider_analytics")) {
            const gtagConsent = modo == 3 ? {
                'ad_storage': 'denied',
                'analytics_storage': "denied",
                'ad_user_data': "denied",
                'ad_personalization': "denied"
            } : modo == 1 ? {
                'ad_storage': 'granted',
                'analytics_storage': "granted",
                'ad_user_data': "denied",
                'ad_personalization': "denied"
            } : {
                'ad_storage': 'granted',
                'analytics_storage': "granted",
                'ad_user_data': "granted",
                'ad_personalization': "granted"
            };
            
            gtag('consent', 'update', gtagConsent);
        }

        // Scripts personalizados
        if (modo == 2) {
            <?php if ($fetch['script']) { ?>
                c21_loadjs('<?php echo $fetch['script']; ?>');
            <?php } ?>
        }

        // Finalizar proceso
        accepted = true;
        c21_popup('hide');
        
        // Informar a IAB y Google
        c21_recalcula_CS(modo);
        setTimeout("c21_avisaGoogle();", 1000);

    } catch (error) {
        console.error('Error in aceptarCM21:', error);
        // Mantener funcionamiento básico incluso si falla TCF
        saveCookieCM21('c21cm_cookie_consent', modo);
    }
}

// Función auxiliar para validar el consentimiento TCF
async function validateTCFConsent(tcString) {
    try {
        const response = await fetch(`${TCF_CONFIG.API_URL}/validate`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ tc_string: tcString })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        return result.success;
    } catch (error) {
        console.error('Error validating TCF consent:', error);
        return false;
    }
}