<?php

@header('Content-Type: application/javascript; charset=utf-8');

include('../../funciones.php');

?>
//JavaScript Document

/*

Declaramos cm21tcf, para identificar que la carga ESTE del script se ha realizado
Y evitar también cargarlo varia veces (utilizando un condicional previo)

*/

var cm21tcf = 'loaded';


if (1==2) {

	if (typeof c21_iab_encoder !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {
	
		document.write('<sc'+'ript src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/Consent-String-SDK-JS-master/src/encode.js"></sc'+'ript>');
		var c21_iab_encoder = 'loaded';
		
	}
	
}






/*

Generamos vario enlaces de STUB, en funcion 
del estado y del desarrollo de las prubas con el CMP.


0 = VALOR OMITIDO
1 = VALOR ACTIVO

*/


if (1) { /*CARGA STUB*/

	if (1) {
	
	document.write('<sc'+'ript src="//iab.cookie21.com/iabtcf-es-master/modules/stub/src/stub.js"></sc'+'ript>');
	
	} else if (0) {
	
	document.write('<sc'+'ript src="//iab.cookie21.com/stub.js"></sc'+'ript>');
	
	} else if (0) {
	
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/stub.js"></sc'+'ript>');
	
	}

}











if (1==2) {

alert('Welcome!');

}





	if (1==2) {

		/*ANULADO SU LLAMADA SE HACE DIRECTAMENTE DESDE IAB.COOKIE21.COM*/

		
		document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/config.js?ctime=<?php echo time(); ?>"></sc'+'ript>');
	
		document.write('<iframe style="display:none;" id="iab_cookie21_com" name="iab_cookie21_com" src="https://cookie21.com/cm/scripts/TCF/config.php?token=<?php echo $_REQUEST['token']; ?>&ctime=<?php echo time(); ?>"></iframe>');


	}



    if (1==2) {
	

		/*
		
		document.write('<sc'+'ript type="module" src="https://iab.cookie21.com/config.js"></sc'+'ript>');
		*/

		/*
		c21_loadjs_module("https://iab.cookie21.com/config.js?ctime=<?php echo time(); ?>");
		*/


		/*
		document.write('<sc'+'ript type="module" src="https://cookie21.com/cm/scripts/TCF/modules.js.php"></sc'+'ript>');
		*/
	/*
	document.write('<sc'+'ript src="https://iab.cookie21.com/modules/stub/src/stub.js"></sc'+'ript>');
	*/


	}



















if (1==2) {


	function __tcfapi(one, twoo, three) { 

	 javascript("window.open('javascript:__tcfapi(one, twoo, three);');",'iab_cookie21_com');


	}


}




















	function c21_iab_CS_process() {
	
		var iabConsentString = false;
		
		const { ConsentString } = require('//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/Consent-String-SDK-JS-master/src/consent-string.js');
		
		const consentData = new ConsentString();

		// Set the global vendor list
		// You need to download and provide the vendor list yourself
		// It can be found here - https://vendorlist.consensu.org/vendorlist.json
		consentData.setGlobalVendorList(vendorList);
		
		// Set the consent data
		consentData.setCmpId(1);
		consentData.setCmpVersion(1);
		consentData.setConsentScreen(1);
		consentData.setConsentLanguage('en');
		consentData.setPurposesAllowed([1, 2, 4]);
		consentData.setVendorsAllowed([1, 24, 245]);
		
		// Encode the data into a web-safe base64 string
		iabConsentString = consentData.getConsentString();
	
	
		alert(iabConsentString);
		
		return iabConsentString;
	
	
	}

	  	
	document.write('<div id="div_iab_ajax"></div>');
	
	
	function load_iab_source() {
	
	  	if (getCookie('iabConsentString')  != 'idioma_sin_proveedores') {
	  	
	  	
	  		if ('v1' == 'v2') {
	  		
	  		
	  			iabConsentString = c21_iab_CS_process();
		  	
		  	
		  		saveCookieCM21('iabConsentString',iabConsentString);
	  			
	  		
		  
			} else if (document.getElementById("iab_manager")) {
			
				/*YA EXISTE*/
				
			} else {
			
		    	var compatible = 'true';
		    	if (compatible) {
				

			
					document.getElementById("div_iab_ajax").innerHTML = '<iframe src="about:blank;" style="position:fixed;top:1px;left:1px;width:99%;height:550px;display:none;" id="iab_manager" name="iab_manager"></iframe>';
			    
			  			
			    
			  		var source_iab= '<script>window.location.href=window.location.href+"#/encode";</script><base href="https://iabtcf.com/"><?php echo limpia(file_get_contents('https://iabtcf.com/')); ?><script type="text/javascript" src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/iab.clone.scripts.js.php?token=<?php echo $_REQUEST['token']; ?>"></script>';
			  		
			  		
			  		
			  		
				    	var compatible = 'true';
				    	if (compatible) {
				    	
			  			
			  			document.getElementById('iab_manager').src = "javascript:document.innerHTML='"+source_iab+"';";
			  			
			  		
			  		} else {
			  		
			  			window.open("javascript:document.innerHTML='"+source_iab+"';",'iab_manager');
			  			
			  		}
			  		
			  		
			  	}
	  		
	  		}
	  		
		}
	  	
	
	}
	
	
	
	function c21_enable_encode() {
		//document.getElementById('iab_manager').src= '#/encode';
	
	}
	
	
	
	
	function c21_iab_auditor() {
	
		document.getElementById("iab_manager").style.display='';
	
	}
	
	function c21_calculaProv(id) {
	
		if (getCookie('iab_'+id)) {
		
			c21_iab_carga_prov(id);
		
		} else {
		
			c21_iab_descarga_prov(id);
		
		}
	
	}
	
	function c21_iab_add_feature(id) {
	
		window.open("javascript:suma('"+id+"');",'iab_manager');
	
	
	}
	function c21_iab_delete_feature(id) {
	
		window.open("javascript:resta('"+id+"');",'iab_manager');
	
	
	}
	function c21_iab_add_special_feature(id) {
	
		window.open("javascript:suma_especial('"+id+"');",'iab_manager');
	
	
	}
	function c21_iab_delete_special_feature(id) {
	
		window.open("javascript:resta_especial('"+id+"');",'iab_manager');
	
	
	}
	
	function c21_iab_carga_prov(id) {
	
	
		window.open("javascript:marca('"+id+"');",'iab_manager');
	
	
	
	}
	function c21_iab_descarga_prov(id) {
	
		window.open("javascript:desmarca('"+id+"');",'iab_manager');
	
	}
	




if (1==2) {
	
	/*
	
	Cargamos la librería STUB de IAB para trabajar su Marco de Transparencia Homologado en Europa (Versión 2)
	
	*/
	
	
	document.write('<sc'+'ript src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/iabtcf-es-master/modules/stub/src/stub.js"></sc'+'ript>');
	
}


	/*
	
	El uso y funcionamiento de ésta librería lo encontraremos, con ejemplos, en:
	https://github.com/InteractiveAdvertisingBureau/GDPR-Transparency-and-Consent-Framework/blob/master/TCFv2/IAB%20Tech%20Lab%20-%20CMP%20API%20v2.md
	
	*/
	/*
	
	Con esta libreria informaremos a los proveedores, de la decisión del cliente sobre el uso que se hace 
	de sus datos.
	
	En el caso de Google, la documentación necesaria la encontraremos en: 
	https://support.google.com/authorizedbuyers/answer/9681920?hl=es
	
	*/
	/*
	Los Proveedores de Tecnología Publicitaria de Google, lo encontraremos actualizados en:
	https://storage.googleapis.com/tcfac/additional-consent-providers.csv
	
	*/
	
	/*
	
	La finalidad de el uso de esta cadena es respetar las políticas de Cookies, Privacidad y Uso de datos, establecidas para EU:
	Cómo se indica en: https://www.google.com/about/company/user-consent-policy/
	
	*/
	
	/*
	
	La información en terminología legal y RESUMIDA de éste proceso la encontramos en:
	
	https://iabspain.es/marco_transparencia_consentimiento_iab_europe/
	
	*/
	
	function tcStringFull(todo) {
	
		if (todo) {
			/*Cadena de retorno cuando se Acepta TODO*/
			return 'CPzCXzQPzCXzQA9AAAENCZC8AP_AAH_AAAiQI7Nd_X__bX9n-_7_6ft0eY1f9_r37uQzDhfNs-8F3L_W_LwX32E7NF36tq4KmR4ku1bBIQNtHMnUDUmxaolVrzHsak2cpyNKJ_JkknsZe2dYGF9Pn9lD-YKZ7_5_9_f52T_9_9_-39z3_9f___dv_-__-vjf_599n_v9fV_78_Kf9______-____________8Edmu_r__tr-z_f9_9P26PMav-_1793IZhwvm2feC7l_rfl4L77Cdmi79W1cFTI8SXatgkIG2jmTqBqTYtUSq15j2NSbOU5GlE_kyST2MvbOsDC-nz-yh_MFM9_8_-_v87J_-_-__b-57_-v___u3__f__Xxv_8--z_3-vq_9-flP-_______f___________-AA.YAAAAAAAAAA';
		}
		else {
			/*Cadena de retorno cuando no se acepta nada*/
			return 'CPzCYNDPzCYNDDgAAAENCZCwAAAAAAAAAAAAAAAAAAAA.YAAAAAAAAAA';
		}
	}
	
	
	function c21_iabShare() {
	
		iabConsentString = c21_calcula_iabConsetString();
		
	}
	
	function c21_iab_changeParameter(id,value) {
	
	
		/*alert("javascript:recambia('"+id+"','"+value+"');");*/
	
		window.open("javascript:recambia('"+id+"','"+value+"');",'iab_manager');
	
	}
	
	function c21_iab_guardaConsentString(iabConsentString) {
	
		saveCookieCM21('iabConsentString',iabConsentString);
		/*alert(c21_calcula_iabConsetString());*/
		
	}
	
	
	function c21_recalcula_CS(modo) {
	
		if (getCookie('c21_old_settings') == modo && modo != 4) {
		
			/*alert('same config');*/
			
		}
		else {
		
			if (getCookie('iabConsentString')  != 'idioma_sin_proveedores') {
		  
		  		
				load_iab_source();
			
		
				saveCookieCM21('c21_old_settings',modo);
			
				/*alert(cadenaTrad('idioma_country_code'));*/
				
				saveCookieCM21('consentLanguage',cadenaTrad('idioma_consent_language'));
				
				
			}
		}
	
	
	}
	
	/*
	function c21_iab_loaded() {
	
			if (document.getElementById('iab_manager')) {
			
				window.open("javascript:iab_calc('"+getCookie('c21cm_cookie_consent')+"');",'iab_manager');
				
			}
	
	}
	*/
	
	
	function c21_calcula_iabConsetString() {
	
		
	
		if (getCookie('iabConsentString')) {
		
			var iabConsentString = getCookie('iabConsentString');
		}
		
		if (!iabConsentString ) {
			iabConsentString = 'CP7qewWP7qewWPnABDENCZCgAAAAAAAAAAiQAAAAAAAA.YAAAAAAAAAA';
		}
		
		saveCookieCM21('iabConsentString',iabConsentString);
		
		return iabConsentString;
	
	}
	
	function c21_check_CSiab() {
	
		window.open("https://iabtcf.com/?#/decode?tcstring=" +getCookie("iabConsentString"),"_blank");
	
	}
	function c21_infoTOTALiabCS() {
	
		alert(cadenaTrad("idioma_sobre_consent_string"));
		
		c21_calcula_iabConsetString();
		
		var iabConsentString = getCookie("iabConsentString")
		
		if (!iabConsentString) {
		
			alert('ERROR: '+cadenaTrad('idioma_sin_configurar'));
		
		}
		else if(iabConsentString  == 'idioma_sin_configurar') {
		
			alert('ERROR: '+cadenaTrad('idioma_sin_configurar'));
		
		}
		else if(iabConsentString  == 'idioma_sin_autorizacion') {
		
			alert('ERROR: '+cadenaTrad('idioma_sin_autorizacion'));
		
		}
		else if(iabConsentString  == 'idioma_sin_proveedores') {
		
			alert('ERROR: '+cadenaTrad('idioma_sin_proveedores'));
		
		}
		else {
			alert('CONSENT STRING: ' + getCookie("iabConsentString"));
		
		
			c21_check_CSiab();
		}
		
	}
	

window.addEventListener("load",function(){
    
    /*NOTHING HERE*/

},false);










	