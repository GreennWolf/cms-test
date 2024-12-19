<?php
session_start();


// Headers actualizados
header("Content-Security-Policy: script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:3000 chrome-extension: https://cookie21.com https://cmp.cookie21.com");
header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

// Manejar el token y el idioma de forma segura
$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : 'demo';
$currentLanguage = isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'es';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($currentLanguage); ?>">
<head>
    <title>BANNER - COOKIE21 - CMP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="def.css?<?php echo time(); ?>">

    <!-- Configuración global de TCF -->
        <!-- Configuración global de TCF -->
        <script>
        window.TCF_CONFIG = {
            API_URL: 'http://localhost:3000/api/tcf',
            VERSION: 2,
            CMP_ID: 12,
            CMP_VERSION: 1,
            TOKEN: '<?php echo htmlspecialchars($token); ?>'
        };
    </script>

    <!-- Cargar TCF Manager primero -->
    <script src="./scripts/TCF/init.js" defer></script>

    <!-- Cargar el CMP después -->
    <script id="jsb_c21" src="//cmp.cookie21.com/banner/?token=<?php echo htmlspecialchars($token); ?>" defer></script>

    <!-- Esperar a que TCF Manager esté disponible -->
    <script>
        function waitForTCFManager() {
            if (window.tcfManager) {
                // TCF Manager está disponible
                tcfIntegration.init();
            } else {
                setTimeout(waitForTCFManager, 100);
            }
        }

        document.addEventListener('DOMContentLoaded', waitForTCFManager);
    </script>
</head>
<body>
    <!-- Integración TCF -->
    <script>
        const tcfIntegration = {
            async init() {
                try {
                    await tcfManager.waitForInitialization();
                    this.registerEventListeners();
                    await this.checkConsent();
                } catch (error) {
                    console.error('Error inicializando TCF:', error);
                }
            },

            registerEventListeners() {
                // Escuchar cambios en el consentimiento
                tcfManager.onConsentUpdate(async (tcData) => {
                    console.log('Consentimiento actualizado:', tcData);
                    await this.validateConsent(tcData.tcString);
                });

                // Escuchar eventos de UI
                document.addEventListener('consentUIShown', () => {
                    console.log('Banner de consentimiento mostrado');
                });

                document.addEventListener('consentSaved', async (event) => {
                    const { tcString } = event.detail;
                    await this.validateConsent(tcString);
                });
            },

            async checkConsent() {
                const tcString = localStorage.getItem('tcf_string');
                if (tcString) {
                    const isValid = await this.validateConsent(tcString);
                    if (!isValid) {
                        this.showConsentBanner();
                    }
                } else {
                    this.showConsentBanner();
                }
            },

            async validateConsent(tcString) {
                try {
                    const response = await fetch(`${TCF_CONFIG.API_URL}/validate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            tcString,
                            token: TCF_CONFIG.TOKEN
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Error validating consent');
                    }

                    const result = await response.json();
                    this.handleValidationResult(result);
                    return result.valid;

                } catch (error) {
                    console.error('Error en validación:', error);
                    return false;
                }
            },

            handleValidationResult(result) {
                if (result.valid) {
                    // Actualizar UI y estado según el resultado
                    if (typeof updateConsentUI === 'function') {
                        updateConsentUI(result);
                    }
                    
                    // Actualizar Google Analytics si está presente
                    if (typeof gtag === 'function') {
                        gtag('consent', 'update', {
                            'analytics_storage': result.purposes['1'] ? 'granted' : 'denied',
                            'ad_storage': result.purposes['3'] ? 'granted' : 'denied',
                            'personalization_storage': result.purposes['5'] ? 'granted' : 'denied'
                        });
                    }
                } else {
                    this.showConsentBanner();
                }
            },

            showConsentBanner() {
                if (typeof cm21_popup === 'function') {
                    cm21_popup('show');
                }
            }
        };

        // Iniciar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            tcfIntegration.init();
        });
    </script>

    <div id="lipsum">
        <h1>Cookie21 CMP</h1>
        <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin placerat enim nec odio bibendum blandit eu sit amet felis.
        </p>
        <p>
        Aliquam pellentesque, leo facilisis interdum rutrum, arcu mi feugiat massa, eu rhoncus justo est sit amet quam.
        </p>
    </div>

    <script>
    console.log('TCF_CONFIG:', window.TCF_CONFIG);
    console.log('tcfManager:', window.tcfManager);
    console.log('Scripts cargados:', {
        init: document.querySelector('script[src*="init.js"]'),
        banner: document.querySelector('script[id="jsb_c21"]')
    });
</script>

    <!-- Debug panel -->
    <?php if (isset($_GET['debug']) && $_GET['debug'] === 'true'): ?>
    <div id="debug-panel" style="position: fixed; bottom: 0; right: 0; background: #fff; border: 1px solid #ccc; padding: 10px;">
        <h3>Debug Info</h3>
        <pre id="debug-info"></pre>
        <script>
            function updateDebugInfo(info) {
                document.getElementById('debug-info').textContent = JSON.stringify(info, null, 2);
            }

            window.addEventListener('consentUpdated', (event) => {
                updateDebugInfo(event.detail);
            });
        </script>
    </div>
    <?php endif; ?>
</body>
</html>