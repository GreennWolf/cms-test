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