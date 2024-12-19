<script>

window.parent.document.getElementById('idiomas_log').innerHTML = 'Comparando idiomas....';

</script>

//alert('Comparando idiomas');
<?php

if (!$_REQUEST['id_idioma']) {
?>
<script>

window.parent.document.getElementById('idiomas_log').innerHTML = 'Inserte un ID válido....';

</script>

<?php
exit();


}

        
    $db = new SQLite3('db/idiomasdb');
    
    
	$q = "SELECT idioma FROM idiomas WHERE idioma LIKE '".$_REQUEST['id_idioma']."'";
	
	
	
	if($resultado = $db->query($q)) {
	
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
					
			$fetch[] = $row;
				  
		}
	
	}
	
	if (!$fetch) {
	?>
	
		<script>

		window.parent.document.getElementById('idiomas_log').innerHTML = 'Correcto....';
		
		</script>
	
		<script>

		window.parent.document.getElementById('idiomas_log').innerHTML = 'Añadiendo idioma...';
		
		</script>
	<?php
	
		
    		$db = new SQLite3('db/idiomasdb');
    
    
		$q = "INSERT INTO idiomas (idioma,estado) VALUES ('".$_REQUEST['id_idioma']."','off')";
	
	
   		if( $resultado = $db->exec($q)) {
   		
   		//mkdir('idiomas/'.$_REQUEST['id_idioma'].'/');
   		
   		?>
	
		<script>

		window.parent.document.getElementById('idiomas_log').innerHTML = 'Idioma creado... recargando...';
		
		window.parent.location.href='/cm/idiomas.php?<?php echo time(); ?>#<?php echo $_REQUEST['id_idioma']; ?>';
		
		</script>
   		
   		<?php
   		
   		
   		}
		
	
	}else{
	
   		?>
	
		<script>

		window.parent.document.getElementById('idiomas_log').innerHTML = 'No se puede crear un idioma que <b style="color:red;">ya existe</b>...';
		
		</script>
   		
   		<?php
   		
	
	
	}
	
	?>