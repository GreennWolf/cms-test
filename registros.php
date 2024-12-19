<?php

session_start();
ini_set('display_errors', FALSE);
if (!$_SESSION['super']) { exit(header('Location: admins.php')); }


?>

<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>
<title>Registros | Consent Manager</title>

<?php include_once('idiomas.banner.php'); ?>
<?php
include_once('userstatus.php'); 



if ($_SESSION['super']) {


	?>
	
	<h1>Registros</h1>
	
	
	<br>
	
	<hr>
	
	<br>
	
	<input type="button" onclick="window.open('nuevo.php','_top');" value="Nuevo registro" >
	
	
	<br>
	
	<hr>
	
	<br>
	<br>
	

<script src="handsontable-pro-master/node_modules/handsontable-pro-master/dist/handsontable.full.min.js"></script>
<script src="handsontable-pro-master/node_modules/handsontable-pro-master/dist/languages/es-MX.js"></script>
<link href="handsontable-pro-master/node_modules/handsontable-pro-master/dist/handsontable.full.min.css" rel="stylesheet" media="screen">


	
<div id="registros" style="zoom:0.8;"></div>
<script>


 
const inci = ["TOKEN","EDITAR","VER CODIGO",/*"VER ACCESOS",*/"FECHA","MAIL","DOMINIO","ENLACE","VISITAR"];


data1 = [


<?php












		
			$db= new SQLite3('db/consentsdb');
			
			
			$q = "SELECT * FROM consents ORDER BY ctime DESC;";
			
			
			
			if($resultadow = $db->query($q)) {
			
			while ($now = $resultadow->fetchArray(SQLITE3_ASSOC)) {
						
						
				$c1  = '<a href=editar.php?token='.$now['token'].' style=color:blue; target=_top>EDITAR</a>';
				$c2  = '<a href=codigo.php?token='.$now['token'].' style=color:blue; target=codigo>VER CÓDIGO</a>';
				$c3  = '<a href=accesos.php?token='.$now['token'].' style=color:blue; target=accesos>VER ACCESOS</a>';
				
				if (1) $c3 = false;
				
				if ($now['enlace']) $cv  = '<a href='.$now['enlace'].' style=color:blue; target=_blank>VISITAR</a>';
				else $cv  = '(Sin enlace principal)';
				
				
				
				
				if ($c3) {
				
		echo '["'.$now['token'].'","'.$c1.'","'.$c2.'","'.$c3.'","'.date('d/m/Y', $now['ctime']).'","'.$now['mail'].'","'.$now['dominio'].'","'.$now['enlace'].'","'.$cv.'"],
		
		';
		
				}
				else {
				
				
		echo '["'.$now['token'].'","'.$c1.'","'.$c2.'","'.date('d/m/Y', $now['ctime']).'","'.$now['mail'].'","'.$now['dominio'].'","'.$now['enlace'].'","'.$cv.'"],
		
		';
				
				
				}
		
		
		
			  
			}
			}
			
?>


];




var containerx = document.getElementById('registros');

hot0 = new Handsontable(containerx, {
  data: data1,
  type: 'autocomplete',
  // use HTML in the source list
  allowHtml: true,
  
  source: data1,
  
  allowInsertColumn: false,
  allowRemoveColumn: false,
  allowRemoveRow: false,
  
  editor: false,
  language: 'es-MX',
  
  
  rowHeaders: false,
  colHeaders: inci,
  filters: false,
  //dropdownMenu: ['filter_by_condition', 'filter_by_value', 'filter_action_bar']
});


</script>




	
	
	
	
	
	
	
	
	
	<br>
	
	<hr>
	
	<br>
	
	
	
	
	<input type="button" onclick="window.open('admins.php','_top');" value="Regresar al inicio" >
	
	<br>
	
	
	<br>
	<br>
	<br>
	
	
	
	<?php
	
}
else {
	
	?>
	
	<script>window.open('/cm/loginManager/formLogin.php','loginManager');</script>
	
	<?php
	
}
?>
</body>
</html>

