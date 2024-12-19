<?php

ini_set('display_errors', FALSE);
session_start();

	if ($_SESSION['super'] && !$_REQUEST['token'] && !$_SESSION['token'])  { $_REQUEST['token'] = 'demo'; }
	if ($_SESSION['token'] && !$_REQUEST['token']) { $_REQUEST['token'] = $_SESSION['token']; }
	
	if (!$_REQUEST['token']) { $_REQUEST['token'] = 'demo'; }
	
	
	if ($_SESSION['super'] || $_SESSION['token']) { /*ok*/ }
	else { exit(header('Location: index.php')); }
	
	include_once('funciones.php');
	
	
?>
<title><?php echo extraevaloridioma('idioma_titulo'); ?></title>
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">


<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  
<?php include_once('idiomas.banner.php'); ?>


<!--
<?php echo htmlspecialchars(extraevaloridioma('idioma_codigo_head')); ?>
<br><br>
<textarea style="width:85%;height:10%;">

<?php echo htmlspecialchars('<script'); ?> src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/head/?token=<?php echo $_REQUEST['token']; ?>"><?php echo htmlspecialchars('</script>'); ?>

</textarea>
<br>
<br>

<?php echo htmlspecialchars(extraevaloridioma('idioma_codigo_body')); ?>
<br><br>
<textarea style="width:85%;height:10%;">

<?php echo htmlspecialchars('<script'); ?>  src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/body?token=<?php echo $_REQUEST['token']; ?>"><?php echo htmlspecialchars('</script>'); ?>

<?php /* echo htmlspecialchars('<noscript><iframe'); ?> src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/iframe.php" height="0" width="0" style="display:none;visibility:hidden"><?php echo htmlspecialchars('</iframe></noscript>'); */ ?>

</textarea>
<br>
<br>
<br>
<br>
-->

<?php echo htmlspecialchars(extraevaloridioma('idioma_codigo_sum')); ?>
<br><br>
<textarea style="width:85%;height:10%;">
	
<?php echo htmlspecialchars('<script'); ?>  id="jsb_c21" src="//cmp.cookie21.com/banner/?token=<?php echo $_REQUEST['token']; ?>"><?php echo htmlspecialchars('</script>'); ?>

</textarea>
<br>
<br>
<br>
<br>

<?php echo htmlspecialchars(extraevaloridioma('idioma_codigo_gestor')); ?>
<br><br>
<textarea style="width:85%;height:10%;">

<?php echo htmlspecialchars('<script'); ?>  src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/gestor/?token=<?php echo $_REQUEST['token']; ?>"><?php echo htmlspecialchars('</script>'); ?>

</textarea>
<br>
<br>
<br>
<br>
	
	<input type="button" onclick="window.open('example.php?token=<?php echo $_REQUEST['token']; ?>','ejemplo');" value="<?php echo extraevaloridioma('idioma_ejemplo_banner'); ?>" >
	
	<input type="button" onclick="window.open('gestor.example.php?token=<?php echo $_REQUEST['token']; ?>','ejemplo-gestor');" value="<?php echo extraevaloridioma('idioma_ejemplo_gestor'); ?>" >
	
	<input type="button" onclick="window.open('mix.example.php?token=<?php echo $_REQUEST['token']; ?>','ejemplo-mixto');" value="<?php echo extraevaloridioma('idioma_ejemplo_mixto'); ?>" >
	
	
	<input type="button" onclick="window.open('editar.php?token=<?php echo $_REQUEST['token']; ?>','_top');" value="<?php echo extraevaloridioma('idioma_editar'); ?>" >
	
 
 <?php 
 
 
 ?>




