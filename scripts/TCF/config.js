



/* new codes */

function c21_load_iab_final() {

	if (1==1) {

		if (document.getElementById('iab_cookie21_com')) {
			
			
			document.getElementById('iab_cookie21_com').src="javascript:loadCMP();";
			/*
			window.open("javascript:loadCMP();",'iab_cookie21_com');
			*/
		}



	}

}


window.addEventListener("load",function(){
    

		 c21_load_iab_final();
	
	

},false);








(function() {

  var gdprAppliesGlobally = true;
  var win = window;
  var doc = document;

  function addFrame() {

    if (!win.frames['__cmpLocator']) {

      if (doc.body) {

        var body = doc.body;

        var iframe = doc.createElement('iframe');

        iframe.style.cssText = 'display:none';

        iframe.name = '__cmpLocator';

        body.appendChild(iframe);

      } else {

        /**
         * In the case where this stub is located in the head, this allows us to
         * inject the iframe more quickly than relying on DOMContentLoaded or
         * other events.
         */

        setTimeout(addFrame, 5);

      }

    }

  }

  addFrame();

  function stubCMP() {

    var b = arguments;

    __cmp.a = __cmp.a || [];

    if (!b.length) {

      return __cmp.a;

    } else if (b[0] === 'ping') {

      b[2]({
        'gdprAppliesGlobally': gdprAppliesGlobally,

        'cmpLoaded': true,
      }, true);

    } else {

      __cmp.a.push([].slice.apply(b));

    }

  }

  function cmpMsgHandler(event) {

    var msgIsString = typeof event.data === 'string';

    try {

      var json = msgIsString ? JSON.parse(event.data) : event.data;

      if (json.__cmpCall) {

        var i = json.__cmpCall;

        win.__cmp(i.command, i.parameter, function(retValue, success) {

          var returnMsg = {
            '__cmpReturn': {

              'returnValue': retValue,

              'success': success,

              'callId': i.callId,

            },
          };

          event.source.postMessage(msgIsString ? JSON.stringify(returnMsg) : returnMsg, '*');

        });

      }

    } catch (ignore) {/* Ignore messages we don't recognize */}

  }

  if (typeof (__cmp) !== 'function') {

    win.__cmp = stubCMP;

    __cmp.msgHandler = cmpMsgHandler;

    win.addEventListener('message', cmpMsgHandler, false);

  }

})();








