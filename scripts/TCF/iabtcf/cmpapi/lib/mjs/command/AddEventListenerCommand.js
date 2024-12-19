import { CmpApiModel } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/CmpApiModel.js';
import { GetTCDataCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/GetTCDataCommand.js';
export class AddEventListenerCommand extends GetTCDataCommand {
    respond() {
        this.listenerId = CmpApiModel.eventQueue.add({
            callback: this.callback,
            param: this.param,
            next: this.next,
        });
        super.respond();
    }
}