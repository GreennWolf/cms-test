import { CmpApiModel } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/CmpApiModel.js';
import { Command } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/Command.js';
export class RemoveEventListenerCommand extends Command {
    respond() {
        this.invokeCallback(CmpApiModel.eventQueue.remove(this.param));
    }
}