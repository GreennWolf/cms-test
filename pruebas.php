<?php
session_Start();
 
ini_set('display_errors', FALSE);

if (!$_SESSION['super']) {

	header('Location: admins.php');
	exit();

}

if (!$_REQUEST['token']) {
$_REQUEST['token'] = 'demo';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

<title>Pruebas | Consent Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>
<script  src="//<?php echo $_SERVER['HTTP_HOST']; ?>/cm/full?token=<?php echo $_REQUEST['token']; ?>"></script>

<script  src="/cm/scripts/TCF/tcf.full.js.php"></script>



<h1>Comprobación de las funciones</h1>
<hr>
<br>
<script  src="/cm/scripts/alertaErrores.js"></script>
Se ha habilitado el debug de errores para ésta página.
<br>
<br>
<br>

<b>LOG INFORMATIVO</b>:
<br>
<textarea id="logInfo" name="logInfo" style="width:90%;height:230px;"></textarea>

<script>

function logInfo(logInfo) {

	document.getElementById('logInfo').innerHTML = logInfo;
	window.location.href="#logInfo";

}

</script>








<br><br><br><br>
<h3>Funciones básicas</h3>
<hr>
<br>

<input type="button" onclick="c21_iab_auditor();" value="Mostrar IAB ENCODER-DECODER">

<input type="button" onclick="document.getElementById('c21_pixels').style.display = '';" value="Mostrar PIXEL CONTROL">

<input type="button" onclick="window.open('desarrollo.php','pruebas');" value="Entorno de desarrollo" >

<input type="button" onclick="window.open('/cm/insertador.php','_blank');" value="Cargar insertador">
	

<input type="button" onclick="alert(ComprobarDebug());" value="ComprobarDebug">

<input type="button" onclick="logInfo(base64encodeURL());" value="base64encodeURL">

<input type="button" onclick="logInfo(base64decode(base64encodeURL()));" value="base64decode">

<input type="button" onclick="logInfo(TCF_Ping());" value="TCF_Ping">

<input type="button" onclick="window.open(vendorList(),'_blank');" value="vendorList()">

<input type="button" onclick="logInfo(construye_tcString(755));" value="construye_tcString(755)">

<input type="button" onclick="logInfo(final_tcString(construye_tcString(755)));" value="final_tcString(construye_tcString(755))">

<input type="button" onclick="logInfo(fechaActual());" value="fechaActual()">

<input type="button" onclick="logInfo(binary_encode('Hola'));" value="binary_encode('Hola')">

<input type="button" onclick="logInfo(espacios8bits(binary_encode('Hola')));" value="espacios8bits(binary_encode('Hola'))">


<input type="button" onclick="logInfo(binary_encode('4'));" value="binary_encode('4')">

<input type="button" onclick="logInfo(convertToBinary('4'));" value="convertToBinary('4')">

<input type="button" onclick="logInfo(convertToBinary('18'));" value="convertToBinary('18')">

<input type="button" onclick="logInfo(binary_long(convertToBinary('4'),16));" value="binary_long(convertToBinary('4'),16)">

<br>

<br><br><br><br>
<hr>
<h3>Recogida de datos</h3>
<hr>
<br>

<input type="button" onclick="alert(Object.entries(TCF_TCData(true)));" value="TCF_TCData">


<input type="button" onclick="alert(Object.entries(TCF_inAppTCData(true)));" value="TCF_inAppTCData">

<br>
<br><br><br><br>
<hr>
<h3>Envío de datos</h3>
<hr>
<br>
<input type="button" onclick="alert(TCF_addEventListener(true));" value="TCF_addEventListener">

<input type="button" onclick="alert(TCF_getInAppTCData(true));" value="TCF_getInAppTCData">



<hr>
<br>
<br>
<br><br><br><br>
<hr>
<h3>Documentaciones</h3>
<hr>

<br>
<a target="_blank" href="https://github.com/InteractiveAdvertisingBureau/GDPR-Transparency-and-Consent-Framework/blob/master/TCFv2/IAB%20Tech%20Lab%20-%20CMP%20API%20v2.md">TCFv2</a>
<br><br>


<a href="https://iabtcf.com/" target="_blank" >Online Encoder-Decoder</a>
<br><br>

<a href="scripts/TCF/iabtcf-master/docs/index.html" target="_blank" >Local Encoder-Decoder</a>
<br><br>


<a href="/cm/scripts/TCF/documentacion.txt" target="_blank" >Documentacion para tcString</a>
<br><br>


<a href="https://google.com/search?q=iab tcf api" target="_blank" >Iab TCF Api</a>
<br><br>
<a href="https://iabspain.es/principales-cambios-y-periodos-de-implementacion-de-la-actualizacion-del-tcf-a-su-version-2-2/" target="_blank" >Normativa de implementación</a>
<br><br>
<a href="https://iabeurope.eu/iab-europe-transparency-consent-framework-policies/" target="_blank" >Policies</a>
<br><br><br>

<br><br>
<br><br><br><br>
<hr>
<h3>Referencias</h3>
<hr>

<br>
<b>TCF</b>: Transparent Consent Manager
	
<br><br>
<b>CMP</b>: Consent Manager Provider

<br><br>
<b>GDPR</b>: Reglamento General de Protección de Datos

<br><br>
<b>npm</b>: Node Package Manager


<br><br><br>

<br><br>
<hr>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>







</body>
</html>


