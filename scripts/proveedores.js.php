<?php

@header('Content-Type: application/javascript');


include_once('../funciones.php');

    $db= new SQLite3('../db/cookiesdb');
        
	$q = "SELECT * FROM cookies ORDER BY prioridad DESC";
	
	$resultado = $db->query($q);
	
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
		$fetch[] = $row;
			  
	}


?>



// JavaScript Document

var cm21proveedores = 'loaded';


if (typeof c21cm_cookies !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

	document.write('<sc'+'ript src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/cookies.js.php?token=<?php echo $_REQUEST['token']; ?>"></sc'+'ript>');
	c21cm_cookies = 'loaded';
}

if (typeof cm21idiomas !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

	document.write('<sc'+'ript src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/idiomas.js.php?token=<?php echo $_REQUEST['token']; ?>"></sc'+'ript>');
	cm21idiomas = 'loaded';
}
	
	function proveedores(cookieNameProv) {
	
		idioma = getCookie('c21_idioma');
	
	/*alert('"'+cookieNameProv+'"');*/
		
		
		if (Array.isArray(c21_cm_cookiesn[idioma][cookieNameProv])) {
		//alert(cookieNameProv);
			return c21_cm_cookiesn[idioma][cookieNameProv];
		
		}
		
		
		
	/*
		let provider= new Array();
		*/
		
		<?php
		if ($comparador=true) {
		$n = 0;
		  while($fetch[$n]) {
		  
		  
		  	$nombre2 = str_replace('#','',$fetch[$n]['nombre']);
		  	
		  	if ($nombre2 != $fetch[$n]['nombre'] && !$loadedArray[$nombre2]) {
		  	
		  		$loadedArray[$nombre2] = true;
		  

		 ?>
if(cookieNameProv.indexOf('<?php echo $nombre2; ?>') !== -1)  {
	if (Array.isArray(c21_cm_cookiesn[idioma]['<?php echo $fetch[$n]['nombre']; ?>'])) {
	 return c21_cm_cookiesn[idioma]['<?php echo $fetch[$n]['nombre']; ?>'];
	}
}
<?php
			}

		  $n++;
		  }
		  }
		 ?>
	/*alert(idioma);*/
	//alert('"'+cookieNameProv+'"');
	
	
		
	
		var provider= new Array();
		provider['proveedor'] = '';
		provider['enlace'] = '';
		provider['duracion'] = '';
		provider['info'] = '';
		provider['prioridad'] = '';
		provider['tipo'] = '';
		provider['conexion'] = '';
		
		
		valuen = 'COOKIE UNDEFINED: COOKIE: '+cookieNameProv+' ; IDIOMA: ' + idioma;
		c21_collect(valuen);
		
	return provider;
}


