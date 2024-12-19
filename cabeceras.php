<?php

session_start();
ini_set('display_errors', FALSE);
if (!$_SESSION['super']) { exit(header('Location: admins.php')); }




$db = new SQLite3('db/idiomasdb');
	    
$q = "UPDATE idiomas SET cabeceras= '".$_REQUEST['cabeceras']."' WHERE idioma LIKE '".$_REQUEST['idioma']."'";

$db->exec($q);



?>

<script>
	alert('Cabeceras actualizadas.')
</script>