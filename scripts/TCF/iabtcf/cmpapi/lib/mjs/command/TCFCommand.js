export var TCFCommand;
(function (TCFCommand) {
    TCFCommand["PING"] = "ping";
    TCFCommand["GET_TC_DATA"] = "getTCData";
    TCFCommand["GET_IN_APP_TC_DATA"] = "getInAppTCData";
    TCFCommand["GET_VENDOR_LIST"] = "getVendorList";
    TCFCommand["ADD_EVENT_LISTENER"] = "addEventListener";
    TCFCommand["REMOVE_EVENT_LISTENER"] = "removeEventListener";
})(TCFCommand || (TCFCommand = {}));