import { CmpApiModel } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/CmpApiModel.js';
import { Response } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/Response.js';
/**
 * Ping response builder
 */
export class Ping extends Response {
    /**
     * true - CMP main script is loaded
     * false - still running stub
     */
    cmpLoaded = true;
    /**
     * see Ping Status Codes in following table
     */
    cmpStatus = CmpApiModel.cmpStatus;
    /**
     * see Ping Status Codes in following table
     */
    displayStatus = CmpApiModel.displayStatus;
    /**
     * version of the CMP API that is supported; e.g. “2”
     */
    apiVersion = String(CmpApiModel.apiVersion);
    /**
     * Version of the GVL currently loaded by the CMP
     * undefined if still the stub
     */
    gvlVersion;
    constructor() {
        super();
        // only if the tcModel is defined
        if (CmpApiModel.tcModel && CmpApiModel.tcModel.vendorListVersion) {
            this.gvlVersion = +CmpApiModel.tcModel.vendorListVersion;
        }
    }
}