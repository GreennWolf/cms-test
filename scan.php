<?php
session_start();
 
ini_set('display_errors', FALSE);


if ($_SESSION['token']) { $_REQUEST['token'] = $_SESSION['token']; }

else if ($_SESSION['token'] && !$_REQUEST['token']) { $_REQUEST['token'] = $_SESSION['token']; }
else if ($_SESSION['super'] && $_REQUEST['token']) { $_SESSION['token'] = $_REQUEST['token']; }
else if ($_SESSION['super']) { /*ok*/ }
else { exit(header('Location: index.php')); }




include_once('funciones.php');

if(!function_exists('ereg'))            { function ereg($pattern, $subject, &$matches = array()) { return preg_match('/'.$pattern.'/', $subject, $matches); } }
if(!function_exists('eregi'))           { function eregi($pattern, $subject, &$matches = array()) { return preg_match('/'.$pattern.'/i', $subject, $matches); } }
if(!function_exists('ereg_replace'))    { function ereg_replace($pattern, $replacement, $string) { return preg_replace('/'.$pattern.'/', $replacement, $string); } }
if(!function_exists('eregi_replace'))   { function eregi_replace($pattern, $replacement, $string) { return preg_replace('/'.$pattern.'/i', $replacement, $string); } }
if(!function_exists('split'))           { function split($pattern, $subject, $limit = -1) { return preg_split('/'.$pattern.'/', $subject, $limit); } }
if(!function_exists('spliti'))          { function spliti($pattern, $subject, $limit = -1) { return preg_split('/'.$pattern.'/i', $subject, $limit); } }



$_SESSION['added'] = false;

function addproviders($token,$iabid=false,$googleid=false) {

	if (!$token || (!$iabid && !$googleid)) {
	
		return false;
		
	}
	if ($_SESSION['added']['iabid'][$iabid]) {
	
		return false;
	
	}
	if ($_SESSION['added']['googleid'][$googleid]) {
	
		return false;
	
	}
	
	
    	$db = new SQLite3('db/tercerosdb');
    	
	if($iabid) { $q = "INSERT INTO terceros (token, iabid) VALUES ('".$token."','".$iabid."')";$_SESSION['added']['iabid'][$iabid] = true; }
	
	if($googleid) { $q = "INSERT INTO terceros (token, googleid) VALUES ('".$token."','".$googleid."')"; $_SESSION['added']['googleid'][$googleid] = true; }
			    
	$resultado = $db->exec($q);
    	

}

/*RESET*/


	
$dbt = new SQLite3('db/tercerosdb');
    	
$q = "DELETE FROM terceros WHERE token LIKE '".$_REQUEST['token']."' AND manual IS NULL";
			    
$resultado = $dbt->exec($q);
    	









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


if ($pruebaTemporalDesarrollo=false) {

	$code = curl_get_contents($url='https://linkedin.com');
	if ($code) {
		echo 'have code';
	}else {
		echo 'unknown';
	}
	//print_r(curl_get_contents($url='https://linkedin.com'));
	exit();


}



    $db= new SQLite3('db/consentsdb');
        
	$q = "SELECT * FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
	//$q = "SELECT * FROM clients";
	
	
	
	$resultado = $db->query($q);
	
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
		$fetch = $row;
			  
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





<h1><?php echo extraevaloridioma('idioma_escanner_proveedores'); ?></h1>

<h3><?php echo $fetch['enlace']; ?></h3>

<h4 id="infoLog" style="color:green;">SCANING...</h4>


<h5> > Google </h5>
<?php

		$url =  $fetch['enlace'];
		
	    	$archivo_web = curl_get_contents($url);
	    	
	    	
	    	
    		$google= new SQLite3('db/proveedoresgoogledb');
	    	
		
			$q = "SELECT * FROM proveedoresgoogle";
		
			$resultado = $google->query($q);
			
			$fetch3 = false;
			while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
				$fetch3[] = $row;
					  
			}
			
			
			
			$xg=0;
			while ($fetch3[$xg]) {
				
				$subdominios = $fetch3[$xg]['subdominios'];
				
				if ($subdominios) {
				
					$subs = explode(' ',$subdominios);
					$xg2=0;
					while ($subs[$xg2]) {
				
						$subfinal = $subs[$xg2];
						//$subfinal = str_replace('*','',$subfinal);
						?>
						
						<script>
							document.getElementById("infoLog").innerHTML = 'Checking <?php echo $subfinal; ?> ...';
						</script>
						
						<?php
						flush();
						ob_flush();
						
						$coincidencias = false;
						
						//$coincidencias = preg_match("/".$subfinal."/", $archivo_web);
						$subfinal = str_replace('*.','',$subfinal);
						$subfinal = str_replace('*','',$subfinal);
						//$subfinal = parse_url($subfinal, PHP_URL_HOST);
						
						$coincidencias = ereg($subfinal, $archivo_web);
						
						
						?>
						
						<script>
							document.getElementById("infoLog").innerHTML = 'Checking <?php echo $subfinal; ?> ...';
						</script>
						
						<?php
						
						$code = false;
						if($coincidencias) {
						
						
							$code = curl_get_contents('https://'.$subfinal);
						}
							
						
						/*
						print_r($fetch3[$xg]['id']);
						
						exit();
						*/
						
						flush();
						ob_flush();
						
						
						if ($code) {
						
							addproviders($_REQUEST['token'],$iabid=false,$googleid=$fetch3[$xg]['id']);
						?>
							 > <?php echo extraevaloridioma('idioma_anyadido'); ?>: <?php echo $fetch3[$xg]['nombre']; ?> (<?php echo $subfinal; ?>)<br>
							<br><br>
							
						
						<?php
						
						//exit();
						}
						
						//echo $subfinal.'<br>';
						
						$xg2++;
					}
					
				}
				
				//exit();
				$xg++;
			}
	    	
	    	
	    	
?>
<br><br>


<h5> > IAB </h5>

<?php
	    	
	    
    		$iab= new SQLite3('db/proveedoresiabdb');
    	
    	
    	
    	
    	
		
		
			$q = "SELECT * FROM proveedoresiab";
		
			$resultado = $iab->query($q);
			
			$fetch2 = false;
			while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
				$fetch2[] = $row;
					  
			}
			
			
			
			$x=0;
			while ($fetch2[$x]) {
				
				
				if ($fetch2[$x]['scandomain'] != 'null') {
				
					$domains = false;
					
					$domains = json_decode($fetch2[$x]['scandomain'],true);
					
					/*
					print_r($domains);
					
					exit();
					*/
					
					$r=0;
					while ($domains[$r]) {
					
						$domain = $domains[$r]['domain'];
					
						//$domain = str_replace('*.','',$domain);
						
						
						
            					//ob_start();
						?>
						<script>
							document.getElementById("infoLog").innerHTML = 'Checking <?php echo $domain; ?> ...';
						</script>
						
						<?php

						//$out1 = ob_get_contents();
						
						//ob_end_clean();
						
						//print($out1);
						
						
						if ($bloqueoTemp = false && $x >= 10) {
							exit();
						}
						
						
						$code = false;
						$coincidencias = false;
						
						$domain = str_replace('*.','',$domain);
						$domain = str_replace('*','',$domain);
						//$domain = parse_url($domain, PHP_URL_HOST);
						$coincidencias = @ereg($domain, $archivo_web);
						
						?>
						
						<script>
							document.getElementById("infoLog").innerHTML = 'Checking <?php echo $domain ; ?> ...';
						</script>
						
						<?php
						if ($coincidencias) {
						
							$code = curl_get_contents('https://'.$domain);
							//echo 'CHECKING .... '.$domain.'<br>';
						}
				
						if ($code && !$added[$fetch2[$x]['id']]) {
						
							$added[$fetch2[$x]['id']] = true;
						
							addproviders($_REQUEST['token'],$iabid=$fetch2[$x]['id'],$googleid=false);
							?>
							 > <?php echo extraevaloridioma('idioma_anyadido'); ?>: <?php echo $fetch2[$x]['nombre']; ?> (<?php echo $domain; ?>)<br>
							<br><br>
							<?php
						
						}
						
						$r++;
					}
				}
			
				$x++;
			}
			
    	
    	
    	
    	
    	
?>
						<script>
							document.getElementById("infoLog").innerHTML = 'COMPLETED!';
						</script>

	<br>
	<br>
	
	<input type="button" onclick="window.open('selector.php?token=<?php echo $_REQUEST['token']; ?>','_top');" value="<?php echo extraevaloridioma('idioma_configurar'); ?>" >
	













