<?php
header('Content-Type: application/javascript; charset=utf-8');

$db = new SQLite3('../db/consentsdb');
$token = $db->escapeString($_REQUEST['token']);
$query = "SELECT * FROM consents WHERE token = '$token'";
$result = $db->query($query);
$fetch = $result->fetchArray(SQLITE3_ASSOC);

if (!$fetch || $fetch['deshabilitado'] === 'SI') {
    exit();
}

// Validar dominio
$validDomains = [
    $fetch['dominio'],
    'www.' . $fetch['dominio'],
    'cookie21.com',
    'www.cookie21.com',
];
$referrerHost = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

if (!in_array($referrerHost, $validDomains)) {
    exit();
}

$gtm = $fetch['gtag'] ?? null;
$analytics = $fetch['analytics'] ?? null;
$tcString = $fetch['tc_string'] ?? null;
?>

(function() {
    // TCF initialization
    window.__tcfapi = function(command, version, callback, parameter) {
        if (command === 'getTCData') {
            var tcData = {
                tcString: '<?php echo $tcString; ?>',
                cmpId: 12,
                cmpVersion: 1,
                gdprApplies: true,
                eventStatus: 'tcloaded',
                purpose: {
                    consents: {
                        1: true,  // Essential
                        2: <?php echo $fetch['analytics'] ? 'true' : 'false'; ?>,  // Analytics
                        3: <?php echo $fetch['gtag'] ? 'true' : 'false'; ?>  // Marketing
                    }
                }
            };
            callback(tcData, true);
        }
    };

    // Load core TCF scripts
    function loadTCFScripts() {
        var scripts = [
            '/cm/scripts/TCF/GLOBALS.js',
            '/cm/scripts/TCF/FUNCTIONS.js'
        ];
        
        scripts.forEach(function(src) {
            var script = document.createElement('script');
            script.src = src;
            script.async = true;
            document.head.appendChild(script);
        });
    }

    // Load Google services only after consent
    function loadGoogleServices(tcData) {
        // GTM
        if (tcData.purpose.consents[3] && '<?php echo $gtm; ?>') {
            (function(w,d,s,l,i){
                w[l]=w[l]||[];
                w[l].push({'gtm.start': new Date().getTime(), event:'gtm.js'});
                var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),
                    dl=l!='dataLayer'?'&l='+l:'';
                j.async=true;
                j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
                f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','<?php echo $gtm; ?>');
        }

        // Analytics
        if (tcData.purpose.consents[2] && '<?php echo $analytics; ?>') {
            var script = document.createElement('script');
            script.async = true;
            script.src = "https://www.googletagmanager.com/gtag/js?id=<?php echo $analytics; ?>";
            document.head.appendChild(script);

            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '<?php echo $analytics; ?>');
        }
    }

    // Load additional resources
    function loadAdditionalResources() {
        // Variables
        if (typeof cm21variables === 'undefined') {
            var scriptVariables = document.createElement('script');
            scriptVariables.src = "https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/variables.js.php?token=<?php echo $token; ?>";
            document.head.appendChild(scriptVariables);
            cm21variables = 'loaded';
        }

        // Languages
        if (typeof cm21idiomas === 'undefined') {
            var scriptIdiomas = document.createElement('script');
            scriptIdiomas.src = "https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/idiomas.js.php?token=<?php echo $token; ?>";
            document.head.appendChild(scriptIdiomas);
            cm21idiomas = 'loaded';
        }

        // Config
        if (typeof cm21config === 'undefined') {
            var scriptConfig = document.createElement('script');
            scriptConfig.src = "https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/config/?token=<?php echo $token; ?>";
            document.head.appendChild(scriptConfig);
            cm21config = 'loaded';
        }

        // Styles
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css";
        document.head.appendChild(link);
    }

    // Initialize
    loadTCFScripts();
    loadAdditionalResources();
    
    // Wait for TCF data and load conditional services
    window.__tcfapi('getTCData', 2, function(tcData, success) {
        if (success) {
            loadGoogleServices(tcData);
        }
    });
})();