<?php

session_Start();

if ($_REQUEST['idioma']) {

	$_SESSION['idioma'] = $_REQUEST['idioma'];

}

?>
<script>
window.opener.location.href='javascript:c21cm_termina_de_traducir_ext("<?php echo $_SESSION['idioma']; ?>");';
</script>