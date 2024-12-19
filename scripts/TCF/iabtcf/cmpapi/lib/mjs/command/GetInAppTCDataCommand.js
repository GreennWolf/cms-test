import { GetTCDataCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/GetTCDataCommand.js';
import { InAppTCData } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/index.js';
export class GetInAppTCDataCommand extends GetTCDataCommand {
    respond() {
        this.throwIfParamInvalid();
        this.invokeCallback(new InAppTCData(this.param));
    }
}