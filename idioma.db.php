<?php


ini_set('display_errors', FALSE);
session_start();

include_once('funciones.php');



if (!$_SESSION['idioma']) { $_SESSION['idioma'] = 'es'; }


if (!$_SESSION['super']) {

  exit(header('Location: idiomas.php'));
	
}

$tag_es = extraevaloridioma('_tag_traduccion','es');
$tag_actual = extraevaloridioma('_tag_traduccion',$_REQUEST['edita']);

$db = new SQLite3('db/idiomadb');
	    
	    
$q = "SELECT * FROM idioma";
		
		
$idiomadb = false;

if($resultado = $db->query($q)) {
		
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
		$idiomadb[] = $row;
					  
	}
		
}


$nx = 0;
while ($idiomadb[$nx]) {


	if (!$cargado[$idiomadb[$nx]['id']]) {
?>



<form method="POST" action="guarda.idioma.db.php" target="guardaIdiomas">

<input type="hidden" name="idioma" id="idioma" value="<?php echo $_SESSION['idioma']; ?>">

<input type="hidden" name="actualiza" id="actualiza" value="true">

<input type="hidden" name="idioma_id" id="idioma_id" value="<?php echo $idiomadb[$nx]['id']; ?>">


<h5>ID</h5>
<b><?php echo $idiomadb[$nx]['id']; ?></b>
<br><br>


<h5>VALOR</h5>
<div id="<?php echo $nx; ?>">
<textarea id="valor" name="valor" width="100%" height="200px" style="width:95%;height:200px;border:2px dotted orange;"><?php echo htmlspecialchars(extraevaloridioma($idiomadb[$nx]['id'])); ?></textarea>
</div>
<br>
<input  type="submit" value="Grabar">

<input  type="button" value="Habilitar textarea" onclick="window.open('textarea.php?id=<?php echo $nx; ?>','_blank');">


<?php if ($_REQUEST['edita'] != 'es') { ?>

<input  type="button" value="Ver version ES" onclick="window.open('idiomas.php?edita=es#<?php echo $nx; ?>','es');">

<input  type="button" value="Traducir del ES" onclick="window.open('https://translate.google.com/?sl=<?php echo $tag_es; ?>&tl=<?php echo $tag_actual; ?>&op=translate&text=<?php echo urlencode(extraevaloridioma($idiomadb[$nx]['id'],'es')); ?>','trad');">


<?php } ?>


</form>


<br><br><br><br><br>


<?php
		$cargado[$idiomadb[$nx]['id']] = true;
	}
	$nx++;
}

?>

















<form method="POST" action="guarda.idioma.db.php" target="guardaIdiomas">

<input type="hidden" name="idioma" id="idioma" value="<?php echo $_SESSION['idioma']; ?>">

<input type="hidden" name="nuevo" id="nuevo" value="true">

<h4>Nuevo valor para <?php echo strtoupper($_SESSION['idioma']); ?></h4>


<h5>ID</h5>
<input type="text" id="idioma_id" name="idioma_id" type="text" height="70%" style="border:2px dotted orange;" value="" >
<br><br>



<h5>VALOR</h5>
<div id="nuevo-valor">
<textarea id="valor" name="valor" width="100%" height="200px" style="width:95%;height:200px;border:2px dotted orange;"></textarea>
</div>
<br>
<input  type="submit" value="Grabar">

<input  type="button" value="Habilitar textarea" onclick="window.open('textarea.php?id=nuevo-valor','_blank');">

</form>


<br><br><br><br><br>

