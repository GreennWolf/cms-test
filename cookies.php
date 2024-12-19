<?php


ini_set('display_errors', FALSE);
session_start();

include_once('funciones.php');



if ($_REQUEST['idioma']) { $_SESSION['idioma'] = $_REQUEST['idioma']; }
if (!$_SESSION['idioma']) { $_SESSION['idioma'] = 'es'; }
if (!$_REQUEST['idioma']) { $_REQUEST['idioma'] = $_SESSION['idioma']; }


if (!$_SESSION['super']) {

  exit(header('Location: idiomas.php'));
	
}

$tag_es = extraevaloridioma('_tag_traduccion','es');
$tag_actual = extraevaloridioma('_tag_traduccion',$_SESSION['idioma']);
$idioma = extraevaloridioma('idioma_idioma',$_SESSION['idioma']);
$nombre = extraevaloridioma('idioma_cookie_nombre',$_SESSION['idioma']);



if ($restaura=false) {



		$db = new SQLite3('db/cookiesdb');
		
			
	   	$q = "UPDATE cookies SET idioma= 'es' WHERE idioma IS NULL";
	    	$db->exec($q);
			
}
?>
<title><?php echo $_SESSION['idioma']; ?> - Cookies DB</title>
<html lang="<?php echo $_SESSION['idioma']; ?>">
<head>

<title>Consent Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>
<?php


include_once('idiomas.banner.php');

?>


<script>

function capitalizeFirstLetter(string) {
return string.charAt(0).toUpperCase() + string.slice(1);
}

</script>


<iframe src="about:blank;" name=guardaCookies id=guardaCookies style=display:none; ></iframe>



<h1>Cookies</h1>







<h2>Nueva cookie para el idioma <?php echo extraevaloridioma('idioma_nombre',$_SESSION['idioma']); ?>:</h2>


<form method="POST" action="guarda.cookies.db.php" target="guardaCookies">

<input type="hidden" name="nuevo" id="nuevo" value="true">

<input type="hidden" name="idioma" id="idioma" value="<?php echo $_SESSION['idioma']; ?>">


<input type="text" name="nombre" id="nombre" value="" PLACEHOLDER="NOMBRE DE LA COOKIE">
<br><br>

<div id="nueva-cookie">
<textarea id="info" name="info"

ondblclick="this.value = capitalizeFirstLetter(this.value);"

 width="100%" height="100px" style="width:95%;height:100px;border:2px dotted orange;" PLACEHOLDER="DESCRIPCIÓN DE LA COOKIE"></textarea>
</div>

<br>
<div style="zoom:0.8;">


<input type="text" name="duracion" id="duracion" placeholder="DURACIÓN">


<input type="text" name="tipo" id="tipo"  placeholder="TIPO">


<input type="text" name="connection" id="connection" placeholder="CONNECTION-TYPE">

<input type="text" name="prioridad" id="prioridad" placeholder="PRIORIDAD">


<input type="text" name="proveedor" id="proveedor"  placeholder="PROVEEDOR">

<input type="text" name="enlace" id="enlace"  placeholder="ENLACE">
</div>

<br>

<input  type="button" value="Habilitar textarea" onclick="window.open('editor.php?id=nueva-cookie','_blank');">


<input  type="submit" value="Grabar">


</form>



<br><hr><br>







<?php
$db = new SQLite3('db/cookiesdb');
	    
	    
$q = "SELECT * FROM cookies WHERE idioma LIKE '".$_SESSION['idioma']."'";
		
		
$cookiesdb = false;

if($resultado = $db->query($q)) {
		
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
		$cookiesdb [] = $row;
					  
	}
		
}


$nx = sizeof($cookiesdb)-1;
while ($cookiesdb[$nx]) {

?>


<span id="<?php echo $cookiesdb[$nx]['nombre']; ?>" name="<?php echo $cookiesdb[$nx]['nombre']; ?>"></span>
<form method="POST" action="guarda.cookies.db.php" target="guardaCookies">

<input type="hidden" name="actualiza" id="actualiza" value="true">

<input type="hidden" name="nombre" id="nombre" value="<?php echo $cookiesdb[$nx]['nombre']; ?>">


<input type="hidden" name="idioma" id="idioma" value="<?php echo $_SESSION['idioma']; ?>">

COOKIE: 
<b><?php echo $cookiesdb[$nx]['nombre']; ?></b>
<br><br>

<div id="<?php echo $nx; ?>">
<textarea id="info" name="info" width="100%" height="100px" PLACEHOLDER="DESCRIPCIÓN DE LA COOKIE" style="width:95%;height:100px;border:2px dotted orange;"><?php echo $cookiesdb[$nx]['info']; ?></textarea>
</div>
<br>


<div style="zoom:0.8;">




<input type="text" name="duracion" id="duracion" PLACEHOLDER="DURACIÓN" value="<?php echo $cookiesdb[$nx]['duracion']; ?>">


<input type="text" name="tipo" id="tipo" PLACEHOLDER="TIPO" value="<?php echo $cookiesdb[$nx]['tipo']; ?>">


<input type="text" name="connection" PLACEHOLDER="CONNECTION-TYPE" id="connection" value="<?php echo $cookiesdb[$nx]['connectionType']; ?>">


<input type="text" name="prioridad" PLACEHOLDER="PRIORIDAD" id="prioridad" value="<?php echo $cookiesdb[$nx]['prioridad']; ?>">



<input type="text" name="proveedor" PLACEHOLDER="PROVEEDOR" id="proveedor" value="<?php echo $cookiesdb[$nx]['proveedor']; ?>">


<input type="text" name="enlace"  PLACEHOLDER="ENLACE" id="enlace" value="<?php echo $cookiesdb[$nx]['enlace']; ?>">
</div>

<BR>
<input  type="button" value="Habilitar textarea" onclick="window.open('editor.php?id=<?php echo $nx; ?>','_blank');">
<input  type="submit" value="Grabar">


<?php if ($_SESSION['idioma'] != 'es') { ?>

<input  type="button" value="Ver version ES" onclick="window.open('cookies.php?idioma=es#<?php echo $cookiesdb[$nx]['nombre']; ?>','es');">

<input  type="button" value="Traducir del ES" onclick="window.open('https://translate.google.com/?sl=<?php echo $tag_es; ?>&tl=<?php echo $tag_actual; ?>&op=translate&text=<?php echo urlencode(extraeinfocookie($cookiesdb[$nx]['nombre'],'es')); ?>','trad');">

<?php } ?>


</form>


<br><hr><br>


<?php

	$nx--;
}

?>









