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
<iframe src="about:blank;" id="ajax_subprocess" name="ajax_subprocess" style="display:none;"></iframe>

<script>

if (confirm('<?php echo extraevaloridioma('idioma_opcion_resetear_proveedores'); ?>')) {

	document.getElementById('ajax_subprocess').src='reset.scan.php?token=<?php echo $_REQUEST['token']; ?>';

}

</script>











