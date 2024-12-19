<html lang="<?php echo $_SESSION['idioma']; ?>">
<head>
<title>Banner personalizado - COOKIE21 - CMP</title>


  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
	
	<script  id="jsb_c21" src="//cmp.cookie21.com/banner/?token=ejemplo-pers"></script>
	
<h1>Cookie21 CMP</h1>
<p>
	<h1>Ejemplo de banner personalizado</h1>
	
</p>
<p>
	Cargaremos el código personalizado 
	<a href="https://cookie21.com/cm/gracias.js" target="_blank">https://cookie21.com/cm/gracias.js</a> 
	al aceptar todas las cookies
	
</p>


<br><br><br>
	<hr>
<p>
	<a onclick="document.body.innerHTML='Recargando...';eliminarCookies();" href="?<?php echo time(); ?>">Eliminar cookies y recargar página para testear de nuevo.</a> 
	
</p>


<br><br><br>

</body>
</html>


