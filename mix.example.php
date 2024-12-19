<?php
session_start();

// Headers de seguridad actualizados
header("Content-Security-Policy: default-src * 'unsafe-inline' 'unsafe-eval'; script-src * 'unsafe-inline' 'unsafe-eval'; connect-src * 'unsafe-inline'; img-src * data: blob: 'unsafe-inline'; frame-src *; style-src * 'unsafe-inline';");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : 'demo';
?>
<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'es'; ?>">
<head>
    <title>MIX - COOKIE21 - CMP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>
    <h1>Cookie21 CMP</h1>

    <!-- Cargar configuración TCF -->
    <script>
        window.TCF_CONFIG = {
            API_URL: 'http://localhost:3000/api/tcf',
            VERSION: 2,
            CMP_ID: 12,
            CMP_VERSION: 1,
            TOKEN: '<?php echo htmlspecialchars($token); ?>'
        };
    </script>

    <!-- Cargar TCF Manager -->
    <script src="/cm/scripts/TCF/init.js"></script>

    <!-- Cargar el gestor -->
    <script src="https://cookie21.com/cm/gestor/?token=<?php echo htmlspecialchars($token); ?>"></script>

    <!-- Integración con TCF -->
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // Esperar a que TCF Manager esté listo
                await tcfManager.waitForInitialization();

                // Verificar consentimiento existente
                const tcString = localStorage.getItem('tcf_string');
                if (tcString) {
                    const isValid = await tcfManager.validateConsent(tcString);
                    if (!isValid) {
                        console.log('Consentimiento no válido, mostrando banner');
                        showConsentBanner();
                    }
                } else {
                    console.log('No hay consentimiento previo, mostrando banner');
                    showConsentBanner();
                }

                // Escuchar cambios en el consentimiento
                tcfManager.onConsentUpdate(async (newTCString) => {
                    console.log('Consentimiento actualizado');
                    await tcfManager.validateConsent(newTCString);
                });

            } catch (error) {
                console.error('Error inicializando TCF:', error);
            }
        });

        // Función para mostrar el banner de consentimiento
        function showConsentBanner() {
            // Tu lógica actual para mostrar el banner
            if (typeof cm21_popup === 'function') {
                cm21_popup('show');
            }
        }
    </script>
</body>
</html>