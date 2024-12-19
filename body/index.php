<?php

header('Content-Type: application/javascript');

?>
//JavaScript Code

var cm21body = 'loaded';

<?php

    $db= new SQLite3('../db/consentsdb');
        
	$q = "SELECT * FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
	//$q = "SELECT * FROM clients";
	
	
	
	$resultado = $db->query($q);
	
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
		$fetch = $row;
			  
	}
	if ($fetch['deshabilitado'] == 'SI') {
	
		exit();
	
	}
	
	if ($fetch['dominio']) {
		
		if (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) == $fetch['dominio']) { }
  		elseif (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) == 'www.'.$fetch['dominio']) { }
  		elseif (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) == 'cookie21.com') { }
  		elseif (parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) == 'www.cookie21.com') { }
  		else 
  		{
  		//echo 'alert("Token/Dominio erroneo");';
  		//exit('');
  		}
  		
		
	}
?>


/*AUDITORIA: Previamente hemos validado el Token en PHP para proseguir con la carga del Consent Manager*/

if (typeof cm21content !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/content/?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));

}