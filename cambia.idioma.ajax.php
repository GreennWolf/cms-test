<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();

if ($_REQUEST['idioma']) {

$_SESSION['idioma'] = $_REQUEST['idioma'];

}
if (!$_SESSION['idioma']) {


$_SESSION['idioma'] = 'es';

}


?>


<script>



/*
document.cookie = "idioma=<?php echo $_SESSION['idioma']; ?>;";
*/


if (window.saveCookieCM21) { /*READY*/}
else {
	function saveCookieCM21(nombre,valor) {
	
		document.cookie = nombre+"=" + valor+ "; expires=Thu, 18 Dec 2999 12:00:00 UTC; path=/";
	
	}
}

saveCookieCM21('c21_idioma','<?php echo $_SESSION['idioma']; ?>');


if (window.parent.document.getElementById('edita_idiomas_log')) {
	window.parent.location.href = '/cm/idiomas.php?edita=<?php echo $_SESSION['idioma']; ?>';

}
else if (window.parent.document.getElementById('guardaCookies')) {
	window.parent.location.href = '/cm/cookies.php?idioma=<?php echo $_SESSION['idioma']; ?>';

}

else {

	
	if (window.parent.document.getElementById('fullidiomas')) {
		window.parent.document.getElementById('fullidiomas').innerHTML = '<img src=/cm/ajax-loader.gif>';
	}
	
	
	window.parent.location.reload();
	window.parent.document.body.innerHTML = '<img src=/cm/ajax-loader.gif>';
	
	

}

</script>