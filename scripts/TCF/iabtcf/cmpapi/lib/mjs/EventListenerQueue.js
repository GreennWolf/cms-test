import { GetTCDataCommand } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/GetTCDataCommand.js';
export class EventListenerQueue {
    eventQueue = new Map();
    queueNumber = 0;
    add(eventItems) {
        this.eventQueue.set(this.queueNumber, eventItems);
        return this.queueNumber++;
    }
    remove(listenerId) {
        return this.eventQueue.delete(listenerId);
    }
    exec() {
        this.eventQueue.forEach((eventItem, listenerId) => {
            new GetTCDataCommand(eventItem.callback, eventItem.param, listenerId, eventItem.next);
        });
    }
    clear() {
        this.queueNumber = 0;
        this.eventQueue.clear();
    }
    get size() {
        return this.eventQueue.size;
    }
}