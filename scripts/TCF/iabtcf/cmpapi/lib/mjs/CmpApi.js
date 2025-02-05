import { CmpApiModel } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/CmpApiModel.js';
import { CmpStatus, DisplayStatus, EventStatus } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/status/index.js';
import { CallResponder } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/CallResponder.js';
import { TCString, TCModel } from '@iabtcf/core';
export class CmpApi {
    callResponder;
    isServiceSpecific;
    numUpdates = 0;
    /**
     * @param {number} cmpId - IAB assigned CMP ID
     * @param {number} cmpVersion - integer version of the CMP
     * @param {boolean} isServiceSpecific - whether or not this cmp is configured to be service specific
     * @param {CustomCommands} [customCommands] - custom commands from the cmp
     */
    constructor(cmpId, cmpVersion, isServiceSpecific = false, customCommands) {
        this.throwIfInvalidInt(cmpId, 'cmpId', 2);
        this.throwIfInvalidInt(cmpVersion, 'cmpVersion', 0);
        CmpApiModel.cmpId = cmpId;
        CmpApiModel.cmpVersion = cmpVersion;
        CmpApiModel.tcfPolicyVersion = 2;
        this.isServiceSpecific = !!isServiceSpecific;
        this.callResponder = new CallResponder(customCommands);
    }
    throwIfInvalidInt(value, name, minValue) {
        if (!(typeof value === 'number' && Number.isInteger(value) && value >= minValue)) {
            throw new Error(`Invalid ${name}: ${value}`);
        }
    }
    /**
     * update - When the state of a CMP changes this function should be called
     * with the updated tc string and whether or not the UI is visible or not
     *
     * @param {string|null} encodedTCString - set a string to signal that
     * gdprApplies and that an encoded tc string is being passed.  If GDPR does
     * not apply, set to null.
     * @param {boolean} uiVisible - default false.  set to true if the ui is
     * being shown with this tc string update, this will set the correct values
     * for eventStatus and displayStatus.
     * @return {void}
     */
    update(encodedTCString, uiVisible = false) {
        if (CmpApiModel.disabled) {
            throw new Error('CmpApi Disabled');
        }
        CmpApiModel.cmpStatus = CmpStatus.LOADED;
        if (uiVisible) {
            CmpApiModel.displayStatus = DisplayStatus.VISIBLE;
            CmpApiModel.eventStatus = EventStatus.CMP_UI_SHOWN;
        }
        else {
            if (CmpApiModel.tcModel === undefined) {
                CmpApiModel.displayStatus = DisplayStatus.DISABLED;
                CmpApiModel.eventStatus = EventStatus.TC_LOADED;
            }
            else {
                CmpApiModel.displayStatus = DisplayStatus.HIDDEN;
                CmpApiModel.eventStatus = EventStatus.USER_ACTION_COMPLETE;
            }
        }
        CmpApiModel.gdprApplies = (encodedTCString !== null);
        if (!CmpApiModel.gdprApplies) {
            CmpApiModel.tcModel = null;
        }
        else {
            if (encodedTCString === '') {
                CmpApiModel.tcModel = new TCModel();
                CmpApiModel.tcModel.cmpId = CmpApiModel.cmpId;
                CmpApiModel.tcModel.cmpVersion = CmpApiModel.cmpVersion;
            }
            else {
                CmpApiModel.tcModel = TCString.decode(encodedTCString);
            }
            CmpApiModel.tcModel.isServiceSpecific = this.isServiceSpecific;
            CmpApiModel.tcfPolicyVersion = Number(CmpApiModel.tcModel.policyVersion);
            CmpApiModel.tcString = encodedTCString;
        }
        if (this.numUpdates === 0) {
            /**
             * Will make AddEventListener Commands respond immediately.
             */
            this.callResponder.purgeQueuedCalls();
        }
        else {
            /**
             * Should be no queued calls and only any addEventListener commands
             */
            CmpApiModel.eventQueue.exec();
        }
        this.numUpdates++;
    }
    /**
     * Disables the CmpApi from serving anything but ping and custom commands
     * Cannot be undone
     *
     * @return {void}
     */
    disable() {
        CmpApiModel.disabled = true;
        CmpApiModel.cmpStatus = CmpStatus.ERROR;
    }
}