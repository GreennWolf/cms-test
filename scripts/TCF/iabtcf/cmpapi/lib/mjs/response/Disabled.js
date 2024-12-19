import { Response } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/Response.js';
import { CmpStatus } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/status/index.js';
export class Disabled extends Response {
    cmpStatus = CmpStatus.ERROR;
}