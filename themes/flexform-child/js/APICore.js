var TmfAPICore_version = { version: 1.001, date: "18 May 2013" };
var TmfAPICore = {};

function getRandomColour() {
    var cols = ["#DD1E2F", "#EBB035", "#06A2CB", "#218559", "#D0C6B1", "#192823", "#CB9006", "#F84416", "#52D8FA", "#06A4CB", "#41CB06", "#CB2E06"];
    return cols[Math.floor(Math.random() * cols.length)];
}

TmfAPICore.ParseTemplateAndAppendToElement = function (d, t, e) {
    try {
                $("#" + t).tmpl(d).appendTo("#" + e);
    } catch(e) {
        if(window.console) {
            window.console.log(e.Message);
        }
    } 
};

TmfAPICore.SetSessionStorageItem = function (key, value) {
    try {
        var storage = window.sessionStorage;

        if (typeof (storage) !== "undefined") {
            window.sessionStorage.setItem(key, JSON.stringify(value));
        }

        else {
            console.log("sessionStorage not supported");
        }
    } catch (e) {
        console.log(e.message);
    }
};

TmfAPICore.GetSessionStorageItem = function (key, defaultValue) {
    var returnVal = defaultValue;
    try {
        var storage = window.sessionStorage;

        if (typeof (storage) !== "undefined") {
            if (window.sessionStorage.getItem(key) != null) {
                returnVal = JSON.parse(window.sessionStorage.getItem(key));
            }
        } else {
            console.log("sessionStorage not supported");
        }
    } catch (e) {
        console.log(e.message);
    }
    return returnVal;
};

TmfAPICore.SetLocalStorageItem = function (key, value) {
    try {
        var storage = window.localStorage;

        if (typeof (storage) !== "undefined") {
            window.localStorage.setItem(key, JSON.stringify(value));
        }

        else {
            console.log("localstorage not supported");
        }
    } catch (e) {
        console.log(e.message);
    }
};

TmfAPICore.GetLocalStorageItem = function(key, defaultValue) {
    var returnVal = defaultValue;
    try {
        var storage = window.localStorage;

        if (typeof(storage) !== "undefined") {
            if (window.localStorage.getItem(key) != null) {
                returnVal = JSON.parse(window.localStorage.getItem(key));
            }
        } else {
            console.log("localstorage not supported");
        }
    } catch(e) {
        console.log(e.message);
    }
    return returnVal;
};

TmfAPICore.SetObject = function(n) {
    var exists = false;
    for (var i = 0; i < TmfObjectStore.length; i++) {
        if (TmfObjectStore[i].ClientId == n.ClientId) {
            TmfObjectStore[i] = n;
            exists = true;
            break;
        }
    }
    if (!exists) {
        window.TmfObjectStore.push(n);
    }
};

TmfAPICore.GetObject = function (n){
    var exists = false;
    for (var i = 0; i < TmfObjectStore.length; i++) {
        if (TmfObjectStore[i].ClientId == n) {
            return TmfObjectStore[i];
        }
    }
    return null;
};
