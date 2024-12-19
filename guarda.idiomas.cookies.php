<?php


ini_set('display_errors', FALSE);
session_start();




if (!$_SESSION['idioma']) { $_SESSION['idioma'] = 'es'; }






if (!$_SESSION['super']) {

  exit(header('Location: idiomas.php'));
	
}





if ($_REQUEST['idioma_cookie_local']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_cookie_local.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_cookie_local']);
			@fclose($gestor);
  }

}



?>

<script>

alert('<?php @include('idiomas/'.$_SESSION['idioma'].'/idioma_cambios_ok.txt'); ?>');

</script>