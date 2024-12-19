<?php

header('Access-Control-Allow-Origin: *');

// set expires header
header('Expires: Thu, 1 Jan 1970 00:00:00 GMT');

// set cache-control header
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0',false);

// set pragma header
header('Pragma: no-cache');

@header('Content-Type: application/javascript; charset=utf-8');

session_Start();

include_once('../funciones.php');

if ($_REQUEST['idioma']) {

$_SESSION['idioma'] = $_REQUEST['idioma'];

}

if(!$_SESSION['idioma']) {

	$_SESSION['idioma'] = 'es';
	
}
?>
// JavaScript Document

<?php if (!$_REQUEST['idioma']) { ?>

var c21cm_cookies = 'loaded';

<?php } ?>


//alert('cookies.js.php');

	
<?php if (!$_REQUEST['idioma']) { ?>

let c21_cm_cookiesn = new Array();

<?php } ?>

<?php

        
    $dbi = new SQLite3('../db/idiomasdb');
    
    
    	if($_SESSION['idioma'] && true) {
		$qi = "SELECT * FROM idiomas WHERE estado LIKE 'on' and idioma LIKE '".$_SESSION['idioma']."' ";
    	
    	}
    	else {
		$qi = "SELECT * FROM idiomas WHERE estado LIKE 'on'";
	}
	
	$fetchi = false;
	if($resultadoi = $dbi->query($qi)) {
	
		while ($row = $resultadoi->fetchArray(SQLITE3_ASSOC)) {
					
			$fetchi[] = $row;
				  
		}
	
	}
	
	if (!$fetchi) {
	
	
	
	} else {
	
		$i=0;
		while ($fetchi[$i]) {
		

				?>

				
c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>'] = new Array();
				<?php


			
			    $db= new SQLite3('../db/cookiesdb');
			        
				$q = "SELECT * FROM cookies WHERE idioma LIKE '".$fetchi[$i]['idioma']."' ORDER BY prioridad DESC";
				
				$resultado = $db->query($q);
				
				$fetch = false;
				while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
							
					$fetch[] = $row;
						  
				}
				
				$x=0;
				while ($fetch[$x]) {

					if (!$declarado[$fetchi[$i]['idioma']][$fetch[$x]['nombre']]) {
?>
c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>']['<?php echo $fetch[$x]['nombre']; ?>'] = new Array();
<?php
						$declarado[$fetchi[$i]['idioma']][$fetch[$x]['nombre']]=true;
					}
					
?>
c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>']['<?php echo $fetch[$x]['nombre']; ?>']['proveedor'] = '<?php echo $fetch[$x]['proveedor']; ?>';
c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>']['<?php echo $fetch[$x]['nombre']; ?>']['enlace'] = '<?php echo $fetch[$x]['enlace']; ?>';
c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>']['<?php echo $fetch[$x]['nombre']; ?>']['duracion'] = '<?php echo $fetch[$x]['duracion']; ?>';
c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>']['<?php echo $fetch[$x]['nombre']; ?>']['info'] = '<?php echo limpia($fetch[$x]['info']); ?>';
c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>']['<?php echo $fetch[$x]['nombre']; ?>']['prioridad'] = '<?php echo $fetch[$x]['prioridad']; ?>';
c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>']['<?php echo $fetch[$x]['nombre']; ?>']['tipo'] = '<?php echo $fetch[$x]['tipo']; ?>';

c21_cm_cookiesn['<?php echo $fetchi[$i]['idioma']; ?>']['<?php echo $fetch[$x]['nombre']; ?>']['conexion'] = '<?php echo $fetch[$x]['connectionType']; ?>';
<?php
				
					$x++;
				}
				/*echo sizeof($fetch);*/
				
				?>
				
				
				
				<?php
				
			$i++;
		}
	}
	
?>


<?php if ($_REQUEST['idioma']) { ?>

c21cm_termina_de_traducir_ext('<?php echo $_SESSION['idioma']; ?>');
c21_calc_notification();

<?php } else { ?>



window.addEventListener("load",function(){
    

		loadIdiomasCM21();
		if (document.getElementById("aviso_cm21")) {
			rellenacm21();
		}
	
	

},false);

<?php } ?>





















