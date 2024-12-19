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
var cm21variables = 'loaded';
<?php } ?>

//alert('variables.js.php');



	
<?php if (!$_REQUEST['idioma']) { ?>
let c21cm_idioma_ = new Array();
<?php } ?>
	
<?php
	
	if ($hard=true) {
	
        
    $db = new SQLite3('../db/idiomasdb');
    
    	if($_SESSION['idioma'] && true) {
		$q = "SELECT * FROM idiomas WHERE estado LIKE 'on' and idioma LIKE '".$_SESSION['idioma']."' ";
    	
    	}
    	else {
		$q = "SELECT * FROM idiomas WHERE estado LIKE 'on'";
	}
	
	
	$fetch = false;
	if($resultado = $db->query($q)) {
	
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
					
			$fetch[] = $row;
				  
		}
	
	}
	
	if (!$fetch) {
	
	
	
	} else {
	
		$i=0;
		while ($fetch[$i]) {
		
		?>
		<?php
        
			    $db2 = new SQLite3('../db/idiomadb');
			    
			    
				$q2 = "SELECT * FROM idioma WHERE idioma LIKE '".$fetch[$i]['idioma']."'";
	
				if($resultado2 = $db2->query($q2)) {
				
					while ($row2 = $resultado2->fetchArray(SQLITE3_ASSOC)) {
								
						$fetchFinal[] = $row2;
							  
					}
				
				}
				
				if (!$declarado[$fetch[$i]['idioma']]) {
				
				?>

c21cm_idioma_['<?php echo $fetch[$i]['idioma']; ?>'] = new Array();

<?php
				
					$declarado[$fetch[$i]['idioma']]=True;
				}
				
				
				$ix=0;
				while ($fetchFinal[$ix]) {
				
					if (!$declarados[$fetchFinal[$ix]['idioma']][$fetchFinal[$ix]['id']]) {
	
			?>
c21cm_idioma_['<?php echo $fetchFinal[$ix]['idioma']; ?>']['<?php echo $fetchFinal[$ix]['id']; ?>'] = '<?php echo limpia($fetchFinal[$ix]['valor']); ?>';			
<?php
			
					$declarados[$fetchFinal[$ix]['idioma']][$fetchFinal[$ix]['id']] = true;
					
					}
					$ix++;
				}
			
			?>
			
			
			
			
			
			
		
				<?php	
			 $i++;
				  
		}
	}
		
}
	
?>

<?php if ($_REQUEST['idioma']) { ?>

    c21_loadjs('https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/cookies.js.php?idioma=<?php echo $_SESSION['idioma']; ?>');
    
<?php } ?>