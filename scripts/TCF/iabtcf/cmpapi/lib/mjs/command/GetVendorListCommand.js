import { CmpApiModel } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/CmpApiModel.js';
import { Command } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/Command.js';
import { GVL } from '@iabtcf/core';
/**
 * Gets a version of the Global Vendors List
 */
export class GetVendorListCommand extends Command {
    respond() {
        const tcModel = CmpApiModel.tcModel;
        const tcModelVersion = tcModel.vendorListVersion;
        let gvl;
        if (this.param === undefined) {
            this.param = tcModelVersion;
        }
        if (this.param === tcModelVersion && tcModel.gvl) {
            gvl = tcModel.gvl;
        }
        else {
            gvl = new GVL(this.param);
        }
        gvl.readyPromise.then(() => {
            this.invokeCallback(gvl.getJson());
        });
    }
}