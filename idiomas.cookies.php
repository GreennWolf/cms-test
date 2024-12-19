<?php

session_start();
ini_set('display_errors', FALSE);
if (!$_SESSION['super']) { exit(header('Location: admins.php')); }

?>



<form method="POST" action="guarda.idiomas.cookies.php" target="guardaIdiomas">

<h4>Cookie LOCAL</h4>

<input id="idioma_cookie_local" name="idioma_cookie_local" type="text" style="border:2px dotted orange;"
 value="<?php @include('idiomas/'.$_SESSION['idioma'].'/idioma_cookie_local.txt'); ?>" >
<br>
<input  type="submit" value="<?php @include('idiomas/'.$_SESSION['idioma'].'/idioma_boton_actualizar_idioma.txt'); ?>">

</form>

<br><br><br><br><br>
