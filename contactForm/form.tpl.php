<?php


exit();

?><!--

POWERED BY JL WEBMASTER



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

-->

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>WebMaker: Contact Form - By JL(C)</title>

		<style>
			table, td, tr { margin:3px; padding:5px; }
		</style>
<!--link id="templatebase" rel="stylesheet" type="text/css" media="screen" href="http://static.websimages.com/static/global/css/templatebase.css"> 
<link rel="stylesheet" type="text/css" href="http://static.websimages.com/static/motifs/Air/Red/style.css" 
media="screen"> 
  <link href="/deco1/templates/rhuk_milkyway/favicon.ico" rel="shortcut icon" type="image/x-icon" /> 
  <link rel="stylesheet" 
  href="http://www.tutiendadeanimales.es/deco1/plugins/system/yoo_effects/lightbox/shadowbox.css" 
  type="text/css" /--> 
  
  
<link id="templatebase" rel="stylesheet" type="text/css" media="screen" href="http://static.websimages.com/static/global/css/templatebase.css"> 
<link id="fw_template_file" rel="stylesheet" type="text/css" href="http://admins-aquitodotm.webs.com/.design.css?r=714" media="screen"> 

	</head>

	<body>

		<div id="Formulario">
			<!--br><i style="color:#c0c0c0;">Formulario de Contacto con los Administradores de la Comunidad</i><br-->
			<form action="indexMailerAjax.php" method="POST" target="indexMailerAjax" id="formSend" onsubmit="document.getElementById('bbSubmit').disabled='disabled';">
				<table style="width:100%;">
					<tr>
						<td>Nombre / Entidad: </td><td><input type="text" name="Name" style="width:300px;"></td>
					</tr>
					<tr>
						<td>Telefonos / FAXs: </td><td><input type="text" name="TelFax" style="width:300px;"></td>
					</tr>
					<tr>
						<td>Mail/s: </td><td><input type="text" name="Mail" style="width:300px;"></td>
					</tr>
					<tr>
						<td>Asunto: </td><td><input type="text" name="Subject" style="width:300px;"></td>
					</tr>
					<tr>
						<td>Mensaje: </td><td><textarea name="Message" style="width:88%;height:200px;font-weight:italic;"></textarea></td>
					</tr>
					<tr>
						<td></td><td><input type="submit" value="Enviar >" id="bbSubmit" style="width:45%;" onclick="document.getElementById('bbSubmit').value='Enviando... ';"></td>
					</tr>
				</table>
			</form>
		</div>	
		<script>
			<!--
				/****** Skans - frameAjax by JL // (c) 2007 - 14
				//<a href="../robots.txt">See</a>
				******************************************/
				
				
				var fr01 = 'about:blank';
				var srce = '<iframe id="indexMailerAjax" name="indexMailerAjax" style="display:none;" src="'+fr01+'"></iframe>';
				document.write(srce);
			-->
		</script>
</body>

</html>
