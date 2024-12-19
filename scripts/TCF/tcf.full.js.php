<?php

@header('Content-Type: application/javascript; charset=utf-8');

?>
//JavaScript Document


	if (1==2) {
	
	/*
	Carga de la librería
	LIBRERIA iabtcf Master
	*/
	
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/index.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/CmpApiModel.js"></sc'+'ript>');
	
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/GetTCDataCommand.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/AddEventListenerCommand.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/Command.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/command/index.js"></sc'+'ript>');
	
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/index.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/Disabled.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/InAppTCData.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/Ping.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/Response.js"></sc'+'ript>');
	document.write('<sc'+'ript src="//cookie21.com/cm/scripts/TCF/iabtcf/cmpapi/lib/mjs/response/TCData.js"></sc'+'ript>');
	
	}
	
	
	
	
	
	
	function vendorList() {
	
		return 'https://vendor-list.consensu.org/v3/vendor-list.json';
		
	}
	
	
	function fechaActual() {
	
	
		return Math.round(Date.UTC(new Date().getUTCFullYear(), new Date().getUTCMonth(), new Date().getUTCDate())/100);
	
	
	
		/*OLD*/
		return Math.round((new Date()).getTime()/100);
		/*Return Deciseconds*/
	
	
		milisegundos = new Date().getTime();
		segundos = milisegundos/1000;
		
		segundos = Math.trunc(segundos);
		//return segundos + ' vs <?php echo time(); ?>' ;
		return segundos;
	}
	
	
	
	/* Funcion para convertir un número a binario en su mínima expresión*/
    	function convertToBinary (number, bin) {
	    if (number > 0) {
	        return convertToBinary( parseInt(number / 2) ) + (number % 2)
	    };
	    return '';
	}
	
	
	
	
	
	function binary_encode( s ) {
	   if (!s) { s = ''; }
           s = unescape( encodeURIComponent( s ) );
           var chr, i = 0, l = s.length, out = '';
           for(var i = 0 ; i < l; i ++ ){
               chr = s.charCodeAt( i ).toString( 2 );
               while( chr.length % 8 != 0 ){ chr = '0' + chr; }
               out += chr;
           }
           if (!out) { out = ''; }
           
           return out;
    	}
    	
    	
    	/*Funcion con que Añadimos 0s al binario hasta lograr los bits deseados*/
    	function binary_long(string,long) {
    	
    		
    		if (string.length < long) {
    			return binary_long('0'+string,long);
    		}
    		return string;
    	
    	}
    	
    	
    	/*Completa el final de una cadena con los 0s necesarios*/
    	function fillbits(string, longitud) {
    		
    		if (!longitud) {
	    		cadena = '00000000';//Múltiples de 8
	    		longitud = cadena.length;
    		}
    		
    		caracteres = string.length;
    		resultado = caracteres/longitud ;
    		
    		if (resultado == Math.trunc(resultado)) {
    			return string;
    		}
    		
    		string = string+'0';
    		
    		return fillbits(string);
    	}
	
	
	function espacios8bits(num) {
		let sp = Array.from(num).reduce((acc,t,i) => {
		   if(i>0 && i%8== 0) acc+=" "; //esta condición es la que hace el truco, tiene que ser divisible por 8 y mayor que cero, esto último para no agregar un espacio al inicio ya que cero es 0/8 es cero
		   acc+=t;
		   return acc;
		});
		
		return sp;
	
	}
	
	function tcDefaultVersion() {
	
		return '2';
			
	}
	
	function defaultVendor() {
	
		return '755';//Google
	
	}
	
	function cmpDefaultId() {
	
		return '1';//Aun no asignado
	
	}
	function languageES() {
		return '000100'+'010010';
	}
	
	
	
	function construye_tcString(vendor, legitimate, allowed, purposes, interests, features, cmpId, cmpVersion, consentScreen, vendorListVersion, purposesVersion, consentLanguage, countryCode, consentCreated, consentLastUpdated, defaultConsent) {
	
		/*
			Documentación:
			https://github.com/InteractiveAdvertisingBureau/GDPR-Transparency-and-Consent-Framework/blob/master/TCFv2/IAB%20Tech%20Lab%20-%20Consent%20string%20and%20vendor%20list%20formats%20v2.md
			
			Versión anterior obsoleta:
			https://github.com/InteractiveAdvertisingBureau/GDPR-Transparency-and-Consent-Framework/blob/master/Consent%20string%20and%20vendor%20list%20formats%20v1.1%20Final.md
		*/
		
		/*
		¿Cuál es el alcance de una TC String?
		Los CMP deben operar en una configuración específica del servicio o del grupo. 
		Una cadena TC en este contexto se aplica solo a un servicio o grupo de servicios, por ejemplo, 
		los sitios o aplicaciones en los que se ejecuta. Se crea uno para cada usuario en un sitio/aplicación determinado
		 o grupo de sitios/aplicaciones. Pueden contener restricciones del editor y un segmento TC del editor cuando los devuelve la API de CMP.
		
		
		*/
		
		
		//Demo tcString de ejemplo para Google Acepta TODOs los propósitos
		//tcString = 'CPyhXpFPyhXpFPZAABENCZCsAP_AAH_AAAiQF5wAQF5gXnABAXmAAA.YAAAAAAAAAA';
		//return tcString;
		//FIN DEMO
		
		//alert('Cargando parámetros de ... tcString');
		
		/*
		Formato de cadena TC
			Hay 3 segmentos distintos de TC String que están unidos en un carácter de "punto". Ellos son:
			
			Los detalles principales de transparencia y consentimiento del proveedor
			Proveedores revelados
			El editor busca transparencia y consentimiento para sus propios usos de datos.
		*/
		
		
		
		tcVersion = tcDefaultVersion();
		
		
		
		
		if (!cmpId) { 
		/*
			Usamos el siguiente para las pruebas
		*/
		
			cmpId = cmpDefaultId();
		}
		
		
		
		
		
		if (!cmpVersion) { cmpVersion = '1'; }
		
		
		
		if (!consentScreen) {
		
			/*
				Número de pantalla de CMP en el que se otorgó el consentimiento para un usuario con el CMP que actualizó por última vez esta cadena de TC. 
				El número es una designación interna de CMP y es específico de CmpVersion. El número se utiliza para identificar en qué pantalla un 
				usuario dio su consentimiento como registro.
			*/
			consentScreen = '1';
		
		}
		
		
		
		
		if (!vendorListVersion) { 
			/*
			consensu.org no está funcionando, usamos la última vendorlist mostrada en 
			https://iabtcf.com/#/encode
			*/
			
			vendorListVersion = '3';
		  }
		
		if (!consentLanguage) { 
			//consentLanguage = 'ES';//4+18
			consentLanguage = languageES();//Numeros en Binario, Cadena de 8 bits
		}
		
		if (!countryCode) { countryCode = consentLanguage; }
		
		//alert('Cargando info de ... tcString');
		
		if (!vendor)  { vendor = defaultVendor();  }
		
		if (!legitimate)  { legitimate = vendor;  }
		
		if (!allowed)  { allowed = vendor;  }
		
		//alert('Cargando fechas de ... tcString');
		
		if (!consentCreated) { consentCreated = fechaActual(); }
		
		//alert('Cargada fecha actuap para ... tcString');
		
		if (!consentLastUpdated) { consentLastUpdated= consentCreated; }
		
		//alert('Fechas cargadas para ... tcString');
		
		
		if (!purposes) { purposes = '1'; }
		if (!interests) { interests = '1'; }
		if (!features) { features = '1'; }
		if (!purposesVersion) { purposesVersion = '1'; }
		
		
		
		//alert('Cargando consent de ... tcString');
		
		if (!defaultConsent) { defaultConsent = '1'; }
		
		
		
		
		
		
		
		//alert('Creando... tcString');
		
		
		
		coreString = '';
		
		
		
		//Version
		coreString += binary_long(convertToBinary(2),6);
		
		
		//Created
		coreString += binary_long(convertToBinary(consentCreated),36);
		
		//LastUpdated
		coreString += binary_long(convertToBinary(consentLastUpdated),36); 
		
		//cmpId
		coreString += binary_long(convertToBinary(cmpId),12);
		
		//cmpVersion
		coreString += binary_long(convertToBinary(cmpVersion),12);
		
		//consentScreen
		coreString += binary_long(convertToBinary(consentScreen),6);
		
		//consentLanguage
		coreString += consentLanguage;
		
		
		//VendorListVersion
		/*Dudas: Interpreta el decoder éste valor, parece que no funciona*/
		
		coreString += binary_long(convertToBinary(vendorListVersion),12);
		/*
		Dudas: Si consensu.org no funciona podemos obtener el último vendorList del decoder?
		https://iabtcf.com
		*/
		
		
		//TcfPolicyVersion
		coreString += binary_long(convertToBinary(2),6);
		/*
		Usamos las versión 2 para el ejemplo de "Google Acepta Todo"
		
		DUDAS: Se usa ¿TcfPolicyVersion?
		(No está plasmada en el decoder: https://iabtcf.com/#/encode)
		*/
		
		
		
		
		//IsServiceSpecific
		coreString += '1';
		/*
			Este campo siempre debe tener el valor de 1. 
			Cuando un proveedor encuentra una cadena TC con IsServiceSpecific=0,
			 se considera no válida.
		*/
		
		
		
		//UseNonStandardTexts
		coreString += '1';
		
		
		//SpecialFeatureOptIns
		coreString += '0000'+'0000'+'0011';
		/*
		The TCF Policies designates certain Features as “special” which means a CMP must afford the user a means to opt in to their use. 
		These “Special Features” are published and numerically identified in the Global Vendor List separately from normal Features.
		
		1 bit por cada una
		*/
		
		
		//PurposesConsent (renamed from PurposesAllowed)
		coreString += '0000'+'0000'+'0000'+'0011'+'1111'+'1111';
		/*One bit for each Purpose:

			1 Consent
			0 No Consent
		*/
		/*
		El valor del consentimiento del usuario para cada Finalidad establecido sobre la base legal del consentimiento.

		Los Propósitos se identifican numéricamente y se publican en la Lista Global de Proveedores. 
		De izquierda a derecha, el Propósito 1 se asigna al bit 0, el propósito 24 se asigna al bit en el índice 23. 
		Los Propósitos especiales son un espacio de identificación diferente y no se incluyen en este campo.
		*/
		
		
		//PurposesLITransparency
		coreString += '0000'+'0000'+'0000'+'0011'+'1111'+'1111';
		/*
		Los requisitos de transparencia del Propósito se cumplen para cada Propósito sobre la base legal del interés legítimo 
		y el usuario no ha ejercido su “Derecho a Oponerse” a ese Propósito.
		De forma predeterminada, o si el usuario ha ejercido su “Derecho a oponerse” a un Propósito, el bit correspondiente para ese Propósito
		 se establece en 0. De izquierda a derecha, el Propósito 1 se asigna al bit 0 y el propósito 24 se asigna al bit en índice 23. Propósitos especiales es un espacio de identificación diferente y no se incluye en este campo.
		Nota: Con TCF v2.2, la compatibilidad con intereses legítimos para los fines 3 a 6 ha quedado obsoleta. Los bits 2 a 5 deben establecerse en 0.
		*/
		
		
		
		//PurposeOneTreatment
		coreString += '0';
		/*
		1 El propósito 1 NO fue revelado en absoluto.

		0 El Propósito 1 se reveló comúnmente como consentimiento como se espera en las Políticas.
		*/
		
		
		//PublisherCC
		coreString += consentLanguage;
		
		
		
		//VendorConsent (Esto es una prueba a 24 bits)
		coreString += binary_long(convertToBinary(vendor),24);
		
		
		
		//VendorLITransparency
		coreString += '0000'+'0000'+'0000'+'0011'+'1111'+'1111';
		
		
		//PublisherRestrictions
		coreString += binary_long(0,12);
		
		
		/*End of core string*/
		
		
		
		
		
		
		
		
		
		//publisherLegitimateInterests
		//tcString += binary_long(convertToBinary(vendor),24);
		
		
		//publisherConsents
		//tcString += binary_long(convertToBinary(vendor),24);
		
		
		
		
		
		
		//purposeLegitimateInterests
		
		
		
		
		
		
		
		
		
		
		
		//return base64encode(tcString);
		/*READY*/
		
		
		
		
		
		
		//tcString += binary_long(convertToBinary(tcVersion),6);//VERSION TCF 2
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//MaxVendorId
		//tcString += binary_long(convertToBinary(vendor),16);
		/*Debido a que esta sección puede tener una longitud variable, esto indica el último ID de la sección para que un 
		decodificador sepa cuándo ha llegado al final.*/
		
		
		//IsRangeEncoding
		//tcString += '0';
		/*
		El esquema de codificación utilizado para codificar los ID en la sección: sigue una sección BitField o una sección de rango. La lógica de codificación debe elegir el esquema de codificación que dé como resultado el tamaño de salida más pequeño para un conjunto determinado.
		*/
		
		
		//BitField
		//tcString += '1';
		/*
		El valor de consentimiento para cada ID de proveedor de 1 a MaxVendorId donde el índice 0 es el ID de proveedor 1.

		Establecer el bit correspondiente a un determinado proveedor en 1 
		si el usuario ha dado su consentimiento para que este proveedor procese sus datos personales.
		*/
		
		
		
		
		//NumEntries
		//tcString += binary_long(convertToBinary(vendor),12);
		
		
		
		/*
		IsARange	1 bit	1 Vendor ID range
					0 Single Vendor ID
		*/
		//tcString += '0';
		
		
		
		
		
		
		
		//StartOrOnlyVendorId
		//tcString += binary_long(convertToBinary(vendor),16);
		
		
		
		//EndVendorId
		//tcString += binary_long(convertToBinary(vendor),16);
		/*
		El último ID de la serie inclusiva y contigua de ID de proveedor en orden ascendente comenzó con StartOrOnlyVendorId, 
		pero solo si esa serie tiene una cardinalidad mayor que 1; de lo contrario, este campo se omite.
		*/
		
		
		//MaxVendorId
		//tcString += binary_long(convertToBinary(vendor),16);
		
		
		//IsRangeEncoding
		//tcString += '0';
		
		
		
		//BitField
		//tcString += '1';
		/*El valor del interés legítimo para cada ID de proveedor desde 1 hasta MaxVendorId donde el índice 0 es el ID de proveedor 1.
		Establezca el bit correspondiente a un proveedor determinado en 1 si el CMP ha establecido transparencia para las divulgaciones
		 de intereses legítimos de ese proveedor para uno o más Propósitos (incluidos Propósitos Especiales).

		Si un usuario ejerce su "derecho a oponerse" al procesamiento de un proveedor basándose en un interés legítimo, 
		entonces el bit de ese proveedor debe establecerse en 0. Para proveedores que se registran únicamente para 
		fines especiales (sin otros fines) y han sido mostrados por el CMP el valor debe establecerse en 1. 
		Nota: Los fines especiales se muestran solo con fines transparentes y no permiten la elección del usuario.
		*/
		
		
		//NumEntries
		//tcString += binary_long(convertToBinary(vendor),12);
		
		
		//IsARange
		//tcString += '0';
		
		
		//StartOrOnlyVendorId
		//tcString += binary_long(convertToBinary(vendor),16);
		
		//EndVendorId
		//tcString += binary_long(convertToBinary(vendor),16);
		
		
		
		
		
		
		/*
		NumPubRestrictions
		*/
		//tcString += binary_long(0,12);
		
		
		/*
		PubRestrictionEntry (Repeated NumPubRestrictions times)
		*/
		//tcString += binary_long(0,12);
		
		
		
		/*
		PurposeId
		El ID de propósito declarado por el proveedor que el editor ha indicado que tiene prioridad.
		*/
		//tcString += binary_long(1,6);
		
		
		
		
		
		
		
		
		
		/********************
		
		RESTRICTIONS
		
		********************/
		
		/*RestrictionType 2bits*/
		//tcString += binary_long(convertToBinary(2),2);
		
		
		/*NumEntries*/
		//tcString += binary_long(0,12);
		/*NumEntries*/
		//tcString += binary_long(0,12);
		
		//IsARange
		//tcString += '0';
		
		/*StartOrOnlyVendorId*/
		//tcString += binary_long(0,16);
		
		/*EndVendorId*/
		//tcString += binary_long(0,16);
		
		
		
		
		
		
		
		
		//coreString = tcString;
		//tcString = '';
		
		
		
		
		/*SegmentType*/
		//tcString += '000';
		
		/*PubPurposesConsent*/
		//tcString += '0111111111'+'1111111111'+'1111';
		
		/*PubPurposesLITransparency*/
		//tcString += '0111111111'+'1111111111'+'1111';
		
		
		/*NumCustomPurposes*/
		//tcString += binary_long(0,6);
		
		
		
		//coreString = fillbits(coreString);
		//tcString = fillbits(tcString);
		
		
		
		//alert('tcString Creado');
		/*
		if (!restrictionsString) restrictionsString = '';
		if (!disclosedVendorsString) disclosedVendorsString= '';
		if (!allowedVendorsString) allowedVendorsString= '';
		*/
		//tcStringFinal = base64encode(coreString)+'.'+base64encode(restrictionsString)+'.'+base64encode(disclosedVendorsString)+'.'+base64encode(allowedVendorsString);
		
		tcStringFinal = base64encode(coreString);
		
		return final_tcString(tcStringFinal);
		//return espacios8bits(tcString);
		
		
		
		/*
		
		Vendor: 755 (Google)
		tcString ES: CPyHjUhPyHjUhPoABBENCZCMAP_AAH_AAAiQF5wAQF5gXnABAXmAAA.II7Nd_X__bX9n-_7_6ft0eY1f9_r37uQzDhfNs-8F3L_W_LwX32E7NF36tq4KmR4ku1bBIQNtHMnUDUmxaolVrzHsak2cpyNKJ_JkknsZe2dYGF9Pn9lD-YKZ7_5_9_f52T_9_9_-39z3_9f___dv_-__-vjf_599n_v9fV_78_Kf9______-____________8A
		
		*/
	}
	
	function final_tcString(string) {
		
		string = string.replace('=','');
		string = string.replace('=','');
		string = string.replace('=','');
		string = string.replace('=','');
		string = string.replace('=','');
		string = string.replace('=','');
		
		return string;
	}
	
	
	/*
	Funcion para construir el "Modo de Consentimiento Adicional de Google"
	
	Se constituye cómo;
	Una cadena ligera de Consentimiento Adicional, 
	addtl_consent, que contiene una lista con Proveedores de Tecnología Publicitaria de Google
	 autorizados que no están registrados en IAB.
	*/
	function construyeCadenaTCFAdicional(IDproveedores) {
	
		version = 2;
		
		cadena = version + '~'+IDproveedores;
		
		addtl_consent = cadena;
		
		return addtl_consent;
	
	}
	function comparteCadenaAdicionalTCF(IDproveedores,vendorURL) {
	
	        URL = window.location.href;
	        addtl_consent = construyeCadenaTCFAdicional(IDproveedores);
	
		document.getElementById('imgAjax1').src = vendorURL+'/?&gdpr=1&URL='+URL+'&addtl_consent='+addtl_consent;
	
	}
	
	function base64encodeURL(url) {
	
		if (!url) { url = window.location.href; }
		
		return base64encode(url);
		
	}
	
	
	function base64encode(string) {
	
		return btoa(string);
	
	}
	
	function base64decode(string) {
	
		return atob(string);
	
	}
	
	
	
	
	
	
	
	/*
	
	Solución de problemas con la implementación del Marco de Transparencia y Consentimiento v. 2.0
	
	https://support.google.com/admanager/answer/9999955?hl=es
	
	*/
	
	
	
	/*Soporte Informativo Adicional
	
	
	IABTCF_AddtlConsent	
	Cadena: cadena de Consentimiento Adicional que incluye la versión de la especificación y el ID del Proveedor de Tecnología Publicitaria que tiene el consentimiento
	
	
	
	
	*/
	
	
	
	/*Funciones para pruebas*/
	/*
	
	https://www.cookie21.com/cm/pruebas.php
	
	*/
	
	function TCF_Ping() {
	
		ping = 'Ping fallido';
	
		__tcfapi('ping', 2, (pingReturn) => {

			ping = 'Ping Correcto';
		
		});
		
		return ping;
	
	}
	
	function TCF_addEventListener(acceptStatus) {
	
		tcData = TCF_TCData(acceptStatus);
		
		
		resultado = 'Funcion fallida';
	
			const callback = (tcData, success) => {

		  if(success && tcData.eventStatus === 'tcloaded') {
		
		    // do something with tcData.tcString
		    resultado = 'Funcion satifactoria';
		
		  } else {
		
		    // do something else
		    resultado = 'Funcion a medias';
		
		  }
		
		}
		
		__tcfapi('addEventListener', 2, callback);
		
		return resultado;
	
	}
	
	function TCF_getInAppTCData(acceptStatus) {
	
		inAppTCData = TCF_inAppTCData(acceptStatus);
		
		resultado = 'Funcion fallida';
	
		__tcfapi('getInAppTCData', 2, (inAppTCData, success) => {
	
		  if(success) {
		
			resultado = 'Funcion Perfecta';
		    // do something with inAppTCData
		
		  } else {
			resultado = 'Funcion con fallos';
		
		    // do something else
		
		  }
		
		});
		
		return resultado;
	
	}
	
	function TCF_TCData(acceptStatus,vendor) {
	
		if (acceptStatus) { acceptStatus = true; } else { acceptStatus = false; }
		if (!vendor) { vendor = 755; } //Google
		
		TCData = {
		  tcString: final_tcString(construye_tcString(vendor)),
		  tcfPolicyVersion: 4,
		  cmpId:1000,
		  cmpVersion: 1000,
		
		  /**
		   * true - GDPR Applies
		   * false - GDPR Does not apply
		   * undefined - unknown whether GDPR Applies
		   * see the section: "What does the gdprApplies value mean?"
		   */
		  gdprApplies: true,
		
		  /*
		   * see addEventListener command
		   */
		  eventStatus: String,
		
		  /**
		   * see Ping Status Codes in following table
		   */
		  cmpStatus: 'string',
		
		  /**
		   * If this TCData is sent to the callback of addEventListener: number,
		   * the unique ID assigned by the CMP to the listener function registered
		   * via addEventListener.
		   * Others: undefined.
		   */
		  listenerId: 1,//edited
		
		  /*
		   * true - Default value
		   * false - TC String is invalid.
		   * since Sept 1st 2021, TC strings established with global-scope are considered invalid.
		   * see the section: ["What happened to Global Scope and Out of Band?"](https://github.com/InteractiveAdvertisingBureau/GDPR-Transparency-and-Consent-Framework/blob/master/TCFv2/TCF-Implementation-Guidelines.md#gsoob) in "IAB Europe Transparency and Consent Framework Implementation Guidelines"
		   */
		  isServiceSpecific: true,
		
		  /**
		   * true - CMP is using publisher-customized stack descriptions and/or modified or supplemented standard Illustrations
		   * false - CMP is NOT using publisher-customized stack descriptions and or modified or supplemented standard Illustrations
		   */
		  useNonStandardTexts: acceptStatus,
		
		  /**
		   * Country code of the country that determines the legislation of
		   * reference.  Normally corresponds to the country code of the country
		   * in which the publisher's business entity is established.
		   */
		  publisherCC: 'ES',//Edited By JLC
		
		  /**
		   *
		   * true - Purpose 1 not disclosed at all. CMPs use PublisherCC to
		   * indicate the publisher's country of establishment to help Vendors
		   * determine whether the vendor requires Purpose 1 consent.
		   *
		   * false - There is no special Purpose 1 treatment status. Purpose 1 was
		   * disclosed normally (consent) as expected by TCF Policy
		   */
		  purposeOneTreatment: acceptStatus,
		
		  purpose: {
		    consents: {
		
		      /**
		       * true - Consent
		       * false | undefined - No Consent.
		       */
		      '[purpose id]': acceptStatus
		    },
		   legitimateInterests: {
		
		      /**
		       * true - Legitimate Interest Established
		       * false | undefined - No Legitimate Interest Established
		       */
		      '[purpose id]': acceptStatus
		    }
		  },
		  vendor: {
		
		    consents: {
		
		      /**
		       * true - Consent
		       * false | undefined - No Consent
		       */
		      '[vendor id]': acceptStatus
		
		    },
		    legitimateInterests: {
		
		      /**
		       * true - Legitimate Interest Established
		       * false | undefined - No Legitimate Interest Established
		       */
		      '[vendor id]': acceptStatus
		
		    }
		  },
		  specialFeatureOptins: {
		
		      /**
		       * true - Special Feature Opted Into
		       * false | undefined - Special Feature NOT Opted Into
		       */
		      '[special feature id]': acceptStatus
		  },
		  publisher: {
		    consents: {
		
		      /**
		       * true - Consent
		       * false | undefined - No Consent
		       */
		      '[purpose id]': acceptStatus
		    },
		    legitimateInterests: {
		
		      /**
		       * true - Legitimate Interest Established
		       * false | undefined - No Legitimate Interest Established
		       */
		      '[purpose id]': acceptStatus
		    },
		    customPurpose: {
		      consents: {
		
		        /**
		         * true - Consent
		         * false | undefined - No Consent
		         */
		        '[purpose id]': acceptStatus
		      },
		      legitimateInterests: {
		
		        /**
		         * true - Legitimate Interest Established
		         * false | undefined - No Legitimate Interest Established
		         */
		        '[purpose id]': acceptStatus
		      },
		    },
		    restrictions: {
		
		      '[purpose id]': {
		
		        /**
		         * 0 - Not Allowed
		         * 1 - Require Consent
		         * 2 - Require Legitimate Interest
		         */
		        '[vendor id]': 1
		      }
		    }
		  }
		};
	  	return TCData;
	}
	
	function TCF_inAppTCData() {
		InAppTCData = {
		  tcString: base64encodeURL(),
		  tcfPolicyVersion: 2,
		  cmpId:1000,
		  cmpVersion: 1000,
		
		  /**
		   * 1 - GDPR Applies
		   * 0 - GDPR Does not apply
		   * undefined - unknown whether GDPR applies
		   * see the section: "What does the gdprApplies value mean?"
		   */
		  gdprApplies: 1,
		
		  /*
		   * see addEventListener command
		   */
		  eventStatus: 'string',
		
		  /*
		   * 1 - Default value
		   * 0 - TC String is invalid.
		   * since Sept 1st 2021, TC strings established with global-scope are considered invalid.
		   * see the section: ["What happened to Global Scope and Out of Band?"](https://github.com/InteractiveAdvertisingBureau/GDPR-Transparency-and-Consent-Framework/blob/master/TCFv2/TCF-Implementation-Guidelines.md#gsoob) in "IAB Europe Transparency and Consent Framework Implementation Guidelines"
		   */
		  isServiceSpecific: 1,
		
		  /**
		   * 1 - CMP is using publisher-customized stack descriptions and/or modified or supplemented standard Illustrations
		   * 0 - CMP is NOT using publisher-customized stack descriptions and/or modified or supplemented standard Illustrations
		   */
		  useNonStandardTexts: 1,
		
		  /**
		   * Country code of the country that determines the legislation of
		   * reference.  Normally corresponds to the country code of the country
		   * in which the publisher's business entity is established.
		   */
		  publisherCC: 'Two-letter ISO 3166-1 alpha-2 code',
		
		  /**
		   * 1 - Purpose 1 not disclosed at all. CMPs use PublisherCC to indicate
		   * the publisher's country of establishment to help vVendors determine
		   * whether the vendor requires Purpose 1 consent.
		   *
		   * 0 - There is no special Purpose 1 treatment status. Purpose 1 was
		   * disclosed normally (consent) as expected by TCF Policy.
		   */
		  purposeOneTreatment: 1,
		
		  purpose: {
		
		    /**
		     * 1 - Consent
		     * 0 | undefined - No Consent
		     */
		    consents: '01010 -- Purpose bitfield',
		
		    /**
		     * 1 - Legitimate Interest Established
		     * 0 | undefined - No Legitimate Interest Established
		     */
		    legitimateInterests: '01010 -- Purpose bitfield'
		  },
		  vendor: {
		
		    /**
		     * 1 - Consent
		     * 0 | undefined - No Consent
		     */
		    consents: '01010 -- Vendor bitfield',
		
		    /**
		     * 1 - Legitimate Interest Established
		     * 0 | undefined - No Legitimate Interest Established
		     */
		    legitimateInterests: '01010 -- Vendor bitfield'
		  },
		
		  /**
		   * 1 - Special Feature Opted Into
		   * 0 | undefined - Special Feature NOT Opted Into
		   */
		  specialFeatureOptins: '01010 -- Special Feature bitfield',
		
		  publisher: {
		
		    /**
		     * 1 - Consent
		     * 0 | undefined - No Consent
		     */
		    consents: '01010 -- Purpose bitfield',
		
		    /**
		     * 1 - Legitimate Interest Established
		     * 0 | undefined - No Legitimate Interest Established
		     */
		    legitimateInterests: '01010 -- Purpose bitfield',
		
		    customPurpose: {
		
		      /**
		       * 1 - Consent
		       * 0 | undefined - No Consent
		       */
		      consents: '01010 -- Purpose bitfield',
		
		      /**
		       * 1 - Legitimate Interest Established
		       * 0 | undefined - No Legitimate Interest Established
		       */
		      legitimateInterests: '01010 -- Purpose bitfield'
		    },
		    restrictions: {
		
		      /**
		       * 0 - Not Allowed
		       * 1 - Require Consent
		       * 2 - Require Legitimate Interest
		       * _ - No Restriction (maintains indexing)
		       *
		       * each position represents vendor id and number represents restriction
		       * type 0-2
		       */
		      '[purpose id]': '01201221'
		    }
		  }
		};
	  	return InAppTCData;
	}
	
