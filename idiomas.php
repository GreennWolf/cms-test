<?php

session_start();
ini_set('display_errors', 0);

if (!$_SESSION['super']) { exit(header('Location: admins.php')); }


if ($_REQUEST['edita'])  { $_SESSION['idioma'] = $_REQUEST['edita']; }

if ($_REQUEST['admin'])  { $_SESSION['idioma'] = $_REQUEST['admin']; }

if (!$_SESSION['idioma'])  { $_SESSION['idioma'] = 'es'; }



include_once('funciones.php');



	if ($_REQUEST['eliminar']) {
	
		if ($_REQUEST['idioma'] == 'es') {
		
		
   	 ?>
   	 <script>
   	 
   	 alert('Éste idioma esta protegido ante eliminaciones, contacte con su técnico.');
   	 
   	 window.parent.location.href = '/cm/idiomas.php?admin=<?php echo $_REQUEST['idioma']; ?>';
   	 
   	 </script>
   	 
   	 <?php
		exit();
		
		}
        
	    $db = new SQLite3('db/idiomasdb');
	    
	    
	    
	  	  $q = "DELETE FROM idiomas WHERE idioma LIKE '".$_REQUEST['idioma']."'";
	  	  
	   	 $db->exec($q);
   	 
   	 ?>
   	 <script>
   	 
   	 window.parent.location.href = '/cm/idiomas.php';
   	 
   	 </script>
   	 
   	 <?php
		
	
		exit();
	}

	else if ($_REQUEST['des-habilitar']) {
	
		if ($_REQUEST['idioma'] == 'es') {
		
		
   	 ?>
   	 <script>
   	 
   	 alert('Éste idioma esta protegido ante deshabilitaciones, contacte con su técnico.');
   	 
   	 window.parent.location.href = '/cm/idiomas.php?admin=<?php echo $_REQUEST['idioma']; ?>';
   	 
   	 </script>
   	 
   	 <?php
		exit();
		
		}
        
	    $db = new SQLite3('db/idiomasdb');
	    
	    
	    
  	  $q = "UPDATE idiomas SET estado= '".$_REQUEST['estadoNuevo']."' WHERE idioma LIKE '".$_REQUEST['idioma']."'";
   	 $db->exec($q);
   	 
   	 ?>
   	 <script>
   	 
   	 window.parent.location.href = '/cm/idiomas.php?admin=<?php echo $_REQUEST['idioma']; ?>';
   	 
   	 </script>
   	 
   	 <?php
		
	
		exit();
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>

<title>Gestor de idiomas - Cookie21 Consent Manager Solutions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>

<?php include_once('idiomas.banner.php'); ?>

<?php

echo extraevaloridioma('idioma_logo');

?>

<h2 style="text-decoration:underline;">Gestión de idiomas</h2>
	
<?php

	if ($_REQUEST['admin']) {
        
	    $db = new SQLite3('db/idiomasdb');
	    
	    
		$q = "SELECT * FROM idiomas WHERE idioma LIKE '".$_REQUEST['admin']."' ";
		
		
		
		if($resultado = $db->query($q)) {
		
			while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
				$fetchx[] = $row;
					  
			}
		
		}
		
		if (!$fetchx) {
		
		
		echo '<br><br><h3 style="color:red;">Idioma erroneo...</3><br><br>';
		?>
		<script>
		
		window.location.href= 'idiomas.php';
		
		</script>
		
		<?php
		exit();
		
		} 
	
		echo '<br><h3 style="color:;">ID de IDIOMA: '.$fetchx[0]['idioma'].'</3><br>';
		?>
		<input type="button" onclick="window.open('idiomas.php?edita=<?php echo $fetchx[0]['idioma']; ?>','_top');" value="Editar" >
	<?php
		if ($fetchx[0]['estado'] == 'on') { $color = 'green'; $reverso ='orange'; $opcion = 'Deshabilitar'; $nuevo = 'off'; }
		else if ($fetchx[0]['estado'] == 'off') { $color = 'orange'; $reverso = 'green'; $opcion = 'Habilitar'; $nuevo = 'on'; }
	
		echo '<br><h3 style="color:'.$color .';">ESTADO del IDIOMA: '.$fetchx[0]['estado'].'</3><br>';
		
	
	?>
	
		<?php if($_REQUEST['admin'] != 'es') { ?>
		
		
		<iframe src="about:blank;" id="des-habilitar" name="des-habilitar" style="display:none;"></iframe>
		
		<input type="button" style="background-color:<?php echo $reverso; ?>;color:white;font-weight:bold;" 
		onclick="this.value='Cargando...'; this.disabled='disabled';window.open('idiomas.php?des-habilitar=true&idioma=<?php echo $fetchx[0]['idioma']; ?>&estadoNuevo=<?php echo $nuevo; ?>','des-habilitar');" value="<?php echo $opcion; ?>" >
		
		
		<br>
		<iframe src="about:blank;" id="eliminar" name="eliminar" style="display:none;"></iframe>
		
		<input type="button" style="background-color:red;color:white;font-weight:bold;" 
		onclick="if(confirm('Va a eliminar un idioma. Esta acccion es irrevocable.')) { if (confirm('Seguro?')) { this.value='Eliminando...'; this.disabled='disabled';window.open('idiomas.php?eliminar=true&idioma=<?php echo $fetchx[0]['idioma']; ?>&','eliminar');}}" value="Eliminar" >
		
		
		<?php } ?>
		
		
		<?php
	
	
	?>
	<br>
	
	<hr>
	
	<br>
	
	
	
	
	<input type="button" onclick="window.open('idiomas.php','_top');" value="Regresar" >
	
	
	</body>
	</html>
	<?php
	
		exit();
	}
	else if ($_REQUEST['edita']) {
	
	
	    $db = new SQLite3('db/idiomasdb');
	    
	    
		$q = "SELECT * FROM idiomas WHERE idioma LIKE '".$_REQUEST['edita']."' ";
		
		
		
		if($resultado = $db->query($q)) {
		
			while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
				$fetchx[] = $row;
					  
			}
		
		}
	
	
	?>
	<!--
	<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="jscripts/tinyFULL.js"></script>
	<script src="jscripts/revisaSource.js"></script>
	-->
	
	<h2 style="color:green;" id="edita_idiomas_log">EDITANDO IDIOMA</h2>
	
	
	<h1 style="color:;" id=""><?php echo strtoupper($_REQUEST['edita']); ?></h1>
	
	<hr>
	
	<iframe src="about:blank;" style="display:none;"  id="guardaIdiomas" name="guardaIdiomas"></iframe>
	
	




<?php include_once('lista.idiomas.php'); ?>

<?php include_once('idioma.db.php'); ?>












	
	
	
	<br>
	
	<br>
	<br>
	<hr>
	
	<br>
	
	
	
	<input type="button" onclick="window.open('cookies.php?idioma=<?php echo $_REQUEST['edita']; ?>','_blank');" value="Gestor de cookies" >
	
	
	<input type="button" onclick="window.open('idiomas.php','_top');" value="Regresar" >
	
	
	</body>
	</html>
	
	<?php
		exit();
	
	}
	else if ($_REQUEST['add']) {
	
	
	?>
	<h2 style="color:green;" id="idiomas_log"></h2>
	
	
	<iframe src="about:blank;" style="display:none;"  id="add_idioma_ajax" name="add_idioma_ajax"></iframe>
	
	<form action="add.idioma.ajax.php" target="add_idioma_ajax" method="_POST">
	
	
	<b>IDIOMA ID</b>: <input type="text"  id="id_idioma" name="id_idioma" >
	<br>
	Los idiomas se añaden con el estado <b>deshabilitado</b> y los puede habilitar una vez completos.
	
	
	<input type="submit" value="Añadir idioma" id="idioma_add_idioma" >
	</form>
	
	
	<br>
	
	<hr>
	
	<br>
	
	<?php
	
	
	
	
	}
	
	
	
	
	
	
	
	
	
        
    $db = new SQLite3('db/idiomasdb');
    
    
	$q = "SELECT * FROM idiomas";
	
	
	
	if($resultado = $db->query($q)) {
	
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
					
			$fetch[] = $row;
				  
		}
	
	}
	
	if (!$fetch) {
	
	
	echo '<br><br><h3 style="color:red;">Sin idiomas</3><br><br>';
	
	
	} else {
	
		$i=0;
		while ($fetch[$i]) {
		
			if(!$showed[$fetch[$i]['idioma']])  {
	
				if ($fetch[$i]['estado'] == 'off') {
				
					$color = 'red';
				
				
				} else {
				
					$color = 'green';
				
				
				}
			
				echo '<br><a href="?admin='.$fetch[$i]['idioma'].'" name="'.$fetch[$i]['idioma'].'" id="'.$fetch[$i]['idioma'].'"><h3 style="color:'.$color.';">IDIOMA: '.strtoupper($fetch[$i]['idioma']).'</h3></a><br>';
				
				$showed[$fetch[$i]['idioma']] = true;
			}
					
			 $i++;
				  
		}
	
	
	}
	
	
	?>
	
	<br>
	
	<hr>
	
	<br>
	
	
	
	<input type="button" onclick="window.open('idiomas.php?add=true','_top');" value="Añadir idioma" >
	
	<br>
	
	<hr>
	
	<br>
	
	
	
	
	<input type="button" onclick="window.open('admins.php','_top');" value="Regresar" >
	
	
	</body>
	</html>