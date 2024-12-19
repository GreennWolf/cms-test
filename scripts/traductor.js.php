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

?>
// JavaScript Document
var cm21traductor = 'loaded';


/*CODIGO OBSOLETO*/

<?php

exit();

?>


function traduccionRecursiva(antiguo,nuevo) {

	if (antiguo!=nuevo) {

		 if (document.getElementById('listaCookiesGestor')) {
			 traduccionRecursivaFinal(antiguo,nuevo,'listaCookiesGestor');
		 }
		 if (document.getElementById('listaCookies')) {
			 traduccionRecursivaFinal(antiguo,nuevo,'listaCookies');
		 }
		 
		 
	 }	

}

function traduccionRecursivaFinal(antiguo,nuevo,id) {

	if (document.getElementById(id)) {
		 code = document.getElementById(id).innerHTML;
		 code = code.replace(antiguo,nuevo);
		 document.getElementById(id).innerHTML = code;
		 
		 if (code.includes(antiguo)) {
		 	traduccionRecursivaFinal(antiguo,nuevo,id);
		 
		 }
	 }
			

}


function traduceCM21(idioma) {


	<?php
	
		
	
	
	
	
	
        
    $db = new SQLite3('../db/idiomasdb');
    
    
	$q = "SELECT * FROM idiomas WHERE estado LIKE 'on'";
	
	
	$fetch = false;
	if($resultado = $db->query($q)) {
	
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
					
			$fetch[] = $row;
				  
		}
	
	}
	
	if (!$fetch) {
	
	
	//echo '<br><br><h3 style="color:red;">Sin idiomas</3><br><br>';
	
	
	} else {
	
		$i=0;
		while ($fetch[$i]) {
	
	
			$n=0;
			while ($fetch[$n]) {
	
	
			?>
			
			
			
			
			if (idioma == '<?php echo $fetch[$i]['idioma']; ?>') {
				
				var val1 = '<?php echo limpia(file_get_contents('../idiomas/'.$fetch[$n]['idioma'].'/idioma_Eliminar.txt')); ?>';
				var val2 = variablesIdiomas('<?php echo $fetch[$i]['idioma']; ?>','idioma_Eliminar');
				
				
				if (val1 != val2) { traduccionRecursiva(val1,val2); }
				
			
			}
			if (idioma == '<?php echo $fetch[$i]['idioma']; ?>') {
				
				var val1 = '<?php echo limpia(file_get_contents('../idiomas/'.$fetch[$n]['idioma'].'/idioma_Valor.txt')); ?>';
				var val2 = variablesIdiomas('<?php echo $fetch[$i]['idioma']; ?>','idioma_Valor');
				
				
				if (val1 != val2) { traduccionRecursiva(val1,val2); }
				
			
			}
			
			
			
			
			
				<?php	
			
			
			
			
			 	$n++;
			 }
			
			 $i++;
				  
		}
	
	
	}
	
	
	?>


}



