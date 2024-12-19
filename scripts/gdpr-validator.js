// Namespace para el validador GDPR
var cm21gdpr = {
    initialized: false,
    debug: true, // Activa logs para desarrollo
    
    // Configuración
    config: {
        validatorEndpoint: '/cm/gdpr-validator.php',
        requiredVendors: [], // IDs de vendors requeridos
        requiredPurposes: [] // IDs de propósitos requeridos
    },
    
    // Estado actual
    state: {
        lastValidation: null,
        tcString: null,
        isValid: false
    },
    
    /**
     * Inicializa el validador GDPR
     */
    init: function() {
        if (this.initialized) return;
        this.log('Inicializando validador GDPR');
        
        // Verificar que TCF está disponible
        if (typeof window.__tcfapi === 'undefined') {
            this.error('TCF API no encontrada. Asegúrate de que el CMP está cargado.');
            return;
        }
        
        // Registrar listener para eventos TCF
        this.registerTCFListener();
        this.initialized = true;
    },
    
    /**
     * Registra el listener para eventos TCF
     */
    registerTCFListener: function() {
        window.__tcfapi('addEventListener', 2, (tcData, success) => {
            if (!success) {
                this.error('Error al registrar TCF listener');
                return;
            }
            
            this.log('Evento TCF recibido:', tcData.eventStatus);
            
            // Manejar diferentes estados de eventos TCF
            switch(tcData.eventStatus) {
                case 'tcloaded':
                    // La UI del CMP se ha cargado y tenemos el primer TC string
                    this.handleTCString(tcData);
                    break;
                    
                case 'cmpuishown':
                    // La UI del CMP se está mostrando al usuario
                    this.log('CMP UI mostrada al usuario');
                    break;
                    
                case 'useractioncomplete':
                    // El usuario ha realizado una acción en el CMP
                    this.handleTCString(tcData);
                    break;
            }
        });
    },
    
    /**
     * Maneja la validación del TC string
     */
    handleTCString: async function(tcData) {
        this.state.tcString = tcData.tcString;
        
        try {
            const validation = await this.validateConsent(tcData);
            this.state.lastValidation = validation;
            this.state.isValid = validation.valid;
            
            // Disparar evento con el resultado
            this.dispatchValidationEvent(validation);
            
        } catch (error) {
            this.error('Error validando consentimiento:', error);
            this.state.isValid = false;
        }
    },
    
    /**
     * Valida el consentimiento con el servidor
     */
    validateConsent: async function(tcData) {
        this.log('Validando consentimiento...');
        
        try {
            const response = await fetch(this.config.validatorEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    tcString: tcData.tcString,
                    token: typeof cm21config !== 'undefined' ? cm21config.token : null
                })
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.error || 'Validación fallida');
            }

            this.log('Validación completada:', result.data);
            return result.data;
            
        } catch (error) {
            this.error('Error en validación:', error);
            throw error;
        }
    },
    
    /**
     * Dispara un evento personalizado con el resultado de la validación
     */
    dispatchValidationEvent: function(validation) {
        const event = new CustomEvent('gdprValidated', {
            detail: validation
        });
        window.dispatchEvent(event);
        this.log('Evento gdprValidated disparado');
    },
    
    /**
     * Comprueba si hay consentimiento válido para un vendor específico
     */
    hasVendorConsent: function(vendorId) {
        if (!this.state.lastValidation) return false;
        return this.state.lastValidation.vendors?.[vendorId] === true;
    },
    
    /**
     * Comprueba si hay consentimiento válido para un propósito específico
     */
    hasPurposeConsent: function(purposeId) {
        if (!this.state.lastValidation) return false;
        return this.state.lastValidation.purposes?.[purposeId] === true;
    },
    
    /**
     * Función de logging para desarrollo
     */
    log: function(...args) {
        if (this.debug) {
            console.log('[CM21 GDPR]', ...args);
        }
    },
    
    /**
     * Función de logging de errores
     */
    error: function(...args) {
        console.error('[CM21 GDPR]', ...args);
    }
};

// Auto-inicialización cuando el documento está listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => cm21gdpr.init());
} else {
    cm21gdpr.init();
}