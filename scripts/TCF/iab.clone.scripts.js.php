<?php

@header('Content-Type: application/javascript; charset=utf-8');

include_once('../../funciones.php');

?>


  
  

	function saveCookieCM21(nombre,valor) {
	
		window.parent.saveCookieCM21(nombre,valor);
	
	}


	function getCookie(cname) {
		return window.parent.getCookie(cname);
	}



  function c21_recambia(id,value) {
    	
  	if (document.getElementById(id)) {
  	
  		
  		document.getElementById(id).value = value;
  		document.getElementById(id).focus();
  		document.getElementById(id).blur();
  
  
  	}
  	
  	
  }
  
  function iab_calc() {
  
  	/*alert('processing...');*/
  	
  	iab_consentLanguage();
  	
  	iab_publisherCountryCode();
  	
  	c21_establece(getCookie('c21cm_cookie_consent'));
  	
  }
  
  
  
  function c21_suma(id) {
  
  	id=id-1;
  
  	var event = new Event('change');
  	
  	
  	var elements = document.getElementById("purposeConsents").options;

      	elements[id].selected = true;
      	
      	document.getElementById("purposeConsents").dispatchEvent(event);
      	
      	
  	var elements = document.getElementById("purposeLegitimateInterests").options;

      	elements[id].selected = true;
      	
      	document.getElementById("purposeLegitimateInterests").dispatchEvent(event);
      	
      	
  
  }
  function c21_resta(id) {
  
  	id = id-1;
  	
  	var event = new Event('change');
  	
  	
  	var elements = document.getElementById("purposeConsents").options;

      	elements[id].selected = false;
      	
      	document.getElementById("purposeConsents").dispatchEvent(event);
      	
      	
  	var elements = document.getElementById("purposeLegitimateInterests").options;

      	elements[id].selected = false;
      	
      	document.getElementById("purposeLegitimateInterests").dispatchEvent(event);
      	
      	
  
  }
  
  function c21_suma_especial(id) {
  
  	id = id-1;
  	
  	var event = new Event('change');
  	
  	
  	var elements = document.getElementById("specialFeatureOptins").options;

      	elements[id].selected = true;
      	
      	document.getElementById("specialFeatureOptins").dispatchEvent(event);
      	
      	
  }
  
  function c21_resta_especial(id) {
  
  	id = id-1;
  
  	var event = new Event('change');
  	
  	
  	var elements = document.getElementById("specialFeatureOptins").options;

      	elements[id].selected = false;
      	
      	document.getElementById("specialFeatureOptins").dispatchEvent(event);
      	
      	
      	
  }
  function c21_reset_providers() {
  
  
  	
  	document.getElementById("vendorConsents").innerHTML = '';
  	
  	document.getElementById("vendorLegitimateInterests").innerHTML = '';
  	
      	document.getElementById("vendorsAllowed").innerHTML = '';
      	
      	
      	
		/*SCANNED PROVIDERS*/
		<?php
		
		
	
    		$terceros = new SQLite3('../../db/tercerosdb');
    		
		$q = "SELECT * FROM terceros WHERE token LIKE '".$_REQUEST['token']."'";
			
		$resultadoTerceros = $terceros->query($q);
			
		$tercero = false;
		while ($rowx = $resultadoTerceros ->fetchArray(SQLITE3_ASSOC)) {
						
			//$tercero[] = $rowx;
			$iab = false;
			
			if ($rowx['iabid']) {
				$iab = iabInfoProvider($rowx['iabid']);
				
				if ($iab['id']) {
			//print_r($iab);
			?>
				
			document.getElementById("vendorConsents").innerHTML += '<option value="<?php echo $iab['id']; ?>"><?php echo $iab['id']; ?></option>';
	      		document.getElementById("vendorLegitimateInterests").innerHTML += '<option value="<?php echo $iab['id']; ?>"><?php echo $iab['id']; ?></option>';
	      		document.getElementById("vendorsAllowed").innerHTML += '<option value="<?php echo $iab['id']; ?>"><?php echo $iab['id']; ?></option>';
		
		
			<?php
				}
			}
			
					  
		}
		
		
		
	?>
	
	
	<?php
	
	
    	$db= new SQLite3('../../db/proveedoresiabdb');
    	
    	$q = "SELECT vendorListVersion FROM proveedoresiab LIMIT 1";
		
	$resultado = $db->query($q);
			
	$fetch = false;
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
		$fetch = $row;
					  
	}
    	
	
	?>
	
	
  	var event = new Event('change');
  	
      	document.getElementById("vendorListVersion").innerHTML = '<option value="<?php echo $fetch['vendorListVersion']; ?>"><?php echo $fetch['vendorListVersion']; ?></option>';
	
      	document.getElementById("vendorListVersion").dispatchEvent(event);
	
  
  }
  
  function c21_proveedores_edit() {
  
  	c21_reset_providers();
  
   	var provider = false;
  	/*ADD VALAUE
  	document.getElementById('vendorConsents').add.value();
  	*/
  	
  	var event = new Event('change');
  	
  	var elements = document.getElementById("vendorConsents").options;
  	
      	for (i = 0; i <= elements.length; i++) {
      		if (elements[i]) {
      			if (elements[i].value) {
		      		if (getCookie('iab_'+elements[i].value)) {
			      		elements[i].selected = true; var provider = true;
				} else {
			      		elements[i].selected = false;
				}
			}
		}
	}
	
	
	
      	document.getElementById("vendorConsents").dispatchEvent(event);
      	
      	
  	var elements = document.getElementById("vendorLegitimateInterests").options;

      	
      	for (i = 0; i <= elements.length; i++) {
      		if (elements[i]) {
      			if (elements[i].value) {
		      		if (getCookie('iab_'+elements[i].value)) {
			      		elements[i].selected = true; var provider = true;
				} else {
			      		elements[i].selected = false;
				}
			}
		}
	}
	
      	document.getElementById("vendorLegitimateInterests").dispatchEvent(event);
      	
      	
  	var elements = document.getElementById("vendorsAllowed").options;

      	
      	for (i = 0; i <= elements.length; i++) {
      		if (elements[i]) {
      			if (elements[i].value) {
		      		if (getCookie('iab_'+elements[i].value)) {
			      		elements[i].selected = true; var provider = true;
				} else {
			      		elements[i].selected = false;
				}
			}
		}
	}
	
      	document.getElementById("vendorsAllowed").dispatchEvent(event);
      	
      	
      	
      	return provider;
      	
  
  }
  
  function c21_propositos() {
  
  
  	if (getCookie('propositoCookies1')) { c21_suma('1'); } else { c21_resta('1'); }
  	if (getCookie('propositoCookies2')) { c21_suma('2'); } else { c21_resta('2'); }
  	if (getCookie('propositoCookies3')) { c21_suma('3'); } else { c21_resta('3'); }
  	if (getCookie('propositoCookies4')) { c21_suma('4'); } else { c21_resta('4'); }
  	if (getCookie('propositoCookies5')) { c21_suma('5'); } else { c21_resta('5'); }
  	if (getCookie('propositoCookies6')) { c21_suma('6'); } else { c21_resta('6'); }
  	if (getCookie('propositoCookies7')) { c21_suma('7'); } else { c21_resta('7'); }
  	if (getCookie('propositoCookies8')) { c21_suma('8'); } else { c21_resta('8'); }
  	if (getCookie('propositoCookies9')) { c21_suma('9'); } else { c21_resta('9'); }
  	if (getCookie('propositoCookies10')) { c21_suma('10'); } else { c21_resta('10'); }
  	
  	if (getCookie('propositoEspecialCookies1')) { c21_suma_especial('1'); } else { c21_resta_especial('1'); }
  	if (getCookie('propositoEspecialCookies2')) { c21_suma_especial('2'); } else { c21_resta_especial('2'); }
  
  	return c21_proveedores_edit();
  
  }
  
  function c21_establece(modo) {
  
  	/*alert(modo);*/
  
  	if (!getCookie('iabConsentString')) {
  	
  		saveCookieCM21('iabConsentString','idioma_sin_configurar');
  		
  		return false;
  	
  	}
  	else if (getCookie('iabConsentString') == 'idioma_sin_proveedores') {
  	
  		return false;
  	
  	}
  	else if (modo == '3') {
  	
  		
		/*
		saveCookieCM21('iabConsentString','idioma_sin_autorizacion');
		
  		return false;
  		*/
  	
  	}
  	
  
  	var event = new Event('change');
  	
  	if (document.getElementsByClassName("form-control")[0]) {
  	
	  	document.getElementsByClassName("form-control")[0].value = '2021';
	  	
	
		document.getElementsByClassName("form-control")[0].dispatchEvent(event);
	 	
	  
	  
	  	
	  	
	  	document.getElementsByClassName("form-control")[1].value = '1';
	  	
	
		document.getElementsByClassName("form-control")[1].dispatchEvent(event);
	 	
	  	
	  	
	  	document.getElementsByClassName("form-control")[2].value = getCookie('c21_consentScreen');
	  	
	
		document.getElementsByClassName("form-control")[2].dispatchEvent(event);
	 	
	 	
	 	
	 	
	  
	  	var event = new Event('change');
	  	
	  	document.getElementById('isServiceSpecific').checked = 'checked';
	  	
	
		document.getElementById('isServiceSpecific').dispatchEvent(event);
	 	
	  
	  	if (c21_propositos() || 'true' == 'true') {
	  	
	  		
	  		setTimeout("iab_grabaString();",1200);
	  	
	  	}
	  	else {
	  	
	  		
			saveCookieCM21('iabConsentString','idioma_sin_autorizacion');
			
	  		return false;
	  	
	  	}
  
 	}
  	
  }
  
  function iab_grabaString() {
  
 	if (document.getElementsByClassName("tcstring-input")[0].value) {
	  	
		  	iabConsentString = document.getElementsByClassName("tcstring-input")[0].value;
		  	
		  	
		  	saveCookieCM21('iabConsentString',iabConsentString);
		  	
		  	
		  	window.parent.c21_avisaGoogle();

	  	window.parent.document.getElementById('div_iab_ajax').innerHTML = '';
  	}
  
  }
  
  function iab_consentLanguage() {
  
  	if (getCookie('consentLanguage')) {
  	
  		if (document.getElementById('consentLanguage')) {
  	
		  	document.getElementById('consentLanguage').value = getCookie('consentLanguage');
		  	
		  	var event = new Event('change');
		
			document.getElementById('consentLanguage').dispatchEvent(event);
		}
	}
  	
  }



if (window.iab_publisherCountryCode) { }

else {
  function iab_publisherCountryCode() {
  
  
  
<?php

@session_start();

if (!$_SESSION['CountryCode']) {

    $ip = $_SERVER['REMOTE_ADDR'];
    
    
    $url = 'http://ip-api.com/php/'.$ip;
    
    
    
  
    if ($_SESSION['cache'][$url]) {
    
     /*ok*/
    
    }
    else if (@file_exists($filename='../../caches/'.sha1($url).'.txt')) {
    
    	$_SESSION['cache'][$url] = @file_get_contents($filename);
    	
    }
    else {
  
	    $archivo_web = @file_get_contents($url);
	    
	    $_SESSION['cache'][$url] = $archivo_web;
	    
	    
		if ($fp = @fopen($filename='../../caches/'.sha1($url).'.txt','w')) {
			@fwrite($fp,$archivo_web);
			@fclose($fp);
		}
	
    }
    
    
    $query = @unserialize($_SESSION['cache'][$url]);
    
    if($query && $query['status'] == 'success')
    {
    
      	/*$_SESSION['Lcity'] = $query['city'];*/
      	
      	$_SESSION['CountryCode'] = $query['countryCode'];
    }
    
    	//print_r($query);
        
}
?>
  	/*alert('<?php echo $_SESSION['CountryCode']; ?>');*/
  
  	
		
	saveCookieCM21('publisherCountryCode','<?php echo $_SESSION['CountryCode']; ?>');
  	
  	if (document.getElementById('publisherCountryCode')) {
  	
	  	document.getElementById('publisherCountryCode').value = '<?php echo $_SESSION['CountryCode']; ?>';
	  	
	  	var event = new Event('change');
	  	
	  	document.getElementById('publisherCountryCode').dispatchEvent(event);
  	
  	}
  	
  }
}
  
  
  /*
  var sleep = function(ms){ return new Promise(resolve => setTimeout(resolve, 2000)); };
  */
  
  function recursiveCalc3() {
  	iab_calc();
  	setTimeout("recursiveCalc1();",1200);
  }
  function recursiveCalc2() {
  	iab_calc();
  	setTimeout("recursiveCalc3();",1200);
  }
  function recursiveCalc1() {
  	iab_calc();
  	setTimeout("recursiveCalc2();",1200);
  }
  
  
  
  recursiveCalc1();