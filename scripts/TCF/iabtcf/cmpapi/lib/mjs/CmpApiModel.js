import { CmpStatus, DisplayStatus } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/status/index.js';
import { EventListenerQueue } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/EventListenerQueue.js';
/**
 * Class holds shareable data across cmp api and provides change event listener for TcModel.
 * Within the context of the CmpApi, this class acts much like a global state or database,
 * where CmpApi sets data and Commands read the data.
 */
export class CmpApiModel {
    static apiVersion = '2';
    static tcfPolicyVersion;
    static eventQueue = new EventListenerQueue();
    static cmpStatus = CmpStatus.LOADING;
    static disabled = false;
    static displayStatus = DisplayStatus.HIDDEN;
    static cmpId;
    static cmpVersion;
    static eventStatus;
    static gdprApplies;
    static tcModel;
    static tcString;
    static reset() {
        delete this.cmpId;
        delete this.cmpVersion;
        delete this.eventStatus;
        delete this.gdprApplies;
        delete this.tcModel;
        delete this.tcString;
        delete this.tcfPolicyVersion;
        this.cmpStatus = CmpStatus.LOADING;
        this.disabled = false;
        this.displayStatus = DisplayStatus.HIDDEN;
        this.eventQueue.clear();
    }
}