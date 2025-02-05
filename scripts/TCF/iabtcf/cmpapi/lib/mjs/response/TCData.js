import { CmpApiModel } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/CmpApiModel.js';
import { Response } from 'https://cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/Response.js';
export class TCData extends Response {
    tcString;
    listenerId;
    eventStatus;
    cmpStatus;
    isServiceSpecific;
    useNonStandardStacks;
    publisherCC;
    purposeOneTreatment;
    outOfBand;
    purpose;
    vendor;
    specialFeatureOptins;
    publisher;
    /**
     * Constructor to create a TCData object from a TCModel
     * @param {number[]} vendorIds - if not undefined, will be used to filter vendor ids
     * @param {number} listenerId - if there is a listenerId to add
     */
    constructor(vendorIds, listenerId) {
        super();
        this.eventStatus = CmpApiModel.eventStatus;
        this.cmpStatus = CmpApiModel.cmpStatus;
        this.listenerId = listenerId;
        if (CmpApiModel.gdprApplies) {
            const tcModel = CmpApiModel.tcModel;
            this.tcString = CmpApiModel.tcString;
            this.isServiceSpecific = tcModel.isServiceSpecific;
            this.useNonStandardStacks = tcModel.useNonStandardStacks;
            this.purposeOneTreatment = tcModel.purposeOneTreatment;
            this.publisherCC = tcModel.publisherCountryCode;
            this.outOfBand = {
                allowedVendors: this.createVectorField(tcModel.vendorsAllowed, vendorIds),
                disclosedVendors: this.createVectorField(tcModel.vendorsDisclosed, vendorIds),
            };
            this.purpose = {
                consents: this.createVectorField(tcModel.purposeConsents),
                legitimateInterests: this.createVectorField(tcModel.purposeLegitimateInterests),
            };
            this.vendor = {
                consents: this.createVectorField(tcModel.vendorConsents, vendorIds),
                legitimateInterests: this.createVectorField(tcModel.vendorLegitimateInterests, vendorIds),
            };
            this.specialFeatureOptins = this.createVectorField(tcModel.specialFeatureOptins);
            this.publisher = {
                consents: this.createVectorField(tcModel.publisherConsents),
                legitimateInterests: this.createVectorField(tcModel.publisherLegitimateInterests),
                customPurpose: {
                    consents: this.createVectorField(tcModel.publisherCustomConsents),
                    legitimateInterests: this.createVectorField(tcModel.publisherCustomLegitimateInterests),
                },
                restrictions: this.createRestrictions(tcModel.publisherRestrictions),
            };
        }
    }
    /**
     * Creates a restrictions object given a PurposeRestrictionVector
     * @param {PurposeRestrictionVector} purpRestrictions
     * @return {Restrictions}
     */
    createRestrictions(purpRestrictions) {
        const retr = {};
        if (purpRestrictions.numRestrictions > 0) {
            const max = purpRestrictions.getMaxVendorId();
            for (let vendorId = 1; vendorId <= max; vendorId++) {
                const strVendorId = vendorId.toString();
                // vendors restrictions
                purpRestrictions.getRestrictions(vendorId).forEach((pRestrict) => {
                    const strPurpId = pRestrict.purposeId.toString();
                    if (!retr[strPurpId]) {
                        retr[strPurpId] = {};
                    }
                    retr[strPurpId][strVendorId] = pRestrict.restrictionType;
                });
            }
        }
        return retr;
    }
    ;
    /**
     * Creates a string bit field with a value for each id where each value is
     * '1' if its id is in the passed in vector Can be overwritten to return a
     * string
     * @param {Vector} vector
     * @param {number[]} ids filter
     * @return {BooleanVector | string}
     */
    createVectorField(vector, ids) {
        if (ids) {
            return ids.reduce((booleanVector, obj) => {
                booleanVector[String(obj)] = vector.has(Number(obj));
                return booleanVector;
            }, {});
        }
        return [...vector].reduce((booleanVector, keys) => {
            booleanVector[keys[0].toString(10)] = keys[1];
            return booleanVector;
        }, {});
    }
}