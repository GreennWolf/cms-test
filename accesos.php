<?php

session_start();
ini_set('display_errors', FALSE);


date_default_timezone_set('Europe/Madrid');

if ($_SESSION['super']) { /*ok*/ }
elseif ($_SESSION['token']) { $_REQUEST['token'] =  $_SESSION['token']; }
else { exit(); }


include_once('funciones.php');

function traduceAccesos($cadena) {

	/*
	$cadena = str_replace('LOAD',extraevaloridioma('_LOAD_'),$cadena);
	*/
	
	$cadena = str_replace('ALL',extraevaloridioma('_ALL_'),$cadena);
	
	$cadena = str_replace('NECESSARY',extraevaloridioma('_NECESSARY_'),$cadena);
	
	$cadena = str_replace('SOME',extraevaloridioma('_SOME_'),$cadena);
	
	$cadena = str_replace('PRELOADED',extraevaloridioma('_PRELOADED_'),$cadena);
	
	$cadena = str_replace('ACTION',extraevaloridioma('_ACTION_'),$cadena);
	
	$cadena = str_replace('LOAD DEFAULTS',extraevaloridioma('_LOAD_DEFAULTS_'),$cadena);
	
	$cadena = str_replace('STATS',extraevaloridioma('_STATS_'),$cadena);

	return $cadena;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>
<?php include_once('idiomas.banner.php'); ?>
<title><?php echo extraevaloridioma('idioma_accesos'); ?> - <?php echo extraevaloridioma('idioma_titulo'); ?></title>

<?php



if ($_REQUEST['token']) {

    if (!$_REQUEST["nRegistros"]) $_REQUEST["nRegistros"] = 50;
    if (!$_REQUEST["acciones"]) $_REQUEST["acciones"] = 'todo';

	?>
	
	<h1><?php echo extraevaloridioma('idioma_accesos'); ?></h1>
	
	
	
	<br>
	<br>
	
	<form  enctype="multipart/form-data"  action="accesos.php" target="_top" method="POST">
	<input type="hidden" name="token" id="token" value="<?php echo $_REQUEST['token']; ?>">
	<?php echo extraevaloridioma('idioma_mostrando_ultimos'); ?> <select id="nRegistros" name="nRegistros">
		<option value="20">20</option>
		<option value="50">50</option>
		<option value="100">100</option>
		<option value="200">200</option>
		<option value="500">500</option>
		<option value="1000">1000</option>
		<option value="99999">99999</option>
	
	</select> <select id="acciones" name="acciones">
		<option value="acciones"><?php echo extraevaloridioma('idioma_acciones'); ?></option>
		<option value="todo" selected><?php echo extraevaloridioma('idioma_accesos_y_acciones'); ?></option>
	
	</select>
	
	<script>
	document.getElementById("nRegistros").value = '<?php echo $_REQUEST["nRegistros"]; ?>';
	</script>
	<script>
	document.getElementById("acciones").value = '<?php echo $_REQUEST["acciones"]; ?>';
	</script>
	
	
		<input type="submit" id="submit" name="submit" value="<?php echo extraevaloridioma('idioma_Actualizar'); ?>"> 
		
	</form>
	
	
	<br>
	<br>

<script src="handsontable-pro-master/node_modules/handsontable-pro-master/dist/handsontable.full.min.js"></script>
<script src="handsontable-pro-master/node_modules/handsontable-pro-master/dist/languages/es-MX.js"></script>
<link href="handsontable-pro-master/node_modules/handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">


	
<div id="registros"></div>
<script>


 
const inci = ["TOKEN","<?php echo strtoupper(extraevaloridioma('idioma_cliente')); ?>","<?php echo strtoupper(extraevaloridioma('idioma_fecha')); ?>","<?php echo strtoupper(extraevaloridioma('idioma_consent')); ?>","<?php echo strtoupper(extraevaloridioma('idioma_referrer')); ?>","<?php echo strtoupper(extraevaloridioma('idioma_navegador')); ?>","<?php echo strtoupper(extraevaloridioma('idioma_ip')); ?>","<?php echo strtoupper(extraevaloridioma('idioma_id_sesion')); ?>"];


data1 = [


<?php












		
			$db= new SQLite3('db/accesosdb');
			
			if ($_REQUEST['acciones']=='acciones') {
			$q = "SELECT * FROM accesos WHERE token LIKE '".$_REQUEST['token']."' AND estado LIKE '%ACTION%' ORDER BY ctime DESC LIMIT ".$_REQUEST["nRegistros"];
			}
			else {
			$q = "SELECT * FROM accesos WHERE token LIKE '".$_REQUEST['token']."' ORDER BY ctime DESC LIMIT ".$_REQUEST["nRegistros"];
			}
			
			
			if($resultadow = $db->query($q)) {
			
			while ($now = $resultadow->fetchArray(SQLITE3_ASSOC)) {
						
			if ($now['estado'] == '0') { $now['estado'] = 'Necesarias'; }
			elseif ($now['estado'] == '1')  { $now['estado'] = '+Estadistica'; }
			else if ($now['estado'] == '2') { $now['estado'] = 'Todas'; }
			//else  { $now['estado'] = '(No seleccionado)'; }
				
				
		echo '["'.$now['token'].'","'.$now['client'].'","'.date("Y-m-d H:i:s",$now['ctime']).'","'.traduceAccesos($now['estado']).'","'.$now['referrer'].'","'.$now['browser'].'","'.$now['ip'].'","'.$now['session'].'"],
		
		';
			  
			}
			}
			
?>


];




var containerx = document.getElementById('registros');

hot0 = new Handsontable(containerx, {
  data: data1,
  type: 'autocomplete',
  // use HTML in the source list
  allowHtml: true,
  
  source: data1,
  
  allowInsertColumn: false,
  allowRemoveColumn: false,
  allowRemoveRow: false,
  
  editor: false,
  language: 'es-MX',
  
  
  rowHeaders: false,
  colHeaders: inci,
  filters: true,
  dropdownMenu: ['filter_by_condition', 'filter_by_value', 'filter_action_bar']
});


</script>




	
	
	
	
	
	
	
	
	
	<br>
	
	<hr>
	
	<br>
	
	
	
	
	<input type="button" onclick="window.open('index.php','_top');" value="<?php echo extraevaloridioma('idioma_regresar_inicio'); ?>" >
	
	<br>
	
	
	<br>
	<br>
	<br>
	
	
	
	<?php
	
}
else {
	
	?>
	
	<script>window.open('index.php','_top');</script>
	
	<?php
	
}
?>
</body>
</html>

