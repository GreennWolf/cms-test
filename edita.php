<?php
session_Start();
 
ini_set('display_errors', FALSE);




if ($_SESSION['super']) { 

	$_SESSION['token'] = $_REQUEST['token'];
}
else if ($_SESSION['token']) { $_REQUEST['token'] = $_SESSION['token']; }
else { exit(header('Location: index.php')); }



		
		
include_once('funciones.php');

		
		
    $db = new SQLite3('db/consentsdb');
		
		
    $q = "UPDATE consents SET CIF= '".$_REQUEST['CIF']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
    
    $q = "UPDATE consents SET color= '".$_REQUEST['color']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET background= '".$_REQUEST['background']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET analytics= '".$_REQUEST['analytics']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET dominio= '".$_REQUEST['dominio']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET mail= '".$_REQUEST['mail']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET gtag= '".$_REQUEST['gtag']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET link= '".$_REQUEST['link']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET script= '".$_REQUEST['script']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET position= '".$_REQUEST['position']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET zoom= '".$_REQUEST['zoom']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET vertical= '".$_REQUEST['vertical']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET contrast= '".$_REQUEST['contrast']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET nombre= '".$_REQUEST['nombre']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET altura= '".$_REQUEST['altura']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET enlace= '".$_REQUEST['enlace']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
    
    $q = "UPDATE consents SET notis= '".$_REQUEST['notis']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
    
    
    
	
	if ($_SESSION['super']) {
	
    $q = "UPDATE consents SET cross= '".$_REQUEST['crossid']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
		
    $q = "UPDATE consents SET hiddenid= '".$_REQUEST['hiddenid']."' WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
    
    	}
    	
    	
    	
    
    
    ?>
    
    <script>
    alert('<?php echo extraevaloridioma('idioma_cambios_guaradados_correctamente'); ?>');
    
    //window.parent.location.href="codigo.php?token=<?php echo $_REQUEST['token']; ?>";
    
    //window.parent.location.reload();
    
    </script>