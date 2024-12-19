<?php

session_start();
ini_set('display_errors', FALSE);

include_once('funciones.php');

if (!$_SESSION['super']) { exit(); }


	if (!$_REQUEST['token']) {
	
		
		
		?>
		
		<script>alert('El token es obligatorio.');</script>
		
		<?php 
		
		
		exit();
		
	}

	
    $db= new SQLite3('db/consentsdb');
        
	$q = "SELECT token FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
	//$q = "SELECT * FROM clients";
	
	
	
	$resultado = $db->query($q);
	
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
		$fetch = $row;
			  
	}
	
	if ($fetch['token']) {
		
		
		?>
		
		<script>alert('Este token ya existe.');</script>
		
		<?php 
		
		
		exit();
		
	}
	
	
	
	
    $db= new SQLite3('db/consentsdb');
        
    $q = "INSERT INTO consents (token, nombre, CIF, dominio, mail, clave, analytics, ctime, gtag, color, background, link, script, position, zoom, vertical, contrast, altura, enlace, hiddenid, cross, notis) VALUES ('".$_REQUEST['token']."','".$_REQUEST['nombre']."', '".$_REQUEST['CIF']."', '".$_REQUEST['dominio']."', '".$_REQUEST['mail']."', '".$_REQUEST['clave']."', '".$_REQUEST['analytics']."', '".time()."', '".$_REQUEST['gtag']."', '".$_REQUEST['color']."', '".$_REQUEST['background']."', '".$_REQUEST['link']."' , '".$_REQUEST['script']."' , '".$_REQUEST['position']."' , '".$_REQUEST['zoom']."'  , '".$_REQUEST['vertical']."' , '".$_REQUEST['contrast']."' , '".$_REQUEST['altura']."' , '".$_REQUEST['enlace']."' , '".$_REQUEST['hiddenid']."' , '".$_REQUEST['crossid']."' , '".$_REQUEST['notis']."' )";
    $resultado = $db->exec($q);
	
	
	
		
?>


<script>

function registroCompletado() {
	alert('Registro completado');
	window.parent.location.href="detalles.php?token=<?php echo $_REQUEST['token']; ?>";
}
</script>
<?php



	$_SESSION['smtp']['mail'] = $_REQUEST['mail'];
	
	
	$message  = extraevaloridioma('_correo_bienvenida',$_SESSION['idioma']);
	
	$message  = str_replace('{token}',$_REQUEST['token'],$message);
	$message  = str_replace('{clave}',$_REQUEST['clave'],$message);
	$message  = str_replace('{empresa}',$_REQUEST['nombre'],$message);
	
	$_SESSION['smtp']['Message'] = iconv('UTF-8', 'windows-1252',$message);
	
	
	$_SESSION['smtp']['Subject'] = 'Registro exitoso en Cookie21';


?>

<iframe src="contactForm/indexMailerAjax.php" style="display:none;" onload="registroCompletado()"></iframe>


	
	
	
	
	
	
	
	
	
	
	
	
	
