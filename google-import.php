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


<h1>Importador de Socios y Proveedores de Google</h1>


<?php

/*
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
*/


function curl_get_contents($url)
{

            ob_start();

    $ch = curl_init();
	
	
	curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']=$_SERVER['HTTP_USER_AGENT']);
	
	//curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    echo $data;

		$out1 = ob_get_contents();
		
		ob_end_clean();
		
		return $out1;
    
    
    
}


if ($_REQUEST["http_provider"]) {


?>

 <h3><?php echo $_REQUEST["http_provider"]; ?></h3>

	<h2 id="txtLog" style="color:green;">Importación iniciada...</h2>
	
<?php
	
	unlink($db='db/proveedoresgoogledb');
	
    	$db = new SQLite3('db/proveedoresgoogledb');
    	
	$q = 'CREATE TABLE IF NOT EXISTS proveedoresgoogle (id TEXT, nombre TEXT, url TEXT, subdominios TEXT)';
	$db->exec($q);
	
	
	
			    
	
	
	
	$url = $_REQUEST["http_provider"];
	
	$archivo_web = curl_get_contents($url);
	
	//$archivo = json_decode($archivo_web, true);
	
	$archivo = $archivo_web;
	
	$lineas = explode('
',$archivo_web);


	$l = 1;
	while($lineas[$l]) {
	
		//echo $lineas[$l];
		
		$linea = '['.$lineas[$l].']';
		
		$datos = false;
		$datos = json_decode($linea, true);
		//$datos = $datos[0];
		
		//print_r($datos);
		
		//exit();
		
		?>
		<script>
		
		document.getElementById("txtLog").innerHTML = 'Importando Google provedor -> <?php echo $datos[1]; ?>';
		
		</script>
		<?php
		
		if ($datos[3]) {
		
		flush();
		ob_flush();
		
		$q = "INSERT INTO proveedoresgoogle (id) VALUES ('".$datos[0]."')";
			    
			$resultado = $db->exec($q);
			
			
			$q = "UPDATE proveedoresgoogle SET nombre= '".$datos[1]."' WHERE id LIKE '".$datos[0]."'";
				    
			$resultado = $db->exec($q);
			
			$q = "UPDATE proveedoresgoogle SET url= '".$datos[2]."' WHERE id LIKE '".$datos[0]."'";
				    
			$resultado = $db->exec($q);
			
			$q = "UPDATE proveedoresgoogle SET subdominios= '".$datos[3]."' WHERE id LIKE '".$datos[0]."'";
				    
			$resultado = $db->exec($q);
			    
		}
		
		
		$l++;
	}
	
	
		
	?>
	
	<textarea style="width:98%;height:250px;display:none;">
	
	
	
	</textarea>
	
<?php
	
	
		//exit();
		
?>
		<script>
		
		document.getElementById("txtLog").innerHTML = 'Importación finalizada!';
		
		</script>
		
	
		
<?php
	

}
else {


//phpinfo();
?>

<form action="/cm/google-import.php" method="POST">

	
	<input type="text" name="http_provider" id="http_provider" value="https://storage.googleapis.com/tcfac/additional-consent-providers.csv">
	
	<br>
	<input type="submit" value="Importar">
	

</form>
<?php

}

?>



<br><br>

	<input type="button" onclick="window.open('index.php','_self');" value="Ir Atrás" >
