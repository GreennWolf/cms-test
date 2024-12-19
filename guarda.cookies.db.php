<?php


ini_set('display_errors', FALSE);
session_start();

include_once('funciones.php');


if (!$_SESSION['super']) {

  exit(header('Location: idiomas.php'));
	
}

if ($_REQUEST['info']) {

	$_REQUEST['info'] = str_replace("'","’",$_REQUEST['info']);
	$_REQUEST['info'] = SQLite3::escapeString($_REQUEST['info']);

}
if ($_REQUEST['proveedor']) {

	$_REQUEST['proveedor'] = str_replace("'","’",$_REQUEST['proveedor']);
	$_REQUEST['proveedor'] = SQLite3::escapeString($_REQUEST['proveedor']);

}
if ($_REQUEST['duracion']) {

	$_REQUEST['duracion'] = str_replace("'","’",$_REQUEST['duracion']);
	$_REQUEST['duracion'] = SQLite3::escapeString($_REQUEST['duracion']);

}



if ($_REQUEST['nuevo'] &&  $_REQUEST['nombre'] &&  $_REQUEST['idioma']) {

	$db = new SQLite3('db/cookiesdb');
		    
		    
	$q = "SELECT * FROM cookies WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
			
			
	$cookiesdb = false;
	if($resultado = $db->query($q)) {
			
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
							
			$cookiesdb[] = $row;
						  
		}
			
	}
	if ($cookiesdb[0]) {
	?>
	<script>
	
		alert('Ésta COOKIE ya existe para este idioma');
		//window.parent.location.href = 'cookies.php?idioma=<?php echo $_REQUEST['idioma']; ?>#<?php echo $_REQUEST['nombre']; ?>';
	
	</script>
	
	<?php
	
		exit();
	
	}
	else {
	
			$db = new SQLite3('db/cookiesdb');
			   
			
	    		$q = "INSERT INTO cookies (nombre, idioma, tipo, info, duracion, proveedor, enlace, prioridad, connectionType) VALUES ('".$_REQUEST['nombre']."','".$_REQUEST['idioma']."', '".$_REQUEST['tipo']."', '".$_REQUEST['info']."', '".$_REQUEST['duracion']."', '".$_REQUEST['proveedor']."', '".$_REQUEST['enlace']."', '".$_REQUEST['prioridad']."', '".$_REQUEST['connection']."' )";
	    		$resultado = $db->exec($q);
    		
    		
    		
	?>
	<script>
	
		alert('Cambios guardados correctamente');
		window.parent.location.href = window.parent.location.href;
	
	</script>
	
	<?php
	
	}

}
else if ($_REQUEST['actualiza'] && $_REQUEST['nombre'] && $_REQUEST['idioma']) {


	
	$db = new SQLite3('db/cookiesdb');
	
	$q = "SELECT * FROM cookies WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
			
			
	$cookiesdb = false;
	if($resultado = $db->query($q)) {
			
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
							
			$cookiesdb[] = $row;
						  
		}
			
	}
	if ($cookiesdb[0]) {
	

		$db = new SQLite3('db/cookiesdb');
		
			
	   	$q = "UPDATE cookies SET info= '".$_REQUEST['info']."' WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
	    	$db->exec($q);
			
	   	$q = "UPDATE cookies SET proveedor= '".$_REQUEST['proveedor']."' WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
	    	$db->exec($q);
	   	$q = "UPDATE cookies SET tipo= '".$_REQUEST['tipo']."' WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
	    	$db->exec($q);
	   	$q = "UPDATE cookies SET enlace= '".$_REQUEST['enlace']."' WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
	    	$db->exec($q);
	   	$q = "UPDATE cookies SET duracion= '".$_REQUEST['duracion']."' WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
	    	$db->exec($q);
	    	
	   	$q = "UPDATE cookies SET prioridad= '".$_REQUEST['prioridad']."' WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
	    	$db->exec($q);
	    	
	   	$q = "UPDATE cookies SET connectionType= '".$_REQUEST['connection']."' WHERE nombre LIKE '".$_REQUEST['nombre']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
	    	$db->exec($q);
	    	
	
	}
    	
    	
?>
	<script>
	
		alert('Cambios guardados correctamente');
	
	</script>
	<?php

} else {

?>
	<script>
	
		alert('El NOMBRE no puede estar vacío.');
	
	</script>
	<?php


}
?>


