<?php


ini_set('display_errors', FALSE);
session_start();




if (!$_SESSION['idioma']) { $_SESSION['idioma'] = 'es'; }






if (!$_SESSION['super']) {

  exit(header('Location: idiomas.php'));
	
}





if ($_REQUEST['idioma_logo']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_logo.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_logo']);
			@fclose($gestor);
  }

}


if ($_REQUEST['idioma_boton_actualizar_idioma']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_boton_actualizar_idioma.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_boton_actualizar_idioma']);
			@fclose($gestor);
  }

}

if ($_REQUEST['idioma_cambios_ok']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_cambios_ok.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_cambios_ok']);
			@fclose($gestor);
  }

}

if ($_REQUEST['idioma_nombre']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_nombre.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_nombre']);
			@fclose($gestor);
  }

}

if ($_REQUEST['idioma_info_cookies_gestor']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_info_cookies_gestor.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_info_cookies_gestor']);
			@fclose($gestor);
  }

}

if ($_REQUEST['idioma_Eliminar']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_Eliminar.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_Eliminar']);
			@fclose($gestor);
  }

}


if ($_REQUEST['idioma_Eliminar_todas']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_Eliminar_todas.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_Eliminar_todas']);
			@fclose($gestor);
  }

}

if ($_REQUEST['idioma_Actualizar']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_Actualizar.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_Actualizar']);
			@fclose($gestor);
  }

}


if ($_REQUEST['idioma_Valor']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_Valor.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_Valor']);
			@fclose($gestor);
  }

}


if ($_REQUEST['idioma_Regresar']) {


  if ($gestor	=	fopen($filename='idiomas/'.$_SESSION['idioma'].'/idioma_Regresar.txt', "w")) {
			@fwrite($gestor,$_REQUEST['idioma_Regresar']);
			@fclose($gestor);
  }

}







?>

<script>

alert('<?php @include('idiomas/'.$_SESSION['idioma'].'/idioma_cambios_ok.txt'); ?>');

</script>