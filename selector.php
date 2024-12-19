<?php
session_start();
 
ini_set('display_errors', FALSE);



if ($_SESSION['super']) { 

	$_SESSION['token'] = $_REQUEST['token'];
	//echo 'Logged'.$_SESSION['token'];
}
else if ($_SESSION['token']) { $_REQUEST['token'] = $_SESSION['token']; }
else { exit(header('Location: index.php')); }

include_once('funciones.php');

?>



<!DOCTYPE html>
<html lang="es">
<head>

<?php include_once('idiomas.banner.php'); ?>

<title><?php echo extraevaloridioma('idioma_selector_de_proveedores'); ?> - <?php echo extraevaloridioma('idioma_titulo'); ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
  
  <style>
  
  .saving {
  
 	 border: solid 1px orange;
  
  }
  .saved {
  
  
 	 border: solid 2px green;
  
  }
  
  
  </style>
  
  
  
</head>
<body>
<div id="block" style="position:fixed;z-index:9999;top:0px;left:0px;width:100%;height:100%;display:none;"></div>

<h1><?php echo extraevaloridioma('idioma_logo'); ?></h1>

<h2><?php echo extraevaloridioma('idioma_selector_de_proveedores'); ?></h2>

<h3>Token: <u><?php echo $_REQUEST['token']; ?></u></h3>



	<hr>
<input type="button" onclick="window.open('editar.php?token=<?php echo $_REQUEST['token']; ?>','_top');" value="<?php echo extraevaloridioma('idioma_regresar'); ?>">
	
	<hr>
	<br>

<input type="button" onclick="window.open('inicio.scan.php?token=<?php echo $_REQUEST['token']; ?>','frame_ajax_providers');"
 value="<?php echo extraevaloridioma('idioma_escanner_proveedores'); ?>"> <?php echo extraevaloridioma('idioma_escaneo_automatico'); ?>
	
	<br>
	<h2 id="consola_informativa" style="color:green;"></h2>
	<br>
	<h2><u><?php echo extraevaloridioma('idioma_seleccion_manual_proveedores'); ?></u></h2>
	
	<iframe src="about:blank" id="frame_ajax_providers" name="frame_ajax_providers" style="display:none;"></iframe>
	
	<script>
	
	function cambiaProveedor(id) {
	
	
		document.getElementById('block').style.display='';
		
		document.getElementById(id).disabled='disabled';
	
		document.getElementById('frame_ajax_providers').src = 'cambia.proveedor.php?token=<?php echo $_REQUEST['token']; ?>&id='+id;
		
		
		
	}
	
	</script>
	
	
	<form id="fullProviders" name="fullProviders" >
	
	<h3> > IAB</h3>

<?php

	    	
	    
    		$iab= new SQLite3('db/proveedoresiabdb');
    	
		
			$q = "SELECT * FROM proveedoresiab";
		
			$resultado = $iab->query($q);
			
			$fetch2 = false;
			while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
				$fetch2[] = $row;
					  
			}
			
			
			
			$x=0;
			while ($fetch2[$x]) {
			
			 if ($fetch2[$x]['nombre']) {
			?>
			
			
			&nbsp; <input onchange="cambiaProveedor(this.id);" type="checkbox" id="iab_<?php echo $fetch2[$x]['id']; ?>"><label 
			for="iab_<?php echo $fetch2[$x]['id']; ?>"> <b><?php echo $fetch2[$x]['nombre']; ?></b></label>
			
			<br>
			
			<?php
			}
				
			
				$x++;
			}
			

?>



	<br>
	<br>
	<h3> > Google</h3>

<?php

	    	
	    
    		$google= new SQLite3('db/proveedoresgoogledb');
    	
		
			$q3 = "SELECT * FROM proveedoresgoogle";
		
			$resultado3 = $google->query($q3);
			
			$fetch3 = false;
			while ($row3 = $resultado3->fetchArray(SQLITE3_ASSOC)) {
						
				$fetch3[] = $row3;
					  
			}
			
			
			
			$x3=0;
			while ($fetch3[$x3]) {
			
			if ($fetch3[$x3]['nombre']) {
			?>
			
			
			&nbsp; <input onchange="cambiaProveedor(this.id);" type="checkbox" id="iab_<?php echo $fetch3[$x3]['id']; ?>"><label 
			for="iab_<?php echo $fetch3[$x3]['id']; ?>"> <b><?php echo $fetch3[$x3]['nombre']; ?></b></label>
			
			<br>
			
			<?php
			}
				
			
				$x3++;
			}
			

?>
	
	
	
	
	</form>
	<br>
	<br>
	<h3 id="manual" name="manual"> > <?php echo extraevaloridioma('idioma_terceros_anyadidos_manualmente'); ?></h3>
	
	
	
	
	
	
	
<?php

$db = new SQLite3('db/tercerosdb');
	    
	    
$q = "SELECT * FROM terceros WHERE token LIKE '".$_REQUEST['token']."' ";
		
		
$tercerosdb = false;

if($resultado = $db->query($q)) {
		
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
		$tercerosdb [] = $row;
					  
	}
		
}


$nx = 0;
while ($tercerosdb[$nx]) {

	$id = false;
	
	if ($tercerosdb[$nx]['iabid']) {
	
		$value = $tercerosdb[$nx]['iabid'];
		$provider = 'iabid';
		$id = 'iab_'.$tercerosdb[$nx]['iabid'];
		$nombre = iabInfoProvider($tercerosdb[$nx]['iabid']);
		$nombre = $nombre['nombre'];
		
		?>
		<script>
			document.getElementById('<?php echo $id; ?>').checked = 'checked';
		</script>
		
		<?php
		
	}
	elseif ($tercerosdb[$nx]['googleid']) {
		$value = $tercerosdb[$nx]['googleid'];
		$provider = 'googleid';
		$id = 'google_'.$tercerosdb[$nx]['googleid'];
		$nombre = googleInfoProvider($tercerosdb[$nx]['googleid']);
		$nombre = $nombre['nombre'];
		?>
		
		<script>
			document.getElementById('<?php echo $id; ?>').checked = 'checked';
		</script>
		
		<?php
		
		
	}
	elseif ($tercerosdb[$nx]['manual']) {
	
		$value = $tercerosdb[$nx]['manual'];
		$provider = 'manual';
		$id = 'prov_'.sha1($tercerosdb[$nx]['manual']);
		$nombre = $tercerosdb[$nx]['manual'];
			?>
			
			
			&nbsp;&bull;&nbsp; <b><?php echo $nombre; ?></b>
			
			<br>
			
			<?php
		
	}


$nx++;
}
?>
	
	
	
	
	<br>
		
<input type="button" onclick="window.open('terceros.php?token=<?php echo $_REQUEST['token']; ?>','_top');" 
value="<?php echo extraevaloridioma('idioma_gestion_terceros'); ?>"> <?php echo extraevaloridioma('idioma_terceros_info'); ?>
		
	
	<br>
	
	
	
	<br>
	<br>
	<br>
	
	
	
	
	
	
	<hr>
	<br>
	<br>

<input type="button" onclick="window.open('editar.php?token=<?php echo $_REQUEST['token']; ?>','_top');" value="<?php echo extraevaloridioma('idioma_regresar'); ?>">
		
		

</body>
</html>
