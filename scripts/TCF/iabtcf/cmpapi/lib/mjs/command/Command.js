export class Command {
    listenerId;
    callback;
    next;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    param;
    success = true;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    constructor(callback, param, listenerId, next) {
        Object.assign(this, {
            callback,
            listenerId,
            param,
            next,
        });
        try {
            this.respond();
        }
        catch (error) {
            this.invokeCallback(null);
        }
    }
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    invokeCallback(response) {
        const success = response !== null;
        if (typeof this.next === 'function') {
            this.callback(this.next, response, success);
        }
        else {
            this.callback(response, success);
        }
    }
}