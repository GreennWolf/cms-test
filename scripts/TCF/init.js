(function() {
    // Configuración global de TCF
    window.TCF_CONFIG = {
        API_URL: 'http://localhost:3000/api/tcf',
        VERSION: 2,
        CMP_ID: 12,
        CMP_VERSION: 1,
        VENDOR_LIST_VERSION: '1'
    };

    // Función para manejar cambios en el consentimiento
    function onConsentChange(tcData) {
        // Actualizar cookies basadas en el consentimiento
        document.cookie = `analytics_consent=${tcData.purpose.consents[2] || false}`;
        document.cookie = `marketing_consent=${tcData.purpose.consents[3] || false}`;
        
        // Actualizar Google Analytics si está presente
        if (typeof gtag === 'function') {
            gtag('consent', 'update', {
                'analytics_storage': tcData.purpose.consents[2] ? 'granted' : 'denied',
                'ad_storage': tcData.purpose.consents[3] ? 'granted' : 'denied',
                'ad_user_data': tcData.purpose.consents[3] ? 'granted' : 'denied',
                'ad_personalization': tcData.purpose.consents[3] ? 'granted' : 'denied'
            });
        }
    }

    // Implementación de TCF API
    window.__tcfapi = function(command, version, callback, parameter) {
        if (command === 'getTCData') {
            const tcString = getCookie('tc_string');
            if (tcString) {
                const tcData = {
                    tcString: tcString,
                    gdprApplies: true,
                    eventStatus: 'tcloaded',
                    purpose: {
                        consents: {
                            1: true, // Essential siempre true
                            2: getCookie('analytics_consent') === 'true',
                            3: getCookie('marketing_consent') === 'true'
                        }
                    },
                    vendor: {
                        consents: {}
                    }
                };
                callback(tcData, true);
                onConsentChange(tcData);
            } else {
                callback({
                    gdprApplies: true,
                    eventStatus: 'cmpuishown'
                }, true);
            }
        }
    };

    // Inicializar TCF cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const tcString = getCookie('tc_string');
            if (!tcString) {
                // Mostrar banner de consentimiento si no hay consentimiento
                if (typeof showConsentBanner === 'function') {
                    showConsentBanner();
                }
            }
        } catch (error) {
            console.error('Error initializing TCF:', error);
        }
    });
})();