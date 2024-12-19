<?php

@header('Content-Type: application/javascript; charset=utf-8');

?>
//JavaScript Source


if (1==1) {

	/*AUDITORIA:Hacemos la llamada al HEAD (Configuración del Consent Manager)*/

	if (typeof cm21head !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

		document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/head/?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
		cm21head = 'loaded';
	}




}

if (1==1) { /*OK*/





	/*AUDITORIA:Hacemos la llamada al BODY (Estructura y cuerpo del Consent Manager)*/


	if (typeof cm21body !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {
		document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/body/?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
		cm21body = 'loaded';
	}


}