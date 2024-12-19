import { Ping } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/index.js';
import { Command } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/Command.js';
export class PingCommand extends Command {
    respond() {
        this.invokeCallback(new Ping());
    }
}