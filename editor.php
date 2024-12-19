<?php

session_start();


if (!$_SESSION['idioma']) { $_SESSION['idioma'] = 'es'; }


if (!$_SESSION['super']) {

  exit(header('Location: idiomas.php'));
	
}

?>
<!DOCTYPE html>
<html lang="es">
<head>

<title>Gestor de idiomas - Gestor textarea</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>

	<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="jscripts/tinyFULL.js"></script>
	<script src="jscripts/revisaSource.js"></script>
	
	
	<div id="contenido"> </div>
	
	<input type="button" onclick="guardaycierra();" value="Edición finalizada">
	
	<script>
	
		function guardaycierra() {
		
			source = '<textarea id="info" name="info" width="100%" height="200px" style="width:95%;height:200px;border:2px dotted orange;">'+document.getElementById("info").value+'</textarea>';
			
			
			window.opener.document.getElementById('<? echo $_REQUEST['id']; ?>').innerHTML = source;
			window.close();
			
		}
	
		document.getElementById("contenido").innerHTML = window.opener.document.getElementById('<? echo $_REQUEST['id']; ?>').innerHTML;
	
	
	</script>