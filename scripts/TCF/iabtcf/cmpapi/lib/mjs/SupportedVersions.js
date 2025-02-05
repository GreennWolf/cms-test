export class SupportedVersions {
    static set_ = new Set([0, 2, undefined, null]);
    static has(value) {
        if (typeof value === 'string') {
            value = Number(value);
        }
        return this.set_.has(value);
    }
}