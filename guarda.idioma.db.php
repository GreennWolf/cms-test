<?php


ini_set('display_errors', FALSE);
session_start();

include_once('funciones.php');



if (!$_SESSION['idioma']) { $_SESSION['idioma'] = 'es'; }


if (!$_SESSION['super']) {

  exit(header('Location: idiomas.php'));
	
}


if ($_REQUEST['valor']) {

	$_REQUEST['valor'] = str_replace("'","’",$_REQUEST['valor']);
	$_REQUEST['valor'] = SQLite3::escapeString($_REQUEST['valor']);

}



if ($_REQUEST['nuevo'] &&  $_REQUEST['idioma_id']) {

	$db = new SQLite3('db/idiomadb');
		    
		    
	$q = "SELECT * FROM idioma WHERE id LIKE '".$_REQUEST['idioma_id']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
			
			
	$idiomadb = false;
	if($resultado = $db->query($q)) {
			
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
							
			$idiomadb[] = $row;
						  
		}
			
	}
	if ($idiomadb[0]) {
	?>
	<script>
	
		alert('Éste ID ya existe');
		//window.parent.location.href= window.parent.location.href;
	
	</script>
	
	<?php
	
		exit();
	
	}
	else {
	
	

		$db = new SQLite3('db/idiomadb');
        
    		$q = "INSERT INTO idioma (id, idioma, tipo, valor) VALUES ('".$_REQUEST['idioma_id']."','".$_REQUEST['idioma']."', '".$_REQUEST['tipo']."', '".$_REQUEST['valor']."' )";
    		$resultado = $db->exec($q);
    		
	?>
	<script>
	
		alert('Cambios guardados correctamente');
		window.parent.location.href = window.parent.location.href;
	
	</script>
	
	<?php
	
	}

}
else if ($_REQUEST['actualiza'] && $_REQUEST['idioma_id']) {


	
	$db = new SQLite3('db/idiomadb');
		    
		    
	$q = "SELECT * FROM idioma WHERE id LIKE '".$_REQUEST['idioma_id']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
			
			
	$idiomadb = false;
	if($resultado = $db->query($q)) {
			
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
							
			$idiomadb[] = $row;
						  
		}
			
	}
	if ($idiomadb[0]) {
	

		$db = new SQLite3('db/idiomadb');
		
			
	   	 $q = "UPDATE idioma SET valor= '".$_REQUEST['valor']."' WHERE id LIKE '".$_REQUEST['idioma_id']."' AND idioma LIKE '".$_REQUEST['idioma']."'";
	    	$db->exec($q);
	    	
	
	}
	else {
	

		$db = new SQLite3('db/idiomadb');
        
    		$q = "INSERT INTO idioma (id, idioma, tipo, valor) VALUES ('".$_REQUEST['idioma_id']."','".$_REQUEST['idioma']."', '".$_REQUEST['tipo']."', '".$_REQUEST['valor']."' )";
    		$resultado = $db->exec($q);
    		
	}
	
	
    	
    	
    	
    	
?>
	<script>
	
		alert('Cambios guardados correctamente');
	
	</script>
	<?php

} else {

?>
	<script>
	
		alert('El ID no puede estar vacío.');
	
	</script>
	<?php


}
?>