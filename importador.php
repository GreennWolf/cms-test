<?php
session_Start();


/*
@ini_set('zlib.output_compression', 0);	

ini_set('output_buffering','Off');

ini_set('implicit_flush	','ON');
*/

ini_set('display_errors', FALSE);

if (!$_SESSION['super']) header('Location: admins.php');

?>
<!DOCTYPE html>
<html lang="es">
<head>

<title>Importador de Socios y Proveedores | CMP Cookie 21</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>


<h1>Importador de Socios y Proveedores</h1>

<form action="/cm/importador.php" method="POST">

	Provider list: <input type="text" value="https://vendor-list.consensu.org/v3/vendor-list.json" name="http_provider" id="http_provider">
	<input type="submit" value="Importar">

</form>

<?php


function curl_get_contents($url)
{
    $ch = curl_init();
	
	
	curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']=$_SERVER['HTTP_USER_AGENT']);
	//curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}


if ($_REQUEST["http_provider"]) {
?>

 <h3><?php echo $_REQUEST["http_provider"]; ?></h3>

	<h2 id="txtLog" style="color:green;">Importación iniciada...</h2>
	<textarea style="width:98%;height:250px;display:none;">
	
	<?php
	
	$url = $_REQUEST["http_provider"];
	
	    $archivo_web = curl_get_contents($url);
		
		//echo $archivo_web;
		
	    $archivo = json_decode($archivo_web, true);
	
	
	
	
	
		//print_r($archivo);
	?>
	
	
	</textarea>
	
	
	<?php if ($deb = false) { ?>
	<pre>
	
	<?php print_r($archivo); ?>
	
	</pre>
	
	<?php } ?>
	
	
	
	
	<script>
	
	document.getElementById('txtLog').innerHTML = 'Actualizando provedoores... <br>';
	
	</script>
	
	
	<?php 
		$vendorListVersion = $archivo['vendorListVersion'];
	?>
	<script>
	
	document.getElementById('txtLog').innerHTML += 'vendorListVersion: <?php echo $vendorListVersion; ?>';
	
	</script>
	
	<?php
	
	$vendors = $archivo['vendors'];
	
	//print_r($vendors);
	
	
    	$db= new SQLite3('db/proveedoresiabdb');
    	
    	
	
	$sum=0;
	while ($sum < 2000) {
	
		$vendor = $vendors[$sum];
		
		flush();
		ob_start();
		ob_end_flush();
		ob_implicit_flush(1);
		flush();
		
		if ($vendor['id']) {
		
		
			$q = "SELECT vendorListVersion FROM proveedoresiab WHERE id LIKE '".$vendor['id']."'";
		
			$resultado = $db->query($q);
			
			$fetch = false;
			while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
				$fetch = $row;
					  
			}
			if (!$fetch && TRUE) {
			
			
			    $q = "INSERT INTO proveedoresiab (id, vendorListVersion) VALUES ('".$vendor['id']."','".$vendorListVersion."')";
			    
			    $resultado = $db->exec($q);
			
			}
			//else /*if ($fetch['vendorListVersion'] == $vendorListVersion)*/ {
			
				
			    $q = "UPDATE proveedoresiab SET url= '".$vendor['urls'][0]['privacy']."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    $q = "UPDATE proveedoresiab SET funcion= '".$vendor['urls'][0]['privacy']."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    $q = "UPDATE proveedoresiab SET vendorListVersion= '".$vendorListVersion."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    $q = "UPDATE proveedoresiab SET nombre= '".$vendor['name']."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    
					    
			    
			    $q = "UPDATE proveedoresiab SET propositos= '".json_encode($vendor['purposes'])."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    
					 
			    
			    
			    
			    $q = "UPDATE proveedoresiab SET fullurls = '".json_encode($vendor['urls'])."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    
			    
			    
			    
			    flush();
			    ob_flush();
			    ob_end_flush();
			    
			    ?>
			    
		<script>
		
		document.getElementById('txtLog').innerHTML = 'Cargando dominios de  <?php echo $vendor['name']; ?> (<?php echo $vendor['deviceStorageDisclosureUrl']; ?>) ';
		
		</script>
		
			    <?php
			    
			    flush();
			    ob_flush();
			    ob_end_flush();
			    
			    $contenido = false;
			    
	    			$contenido = curl_get_contents($vendor['deviceStorageDisclosureUrl']);
		
			    
			    $deviceStorageDisclosureUrl = json_decode($contenido, true);
			    
			    //print_r($deviceStorageDisclosureUrl);
			    
			    $scandomain = json_encode($deviceStorageDisclosureUrl['domains']);
			    
			    
			    $q = "UPDATE proveedoresiab SET scandomain = '".$scandomain."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    
			    
			    
			    
			    
			    
			    $q = "UPDATE proveedoresiab SET flexiblePurposes= '".json_encode($vendor['flexiblePurposes'])."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    
			    
			    
			    $q = "UPDATE proveedoresiab SET specialPurposes= '".json_encode($vendor['specialPurposes'])."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    
			    
			    $q = "UPDATE proveedoresiab SET features= '".json_encode($vendor['features'])."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    
			    
			    
			    $q = "UPDATE proveedoresiab SET specialFeatures= '".json_encode($vendor['specialFeatures'])."' WHERE id LIKE '".$vendor['id']."'";
			    
			    $resultado = $db->exec($q);
			    
			    
			    
			     
			
			//}
			//usleep(300);
			
			flush();
			
			ob_flush();
			
			    
			    flush();
			    ob_flush();
			    ob_end_flush();
		
	?>
	
		<script>
		
		document.getElementById('txtLog').innerHTML = 'VENDOR ID: <?php echo $vendor['id']; ?> (<?php echo $vendor['name']; ?>) Actualizado ';
		
		</script>
		
		
		
		
	<?php
	
	
		}
		
		
			    
			    flush();
			    ob_flush();
			    ob_end_flush();
		
		
		
		
	
		$sum++;
	}
	?>
	
	
		<script>
		
		document.getElementById('txtLog').innerHTML = 'Importacion vendorListVersion= <?php echo $vendorListVersion; ?> FINALIZADA';
		
		</script>
		
		
	
		<script>
		
		document.getElementById('txtLog').innerHTML = 'Borrando registros anteriores....';
		
		</script>
		
		
	
	
<?php


			    
			    flush();
			    ob_flush();
			    ob_end_flush();
		
		
			$q = "SELECT * FROM proveedoresiab";
		
			$resultado = $db->query($q);
			
			$fetch = false;
			while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
				$fetch[] = $row;
					  
			}
			
			
			$x=0;
			while ($fetch[$x]) {
			
				if ($fetch[$x]['vendorListVersion'] != $vendorListVersion) {
				
				
   				 $q = "DELETE FROM proveedoresiab WHERE vendorListVersion LIKE '".$fetch[$x]['vendorListVersion']."'";
					 $resultado = $db->exec($q);
				}
			
			    	//$q = "INSERT INTO proveedoresiab (id, vendorListVersion) VALUES ('".$vendor['id']."','".."')";
			    
			
				$x++;
			}
			
			    
			    flush();
			    ob_flush();
			    ob_end_flush();
			?>
			
			
	
		<script>
		
		document.getElementById('txtLog').innerHTML = 'IMPORTACION FINALIZADA para vendorListversion: <?php echo $vendorListVersion; ?>';
		
		</script>
		
		
			
			
			<?php
	

}


//phpinfo();
?>



<br><br>

	<input type="button" onclick="window.open('index.php','_self');" value="Ir Atrás" >
