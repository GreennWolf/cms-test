import { TCData } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/TCData.js';
/**
 * InAppTCData response builder
 */
export class InAppTCData extends TCData {
    constructor(vendorIds) {
        super(vendorIds);
        delete this.outOfBand;
    }
    /**
     * Creates a string bit field with a value for each id where each value is '1' if its id is in the passed in vector
     * @override
     * @param {Vector} vector
     * @return {string}
     */
    createVectorField(vector) {
        return [...vector].reduce((str, tpl) => {
            str += tpl[1] ? '1' : '0';
            return str;
        }, '');
    }
    /**
     * Creates a restrictions object given a PurposeRestrictionVector
     * @override
     * @param {PurposeRestrictionVector} purpRestrictions
     * @return {Restrictions}
     */
    createRestrictions(purpRestrictions) {
        const retr = {};
        if (purpRestrictions.numRestrictions > 0) {
            const maxVendorId = purpRestrictions.getMaxVendorId();
            /**
             * First create a string of empty values for each purpose that is long
             * enough to contain up to the max vendor id
             */
            purpRestrictions.getRestrictions().forEach((pRestrict) => {
                retr[pRestrict.purposeId.toString()] = '_'.repeat(maxVendorId);
            });
            /**
             * go through all of the vendor ids and insert their restriction type
             * number at the index of their vendor id on the purposeID string
             */
            for (let i = 0; i < maxVendorId; i++) {
                // offset by one
                const vendorId = i + 1;
                // Gets a list of purpose restrictions for this vendor
                purpRestrictions.getRestrictions(vendorId).forEach((pRestrict) => {
                    const strType = pRestrict.restrictionType.toString();
                    const strPurp = pRestrict.purposeId.toString();
                    // insert the restriction type at the index of the vendor ID
                    const firstPart = retr[strPurp].substr(0, i);
                    const lastPart = retr[strPurp].substr(i + 1);
                    retr[strPurp] = firstPart + strType + lastPart;
                });
            }
        }
        return retr;
    }
    ;
}