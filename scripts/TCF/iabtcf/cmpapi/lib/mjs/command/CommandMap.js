import { PingCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/PingCommand.js';
import { GetTCDataCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/GetTCDataCommand.js';
import { GetInAppTCDataCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/GetInAppTCDataCommand.js';
import { GetVendorListCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/GetVendorListCommand.js';
import { AddEventListenerCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/AddEventListenerCommand.js';
import { RemoveEventListenerCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/RemoveEventListenerCommand.js';
import { TCFCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/TCFCommand.js';
export class CommandMap {
    static [TCFCommand.PING] = PingCommand;
    static [TCFCommand.GET_TC_DATA] = GetTCDataCommand;
    static [TCFCommand.GET_IN_APP_TC_DATA] = GetInAppTCDataCommand;
    static [TCFCommand.GET_VENDOR_LIST] = GetVendorListCommand;
    static [TCFCommand.ADD_EVENT_LISTENER] = AddEventListenerCommand;
    static [TCFCommand.REMOVE_EVENT_LISTENER] = RemoveEventListenerCommand;
}