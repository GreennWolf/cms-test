<?php
session_start();
 
ini_set('display_errors', FALSE);



if ($_SESSION['super']) { 

	$_SESSION['token'] = $_REQUEST['token'];
	//echo 'Logged'.$_SESSION['token'];
}
else if ($_SESSION['token']) { $_REQUEST['token'] = $_SESSION['token']; }
else { exit(header('Location: index.php')); }



if ($_REQUEST['elimina']) {

	unlink('logos/'.sha1($_REQUEST['token']).'.png');

?>
<script>
	window.parent.location.href="adm-logo.php?token=<?php echo $_REQUEST['token']; ?>";
</script>
<?php
	exit();

}
else if ($_FILES["file"]["tmp_name"]) {

	echo 'Analizando archivo '.$_FILES["file"]["tmp_name"].' . . . <br><br>';


	unlink('logos/'.sha1($_REQUEST['token']).'.png');

    move_uploaded_file($_FILES["file"]["tmp_name"],$originalFile='logos/'.sha1($_REQUEST['token']).'.png');
	
	
	/*
	function png2jpg($originalFile, $outputFile, $quality) {
		$image = imagecreatefrompng($originalFile);
		imagejpeg($image, $outputFile, $quality);
		imagedestroy($image);
	}

	@png2jpg($originalFile,$outputFile=$originalFile , $quality=100);
	*/


?>
<script>
	window.parent.location.href="adm-logo.php?token=<?php echo $_REQUEST['token']; ?>";
</script>
<?php
	exit();
}












?>


<!DOCTYPE html>
<html lang="es">
<head>

<?php include_once('idiomas.banner.php'); ?>
<title><?php echo extraevaloridioma('idioma_editar'); ?> LOGO - <?php echo extraevaloridioma('idioma_titulo'); ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>




<iframe src="about:blank;" style="display:none;" id="editaLogo" name="editaLogo"></iframe>



<?php if (@file_exists('logos/'.sha1($_REQUEST['token']).'.png')) { ?>


<div id="jpg"><img src="logos/<?php echo sha1($_REQUEST['token']); ?>.png?<?php echo time();?>">


</div>


<br><br>
	<input type="button" 
	onclick="window.open('adm-logo.php?elimina=si&token=<?php echo $_REQUEST['token']; ?>','editaLogo');"
	 value="<?php echo extraevaloridioma('idioma_eliminar'); ?> logo" >
	 
	 


<?php } else { ?>

	

 
<form  enctype="multipart/form-data" id=formLogo name=formLogo action="adm-logo.php" target="editaLogo" method=POST>




	<input type="hidden" name="token" id="token" value="<?php echo $_REQUEST['token']; ?>">

	<input type="file" id="file" name="file">
	
	
	<input type="submit" name="<?php echo extraevaloridioma('idioma_enviar'); ?>">



</form>


<?php } ?>





<br><br>


	<input type="button" onclick="window.open('editar.php?token=<?php echo $_REQUEST['token']; ?>','_top');" value="<?php echo extraevaloridioma('idioma_regresar'); ?>" >
	
	<input type="button" onclick="window.open('index.php','_top');" value="<?php echo extraevaloridioma('idioma_regresar_inicio'); ?>" >
	
		
</body>
</html>