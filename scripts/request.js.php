<?php

  header('Content-type: text/html');
  
  header('Access-Control-Allow-Origin: *');

include_once('../funciones.php');

if ($_REQUEST['id'] && $_REQUEST['idioma']) {
	$idiomax = extraevaloridioma($id=$_REQUEST['id'],$idioma=$_REQUEST['idioma']);
	echo $idiomax;
}

	
	
	