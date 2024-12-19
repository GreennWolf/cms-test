// cm/scripts/TCF/GLOBALS.js
"use strict";

const TCF_CONFIG = {
    API_URL: 'http://localhost:3000/api/tcf',
    VERSION: 2,
    CMP_ID: 12,
    CMP_VERSION: 1,
    VENDOR_LIST_VERSION: '1',
    RETRY_ATTEMPTS: 3,
    RETRY_DELAY: 1000,
    COOKIE_NAME: 'tcf_token',
    STORAGE_KEYS: {
        TOKEN: 'tcf_token',
        TC_STRING: 'tcf_string',
        CONSENT_STATE: 'tcf_consent_state'
    }
};

const CONSENT_STATES = {
    NONE: 0,
    ANALYTICS_ONLY: 1,
    ALL: 2,
    ESSENTIAL_ONLY: 3,
    CUSTOM: 4
};

const PURPOSES = {
    ESSENTIAL: 1,
    ANALYTICS: 2,
    MARKETING: 3,
    PERSONALIZATION: 4
};

window.TCF_GLOBALS = {
    CONFIG: TCF_CONFIG,
    CONSENT_STATES: CONSENT_STATES,
    PURPOSES: PURPOSES
};

// cm/scripts/TCF/FUNCTIONS.js
"use strict";

class TCFManager {
    constructor() {
        this.config = window.TCF_GLOBALS.CONFIG;
        this.initialized = false;
        this.initializePromise = this.initialize();
        this.consentCallbacks = [];
    }

    async initialize() {
        if (this.initialized) return;
        
        try {
            await this.loadVendorList();
            const gdprApplies = await this.checkGDPRApplies();
            
            if (gdprApplies) {
                await this.validateCurrentConsent();
            }
            
            this.initialized = true;
            this.setupEventListeners();
        } catch (error) {
            console.error('TCF initialization failed:', error);
            throw error;
        }
    }

    setupEventListeners() {
        window.addEventListener('storage', (e) => {
            if (e.key === this.config.STORAGE_KEYS.TC_STRING) {
                this.notifyConsentUpdate(e.newValue);
            }
        });
    }

    onConsentUpdate(callback) {
        this.consentCallbacks.push(callback);
    }

    notifyConsentUpdate(tcString) {
        this.consentCallbacks.forEach(callback => {
            try {
                callback(tcString);
            } catch (error) {
                console.error('Error in consent callback:', error);
            }
        });
    }

    async loadVendorList() {
        try {
            const response = await fetch(`${this.config.API_URL}/vendor-list`);
            if (!response.ok) throw new Error('Failed to load vendor list');
            this.vendorList = await response.json();
        } catch (error) {
            console.error('Error loading vendor list:', error);
            this.vendorList = { vendors: {}, purposes: {} };
        }
    }

    async updateTCFConsent(consentData, retries = this.config.RETRY_ATTEMPTS) {
        await this.waitForInitialization();
        
        for (let i = 0; i < retries; i++) {
            try {
                const response = await fetch(`${this.config.API_URL}/validate`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.prepareConsentData(consentData))
                });

                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                const result = await response.json();
                if (result.success) {
                    await this.saveTCFState(result);
                    return true;
                }
            } catch (error) {
                console.error(`TCF update attempt ${i + 1} failed:`, error);
                if (i === retries - 1) throw error;
                await new Promise(r => setTimeout(r, this.config.RETRY_DELAY * Math.pow(2, i)));
            }
        }
        return false;
    }

    prepareConsentData(consentData) {
        return {
            ...consentData,
            domain: window.location.hostname,
            timestamp: new Date().toISOString(),
            cmpId: this.config.CMP_ID,
            cmpVersion: this.config.CMP_VERSION,
            tcfVersion: this.config.VERSION
        };
    }

    async saveTCFState(tcData) {
        if (!tcData?.tcString) return false;

        const token = this.getToken();
        try {
            const response = await fetch('/cm/scripts/tcf_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    token: token,
                    tc_string: tcData.tcString
                })
            });

            if (!response.ok) throw new Error('Failed to save TCF state');

            localStorage.setItem(this.config.STORAGE_KEYS.TC_STRING, tcData.tcString);
            this.notifyConsentUpdate(tcData.tcString);
            return true;
        } catch (error) {
            console.error('Error saving TCF state:', error);
            return false;
        }
    }

    async validateCurrentConsent() {
        const tcString = localStorage.getItem(this.config.STORAGE_KEYS.TC_STRING);
        if (!tcString) return false;

        try {
            const response = await fetch(`${this.config.API_URL}/validate`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tc_string: tcString })
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            return result.success;
        } catch (error) {
            console.error('Error validating consent:', error);
            return false;
        }
    }

    async checkPurposeConsent(purposeId) {
        const tcString = localStorage.getItem(this.config.STORAGE_KEYS.TC_STRING);
        if (!tcString) return false;

        try {
            const response = await fetch(`${this.config.API_URL}/validate`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    tc_string: tcString,
                    purpose_id: purposeId
                })
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const result = await response.json();
            return result.purposeConsent?.[purposeId] === true;
        } catch (error) {
            console.error(`Error checking purpose ${purposeId} consent:`, error);
            return false;
        }
    }

    getToken() {
        let token = localStorage.getItem(this.config.STORAGE_KEYS.TOKEN);
        if (!token) {
            token = this.generateToken();
            localStorage.setItem(this.config.STORAGE_KEYS.TOKEN, token);
            this.setCookie(this.config.COOKIE_NAME, token, 180); // 180 días
        }
        return token;
    }

    generateToken() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = `expires=${date.toUTCString()}`;
        document.cookie = `${name}=${value};${expires};path=/;SameSite=Lax`;
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

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const result = await response.json();
            return result.applies;
        } catch (error) {
            console.error('Error checking GDPR:', error);
            return true; // Por defecto asumimos que aplica
        }
    }

    async waitForInitialization() {
        await this.initializePromise;
    }
}

// Crear instancia global
window.tcfManager = new TCFManager();

// cm/scripts/TCF/event-handlers.js
"use strict";

document.addEventListener('DOMContentLoaded', () => {
    const tcfManager = window.tcfManager;

    // Manejador para el formulario de consentimiento
    const consentForm = document.getElementById('tcf-consent-form');
    if (consentForm) {
        consentForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(consentForm);
            const consentData = {
                analytics_consent: formData.get('analytics') === 'true',
                marketing_consent: formData.get('marketing') === 'true',
                essential_consent: true, // Siempre true
                purposes: {
                    1: true, // Essential
                    2: formData.get('analytics') === 'true',
                    3: formData.get('marketing') === 'true'
                }
            };

            try {
                await tcfManager.updateTCFConsent(consentData);
                window.location.reload();
            } catch (error) {
                console.error('Error updating consent:', error);
                alert('Error updating consent preferences. Please try again.');
            }
        });
    }

    // Ejemplo de uso de callbacks de consentimiento
    tcfManager.onConsentUpdate((tcString) => {
        // Actualizar UI o recargar elementos basados en el consentimiento
        console.log('Consent updated:', tcString);
    });
});