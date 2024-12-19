<?php


ini_set('display_errors', FALSE);
session_start();

include_once('funciones.php');



if ($_REQUEST['idioma']) { $_SESSION['idioma'] = $_REQUEST['idioma']; }
if (!$_SESSION['idioma']) { $_SESSION['idioma'] = 'es'; }
if (!$_REQUEST['idioma']) { $_REQUEST['idioma'] = $_SESSION['idioma']; }

if ($_SESSION['token']) { $_REQUEST['token'] = $_SESSION['token']; }


if (!$_SESSION['super'] && !$_SESSION['token']) {

  exit(header('Location: idiomas.php'));
	
}

if ($_REQUEST['token']) { $_SESSION['token'] = $_REQUEST['token']; }


if ($_REQUEST['nuevo']) {

	if (!$_REQUEST['manual']) {
	
		?>
		<script>
			alert('<?php echo extraevaloridioma('idioma_complete_formulario'); ?>');
		</script>
		<?php
		exit();
	
	}

	$db = new SQLite3('db/tercerosdb');
        
    	$q = "INSERT INTO terceros (token, manual) VALUES ('".$_REQUEST['token']."','".$_REQUEST['manual']."' )";
    	$resultado = $db->exec($q);
    	?>
		<script>
			alert('<?php echo extraevaloridioma('idioma_cambios_guaradados_correctamente'); ?>');
			window.parent.location.href=window.parent.location.href;
		</script>
    	
    	
    	<?php
    	exit();
		

}
else if ($_REQUEST['elimina'] && $_REQUEST['provider'] && $_REQUEST['value']) {


	$db = new SQLite3('db/tercerosdb');
        
    	$q = "DELETE FROM terceros WHERE ".$_REQUEST['provider']." LIKE '".$_REQUEST['value']."' ";
    	$resultado = $db->exec($q);

    	?>
		<script>
			alert('<?php echo extraevaloridioma('idioma_cambios_guaradados_correctamente'); ?>');
			window.parent.location.href=window.parent.location.href;
		</script>
    	
    	
    	<?php
    	exit();

}


?>
<title><?php echo extraevaloridioma('idioma_gestion_terceros'); ?> - <?php echo extraevaloridioma('idioma_titulo'); ?></title>
<html lang="<?php echo $_SESSION['idioma']; ?>">
<head>

<title>Consent Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>
<?php


include_once('idiomas.banner.php');

?>
<h1><?php echo extraevaloridioma('idioma_gestion_terceros'); ?></h1>
<h2><?php echo $_REQUEST['token']; ?></h2>

<iframe src="about:blank;" name=editaTerceros id=editaTerceros style=display:none; ></iframe>
<?php
$db = new SQLite3('db/tercerosdb');
	    
	    
$q = "SELECT * FROM terceros WHERE token LIKE '".$_REQUEST['token']."' AND manual LIKE '%%' ";
		
		
$tercerosdb = false;

if($resultado = $db->query($q)) {
		
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
		$tercerosdb [] = $row;
					  
	}
		
}


$nx = 0;
while ($tercerosdb[$nx]) {

?>



<form method="POST" action="terceros.php" target="editaTerceros">

<input type="hidden" name="elimina" id="elimina" value="true">


<?php
$id = false;

if ($tercerosdb[$nx]['iabid'] && FALSE) {

	$value = $tercerosdb[$nx]['iabid'];
	$provider = 'iabid';
	$id = 'iab_'.$tercerosdb[$nx]['iabid'];
	$nombre = iabInfoProvider($tercerosdb[$nx]['iabid']);
	$nombre = $nombre['nombre'];
	
}
elseif ($tercerosdb[$nx]['googleid'] && FALSE) {
	$value = $tercerosdb[$nx]['googleid'];
	$provider = 'googleid';
	$id = 'google_'.$tercerosdb[$nx]['googleid'];
	$nombre = googleInfoProvider($tercerosdb[$nx]['googleid']);
	$nombre = $nombre['nombre'];
	
}
elseif ($tercerosdb[$nx]['manual']) {

	$value = $tercerosdb[$nx]['manual'];
	$provider = 'manual';
	$id = 'prov_'.sha1($tercerosdb[$nx]['manual']);
	$nombre = $tercerosdb[$nx]['manual'];
	
}

?>


<input type="hidden" name="provider" id="provider " value="<?php echo $provider; ?>">

<input type="hidden" name="value" id="value" value="<?php echo $value; ?>">



	<fieldset><legend><h3><?php echo $nombre; ?></h3></legend>
	Cookie: 
	<b><?php echo $id; ?></b>
	<br><br>
	</fieldset>



<br>
<input  type="submit" value="Eliminar">

</form>


<br><hr><br><br><br><br>


<?php

	$nx++;
}

?>














<h2><?php echo extraevaloridioma('idioma_nuevo_tercero'); ?>:</h2>


<form method="POST" action="terceros.php" target="editaTerceros">

<input type="hidden" name="nuevo" id="nuevo" value="true">

<input type="text" name="manual" id="manual" value="">

<br>
<input  type="submit" value="Grabar">
<br><br>
<?php echo extraevaloridioma('idioma_info_sha_terceros'); ?>

</form>



<br><br><br><br><br>


	<input type="button" onclick="window.open('/cm/selector.php?token=<?php echo $_REQUEST['token']; ?>#manual','_top');" value="<?php echo extraevaloridioma('idioma_regresar'); ?>" >
	
