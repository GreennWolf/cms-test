<?php

@header('Content-Type: application/javascript; charset=utf-8');

include_once('../../funciones.php');

?>

if (window.saveCookieCM21) { /*READY*/}
else {
	function saveCookieCM21(nombre,valor) {
	
		document.cookie = nombre+"=" + valor+ "; expires=Thu, 18 Dec 2999 12:00:00 UTC; path=/";
	
	}
}


if (window.getCookie) { } 
else {
	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
		c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
		return c.substring(name.length, c.length);
		}
		}
		return "";
	}
}




      	
		<?php
		
	if ($individualPixel=false) {
	
    		$terceros = new SQLite3('../../db/tercerosdb');
    		
		$q = "SELECT * FROM terceros WHERE token LIKE '".$_REQUEST['token']."'";
			
		$resultadoTerceros = $terceros->query($q);
			
			
		while ($rowx = $resultadoTerceros ->fetchArray(SQLITE3_ASSOC)) {
					
			
			if ($rowx['googleid']) {
			
				$google = googleInfoProvider($rowx['googleid']);
				
				if ($google['id']) {
				
				
			?>
				
			document.write('<br><img id="google_<?php echo $google['id']; ?>" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/ajax-loader.gif" > Pixel for Google ID: <?php echo $google['id']; ?> <br>');
		
		
			<?php
			
			
				}
			}
			
					  
		}
		
	} else {	
		
	?>
	
	
	document.write('<br><img id="c21_google_vendors_pixel" src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/ajax-loader.gif" > Pixel for Google All Google IDs <br>');
		
	
	
	<?php
	
	}
	
	?>


function c21_pixel_result() {


			
		var vendor = window.parent.c21cm_vendor();
		vendor += '&addtl_consent=2~';
		
		var c21_v = '';
		var c21_dv = '';
      	
		<?php
		
		
	
    		$terceros = new SQLite3('../../db/tercerosdb');
    		
		$q = "SELECT * FROM terceros WHERE token LIKE '".$_REQUEST['token']."'";
			
		$resultadoTerceros = $terceros->query($q);
			
			
		while ($rowx = $resultadoTerceros ->fetchArray(SQLITE3_ASSOC)) {
					
			
			if ($rowx['googleid']) {
			
				$google = googleInfoProvider($rowx['googleid']);
				
				if ($google['id']) {
				
				
			?>
			
			if (window.parent.getCookie('google_<?php echo $google['id']; ?>')) {
					
				/*
				document.getElementById('google_<?php echo $google['id']; ?>').src= vendor + '&addtl_consent=2~<?php echo $google['id']; ?>';
				*/
				if (c21_v) { c21_v += '.'; }
				c21_v += '<?php echo $google['id']; ?>';
				
			} else {
			
				/*
				document.getElementById('google_<?php echo $google['id']; ?>').src= vendor +'&addtl_consent=2~dv.<?php echo $google['id']; ?>';
				*/
				if (c21_dv) { c21_dv += '.'; }
				c21_dv += '<?php echo $google['id']; ?>';
			}
			
			<?php
			
			
				}
			}
			
					  
		}
		
		
		
	?>

	if (c21_dv) {
	
		if (c21_dv) { c21_dv = '~dv.'+c21_dv ; }
		else { c21_dv = 'dv.' + c21_dv; }
		
	} else {
	
		c21_dv = '';
	}

	var c21_pixel_src = vendor + c21_v + c21_dv;
	
	if (document.getElementById('c21_google_vendors_pixel')) {
	
		if (document.getElementById('c21_google_vendors_pixel').src) {
	
			if (document.getElementById('c21_google_vendors_pixel').src != c21_pixel_src ) {
	
			document.getElementById('c21_google_vendors_pixel').src= c21_pixel_src ;
			
			}
		}
	}

}


/*alert('Loaded pixel control');*/









