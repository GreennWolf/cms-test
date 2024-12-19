<?php
session_Start();
 
ini_set('display_errors', FALSE);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<title>Nuevo registro | Consent Manager</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>

<?php include_once('idiomas.banner.php'); ?>

<?php
include_once('userstatus.php'); 



if ($_SESSION['super']) {
	?>
	
	<h1>Nuevo registro</h1>
	
	<iframe src="about:blank;" style="display:none;" id="registra" name="registra"></iframe>
	
	

	<form  enctype="multipart/form-data"  action="crea.php" target="registra" method=POST>
	<table>
	
		<tr>
		<td>Nombre de la empresa:</td>
		<td><input type="text" id="nombre" name="nombre" value=""></td>
		</tr>
		
		<tr>
		<td>NIF/CIF:</td>
		<td><input type="text" id="CIF" name="CIF" value=""></td>
		</tr>
		
		<tr>
		<td>Dominio:</td>
		<td><input type="text" id="dominio" name="dominio" value=""> <span style="font-size:0.8em;">Lo puede dejar en blanco para utilizar multidominio</span></td>
		</tr>
	
		
		<tr>
		<td>Enlace principal:</td>
		<td><input type="text" id="enlace" name="enlace" value="http://"> <span style="font-size:0.8em;">Enlace principal de la web. Se usará para escanear sus proveedores.</span></td>
		</tr>
	
		<tr>
		<td>Token:</td>
		<td><input type="text" id="token" name="token" value="<?php echo substr(sha1(time().rand(9,9999999)),1,7); ?>"></td>
		</tr>
	
		<tr>
		<td>Correo electrónico:</td>
		<td><input type="text" id="mail" name="mail" value=""></td>
		</tr>
	
		<tr>
		<td>Clave:</td>
		<td><input type="password" id="clave" name="clave" value=""></td>
		</tr>
	
		<tr>
		<td>ID de Analitics:</td>
		<td><input type="text" id="analytics" name="analytics" value=""></td>
		</tr>
	
		<tr>
		<td>ID de Google TAG Manager:</td>
		<td><input type="text" id="gtag" name="gtag" value=""></td>
		</tr>
		<tr>
		<td>Link informativo:</td>
		<td><input type="text" id="link" name="link" value=""> <span style="font-size:0.8em;">Políticas adicionales de la empresa, etc </span></td>
		</tr>
		<tr>
		<td>Script:</td>
		<td><input type="text" id="script" name="script" value=""> <span style="font-size:0.8em;">Introduzca si desea, la URL del script *personalizado* si debiera ejecutarse cuendo el cliente pulsa ACEPTAR las cookies</span></td>
		</tr>
	
		<tr>
		<td>Color primario:</td>
		<td><input type="text" id="color" name="color" value="#336699"> <a href="colores.php?color=color" target="colores">(Seleccionar)</a></td>
		</tr>
	
		<tr>
		<td>Color de borde:</td>
		<td><input type="text" id="contrast" name="contrast" value="transparent"> <a href="colores.php?color=contrast" target="colores">(Seleccionar)</a></td>
		</tr>
	
		<tr>
		<td>Color de fondo:</td>
		<td><input type="text" id="background" name="background" value="#c0c0c0"> <a href="colores.php?color=background" target="colores">(Seleccionar)</a></td>
		</tr>
	
		<tr>
		<td>Posicion:</td>
		<td>
		<select id="position" name="position">
			<option value="right">Derecha</option>
			<option value="left">Izquierda</option>
		</select>
		<select id="vertical" name="vertical">
			<option value="bottom">Inferior</option>
			<option value="top">Superior</option>
		</select>
		</td>
		</tr>
		
		<tr>
		<td>Tamaño del banner (Altura):</td>
		<td>
		<input type="text" name="altura" id="altura" value="90">% <span style="font-size:0.8em;">Introduzca, si desea, la altura del banner, por si desea reducir su tamaño se aplicarán scrolls.</span>
		</td>
		</tr>
		
		<tr>
		<td>Zoom:</td>
		<td>
		<select id="zoom" name="zoom">
			<option value=0.75>75%</option>
			<option value=1 selected>100%</option>
			<option value=1.5>150%</option>
		</select>
		</td>
		</tr>
		
		
		<tr>
		<td>Notificaciones habilitadas:</td>
		<td>
		<input type="checkbox" name="notis" id="notis"><label for="notis"> Esta notificación emergente, informará al cliente de la mejor decisión de cookies.</label>
		</td>
		</tr>
		
		<tr>
		<td style="color:Red;">Opciones de desarrollo</td>
		<td>
		
		<input type="checkbox" name="hiddenid" id="hiddenid" value="hiddenid"><label for="hiddenid"> Ocultar banner (Mostrar inicialmente solo el boton)</label>
		<br>
		<input type="checkbox" name="crossid" id="crossid" value="crossid"><label for="crossid"> Mostrar opción de Cerrar (Guardar y Salir) con una Cruz</label>
		
		</td>
		</tr>
		
		
		
		<tr>
		<td><input type="submit" id="submit" name="submit" value="Registrar"></td>
		<td></td>
		</tr>
	
	</table>
	</form>
	
	<br>
	<br>
	<hr>
	<br>
	
	<input type="button" onclick="window.open('index.php','_top');" value="Regresar al inicio" >
	
	
	
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