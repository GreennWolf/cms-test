/**
 * Number of bits for encoding the version integer
 * Expected to be the same across versions
 */
const versionNumBits = 6;

/**
 * Definition of the consent string encoded format
 *
 * From https://github.com/InteractiveAdvertisingBureau/GDPR-Transparency-and-Consent-Framework/blob/master/Draft_for_Public_Comment_Transparency%20%26%20Consent%20Framework%20-%20cookie%20and%20vendor%20list%20format%20specification%20v1.0a.pdf
 */
const vendorVersionMap = {
  /**
   * Version 1
   */
  1: {
    version: 1,
    metadataFields: ['version', 'created', 'lastUpdated', 'cmpId',
      'cmpVersion', 'consentScreen', 'vendorListVersion'],
    fields: [
      { name: 'version', type: 'int', numBits: 6 },
      { name: 'created', type: 'date', numBits: 36 },
      { name: 'lastUpdated', type: 'date', numBits: 36 },
      { name: 'cmpId', type: 'int', numBits: 12 },
      { name: 'cmpVersion', type: 'int', numBits: 12 },
      { name: 'consentScreen', type: 'int', numBits: 6 },
      { name: 'consentLanguage', type: 'language', numBits: 12 },
      { name: 'vendorListVersion', type: 'int', numBits: 12 },
      { name: 'purposeIdBitString', type: 'bits', numBits: 24 },
      { name: 'maxVendorId', type: 'int', numBits: 16 },
      { name: 'isRange', type: 'bool', numBits: 1 },
      {
        name: 'vendorIdBitString',
        type: 'bits',
        numBits: decodedObject => decodedObject.maxVendorId,
        validator: decodedObject => !decodedObject.isRange,
      },
      {
        name: 'defaultConsent',
        type: 'bool',
        numBits: 1,
        validator: decodedObject => decodedObject.isRange,
      },
      {
        name: 'numEntries',
        numBits: 12,
        type: 'int',
        validator: decodedObject => decodedObject.isRange,
      },
      {
        name: 'vendorRangeList',
        type: 'list',
        listCount: decodedObject => decodedObject.numEntries,
        validator: decodedObject => decodedObject.isRange,
        fields: [
          {
            name: 'isRange',
            type: 'bool',
            numBits: 1,
          },
          {
            name: 'startVendorId',
            type: 'int',
            numBits: 16,
          },
          {
            name: 'endVendorId',
            type: 'int',
            numBits: 16,
            validator: decodedObject => decodedObject.isRange,
          },
        ],
      },
    ],
  },
};

module.exports = {
  versionNumBits,
  vendorVersionMap,
};
