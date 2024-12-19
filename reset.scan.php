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



	
$dbt = new SQLite3('db/tercerosdb');
    	
$q = "DELETE FROM terceros WHERE token LIKE '".$_REQUEST['token']."' AND manual IS NULL";
			    
$resultado = $dbt->exec($q);



?>

<script>

window.top.document.getElementById('fullProviders').reset();

</script>

<script>

window.top.document.getElementById('consola_informativa').innerHTML = '<?php echo extraevaloridioma('idioma_reset_ok_inico_scanner'); ?>';

</script>

<script>

function iniciaScanner() {

	window.top.location.href = 'scan.php?token=<?php echo $_REQUEST['token']; ?>';

}

setTimeout("iniciaScanner()",3000);

</script>