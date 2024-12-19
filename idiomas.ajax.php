<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();

include('funciones.php');

if ($_REQUEST['cambia']) {

	$_SESSION['idioma'] = $_REQUEST['cambia'];

	include_once('cambia.idioma.ajax.php');
	
	?>
	

<script>

	if (window.parent.document.getElementById('fullidiomas')) {
		window.opener.document.getElementById("fullidiomas").remove();
	}
</script>

	
	<?php
	
	exit();
}

?>

<script>

//alert('en desarrollo');

</script>

<div id="ventana">

	<div id="fullidiomas" style="background-color:white;z-index:999999999;border:solid 2px blue;position:fixed;top:2px;left:2px;width:99%;height:99%;">
	
	<svg  style="margin:2px;float:right;height:20px;cursor:help;" 
		onclick='document.getElementById("fullidiomas").remove();' xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
		
		
		<h2 style="padding:10px;"><img src="https://cookie21.com/cm/idiomas.png" style="cursor:help;height:40px;"></h2>
	
	
	
	<hr><br><br>
	
	
	<?php
	
		
	
	
	
	
	
        
    $db = new SQLite3('db/idiomasdb');
    
    
	$q = "SELECT * FROM idiomas WHERE estado LIKE 'on'";
	
	
	
	if($resultado = $db->query($q)) {
	
		while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
					
			$fetch[] = $row;
				  
		}
	
	}
	
	if (!$fetch) {
	
	
	echo '<br><br><h3 style="color:red;">Sin idiomas</3><br><br>';
	
	
	} else {
	
		$i=0;
		while ($fetch[$i]) {
	
			$idiomax = extraevaloridioma($id='idioma_nombre',$idioma=$fetch[$i]['idioma']);
			
			if ($fetch[$i]['idioma'] == $_SESSION['idioma']) {
				$border = 'solid 2px orange';
			}
			else {
				$border = 'solid 1px';
			}
			
			?>
			
			<input type="button" style="border:<?php echo $border; ?>;padding:20px;margin:20px;font-size:1.3em;"
			 onclick="window.open('idiomas.ajax.php?&time=<?php echo time() ;?>&cambia=<?php echo $fetch[$i]['idioma']; ?>','jajasIdiomas');" value="<?php echo $idiomax; ?>" >
		
				<?php	
			 $i++;
				  
		}
	
	
	}
	
	
	?>
	
	
	<br><br>
	
	
	
	</div>


</div>

<script>

window.parent.document.body.innerHTML += document.getElementById('ventana').innerHTML;

</script>