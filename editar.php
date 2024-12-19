<?php
session_start();
 
ini_set('display_errors', FALSE);



if ($_SESSION['super']) { 

	$_SESSION['token'] = $_REQUEST['token'];
	//echo 'Logged'.$_SESSION['token'];
}
else if ($_SESSION['token']) { $_REQUEST['token'] = $_SESSION['token']; }
else { exit(header('Location: index.php')); }

include_once('funciones.php');




    $db= new SQLite3('db/consentsdb');
        
	$q = "SELECT * FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
	//$q = "SELECT * FROM clients";
	
	
	
	$resultado = $db->query($q);
	
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
		$fetch = $row;
			  
	}
	
	
	if ($fetch['gtag']) {
		
		
  		$_REQUEST['GTM'] = $fetch['gtag'];
  		
		
	}
	
	if ($fetch['analytics']) {
		
		
  		$_REQUEST['analytics'] = $fetch['analytics'];
  		
		
	}


?>

<!DOCTYPE html>
<html lang="es">
<head>

<?php include_once('idiomas.banner.php'); ?>
<title><?php echo extraevaloridioma('idioma_editar'); ?> - <?php echo extraevaloridioma('idioma_titulo'); ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>

<?php


if ($_SESSION['super']) include_once('userstatus.php'); 



















if ($_SESSION['super'] || $_SESSION['token']) {
	?>
	
	<h1><?php echo extraevaloridioma('idioma_editar_registro'); ?></h1>
	
	<h2>Token: <u><?php echo $_REQUEST['token']; ?></u></h2>
	
	<iframe src="about:blank;" style="display:none;" id="edita" name="edita"></iframe>
	
	
	
	

	<form  enctype="multipart/form-data"  action="edita.php" target="edita" method=POST>
	<input type="hidden" name="token" id="token" value="<?php echo $_REQUEST['token']; ?>">
	<table cellpadding="4">
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_nombre_empresa'); ?>:</td>
		<td><input type="text" id="nombre" name="nombre" value="<?php echo $fetch['nombre']; ?>"></td>
		</tr>
		<tr>
		<td>LOGO:</td>
		<td style="height:160px;v-align:middle; vertical-align:middle;">
		
		
<?php if (@file_exists('logos/'.sha1($_REQUEST['token']).'.png')) { ?>


<img src="logos/<?php echo sha1($_REQUEST['token']); ?>.png?<?php echo time();?>" style="cursor:pointer;width:150px;margin-right:10px;"

		onclick="window.location.href='adm-logo.php?token=<?php echo $_REQUEST['token']; ?>';"
		

><br>

<?php } ?>
		
		
		<input type="button" value="Admin Logo" style="cursor:pointer;"
		
		onclick="window.location.href='adm-logo.php?token=<?php echo $_REQUEST['token']; ?>';"
		
		>
		

		
		</td>
		</tr>
		<tr>
		<td>NIF/CIF:</td>
		<td><input type="text" id="CIF" name="CIF" value="<?php echo $fetch['CIF']; ?>"></td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_dominio'); ?>:</td>
		<td><input type="text" id="dominio" name="dominio" value="<?php echo $fetch['dominio']; ?>"> 
		<span style="font-size:0.8em;"><?php echo extraevaloridioma('idioma_info_dominio'); ?></span></td>
		</tr>
	
		
		<tr>
		<td><?php echo extraevaloridioma('idioma_enlace_principal'); ?>:</td>
		<td><input type="text" id="enlace" name="enlace" value="<?php echo $fetch['enlace']; ?>">
		 <span style="font-size:0.8em;"><?php echo extraevaloridioma('idioma_enlace_principal_info'); ?></span>
		 
		
		<input type="button" onclick="window.open('selector.php?token=<?php echo $_REQUEST['token']; ?>','_top');" value="<?php echo extraevaloridioma('idioma_selector_de_proveedores'); ?>">
		
		
		 
		 </td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_correo_electronico'); ?>:</td>
		<td><input type="text" id="mail" name="mail" value="<?php echo $fetch['mail']; ?>"></td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_clave'); ?>:</td>
		<td><input type="password" id="clave" name="clave" value="<?php echo $fetch['clave']; ?>"></td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_id_analytics'); ?>:</td>
		<td><input type="text" id="analytics" name="analytics" value="<?php echo $fetch['analytics']; ?>"></td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_id_de_tag_manager'); ?>:</td>
		<td><input type="text" id="gtag" name="gtag" value="<?php echo $fetch['gtag']; ?>"></td>
		</tr>
		<tr>
		<td><?php echo extraevaloridioma('idioma_link_informativo'); ?>:</td>
		<td><input type="text" id="link" name="link" value="<?php echo $fetch['link']; ?>">
		 <span style="font-size:0.8em;"><?php echo extraevaloridioma('idioma_politicas_extra'); ?></span></td>
		</tr>
		<tr>
		<td><?php echo extraevaloridioma('idioma_script'); ?>:</td>
		<td><input type="text" id="script" name="script" value="<?php echo $fetch['script']; ?>">
		 <span style="font-size:0.8em;"><?php echo extraevaloridioma('idioma_script_info'); ?></span></td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_color_primario'); ?>:</td>
		<td><input type="text" id="color" name="color" value="<?php echo $fetch['color']; ?>">
		 <a href="colores.php?color=color" target="colores">(<?php echo extraevaloridioma('idioma_seleccionar'); ?>)</a></td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_color_borde'); ?>:</td>
		<td><input type="text" id="contrast" name="contrast" value="<?php echo $fetch['contrast']; ?>">
		 <a href="colores.php?color=contrast" target="colores">(<?php echo extraevaloridioma('idioma_seleccionar'); ?>)</a></td>
		</tr>
	
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_color_fondo'); ?>:</td>
		<td><input type="text" id="background" name="background" value="<?php echo $fetch['background']; ?>">
		 <a href="colores.php?color=background" target="colores">(<?php echo extraevaloridioma('idioma_seleccionar'); ?>)</a></td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_posicion'); ?>:</td>
		<td>
		<select id="position" name="position">
			<option value="right"><?php echo extraevaloridioma('idioma_derecha'); ?></option>
			<option value="left"><?php echo extraevaloridioma('idioma_izquierda'); ?></option>
		</select>
		<select id="vertical" name="vertical">
			<option value="top"><?php echo extraevaloridioma('idioma_superior'); ?></option>
			<option value="bottom"><?php echo extraevaloridioma('idioma_inferior'); ?></option>
		</select>
		<script>
			document.getElementById("position").value='<?php echo $fetch['position']; ?>';
		</script>
		<script>
			document.getElementById("vertical").value='<?php echo $fetch['vertical']; ?>';
		</script>
		</td>
		</tr>
	
		<tr>
		<td><?php echo extraevaloridioma('idioma_tamanyo_banner'); ?>:</td>
		<td>
		<input type="text" name="altura" id="altura" value="<?php echo $fetch['altura']; ?>">% 
		<span style="font-size:0.8em;"><?php echo extraevaloridioma('idioma_altura_info'); ?></span>
		</td>
		</tr>
		
		
		<tr>
		<td><?php echo extraevaloridioma('idioma_zoom'); ?>:</td>
		<td>
		<select id="zoom" name="zoom">
			<option value=0.75>75%</option>
			<option value=1 selected>100%</option>
			<option value=1.5>150%</option>
		</select>
		<script>
			document.getElementById("zoom").value='<?php echo $fetch['zoom']; ?>';
		</script>
		</td>
		</tr>
		
		<tr>
		<td><?php echo extraevaloridioma('idioma_notificaciones_habilitadas'); ?>:</td>
		<td>
		<input type="checkbox" name="notis" id="notis"><label 
		for="notis"> <?php echo extraevaloridioma('idioma_notis_info'); ?></label>
		
		
		<?php  if ($fetch['notis']) { ?>
		<script>
			document.getElementById("notis").checked='checked';
		</script>
		
		<?php } ?>
		</td>
		</tr>
		
		
		<?php if ($_SESSION['super']) { ?>
		
		<tr>
		<td style="color:Red;">Opciones de desarrollo</td>
		<td>
		
		<input type="checkbox" name="hiddenid" id="hiddenid" value="hiddenid"><label for="hiddenid"> Ocultar banner (Mostrar inicialmente solo el boton)</label>
		<br>
		<input type="checkbox" name="crossid" id="crossid" value="crossid"><label for="crossid"> Mostrar opción de Cerrar (Guardar y Salir) con una Cruz</label>
		
		
		
		
		<?php  if ($fetch['hiddenid']) { ?>
		<script>
			document.getElementById("hiddenid").checked='checked';
		</script>
	
		<?php } ?>
		
		<?php  if ($fetch['cross']) { ?>
		<script>
			document.getElementById("crossid").checked='checked';
		</script>
	
		<?php } ?>
		
		</td>
		</tr>
		
		<?php } ?>
		
		
		
		<tr>
		<td colspan=2><input type="submit" id="submit" name="submit" value="<?php echo extraevaloridioma('idioma_guardar_cambios'); ?>">
		
		
		
		
		<?php if ($_SESSION['super']) { ?>
		
		
		<?php 
		
		$_SESSION['token2'] = sha1($_SESSION['token']);
		
		?>
		
		 <input type="button" value="Eliminar" style="border:solid 2px red;background-color:red;color:white;font-weight:bold;"
		 onclick="if (confirm('Ésta acción es irreversible, seguro que lo desea eliminar?')) { window.open('elimina.php?token=<?php echo $_REQUEST['token']; ?>&token2=<?php echo $_SESSION['token2']; ?>','edita');}" >
		 
		 
			 <?php if ($fetch['deshabilitado'] == 'SI') { ?>
			 
			 <input type="button" value="Activar" style="border:solid 2px green;background-color:green;color:white;font-weight:bold;"
			 onclick="window.open('desactiva.php?token=<?php echo $_REQUEST['token']; ?>&deshabilitado=NO','edita');" >
			 
			 <?php } else { ?>
			 
			 <input type="button" value="Desactivar" style="border:solid 2px orange;background-color:orange;color:white;font-weight:bold;"
			 onclick="window.open('desactiva.php?token=<?php echo $_REQUEST['token']; ?>&deshabilitado=SI','edita');" >
			 
			 
			 <?php } ?>
		 
		 <?php } ?>
		 
		 
		 <input type="button" value="<?php echo extraevaloridioma('idioma_ver_codigo_instalacion'); ?>" onclick="window.open('codigo.php?token=<?php echo $_REQUEST['token']; ?>','codigo');"> 
		 <input type="button" value="<?php echo extraevaloridioma('idioma_ejemplo_banner'); ?>" onclick="window.open('example.php?token=<?php echo $_REQUEST['token']; ?>','ejemplo');">
		 <input type="button" value="<?php echo extraevaloridioma('idioma_ejemplo_gestor'); ?>" onclick="window.open('gestor.example.php?token=<?php echo $_REQUEST['token']; ?>','ejemplo-gestor');">
		 <input type="button" value="<?php echo extraevaloridioma('idioma_ejemplo_mixto'); ?>" onclick="window.open('mix.example.php?token=<?php echo $_REQUEST['token']; ?>','ejemplo-mixto');">
		 
		 </td>
		<td></td>
		</tr>
	
	</table>
	</form>
	
	<br>
	<br>
	<hr>
	<br>
	
	<input type="button" onclick="window.open('index.php','_top');" value="<?php echo extraevaloridioma('idioma_regresar_inicio'); ?>" >
	
	
	
	<?php
	
}
else {
	
	?>
	
	<script>window.open('/cm/loginManager/formLogin.php','loginManager');</script>
	
	<?php
	
}
?>
</body>
</html>