<?php

header('Access-Control-Allow-Origin: *');

@header('Content-Type: application/javascript; charset=utf-8');

session_start();

if (!$_REQUEST['token']) {

	exit('/*NEED A TOKEN*/');

}

if(!$_SESSION['idioma']) {
	$_SESSION['idioma'] = 'es';
}

include_once('../funciones.php');

?>
// JavaScript Document

/*

Declaramos "cm21content"

para evitar cargar el mismo javascript varias veces, y/o saber si se ha cargado


*/



var cm21content = 'loaded';








if (typeof cm21idiomas !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

	document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/idiomas.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
	cm21idiomas = 'loaded';

}


<?php

    $db= new SQLite3('../db/consentsdb');
        
	$q = "SELECT * FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
	
	
	
	$resultado = $db->query($q);
	
	$resultados = false;
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
				
		$fetch = $row;
		
		$resultados = true;
			  
	}
	
	if (!$resultados) {
	
		exit('/*INVALID TOKEN*/');
		
	}
	
	if (!$fetch['color']) $fetch['color'] = '#003366';
	if (!$fetch['background'])  $fetch['background'] = '#fff';
	if (!$fetch['position'])  $fetch['position'] = 'right';
	if (!$fetch['vertical'])  $fetch['vertical'] = 'bottom';
	if (!$fetch['altura'])  $fetch['altura'] = '60';
	/*
	if ($fetch['dominio']) {
	
	
	}*/
?>





	/*
	
	Recuperamos las Variables de configuración del archivo /config/ y
	Las reorganizamos de manera sencilla para el Consent Manager
	
	*/

<?php if ($fetch['analytics']) { ?>
	var gaid = '<?php echo $fetch['analytics']; ?>';
<?php } ?>

	var c21cm_cookie_consent = getCookie("c21cm_cookie_consent");
	var consent = 3;
	var accepted = false;


	if(getCookie("c21cm_cookie_consent")) {
	 	consent = getCookie("c21cm_cookie_consent");
	}
	
	
	/*
	
	AUDITORÍA 
	
		Valores establecidos para el control de cookies del consent
		
		VALOR               ESTADO
		
		  1                  1) El Cliente sólo acepta estadística
		  2                  2) El Cliente acepta todas
		  3                  3) El Cliente NO acepta cookies (Solo necesarias)
		  4                  4) El Cliente ha personalizado sus cookies
	
	
	*/



	// GOOGLE ANALYTICS CONFIGURATION
	/*
	
	Sólo generamos la consulta a Google ANALYTICS Si el Cliente ha configurado su ID
	en el panel del cliente: https://cookie21.com/cm
	
	*/

<?php if ($fetch['analytics']) { ?>
	if (gaid !='' && gaid) {
	
		document.write('<sc'+'ript async src="https://www.googletagmanager.com/gtag/js?id='+gaid+'"></sc'+'ript>');
		
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		
	
		// if we have consent (by cookie) granted, if not, denied.
		if(consent == 1) {
			/*SE ACEPTA SOLO ESTADÍSTICA*/
		
			gtag('consent', 'default', {
			
			'analytics_storage': "granted",
			'ad_user_data': "denied",
			'ad_personalization': "denied"
			
			
			});
			
			
		}
		if(consent == 2) { 
			/*SE ACEPTA TODO*/
		
			gtag('consent', 'default', {
			'ad_storage': 'granted', 
			'analytics_storage': "granted",
			'ad_user_data': "granted",
			'ad_personalization': "granted"
			
			});
			
			
			
		}
		if(consent == 3) {
			/*SOLO NECESARIAS*/
		
		
			gtag('consent', 'default', {
			'ad_storage': 'denied', 
			'analytics_storage': "denied",
			'ad_user_data': "denied",
			'ad_personalization': "denied"
			});
			
			
		}
		if(consent == 4) {
			/*COOKIES PERSONALIZADAS*/
		
			if (document.getElementById("provider_analytics")) {
			
				if (getCookie("provider_analytics") == 'checked') {
				
					if (getCookie("propositoCookies3") == 'checked') {
				
						gtag('consent', 'default', {
						'ad_storage': 'granted', 
						'analytics_storage': "granted",
						'ad_user_data': "granted",
						'ad_personalization': "granted"
						});
					
					} else {
					
					
						gtag('consent', 'default', {
						'ad_storage': 'granted', 
						'analytics_storage': "granted",
						'ad_user_data': "denied",
						'ad_personalization': "denied"
						});
					
					}
					
				}
				else {
				
					if (getCookie("propositoCookies3") == 'checked') {
				
						gtag('consent', 'default', {
						'ad_storage': 'denied', 
						'analytics_storage': "denied",
						'ad_user_data': "granted",
						'ad_personalization': "granted"
						});
					
					} else {
					
					
						gtag('consent', 'default', {
						'ad_storage': 'denied', 
						'analytics_storage': "denied",
						'ad_user_data': "denied",
						'ad_personalization': "denied"
						});
					
					}
					
				}
			}
			
		}
			
		gtag('config', gaid);
	}

<?php } ?>
	// END OF GOOGLE TAG CONFIGURATION
	




/*AUDITORIA: FUNCION PARA EL CONTROL DE MULTIPLES CMP QUE PUEDAN ENTRAR EN CONFLICTO*/

if (typeof c21_have_checkCompetence === 'function') { /*EXISTS*/ } else {
			
	function c21_have_checkCompetence() {


				if (document.documentElement.innerHTML.includes('/adsbygoogle.js')) { return true; }

				return false;
	}
			
}









	
	
	
	/*TRANSPARENCY SHARED CONSENT para TCF*/
	/*IMG preparada para compartir la cadena de consentimiento*/
	//document.write('<img id="imgAjax1" src="about:blank;" style="display:none;">');
	/*
	
	Ésta opción esta deshabilitada pues el pixel se entrega en el panel de proveedores.
	De manera individual por proveedor.
	
	
	Además de éste pixel invisible para compartir datos, 
	generamos un elemelemto iframe mediante el código
	Stub.js llamado al final del script, con el cual
	facilitaremos a iab las decisiones del usuario
	para que éste, lo transfiera a los proveedores
	de publicidad autorizados. (  https://cookie21.com/cm/scripts/TCF/vendor-list.json  )
	
	*/
	
	
	
	
	if (!c21_have_checkCompetence()) {

				document.write(unescape("%3Cscript src='//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/GLOBALS.js?ctime=<?php echo time(); ?>' type='text/javascript'%3E%3C/script%3E"));

	}
	

	/*AUDITORÍA: Cargamos la libreria TCF de iAB*/
	if (typeof cm21tcf !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {
	

		if (!c21_have_checkCompetence()) {

				document.write(unescape("%3Cscript src='//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/tcf.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));

				cm21tcf = 'loaded';
		}
	}
	
	
	/*Esta función se puede reemplazar por un include php, 
	en ese caso, su contenido, quedaría dentro de éste mísmo archivo*/
	
	<?php
	
	//include_once('../scripts/TCF/tcf.js.php');
	
	?>
	
	
	
	
	if (!c21_have_checkCompetence()) {

				document.write(unescape("%3Cscript src='//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/FUNCTIONS.js?ctime=<?php echo time(); ?>' type='text/javascript'%3E%3C/script%3E"));

	}
	
	
	
	


	
	
	/*iFrame para consultas ajax*/
	/*
	
	Éste iframe nos servirá para inputs a enlaces externos e internos de manera invisible, 
	asi como mantener una trazabilidad de las acciones del usuario.
	
	*/
	document.write('<iframe id="cm21jajax" src="about:blank;" style="display:none;"></iframe>');
	
	
	
	











	
	
	/*
	
	AUDITORIA 
	
	Realizamos un input en frame-ajax al proveedor para su trazabilidad
	
	*/
	if ('trazabilidad' == 'NO') {
	
	if ( getCookie("c21cm_cookie_consent") ) {
	
		document.write('<iframe style="display:none;" id="imgInnerConsent" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/acceso/?&load=true&referrer='+window.parent.location.href+'&token=<?php echo $fetch['token']; ?>&consent='+consent+'"></iframe>');
	
	} else {
	
		document.write('<iframe style="display:none;" id="imgInnerConsent" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/acceso/?&default=true&referrer='+window.parent.location.href+'&token=<?php echo $fetch['token']; ?>&consent='+consent+'"></iframe>');
	
	}
	
	}
	
	
	//CSS de Banner del CM (Consent Manger) de Cookie21
	//document.write('<style> @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"); </style>');
	
	document.write('<style> .cm21color { color:<?php echo $fetch['color']; ?>;font-family:Arial; }  .c21_bg_color {background-color: <?php echo $fetch['background']; ?>;} .c21_bg_color#hover {background-color: <?php echo $fetch['background']; ?>;}     .c21padding {padding:5px; overflow: auto; text-align:left;font-family:Arial; } div#cookie_button {z-index: 999999999; cursor:help;position: fixed; <?php echo  $fetch['vertical']; ?>: 10px; <?php echo $fetch['position']; ?>:10px; color: <?php echo $fetch['background']; ?>;transition: all 2s ease-in;}.aviso_cm21 {border:solid 1px <?php echo $fetch['contrast']; ?>;z-index: 999999999;visibility: visible;opacity: 1;position: fixed;<?php echo $fetch['vertical']; ?>: 0;<?php echo $fetch['position']; ?>: 0;width: 100%;max-width: 100%;background-color: <?php echo $fetch['background']; ?>;PADDING: 5px;PADDING-left: 25px;PADDING-bottom: 50px;transition: opacity 1s;line-height: 20px;text-align: center;font-family:Arial;}.aviso_cm21 p {margin: 0;margin-bottom: 10px;font-family:Arial;} a#c21_nulled1 {font-family:Arial;padding: 10px;margin: 7px;border: 0;cursor: pointer; background-color: <?php echo $fetch['background']; ?>;} a.c21cm-more-info {color: <?php echo $fetch['background']; ?>;font-family:Arial;} svg#Capa_1 {width: 40px;height: 40px;fill: <?php echo $fetch['color']; ?>;position: relative;top: 8px;left: 8px;} button#cookie_button_b {background-color: transparent;margin: 0;padding: 20px;border-radius: 140px 0 0;} .c21cm-button, .cm21button , a#botonPropositos , a#configuracm21, a#botonListaCookies, a#botonPoliticaCookies ,  a#botonListaProveedores, span#auditoriacm21, span#regresarInicio, span#eliminarTodas, a#acepta, a#acepta2, a#acepta2, a#acepta1, .configuracm21  { float:left; font-family:Arial;background-color: <?php echo $fetch['color']; ?>;color: <?php echo $fetch['background']; ?>;padding: 10px;margin: 10px 10px 10px 10px;cursor:pointer;border:solid 1px <?php echo $fetch['color']; ?>;cursor:pointer;} svg#config{position: relative;top: 5px;margin-right: 3px;margin-top: -11px;fill: <?php echo $fetch['background']; ?>} a#c21nulled4 {font-family:Arial;padding: 10px;margin: 7px;cursor:pointer;border:solid 1px <?php echo $fetch['color']; ?>;cursor:pointer;color: <?php echo $fetch['color']; ?>;background-color: <?php echo $fetch['background']; ?>;}a.c21cm-more-info {color: <?php echo $fetch['color']; ?>;font-weight: 700;text-decoration: underline;font-family:Arial;} div#c21cm_stateOFF { float:left;font-family:Arial;margin-top: 20px;margin-bottom: 10px;}.pieadvice {position: fixed;bottom: 10px;right: 10px;padding: 2px;color: #666;font-family:Arial;} a#c21_nulled2 { background-color: <?php echo $fetch['color']; ?>;font-family:Arial;}svg#closeams {position: absolute;top: 20px;right: 20px;cursor: pointer;}</style>');
	
	
	
	
	function C21CM_estadoCookies(consent) {
	
		if (!consent) consent = 3;
	
		if(consent) {
			if(consent==4) { estadoCookies = cadenaTrad('idioma_aceptado_algunas_cookies'); }
			if(consent==3) { estadoCookies = cadenaTrad('idioma_aceptado_cookies_necesarias'); }
			if(consent==1) { estadoCookies = cadenaTrad('idioma_aceptado_stats'); }
			if(consent==2) { estadoCookies = cadenaTrad('idioma_todas_aceptadas'); }
			if(consent != 3) {
			
				document.addEventListener('DOMContentLoaded', function() {
					aceptarCM21(consent);
				});
			}
			
		}
	
		return estadoCookies;
	}
	
	
	
	
	document.write('<div id="c21_div_pixels" style="position:fixed;top:1px;left:1px;background-color:white;"></div>');
	
	
	
	function c21_pixel_control() {
	
	
		document.getElementById("c21_div_pixels").innerHTML = '<iframe id="c21_pixels" name="c21_pixels" src="about:blank;" style="display:none;" src="about:blank;"></iframe>';
		
		var c21_code = 'javascript:document.innerHTML="<html><body><script src=\'https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/pixel.js.php?token=<?php echo $_REQUEST['token']; ?>\' ></script><h1>Welcome to pixel control</h1></body></html>";';
				
		if (document.getElementById("c21_pixels")) {
		
		    	var compatible = true;
		    	if (compatible) {
				document.getElementById("c21_pixels").src = c21_code;
			} else {
				window.open(c21_code,'c21_pixels');
			}
		
		}
	
	}
	
	function c21_avisaGoogle() {
	
		var c21_code = 'javascript:c21_pixel_result();';
		
		if (document.getElementById("c21_pixels")) {
			window.open(c21_code,'c21_pixels');
		}
	
	
	}
	
	
	
	
	function c21cm_proveedores_cookies() {
	
		c21_consentScreen(2);
		
		if (!getCookie('iabConsentString')) {
			saveCookieCM21('iabConsentString','idioma_sin_proveedores');
		}
	
		var proveedoresCookies = '<div style="text-align:left;padding:25px;height:100%;" class="c21padding"><h2>'+cadenaTrad('idioma_cookies_de_terceros')+'</h2>';
		proveedoresCookies += '<hr>';
		proveedoresCookies += '<p style="cursor:help;" onclick=\'if (confirm("'+cadenaTrad('idioma_utilizamos_la_cadena_iab')+'")) { window.open("https://support.google.com/admob/answer/9461778?hl=es","_blank");  }\'    ><b>'+cadenaTrad('idioma_informaremos_proveedores')+'</b></p>';
		proveedoresCookies += '<hr>';
		
		
		proveedoresCookies += '<input type="checkbox" style="cursor:not-allowed" id="provider_local" checked="checked" onclick="return false;" > '+cadenaTrad('idioma_cookies_locales_sistema')+'<br>';

<?php if ($fetch['analytics']) { ?>

		proveedoresCookies += '<input type="checkbox" id="provider_analytics" '+getCookie("provider_analytics")+' onchange="calculoindividualcookies();"><label for="provider_analytics">&nbsp;Google Analytics ('+cadenaTrad('idioma_estadistica')+')</label><br>';

<?php } ?>

		proveedoresCookies += '<hr>';
		
		
		/*SCANNED PROVIDERS*/
		<?php
		
		
	
    		$terceros = new SQLite3('../db/tercerosdb');
		$q = "SELECT * FROM terceros WHERE token LIKE '".$_REQUEST['token']."'";
			
		$resultadoTerceros = $terceros->query($q);
			
		$tercero = false;
		
		$_SESSION['google_enabled'] = false;
		$_SESSION['iab_enabled'] = false;
		
		
		while ($rowx = $resultadoTerceros ->fetchArray(SQLITE3_ASSOC)) {
						
			//$tercero[] = $rowx;
			$iab = false;
			$google = false;
			
			if ($rowx['manual']) {
			
			
			?>
			
				cm21_guardaCola_TODO('saveCookieCM21("<?php echo 'prov_'.sha1($rowx['manual']); ?>","checked");');
				cm21_guardaCola_NADA('eliminaCookie("<?php echo 'prov_'.sha1($rowx['manual']); ?>");');
				
				proveedoresCookies += '<input type="checkbox" id="<?php echo 'prov_'.sha1($rowx['manual']); ?>" '+getCookie("<?php echo 'prov_'.sha1($rowx['manual']); ?>")+'  onchange=cm21_guardaCola(\'cm21_editacookie("<?php echo 'prov_'.sha1($rowx['manual']); ?>");\');calculoindividualcookies(); ><label for="<?php echo 'prov_'.sha1($rowx['manual']); ?>">&nbsp;<?php echo $rowx['manual']; ?></label><br>';
		
		
			<?php
			
			}
			else if ($rowx['iabid']) {
				$iab = iabInfoProvider($rowx['iabid']);
				if ($iab['id']) {
				
					$_SESSION['iab_enabled'] = true;
					
					
			//print_r($iab);
			?>
				
				if (getCookie('iabConsentString') == 'idioma_sin_proveedores') {
				
					saveCookieCM21('iabConsentString','idioma_sin_configurar');
					
				}
				
				cm21_guardaCola_TODO('saveCookieCM21("iab_<?php echo $iab['id']; ?>","checked");');
				cm21_guardaCola_NADA('eliminaCookie("iab_<?php echo $iab['id']; ?>");');
				
				proveedoresCookies += '<input type="checkbox" id="iab_<?php echo $iab['id']; ?>" '+getCookie("iab_<?php echo $iab['id']; ?>")+'  onchange=cm21_guardaCola(\'cm21_editacookie("iab_<?php echo $iab['id']; ?>");\');calculoindividualcookies(); ><label for="iab_<?php echo $iab['id']; ?>">&nbsp;<?php echo $iab['nombre']; ?> (<a target="_blank" href="<?php echo $iab['url']; ?>">+</a>)</label><br>';
		
		
			<?php
				}
			}
			else if ($rowx['googleid']) {
				$google = googleInfoProvider($rowx['googleid']);
				if ($google['id']) {
				
					$_SESSION['google_enabled'] = true;
			//print_r($iab);
			?>
			
				cm21_guardaCola_TODO('saveCookieCM21("google_<?php echo $google['id']; ?>","checked");avisaGoogle("<?php echo $google['id']; ?>");');
				cm21_guardaCola_NADA('eliminaCookie("google_<?php echo $google['id']; ?>");avisaGoogle("<?php echo $google['id']; ?>");');
				
				
				/*
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img" style="display:none;">';
				*/
				
				<?php  if ($fulls =false ) { ?>
				
				
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p1" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p2" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p3" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p4" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p5" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p6" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p7" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p8" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p9" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_p10" style="display:none;">';
				
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_pe1" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_pe2" style="display:none;">';
				
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_f1" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_f2" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_f3" style="display:none;">';
				
				
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_fe1" style="display:none;">';
				proveedoresCookies += '<img src="about:blank;" id="google_<?php echo $google['id']; ?>_img_fe2" style="display:none;">';
				
				
				<?php  } ?>
				
				proveedoresCookies += '<input type="checkbox" id="google_<?php echo $google['id']; ?>" '+getCookie("google_<?php echo $google['id']; ?>")+'  onchange=cm21_guardaCola(\'cm21_editacookie("google_<?php echo $google['id']; ?>");avisaGoogle("<?php echo $google['id']; ?>");\');calculoindividualcookies(); ><label for="google_<?php echo $google['id']; ?>">&nbsp;<?php echo $google['nombre']; ?> (<a target="_blank" href="<?php echo $google['url']; ?>">+</a>)</label><br>';
		
		
			<?php
				}
			}
			
					  
		}
		
		if ( $_SESSION['google_enabled'] || $_SESSION['iab_enabled'] ) {
		
		?>
		
		c21_pixel_control();
		
		
		<?php
		
		
		}
		
		
		
		?>
		
		proveedoresCookies += '<br>';
		proveedoresCookies += '<div class="c21cm-button" onclick="aceptarCM21(2);" >'+cadenaTrad("idioma_aceptar_todo")+'</div> ';
		proveedoresCookies += '<div class="c21cm-button" onclick="solo_necesarias();">'+cadenaTrad('idioma_rechazar_todo')+'</div> ';
		
		proveedoresCookies += '<div class="c21cm-button" onclick="cm21_ejecutaCola();aceptarCM21();">'+cadenaTrad('idioma_guardar_y_salir')+'</div> ';
		proveedoresCookies += ' <div class="cm21button" onclick="cookiesEnUso();" >'+cadenaTrad('idioma_edicion_individual')+'</div>';
		proveedoresCookies += ' <div class="cm21button" onclick="oldsource();" >'+cadenaTrad('idioma_regresar')+'</div>';
		proveedoresCookies += '<br></div>';
		
		return proveedoresCookies;
	}
	
	
	
	function c21cm_srcid(id,urlf) {
	
			
	
			/*
			if (document.getElementById(id).src == urlf) { 
			
			
			 }
			else {
			
				//alert(urlf);
				document.getElementById(id).src = urlf;
				
			}
			*/
			
			/*alert(urlf);*/
			
			
			var c21_code = 'Loading pixel control...<br>';
	
			
			code = '<img src='+urlf+' id='+id+' >'+c21_code ;
			
			code = 'javascript:document.body.innerHTML+="'+code+'";';
			
		if (document.getElementById("c21_pixels")) {
			window.open(code,'c21_pixels');
			
			}
			/*document.getElementById('c21_pixelsc21_pixels').src = code ;*/
			
			
	}
	
	
	
	
	function c21cm_vendor() {
	
		return verdorURL = 'https://www.cookiebot.com/?hostname='+window.location.host+'&gdpr=1&gdpr_consent='+getCookie("iabConsentString")+'&addtl_consent=2~';
	
	}
	
	function c21cm_gstring(proposito,id) {
	
		string = proposito+'~'+id;
		
		verdorURL = c21cm_vendor();
		verdorURL += '&addtl_consent='+string;
		
		return verdorURL;
	}
	function c21cm_gstring_off(proposito,id) {
	
		string = proposito+'~dv.'+id;
		
		verdorURL = c21cm_vendor();
		verdorURL += '&addtl_consent='+string;
		
		return verdorURL;
	}
	
	function c21cm_calculayavisa(id,proposito,idf,cookiename) {
	
		checkedid = document.getElementById('google_'+id).checked;
		//alert(checkedid);
		
		if (getCookie(cookiename) && checkedid) {
		
			url = c21cm_gstring(proposito,id);
			
		} else {
			
			url = c21cm_gstring_off(proposito,id);
		
		}
		//c21cm_srcid(idf,url);
	
	}
	
	function avisaGoogle(id) {
	
	
		//&addtl_consent=${ADDTL_CONSENT}
		
		proposito = 2;
		idf = 'google_'+id+'_img';
		cookiename = 'marcaTodasCM21';
		
		c21cm_calculayavisa(id,proposito,idf,cookiename);
		
		
		
	}
	
	
	
	
	document.write('<div id="cm21_cola_todo" style="display:none;"></div>');
	
	function cm21_guardaCola_TODO(proceso) {
		
		document.getElementById("cm21_cola_todo").innerHTML += proceso;
		
	}
	
	function cm21_ejecutaCola_TODO() {
	
	
		if (!getCookie('cm21_pers')) {
		
			//alert('todo...');
			cola = document.getElementById("cm21_cola_todo").innerHTML;
			if (cola) {
			
				window.open('javascript:'+cola ,"_top");
				cm21_eliminaCola_TODO();
			}
			
		}
		
	}
	function cm21_eliminaCola_TODO() {
	
		document.getElementById("cm21_cola_todo").innerHTML = '';
		
	}
	
	document.write('<div id="cm21_cola_nada" style="display:none;"></div>');
	
	function cm21_guardaCola_NADA(proceso) {
		
		document.getElementById("cm21_cola_nada").innerHTML += proceso;
		
	}
	
	function cm21_ejecutaCola_NADA() {
	
		if (!getCookie('cm21_pers')) {
	
			cola = document.getElementById("cm21_cola_nada").innerHTML;
			if (cola) {
			
				window.open('javascript:'+cola ,"_top");
				cm21_eliminaCola_NADA();
			}
		}
		
	}
	function cm21_eliminaCola_NADA() {
	
		document.getElementById("cm21_cola_nada").innerHTML = '';
		
	}
	
	
	document.write('<div id="cm21_cola" style="display:none;"></div>');
	
	
	
	function cm21_guardaCola(proceso) {
	
		//alert('Guardando cola...');
		
		document.getElementById("cm21_cola").innerHTML += proceso;
		
	}
	
	function cm21_ejecutaCola() {
	
		//alert('Procesando cola...');
		cola = document.getElementById("cm21_cola").innerHTML;
		if (cola) {
			//alert(cola);
			window.open('javascript:'+document.getElementById("cm21_cola").innerHTML,"_top");
			
			saveCookieCM21('cm21_pers','true');
			
			cm21_eliminaCola();
		}
		
	}
	function cm21_eliminaCola() {
	
		document.getElementById("cm21_cola").innerHTML = '';
		
	}
	
	
	
	
	function cm21_editacookie(id) {
	
		checkedid = document.getElementById(id).checked;
		//alert(checkedid);
	
		if (checkedid) {
			saveCookieCM21(id,"checked");
		} else {
		
			eliminaCookie(id);
		
		}
		
	}
	
	
	
	
	//SIMPLE configuration button by JLC
	
	function c21cm_boton_guardar() {
	
		var botonGuardarCookieCM21 = '<a id="botonGuardarCookies" style="display:none;" onclick="aceptarCM21();cm21_ejecutaCola();" class="c21cm-button">' + cadenaTrad('idioma_guardar_y_salir') + '</a>';
		return botonGuardarCookieCM21;
	}
	
	function c21cm_boton_politicas() {
	
		var botonPoliticaCookiesCM21 = '<a id="botonPoliticaCookies" class="cm21button" style="text-align:center;" onclick="politicaDeCookiesCM21();">'+cadenaTrad('idioma_politica_de_cookies')+'</a>';
		return botonPoliticaCookiesCM21;
	}
	
	function c21cm_boton_propositos() {
	
		var botonPropositosCM21 = '<a type="button" id="botonPropositos"  class="cm21button" style="text-align:center;" onclick="propositosCM21();">'+cadenaTrad('idioma_propositos')+'</a>';
		return botonPropositosCM21;
	
	}
	
	
	
	function c21cm_botones_cookies() {
		var botonesCookiesCM21 = c21cm_boton_guardar() + ' ' +c21cm_boton_politicas() + c21cm_boton_propositos() +' <a  id="botonListaProveedores" style="text-align:center;" onclick="gestionProveedoresCM21();">'+cadenaTrad('idioma_gestiona_proveedores_y_socios')+'</a> <a type="button" id="botonListaCookies" style="text-align:center;" onclick="cookiesEnUso();">'+cadenaTrad('idioma_gestion_individual')+'</a> <a class="cm21button" onclick="oldsource();">'+cadenaTrad('idioma_regresar')+'</a>';
		return botonesCookiesCM21;
	}
	
	function c21cm_div_lista_cookies() {
	
		var divListaCookies = '<div id="listaCookies" style="height:<?php echo $fetch['altura']; ?>%;display:none;padding-left:5px;padding-right:5px;" class="aviso_cm21"></div>';
		return divListaCookies;
	}
	
	function c21cm_div_proveedores() {
	
		var divProveedoresCookies = '<div id="proveedoresCookies" style="height:<?php echo $fetch['altura']; ?>%;display:none;padding-left:5px;padding-right:5px;" class="aviso_cm21">'+c21cm_proveedores_cookies()+'</div>';
		return divProveedoresCookies;
	}
	
	
	/*INPUT OBLIGATORIO DE COOKIES NECESARIAS*/
	function c21cm_cookiesNecesarias() {
	
		var necessariesCookiesCM = '<?php echo limpia(file_get_contents('../inner/cookies.necesarias.html')); ?>';
		
		necessariesCookiesCM = necessariesCookiesCM.replace('{idioma_cookies_necesarias}',cadenaTrad('idioma_cookies_necesarias'));
		necessariesCookiesCM = necessariesCookiesCM.replace('{idioma_cookies_necesarias_info}',cadenaTrad('idioma_cookies_necesarias_info'));
		necessariesCookiesCM = necessariesCookiesCM.replace('{idiomas_cookies_necesarias_extra}',cadenaTrad('idiomas_cookies_necesarias_extra'));
		
		return necessariesCookiesCM;
	}
	
	function c21cm_stats_Cookies() {
		
		/*COOKIES de MEDICION*//*Se aplican si el cliente usa Analytics*/
		var statsCookies = '<?php echo borraSaltos(file_get_contents('../inner/cookies.medicion.html')); ?>';
	
		statsCookies = statsCookies.replace('{cookies_medicion}',cadenaTrad('cookies_medicion'));
		statsCookies = statsCookies.replace('{idioma_cookies_medicion_info}',cadenaTrad('idioma_cookies_medicion_info'));
		statsCookies = statsCookies.replace('{idioma_cookies_medicion_extra}',cadenaTrad('idioma_cookies_medicion_extra'));
		
		return statsCookies;
	
	}
	
	
	 
	
	 
	 
	 function c21cm_all_cookies() {
	 
		var allCookies = '<input type="checkbox" id="marcaTodasCM21" '+getCookie("marcaTodasCM21")+' onchange="marcaTodasCM21();" ><label for="marcaTodasCM21"> <b>'+cadenaTrad('idioma_des_marcar_todas')+'</b> </label><br>';
		return allCookies;
	
	 
	 }
	 
	function C21CM_pubCookies() {
	
		var pubCookies = '<?php echo borraSaltos(file_get_contents('../inner/cookies.publicidad.html')); ?>';
		pubCookies = pubCookies.replace('{idiomas_cookies_publicidad}',cadenaTrad('idiomas_cookies_publicidad'));
		pubCookies = pubCookies.replace('{idioma_cookies_publicidad_info}',cadenaTrad('idioma_cookies_publicidad_info'));
		pubCookies = pubCookies.replace('{idioma_cookies_publicidad_extra}',cadenaTrad('idioma_cookies_publicidad_extra'));
		return pubCookies;
	}
	
	//var pubCookies = C21CM_pubCookies();
	
	
	
	 
	function C21CM_persCookies() {
	
		var persCookies = '<?php echo borraSaltos(file_get_contents('../inner/cookies.preferencias.html')); ?>';
		persCookies = persCookies.replace('{idioma_pers_cookies}',cadenaTrad('idioma_pers_cookies'));
		persCookies = persCookies.replace('{idioma_pers_cookies_info}',cadenaTrad('idioma_pers_cookies_info'));
		persCookies = persCookies.replace('{idioma_pers_cookies_extras}',cadenaTrad('idioma_pers_cookies_extras'));
		return persCookies;
		
	}
	
	
	
	
	
	function c21cm_div_edita_Cookies() {
	
	
		c21_consentScreen(1);
	
		var c21_eC_botones = '';
		c21_eC_botones += '<a class="c21cm-button" onclick="aceptarCM21(2);" >'+cadenaTrad('idioma_aceptar_todo')+'</a> ';
		c21_eC_botones += '<a class="c21cm-button" onclick="solo_necesarias();">'+cadenaTrad('idioma_rechazar_todo')+'</a> ';
		
	
		var divEditarCookies = '<div style="height:<?php echo $fetch['altura']; ?>%;overflow:auto;display:none;padding-left:5px;padding-right:5px;text-align:left;" class="aviso_cm21" id="editarCookies"><div class="c21padding"><h2>' +cadenaTrad('idioma_gestion_cookies')+ '</h2><hr><br>'+ c21cm_cookiesNecesarias() + c21cm_all_cookies() + c21cm_stats_Cookies() + C21CM_pubCookies() + C21CM_persCookies() +'<br><hr><br>'+c21_eC_botones +c21cm_botones_cookies()+'</div></div>';
		return divEditarCookies;
	
	}
	
	document.write('<div id="c21cm_div_more_content_id"></div>');

	document.write('<div id="c21cm_idiomas_control_banner" style="z-index:99999999999999999999;position:absolute;"></div>');

	function c21cm_div_more_content() {
		
		var c21cm_div_more_content_n = c21cm_div_lista_cookies() + c21cm_div_proveedores() + c21cm_div_edita_Cookies() +'<div class="cookie_button" id="cookie_button"><span style="border:0;background:transparent;" type="button" id="cookie_button_b"  onclick="hideAllCM21();show_c21_popup();" ><svg width="25.000000pt" height="25.000000pt" viewBox="0 0 256.000000 255.000000" xmlns="http://www.w3.org/2000/svg"><g transform="translate(0.000000,255.000000) scale(0.100000,-0.100000)" fill="<?php echo $fetch['color']; ?>" stroke="none"><path d="M1150 2475 c0 -24 -2 -25 -75 -25 -75 0 -75 0 -75 -75 0 -73 -1 -75 -25 -75 -23 0 -25 -3 -25 -50 0 -50 0 -50 -50 -50 -47 0 -50 -2 -50 -25 0 -20 -5 -25 -25 -25 -20 0 -25 5 -25 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 25 0 25 -100 25 -100 0 -100 0 -100 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -24 0 -25 -2 -25 -75 0 -73 1 -75 25 -75 23 0 25 -3 25 -50 0 -47 2 -50 25 -50 23 0 25 -3 25 -50 0 -47 -2 -50 -25 -50 -23 0 -25 -3 -25 -50 0 -50 0 -50 -75 -50 -73 0 -75 -1 -75 -25 0 -23 -3 -25 -50 -25 -50 0 -50 0 -50 -250 0 -250 0 -250 75 -250 73 0 75 -1 75 -25 0 -23 3 -25 50 -25 50 0 50 0 50 -50 0 -47 2 -50 25 -50 23 0 25 -3 25 -50 0 -47 -2 -50 -25 -50 -24 0 -25 -2 -25 -75 0 -73 -1 -75 -25 -75 -20 0 -25 -5 -25 -25 0 -20 5 -25 25 -25 23 0 25 -3 25 -50 0 -47 2 -50 25 -50 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -24 2 -25 75 -25 73 0 75 1 75 25 0 23 3 25 50 25 47 0 50 2 50 25 0 20 5 25 25 25 20 0 25 -5 25 -25 0 -23 3 -25 50 -25 50 0 50 0 50 -50 0 -47 2 -50 25 -50 23 0 25 -3 25 -50 0 -47 2 -50 25 -50 20 0 25 -5 25 -25 0 -24 2 -25 75 -25 73 0 75 -1 75 -25 0 -25 1 -25 80 -25 79 0 80 0 80 25 0 24 2 25 75 25 73 0 75 1 75 25 0 20 5 25 25 25 24 0 25 2 25 75 0 73 1 75 25 75 20 0 25 5 25 25 0 23 3 25 50 25 47 0 50 2 50 25 0 20 5 25 25 25 20 0 25 -5 25 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -24 2 -25 75 -25 73 0 75 1 75 25 0 20 5 25 25 25 20 0 25 5 25 25 0 23 3 25 50 25 50 0 50 0 50 50 0 47 2 50 25 50 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 -5 25 -25 25 -23 0 -25 3 -25 50 0 47 -2 50 -25 50 -25 0 -25 0 -25 100 0 100 0 100 25 100 20 0 25 5 25 25 0 23 3 25 50 25 47 0 50 2 50 25 0 23 3 25 50 25 47 0 50 2 50 25 0 20 5 25 25 25 25 0 25 0 25 225 0 225 0 225 -50 225 -47 0 -50 2 -50 25 0 24 -2 25 -75 25 -73 0 -75 1 -75 25 0 20 -5 25 -25 25 -25 0 -25 0 -25 100 0 100 0 100 25 100 23 0 25 3 25 50 0 47 2 50 25 50 20 0 25 5 25 25 0 20 -5 25 -25 25 -23 0 -25 3 -25 50 0 47 -2 50 -25 50 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 24 -2 25 -75 25 -73 0 -75 -1 -75 -25 0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -20 -5 -25 -25 -25 -20 0 -25 5 -25 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 20 -5 25 -25 25 -24 0 -25 2 -25 75 0 73 -1 75 -25 75 -20 0 -25 5 -25 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 25 0 25 -130 25 -130 0 -130 0 -130 -25z m360 -150 c0 -73 1 -75 25 -75 23 0 25 -3 25 -50 0 -50 0 -50 75 -50 73 0 75 -1 75 -25 0 -20 5 -25 25 -25 20 0 25 5 25 25 0 23 3 25 50 25 47 0 50 2 50 25 0 24 2 25 75 25 73 0 75 -1 75 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 24 0 25 -2 25 -75 0 -73 -1 -75 -25 -75 -25 0 -25 0 -25 -125 0 -125 0 -125 25 -125 23 0 25 -3 25 -50 0 -50 0 -50 75 -50 73 0 75 -1 75 -25 0 -23 3 -25 50 -25 50 0 50 0 50 -175 0 -175 0 -175 -25 -175 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -24 -2 -25 -75 -25 -75 0 -75 0 -75 -50 0 -47 -2 -50 -25 -50 -25 0 -25 0 -25 -100 0 -100 0 -100 25 -100 25 0 25 0 25 -100 0 -100 0 -100 -25 -100 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -23 -3 -25 -50 -25 -47 0 -50 2 -50 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 24 -2 25 -75 25 -73 0 -75 -1 -75 -25 0 -23 -3 -25 -50 -25 -50 0 -50 0 -50 -50 0 -47 -2 -50 -25 -50 -24 0 -25 -2 -25 -75 0 -75 0 -75 -230 -75 -230 0 -230 0 -230 75 0 73 -1 75 -25 75 -23 0 -25 3 -25 50 0 50 0 50 -50 50 -47 0 -50 2 -50 25 0 24 -2 25 -75 25 -73 0 -75 -1 -75 -25 0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -23 -3 -25 -50 -25 -47 0 -50 2 -50 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 5 25 25 25 23 0 25 3 25 50 0 47 2 50 25 50 25 0 25 0 25 100 0 100 0 100 -25 100 -23 0 -25 3 -25 50 0 50 0 50 -75 50 -73 0 -75 1 -75 25 0 23 -3 25 -50 25 -50 0 -50 0 -50 200 0 200 0 200 50 200 47 0 50 2 50 25 0 24 2 25 75 25 75 0 75 0 75 50 0 47 2 50 25 50 25 0 25 0 25 100 0 100 0 100 -25 100 -23 0 -25 3 -25 50 0 47 -2 50 -25 50 -20 0 -25 5 -25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 23 3 25 50 25 47 0 50 -2 50 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -23 3 -25 50 -25 47 0 50 2 50 25 0 23 3 25 50 25 47 0 50 2 50 25 0 20 5 25 25 25 23 0 25 3 25 50 0 47 2 50 25 50 23 0 25 3 25 50 0 50 0 50 230 50 230 0 230 0 230 -75z" />     <path d="M1050 2125 c0 -24 -2 -25 -75 -25 -73 0 -75 -1 -75 -25 0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -23 0 -25 -3 -25 -50 0 -50 0 -50 50 -50 47 0 50 -2 50 -25 0 -23 3 -25 50 -25 47 0 50 2 50 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 23 0 25 -3 25 -50 0 -47 -2 -50 -25 -50 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -24 0 -25 -2 -25 -75 0 -73 -1 -75 -25 -75 -25 0 -25 0 -25 -150 0 -150 0 -150 25 -150 24 0 25 -2 25 -75 0 -73 -1 -75 -25 -75 -20 0 -25 -5 -25 -25 0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -20 -5 -25 -25 -25 -23 0 -25 -3 -25 -50 0 -47 2 -50 25 -50 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -24 2 -25 75 -25 73 0 75 -1 75 -25 0 -24 2 -25 75 -25 73 0 75 -1 75 -25 0 -25 0 -25 180 -25 180 0 180 0 180 25 0 24 2 25 75 25 73 0 75 1 75 25 0 23 3 25 50 25 47 0 50 2 50 25 0 23 3 25 50 25 47 0 50 2 50 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 23 0 25 3 25 50 0 47 2 50 25 50 24 0 25 2 25 75 0 73 1 75 25 75 25 0 25 0 25 250 0 250 0 250 -25 250 -24 0 -25 2 -25 75 0 73 -1 75 -25 75 -23 0 -25 3 -25 50 0 47 -2 50 -25 50 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 24 -2 25 -75 25 -73 0 -75 1 -75 25 0 25 0 25 -230 25 -230 0 -230 0 -230 -25z m460 -250 c0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 23 0 25 -3 25 -50 0 -47 2 -50 25 -50 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 25 0 25 0 25 -100 0 -100 0 -100 25 -100 25 0 25 0 25 -100 0 -100 0 -100 -25 -100 -24 0 -25 -2 -25 -75 0 -73 -1 -75 -25 -75 -23 0 -25 -3 -25 -50 0 -47 -2 -50 -25 -50 -23 0 -25 -3 -25 -50 0 -47 -2 -50 -25 -50 -20 0 -25 -5 -25 -25 0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -25 0 -25 -230 -25 -230 0 -230 0 -230 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -23 0 -25 3 -25 50 0 47 2 50 25 50 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 23 0 25 3 25 50 0 47 -2 50 -25 50 -24 0 -25 2 -25 75 0 73 -1 75 -25 75 -25 0 -25 0 -25 100 0 100 0 100 25 100 24 0 25 2 25 75 0 73 1 75 25 75 23 0 25 3 25 50 0 47 2 50 25 50 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 20 5 25 25 25 20 0 25 5 25 25 0 23 3 25 50 25 47 0 50 2 50 25 0 23 3 25 50 25 47 0 50 2 50 25 0 25 0 25 230 25 230 0 230 0 230 -25z" />     <path d="M1050 1825 c0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 5 -25 25 -25 20 0 25 5 25 25 0 23 3 25 50 25 47 0 50 2 50 25 0 25 0 25 205 25 205 0 205 0 205 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -20 5 -25 25 -25 23 0 25 -3 25 -50 0 -47 2 -50 25 -50 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 25 0 25 0 25 -250 0 -250 0 -250 -25 -250 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -23 0 -25 -3 -25 -50 0 -50 0 -50 -50 -50 -47 0 -50 -2 -50 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -25 0 -25 -180 -25 -180 0 -180 0 -180 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 -5 -25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -25 0 -25 205 -25 205 0 205 0 205 25 0 24 2 25 75 25 73 0 75 1 75 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 23 0 25 3 25 50 0 47 2 50 25 50 24 0 25 2 25 75 0 73 1 75 25 75 25 0 25 0 25 100 0 100 0 100 -25 100 -24 0 -25 2 -25 75 0 73 -1 75 -25 75 -23 0 -25 3 -25 50 0 47 -2 50 -25 50 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 25 0 25 -230 25 -230 0 -230 0 -230 -25z" /><path d="M1100 1675 c0 -23 -3 -25 -50 -25 -47 0 -50 -2 -50 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -24 0 -25 -2 -25 -75 0 -73 -1 -75 -25 -75 -25 0 -25 0 -25 -100 0 -100 0 -100 25 -100 24 0 25 -2 25 -75 0 -73 1 -75 25 -75 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -20 5 -25 25 -25 20 0 25 -5 25 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -25 0 -25 180 -25 180 0 180 0 180 25 0 23 3 25 50 25 47 0 50 2 50 25 0 20 5 25 25 25 20 0 25 5 25 25 0 20 5 25 25 25 23 0 25 3 25 50 0 47 -2 50 -25 50 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 23 -3 25 -50 25 -50 0 -50 0 -50 -50 0 -50 0 -50 -50 -50 -47 0 -50 -2 -50 -25 0 -25 -1 -25 -80 -25 -79 0 -80 0 -80 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 20 -5 25 -25 25 -25 0 -25 0 -25 150 0 150 0 150 25 150 20 0 25 5 25 25 0 20 5 25 25 25 20 0 25 5 25 25 0 25 0 25 105 25 105 0 105 0 105 -25 0 -23 3 -25 50 -25 47 0 50 -2 50 -25 0 -24 2 -25 75 -25 73 0 75 1 75 25 0 20 5 25 25 25 23 0 25 3 25 50 0 47 -2 50 -25 50 -20 0 -25 5 -25 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 23 -3 25 -50 25 -47 0 -50 2 -50 25 0 25 0 25 -180 25 -180 0 -180 0 -180 -25z" /><path d="M200 1375 c0 -23 3 -25 50 -25 50 0 50 0 50 -50 0 -47 -2 -50 -25 -50 -20 0 -25 -5 -25 -25 0 -20 -5 -25 -25 -25 -20 0 -25 -5 -25 -25 0 -24 2 -25 75 -25 73 0 75 1 75 25 0 20 -5 25 -25 25 -20 0 -25 5 -25 25 0 20 5 25 25 25 24 0 25 2 25 75 0 75 0 75 -75 75 -73 0 -75 -1 -75 -25z" /><path d="M450 1275 c0 -125 0 -125 25 -125 25 0 25 0 25 125 0 125 0 125 -25 125 -25 0 -25 0 -25 -125z" /></g></svg></span></div>';
	
		document.getElementById("c21cm_div_more_content_id").innerHTML = c21cm_div_more_content_n;
	
		
		
	}

	
	
	var c21_precarga_banner = '<img src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/ajax-loader.gif">';

	document.write('<div class="aviso_cm21" id="aviso_cm21" style="display:none;zoom:<?php echo $fetch['zoom']; ?>;max-height:<?php echo $fetch['altura']; ?>%;overflow:auto;" >'+c21_precarga_banner +'</div>');




let c21_anclaje_banner = c21_precarga_banner;


function c21_confirm_update() {

			if (confirm('Estamos teniendo dificultades técnicas. Si su conexión es estable, es posible que su navegador esté obsoleto. Si el problema persiste, actualicelo. ¿DESEA ACTUALIZA AHORA?')) {
			
				window.open('https://www.google.com/chrome/','_blank');
			}
}

	
function c21_actualiza_navegador_banner() {
	
		
	
		if (!document.getElementById("aviso_cm21")) {
	
			c21_confirm_update();
			
		}
		else if (document.getElementById("aviso_cm21").innerHTML == c21_anclaje_banner ) {
	
			c21_confirm_update();
			
		}
	
}



window.addEventListener("load",function(){

   	 
	setTimeout("c21_actualiza_navegador_banner();",30000);
	
    
},false);




	function C21CM_pie() {
	
		return '<div class="pieadvice"><table style="border:0;background:transparent;" border=0><tr  style="border:0;background:transparent;" ><td style="v-align:middle;border:0;background:transparent;"><img src="https://cookie21.com/app/cookie.png" style="height:20px;"></td><td  style="border:0;background:transparent;height:30px;vertical-align:middle;position:relative;"> <a href="https://cookie21.com/" class="c21cmlink" target="_blank" style="border:0;background:transparent;color:<?php echo $fetch['color']; ?>;">' +cadenaTrad('idioma_desarrollado_por_cookie21')+ '</a></td></tr></table></div>';
	}
	function contenidoAvisoCM21() {
	
		var logotm = '';
			
<?php if (@file_exists('../logos/'.sha1($_REQUEST['token']).'.png')) { ?>


var logotm = '<img style="max-width:90px;max-height:50px;cursor:help;float:left;margin-left:20px;margin-top:20px;" src="https://cookie21.com/cm/logos/<?php echo sha1($_REQUEST['token']); ?>.png?<?php echo time();?>"><br><br>';


<?php } ?>
		
	
		return logotm+'<h2 id=idioma_informacion_de_cookies  >'+cadenaTrad('idioma_informacion_de_cookies')+'</h2><hr color="<?php echo $fetch['contrast']; ?>"><p class="c21padding">'+infoCookiesCM21F()+'</p>';
	
	}
	function infoClienteCM21() {
	
		return '<a href="<?php echo $fetch['link'] ; ?>" class="c21cm-more-info">'+ cadenaTrad('idioma_saber_mas') +'</a>';
	}

	function contenidocm21() {
	
		return '<iframe style="display:none;" src="about:blank" id="saveSessionIdioma" name="saveSessionIdioma"></iframe><img src="https://cookie21.com/cm/idiomas.png" style="margin:5px;float:right;height:20px;cursor:help;<?php if ($fetch['cross'])  { ?>margin-right:40px;<?php } ?>" onclick="cm21cargaidiomas();"><?php if ($fetch['cross'])  { ?><svg id="closeams" style="display:;"  onclick="aceptarCM21();"  xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg><?php } ?>' + contenidoAvisoCM21() + '<table style="border:0;background:transparent;" border=0 class="c21_bg_color"><tr style="border:0;background:transparent;" class="c21_bg_color"><td  style="border:0;background:transparent;" class="c21_bg_color"><div style="padding:5px;"><a style=""  class="c21cm-button" id="acepta1"  onclick="solo_necesarias();">' + cadenaTrad('idioma_rechazar_todo') + '</a> <a style="" class="c21cm-button" id="acepta"  onclick="aceptarCM21(2);">' +  cadenaTrad('idioma_aceptar_todo') + '</a> <a id="configuracm21" class="configuracm21" style="" onclick="configurar_cm21();">' + cadenaTrad('idioma_Configurar') + '</a> <a id="guardarysalircm21" class="configuracm21" style="" onclick="aceptarCM21();cm21_ejecutaCola();">' +  cadenaTrad('idioma_guardar_y_salir') + '</a></div></td></tr><tr ><td ><div id="c21cm_state"  style="width:100%;align:left;text-align:left;padding-left:40px;">' + C21CM_estadoCookies(getCookie('c21cm_cookie_consent')) + '</div><?php if ($fetch['link']) { ?><div id="aviso_cm212" style="width:100%;align:left;text-align:left;padding-left:40px;">' + infoClienteCM21() + '</div></td></tr></table><?php } ?>' + C21CM_pie()  + '';
	
	}

	function rellenacm21() {
	
	
		if (document.getElementById("aviso_cm21")) {
		
			c21cm_div_more_content();
			
			document.getElementById("aviso_cm21").innerHTML = contenidocm21();
    			document.getElementById("cookie_button").style.display = '';
			
    			c21cm_loaded();
    			
    			
			c21_consentScreen('0');
			
			
		}
	}

	


	function c21_popup(option) {
	
		if(option == 'show') { 
		
		document.getElementById("aviso_cm21").style.display = '';
		c21cm_div_more_content();c21_consentScreen('0');
		
		
		
		 }
		else  {
			document.getElementById("aviso_cm21").style.display = 'none';
			document.getElementById("proveedoresCookies").style.display = 'none';
			hideAllCM21();
		}
		
		
	}
	
	function c21cm_loaded() {
	
		<?php if (!$fetch['hiddenid']) { ?>
	
		
		
		if (!getCookie("c21cm_cookie_consent")) { c21_popup('show'); }
		
	
		<?php } ?>
		
		
		c21_consentScreen('0');
	}
	
	
	

	function aceptarCM21(modo) {
	
	
		if (!modo) modo = calculacookies();
		if (!modo) modo = getCookie("c21cm_cookie_consent");
		if (!modo) modo = '3';
		
		
		if (modo == 1) {
			document.getElementById("statsCookies").checked = 'checked';
			if (document.getElementById("provider_analytics")) {
			document.getElementById("provider_analytics").checked = 'checked';
			}
			document.getElementById("pubCookies").checked = '';
			document.getElementById("persCookies").checked = '';
	
		
		}
		else if (modo == 2) {
		
		
			eliminaCookie('cm21_pers');
			cm21_ejecutaCola_TODO();
			
			document.getElementById("statsCookies").checked = 'checked';
			if (document.getElementById("provider_analytics")) {
			document.getElementById("provider_analytics").checked = 'checked';
			}
			document.getElementById("marcaTodasCM21").checked = 'checked';
			document.getElementById("pubCookies").checked = 'checked';
			document.getElementById("persCookies").checked = 'checked';
			
			
		
			saveCookieCM21('propositoCookies1','checked');
			saveCookieCM21('propositoCookies2','checked');
			saveCookieCM21('propositoCookies3','checked');
			saveCookieCM21('propositoCookies4','checked');
			saveCookieCM21('propositoCookies5','checked');
			saveCookieCM21('propositoCookies6','checked');
			saveCookieCM21('propositoCookies7','checked');
			saveCookieCM21('propositoCookies8','checked');
			saveCookieCM21('propositoCookies9','checked');
			saveCookieCM21('propositoCookies10','checked');
			saveCookieCM21('propositoEspecialCookies1','checked');
			saveCookieCM21('propositoEspecialCookies2','checked');
			saveCookieCM21('funcionCookies1','checked');
			saveCookieCM21('funcionCookies2','checked');
			saveCookieCM21('funcionCookies3','checked');
			saveCookieCM21('funcionEspecialCookies1','checked');
			saveCookieCM21('funcionEspecialCookies2','checked');
			
	
		
		}
		else if (modo == 3) {
		
			document.getElementById("statsCookies").checked = '';
			if (document.getElementById("provider_analytics")) {
			document.getElementById("provider_analytics").checked = '';
			}
			document.getElementById("marcaTodasCM21").checked = '';
			document.getElementById("pubCookies").checked = '';
			document.getElementById("persCookies").checked = '';
	
		}
		else if (modo == 4) {
			
			/*Cookies personalizadas*/
		
	
		}
		
		saveCookieStatus('marcaTodasCM21');
		saveCookieStatus('statsCookies');
		if (document.getElementById("provider_analytics")) {
		saveCookieStatus('provider_analytics');
		}
		saveCookieStatus('pubCookies');
		saveCookieStatus('persCookies');
		
		
		
		
		
		if ('trazabilidad' == 'NO') {
	
		if ( getCookie("c21cm_cookie_consent") ==  modo) {
			document.getElementById('imgInnerConsent').src= 'https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/acceso/?load=true&referrer='+window.parent.location.href+'&token=<?php echo $fetch['token']; ?>&consent='+modo;
			} else {
			document.getElementById('imgInnerConsent').src= 'https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/acceso/?&referrer='+window.parent.location.href+'&token=<?php echo $fetch['token']; ?>&consent='+modo;
			
		}
		
		}
		
		
		
		
		if (document.getElementById("closeams")) { document.getElementById("closeams").style.display = "block"; }
		
		if(modo==4) document.getElementById("c21cm_state").innerHTML = cadenaTrad('idioma_aceptado_algunas_cookies');
		if(modo==3) document.getElementById("c21cm_state").innerHTML = cadenaTrad('idioma_aceptado_cookies_necesarias');
		if(modo==1) document.getElementById("c21cm_state").innerHTML = cadenaTrad('idioma_aceptado_stats');
		if(modo==2) document.getElementById("c21cm_state").innerHTML = cadenaTrad('idioma_todas_aceptadas');
		
		saveCookieCM21('c21cm_cookie_consent',modo);
		
		if(!accepted) {
			
			//UPDATE GTAG
			if (document.getElementById("provider_analytics")) {
				if(modo==3) {
				
					/*RECHAZA TODO*/
				
					/*
					gtag('consent', 'update', {'analytics_storage': 'denied'});
					*/
					
					gtag('consent', 'update', {
					'ad_storage': 'denied', 
					'analytics_storage': "denied",
					'ad_user_data': "denied",
					'ad_personalization': "denied"
					
					});
				
				}
				if(modo==1) {
					/*SOLO STATS*/
				
					/*
					gtag('consent', 'update', {'analytics_storage': 'granted'});	
					*/
					
					gtag('consent', 'update', {
					'ad_storage': 'granted', 
					'analytics_storage': "granted",
					'ad_user_data': "denied",
					'ad_personalization': "denied"
					
					});
					
					
				}
				if(modo==2) { 
				
					/*V1
					
					gtag('consent', 'update', {'ad_storage': 'granted', 'analytics_storage': 'granted'});
					*/
					
					gtag('consent', 'update', {
					'ad_storage': 'granted', 
					'analytics_storage': "granted",
					'ad_user_data': "granted",
					'ad_personalization': "granted"
					
					});
					
				}
			}
			
			if(modo==4) {
			
				if (document.getElementById("provider_analytics")) {
				
				 	if (getCookie('provider_analytics') == 'checked') {
				 	
				 		if (getCookie('propositoCookies3') == 'checked') {
				 		
							gtag('consent', 'update', {
							'ad_storage': 'granted', 
							'analytics_storage': "granted",
							'ad_user_data': "granted",
							'ad_personalization': "granted"
							
							});
					
				 		}
				 		else {
				 		
							gtag('consent', 'update', {
							'ad_storage': 'granted', 
							'analytics_storage': "granted",
							'ad_user_data': "denied",
							'ad_personalization': "denied"
							
							});
				 		
				 		}
				 	}
				 	else {
				 	
				 	
				 		if (getCookie('propositoCookies3') == 'checked') {
				 		
							gtag('consent', 'update', {
							'ad_storage': 'denied', 
							'analytics_storage': "denied",
							'ad_user_data': "granted",
							'ad_personalization': "granted"
							
							});
					
				 		}
				 		else {
				 		
							gtag('consent', 'update', {
							'ad_storage': 'denied', 
							'analytics_storage': "denied",
							'ad_user_data': "denied",
							'ad_personalization': "denied"
							
							});
				 		
				 		}
				 	
				 	}
			 	}
			 	
			 }

			if(modo==2) {
				
				//HERE YOU CAN ENTER YOUR OWN SCRIPTS
				//loadjs('/media/aceptar.js');
				
				<?php if ($fetch['script']) { ?>
				
				c21_loadjs('<?php echo $fetch['script']; ?>');
				
				<?php } ?>
				
				/* insert code here */	

				// alert('hello world this is cookie mode 2');
				
				/* end code */
				
				/*

				var scripts = document.getElementsByTagName('script');			
				for (var i = 0; i < scripts.length; i++) {
					if(scripts[i].type == 'text/plain' && !scripts[i].dataset.main) {	
						if (scripts[i].src) loadjs(scripts[i].src, scripts[i].dataset.child);				
						else eval(scripts[i].innerHTML);
					}
				}
				*/

			}

		}

		accepted = true;
		c21_popup('hide');
		
		
		/*INFORMAMOS A IAB*/
		
		c21_recalcula_CS(modo);
		
		
		
		/*INFORMAMOS A GOOGLE*/
		
		setTimeout("c21_avisaGoogle();",1000);
		
	}	
	
	




	/*AUDITORÍA: 
			
			Hacemos una carga dinámica de proveedores, 
			con el objetivo de que ésta permaneza en caché y acelere la website
			
	*/
	
	
	if (typeof cm21proveedores !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {
		document.write(unescape("%3Cscript src='//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/proveedores.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
		cm21proveedores = 'loaded';
		
	}
	/*Esta función se puede reemplazar por un include php*/
	<?php
	
	//include_once('../scripts/proveedores.js.php');
	
	?>
	
	
	
	/*AUDITORÍA: Cargamos funciones vitales*/
	/*AUDITORÍA: Hacemos una carga dinámica las funciones no personalizables, con el objetivo de que ésta permaneza en caché y acelere la website*/
	
	if (typeof cm21funciones !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {
	
		document.write(unescape("%3Cscript src='//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/funciones.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
		cm21funciones = 'loaded';
	}
		
	/*Esta función se puede reemplazar por un include php*/
	
	<?php
	
	//include_once('../scripts/funciones.js.php');
	
	?>
	
	
	

function c21_setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
	

function c21_notificacionBienvenida() {

	/*
        var img = "https://<?php echo $_SERVER['HTTP_HOST']; ?>/app/cookie.png";
	var text = cadenaTrad('notificacion_bienvenida');
	var notification = new Notification('Cookie21 CMP', {
	  body: text,
	  icon: img,
	});
	notification.onclick = function(){ 
	    aceptarCM21(2);
	    this.close();
	};
	*/
	
	
		if ('true'=='true') {
		
			var img = "https://<?php echo $_SERVER['HTTP_HOST']; ?>/app/cookie.png";
			var text = cadenaTrad('notificacion_bienvenida');
			
			navigator.serviceWorker.register('sw.js');
				Notification.requestPermission(function(result) {
				  if (result === 'granted') {
				    navigator.serviceWorker.ready.then(function(registration) {
				      registration.showNotification('Cookie21 CMP', {
						  body: text,
						  icon: img,
       						  vibrate: [200, 100, 200, 100, 200, 100, 200],
       						  
						});
				    });
				  }
				});
				
				
				
				
			self.addEventListener(
			  "notificationclick",
			  (event) => {
			    event.notification.close();
			  },
			  false,
			);
		}
        c21_setCookie('c21_bienvenida',getCookie('c21_idioma'),'9999');

}

function c21_calc_notification() {

	Notification.requestPermission(function (permission) {
	    // If the user accepts, let's create a notification
	    if (permission === "granted") {
	    
	    	if (getCookie('c21_bienvenida') == getCookie('c21_idioma') || getCookie('c21cm_cookie_consent')) { } else { c21_notificacionBienvenida(); }
	        //var notification = new Notification("Bienvenid@ a cambiazos!");
	        
	        
	        
	    }
	});

}
			
		
function c21_tcData_create() {
			
			/*FUNCION MIGRADA A GLOBALS*/
			
}
			
			
			
			
/*
	
Esta funcion esta pensada para el debug dinámico, siendo llamado este desde la barra del navegador,
con la url: javascript:c21_halt_debug();

O desde El boton de auditoría.
			
*/
			
			
function c21_halt_debug() {
		
			alert(Object.keys(window));
			alert(Object.keys(document));
			alert(Object.keys(tcData));
			
			
}
			
function c21_bulk_data() {
			
			
		if (typeof tcData !== 'undefined') {

			const callback = (tcData, success) => {

			  if(success && tcData.eventStatus === 'tcloaded') {

				// do something with tcData.tcString

			  } else {

				// do something else

			  }

			}

			__tcfapi('addEventListener', 2, callback);	

		}
			
}
	

window.addEventListener("load",function(){
    

	<?php 
	
	if ($fetch['notis']) {
	
	?>
	
	c21_calc_notification();
	
	<?php 
	
	}
	
	?>
	


				if (c21_have_checkCompetence()) { 
			
					console.log('CMPs - Conflict');
					/*document.getElementsByClassName("fc-consent-root")[0].remove();*/
					/*document.getElementById('aviso_cm21').remove();*/
					/*document.getElementById('aviso_cm21').style.left="-100000000";*/
			
			
					setTimeout("aceptarCM21(4);",4000);
			
					setTimeout("hideAllCM21();",3000);
			
				} else {
			
					c21_bulk_data();
			
				}

},false);
			
			
	
	
	
	
	