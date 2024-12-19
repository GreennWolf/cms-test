<?php
session_Start();
 
ini_set('display_errors', FALSE);

if ($_SESSION['super']) { /*ok*/ }
else { exit(header('Location: index.php')); }


		
		
		
		
    $db = new SQLite3('db/consentsdb');
		
	$q = "UPDATE consents SET deshabilitado = '".$_REQUEST['deshabilitado']."' WHERE token LIKE '".$_REQUEST['token']."'";
	$db->exec($q);
    	
    	
    
    
    ?>
    
    <script>
    
    alert('Cambios guardados correctamente.');
    window.parent.location.href=window.parent.location.href;
    
    </script>