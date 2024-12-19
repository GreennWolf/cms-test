<?php
session_start();


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
 
ini_set('display_errors', FALSE);

include_once('funciones.php');

?>


<?php

if ($_REQUEST['add']) {

	$source = file_get_contents($filename='db/collect.txt');
	
	if (ereg($_REQUEST['add'],$source)) {
	
		exit('Data already exists.');
	
	}
	
	

  if ($gestor	=	fopen($filename='db/collect.txt', "a+")) {
			@fwrite($gestor,$_REQUEST['add']." ( En ".$_SERVER['HTTP_REFERER']." ) \r\n \r\n ");
			@fclose($gestor);
  }
  
  
  
	exit();
}



if (!$_SESSION['super']) {

	header('Location: admins.php');
	exit();
}

if ($_REQUEST['data']) {



  if ($gestor	=	fopen($filename='db/collect.txt', "w")) {
			@fwrite($gestor,$_REQUEST['data']);
			@fclose($gestor);
  }
  
  
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

<title>Data Collect - Cookie21 CMP - Consent Manager Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>


<form method="POST" action="collect.php" target="_SELF" id="formCollect" name="formCollect">

<h4>DATA COLLECT</h4>

<textarea id="data" name="data" style="border:2px dotted orange;width:95%;height:400px;"
 ><?php @include_once($filename='db/collect.txt'); ?></textarea>
 
<br>

<input  type="submit" value="Guardar">

<input  type="button" value="Borrar todo" onclick="document.getElementById('data').innerHTML= ' ';document.getElementById('formCollect').submit();"  >

<input  type="button" value="Actualizar" onclick="window.location.href=window.location.href;"  >

</form>




</body>
</html>











