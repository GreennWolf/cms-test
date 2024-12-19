<?php

session_start();
ini_set('display_errors', FALSE);
if (!$_SESSION['super']) { exit(header('Location: admins.php')); }

?>


<form method="POST" action="cabeceras.php?idioma=<?php echo $_REQUEST['edita']; ?>" target="guardaIdiomas">

<h4>Cabeceras</h4>
<h5>Separe por comas, las cabeceras de los distintos idiomas que heredaran en éste</h5>

<input id="cabeceras" name="cabeceras" type="text" style="border:2px dotted orange;"
 value="<?php echo $fetchx[0]['cabeceras']; ?>" >
<br>
<input  type="submit" value="Guardar">

<input  type="button" value="Sumar cabecera actual" onclick="document.getElementById('cabeceras').value += ','+window.navigator.language+',';"  >

</form>

<br><br><br><br><br>





