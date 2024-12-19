<?php

header('Access-Control-Allow-Origin: *');

// set expires header
header('Expires: Thu, 1 Jan 1970 00:00:00 GMT');

// set cache-control header
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0',false);

// set pragma header
header('Pragma: no-cache');

@header('Content-Type: application/javascript; charset=utf-8');

session_Start();

include_once('../funciones.php');


if(!$_SESSION['idioma']) {
	$_SESSION['idioma'] = 'es';
}



    $db= new SQLite3('../db/consentsdb');
        
	$q = "SELECT * FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
	
	
	
	$resultado = $db->query($q);
	
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
		$token = $row;
			  
	}
	
	/*
	if ($fetch['dominio']) {
	
	
	}*/
	





include_once('../funciones.php');

?>
// JavaScript Document
var cm21idiomas = 'loaded';





if (typeof cm21variables !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {


	document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/variables.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
	cm21variables = 'loaded';
}

// Cargar TCF init
if (typeof tcf_init !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {
    document.write('<sc'+'ript src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/TCF/init.js?token=<?php echo $_REQUEST['token']; ?>"></sc'+'ript>');
    tcf_init = 'loaded';
}



<?php if($_SESSION['desarrollador']) { ?>

window.onerror = function(msg, url, linenumber) {
    alert('Error message: '+msg+'\nURL: '+url+'\nLine Number: '+linenumber);
    return true;
}

<?php } ?>




if (typeof cm21traductor   !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

	document.write('<sc'+'ript src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/traductor.js.php?token=<?php echo $_REQUEST['token']; ?>"></sc'+'ript>');
	cm21traductor   = 'loaded';
}


if (typeof cm21config  !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

	document.write('<sc'+'ript src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/config/?token=<?php echo $_REQUEST['token']; ?>"></sc'+'ript>');
	cm21config  = 'loaded';
}

//alert('scrcipt cargado');

if (typeof cm21funciones !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

	document.write('<sc'+'ript src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/funciones.js.php?token=<?php echo $_REQUEST['token']; ?>"></sc'+'ript>');
	cm21funciones = 'loaded';
}



if (window.getCookie) {
    
} else {

	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
		c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
		return c.substring(name.length, c.length);
		}
		}
		return "";
	}

}

if (window.saveCookieCM21) { /*READY*/}
else {
	function saveCookieCM21(nombre,valor) {
	
		document.cookie = nombre+"=" + valor+ "; expires=Thu, 18 Dec 2999 12:00:00 UTC; path=/";
	
	}
}




function c21_actualiza_navegador_idiomas_banner() {

	if (document.getElementById("fullidiomasBanner")) {
	
		if (document.getElementById("fullidiomasBanner").innerHTML == '<img src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/ajax-loader.gif">' ) {
		
			document.getElementById("fullidiomasBanner").innerHTML = '<br><b>Estamos teniendo dificultades técnicas</b>';
			document.getElementById("fullidiomasBanner").innerHTML += '<br>Parece que su navegador está <b>obsoleto</b>.';
			document.getElementById("fullidiomasBanner").innerHTML += '<br>';
			document.getElementById("fullidiomasBanner").innerHTML += '<br>Si el problema persiste, <b>actualicelo.</b>.';
			document.getElementById("fullidiomasBanner").innerHTML += '<br><br><a href="https://www.google.com/chrome/" target="_blank">Actualizar ahora</a>';
		
		}
	}
	
}

function c21_actualiza_navegador_idiomas_gestor() {

	if (document.getElementById("fullidiomasExternal")) {
	
		if (document.getElementById("fullidiomasExternal").innerHTML == '<img src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/ajax-loader.gif">' ) {
		
			document.getElementById("fullidiomasExternal").innerHTML = '<br><b>Estamos teniendo dificultades técnicas</b>';
			document.getElementById("fullidiomasExternal").innerHTML += '<br>Parece que su navegador está <b>obsoleto</b>.';
			document.getElementById("fullidiomasExternal").innerHTML += '<br>';
			document.getElementById("fullidiomasExternal").innerHTML += '<br>Si el problema persiste, <b>actualicelo.</b>.';
			document.getElementById("fullidiomasExternal").innerHTML += '<br><br><a href="https://www.google.com/chrome/" target="_blank">Actualizar ahora</a>';
		
		}
	}
	
}



function cm21cargaidiomas() {

	//alert('Idiomas: En desarrollo....');
	
	
	setTimeout("c21_actualiza_navegador_idiomas_banner();",9000);
	
	source = '<div id="fullidiomasBanner" style="padding:20px;z-index:999999999;border:solid 2px blue;position:fixed;top:2px;left:2px;width:99%;height:99%;background-color:White;">';
	source += '<svg  style="margin:2px;float:right;height:20px;cursor:help;" onclick=document.getElementById("fullidiomasBanner").remove(); xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
	source += '<h2 style="padding:10px;"><img src="https://cookie21.com/cm/idiomas.png" style="cursor:help;height:40px;"></h2><hr><br><br>';
	
	
	<?php
	
		
	
	
	
	
	
        
    $db = new SQLite3('../db/idiomasdb');
    
    
	$q = "SELECT * FROM idiomas WHERE estado LIKE 'on'";
	
	
	$fetch = false;
	if($resultado = $db->query($q)) {
	
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
					
			$fetch[] = $row;
				  
		}
	
	}
	
	if (!$fetch) {
	
	
	//echo '<br><br><h3 style="color:red;">Sin idiomas</3><br><br>';
	
	
	} else {
	
		$i=0;
		while ($fetch[$i]) {
	
			$idiomax = extraevaloridioma($id='idioma_nombre',$idioma=$fetch[$i]['idioma']);
		
			?>
			
			if (getCookie('c21_idioma') == '<?php echo $fetch[$i]['idioma']; ?>') {
			
				border = 'solid 2px <?php echo $token['color']; ?>';
			
			} else {
			
				border = 'solid 1px';
			}
			
			source += '<input type="button" id="boton_idioma_<?php echo $fetch[$i]['idioma']; ?>" style="border:'+border +';padding:20px;margin:20px;font-size:1.3em;" onclick=cm21cambiaIdioma("<?php echo $fetch[$i]['idioma']; ?>") value="<?php echo $idiomax; ?>" >';
		
				<?php	
			 $i++;
				  
		}
	
	
	}
	
	
	?>
	
	source += '<br><br></div>';
	
	/*document.body.innerHTML += source;*/
	
	document.getElementById('c21cm_idiomas_control_banner').innerHTML = source;
}


function cm21cargaidiomasExternal() {

	setTimeout("c21_actualiza_navegador_idiomas_gestor();",9000);
	
	//alert('Idiomas: En desarrollo....');
	
	source = '<div id="fullidiomasExternal" style="padding:20px;z-index:999999999;border:solid 2px blue;position:fixed;top:2px;left:2px;width:99%;height:99%;background-color:White;">';
	source += '<svg  style="margin:2px;float:right;height:20px;cursor:help;" onclick=document.getElementById("fullidiomasExternal").remove(); xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
	source += '<h2 style="padding:10px;"><img src="https://cookie21.com/cm/idiomas.png" style="cursor:help;height:40px;"></h2><hr><br><br>';
	
	
	<?php
	
		
	
	
	
	
	
        
    $db = new SQLite3('../db/idiomasdb');
    
    
	$q = "SELECT * FROM idiomas WHERE estado LIKE 'on'";
	
	
	$fetch = false;
	if($resultado = $db->query($q)) {
	
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
					
			$fetch[] = $row;
				  
		}
	
	}
	
	if (!$fetch) {
	
	
	//echo '<br><br><h3 style="color:red;">Sin idiomas</3><br><br>';
	
	
	} else {
	
		$i=0;
		while ($fetch[$i]) {
	
			$idiomax = extraevaloridioma($id='idioma_nombre',$idioma=$fetch[$i]['idioma']);
		
			?>
			
			if (getCookie('c21_idioma') == '<?php echo $fetch[$i]['idioma']; ?>') {
			
				border = 'solid 2px  <?php echo $token['color']; ?>';
			
			} else {
			
				border = 'solid 1px';
			}
			
			source += '<input type="button" id="boton_idioma_<?php echo $fetch[$i]['idioma']; ?>_external" style="border:'+border+';padding:20px;margin:20px;font-size:1.3em;" onclick=cm21cambiaIdiomaExternal("<?php echo $fetch[$i]['idioma']; ?>") value="<?php echo $idiomax; ?>" >';
		
				<?php	
			 $i++;
				  
		}
	
	
	}
	
	
	?>
	
	
	source += '<br><br></div>';
	
	/*document.body.innerHTML += source;*/

	document.getElementById('c21cm_idiomas_control_gestor').innerHTML = source;
}


function c21cm_termina_de_traducir_ext(nuevoidioma) {

	/*alert(nuevoidioma);*/
	
	saveCookieCM21('c21_idioma',nuevoidioma);
	
					
	if (document.getElementById("fullidiomasExternal")) {
				
		document.getElementById("fullidiomasExternal").remove();
	}
	
	if (document.getElementById('listaCookiesGestor')) {
	
		cookiesExternal();
		
	}
	if (document.getElementById('listaCookies')) {
		if (document.getElementById('listaCookies').style.display == '') {
			cookiesEnUso();
		}
	}
	
	if (document.getElementById("aviso_cm21")) {
		
		rellenacm21();
		
	}
	

	if (document.getElementById("fullidiomasBanner")) {
		document.getElementById("fullidiomasBanner").remove();
	}
	
	

}

document.write('<iframe src="about:blank;" id="c21_cm_sesion_idioma" name="c21_cm_sesion_idioma" style="display:none;"></iframe>');


function cm21cambiaIdiomaExternal(nuevoidioma) {

	cm21cambiaIdioma(nuevoidioma);
		
}



function cm21cambiaIdioma(nuevoidioma) {

	if (getCookie('c21_idioma') == nuevoidioma && '<?php echo $_SESSION['idioma']; ?>' == nuevoidioma ) {
	
		if (document.getElementById('fullidiomasBanner')) {
			document.getElementById('fullidiomasBanner').remove();
		}
		if (document.getElementById('fullidiomasExternal')) {
			document.getElementById('fullidiomasExternal').remove();
		}
		
	} else {
	
		if (document.getElementById('fullidiomasBanner')) {
			document.getElementById('fullidiomasBanner').innerHTML = '<img src=//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/ajax-loader.gif>';
		}
		if (document.getElementById('fullidiomasExternal')) {
			document.getElementById('fullidiomasExternal').innerHTML = '<img src=//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/ajax-loader.gif>';
		}
		
		
		
		if ( Array.isArray( c21cm_idioma_[nuevoidioma] ) ) {
		
		
		setTimeout("c21_actualiza_navegador_idiomas_banner();",9000);
		
			//window.open('https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/session.idioma.php?idioma='+nuevoidioma,'c21_cm_sesion_idioma');
			c21cm_termina_de_traducir_ext(nuevoidioma);
		}
		else {
		
			c21_loadjs('https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/variables.js.php?idioma='+nuevoidioma);
		
		}
	}
	
}









function variablesIdiomas(idioma,variable) {

	return c21cm_idioma_[idioma][variable];
	
}


function idiomavalidocm21(idioma) {

	var devolucion;
	
	
	
	
	<?php
	
		
	
	
	
	
	
        
    $db = new SQLite3('../db/idiomasdb');
    
    
	$q = "SELECT * FROM idiomas WHERE estado LIKE 'on'";
	
	
	$fetch = false;
	if($resultado = $db->query($q)) {
	
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
					
			$fetch[] = $row;
				  
		}
	
	}
	
	if (!$fetch) {
	
	
	
	} else {
	
		$i=0;
		while ($fetch[$i]) {
		
		//print_r($fetch[$i]);
		
			$n=0;
			$cabeceras = explode(',',$fetch[$i]['cabeceras']);
			
			//print_R($cabeceras)
			
			while ($n < sizeof($cabeceras)) {
			
				if ($cabeceras[$n]) {
	
			?>
			
				if (idioma == '<?php echo $cabeceras[$n]; ?>') {
					
					
					devolucion = '<?php echo $fetch[$i]['idioma']; ?>';
					
				
				}
			
			<?php
				}
				$n++;
			}
			
			?>
			
			if (idioma == '<?php echo $fetch[$i]['idioma']; ?>') {
				
				
				devolucion = idioma;
				
			
			}
			
		
				<?php	
			 $i++;
				  
		}
	
	
	}
	
	
	?>
	
	if (!devolucion) {
	
		
		valuen = 'LANGUAGE UNDEFINED: LANGUAGE:' + idioma;
		
		c21_collect(valuen);
		
		return false;
	
	}
	
	return devolucion;

}



function loadIdiomasCM21() {

		var browserLang = getCookie('c21_idioma');
		
		
		if (!browserLang) {
		
			var browserLang = window.navigator.userLanguage || window.navigator.language;
			var browserLang = idiomavalidocm21(browserLang);
		}
		
		if (!browserLang) {
		
			var browserLang = '<?php echo $_SESSION['idioma']; ?>';
		}
		
		
		
		if (!browserLang) {
		
			var browserLang = 'es';
		}
		
		
		if (browserLang) {
	
			cm21cambiaIdioma(browserLang);
		
		}
		
}

