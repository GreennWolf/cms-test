<?php
session_start();
 
ini_set('display_errors', FALSE);



if ($_SESSION['super']) { 

	$_SESSION['token'] = $_REQUEST['token'];
	//echo 'Logged'.$_SESSION['token'];
}
else if ($_SESSION['token']) { $_REQUEST['token'] = $_SESSION['token']; }
else { exit(header('Location: index.php')); }

include_once('funciones.php');



if(!function_exists('ereg'))            { function ereg($pattern, $subject, &$matches = array()) { return preg_match('/'.$pattern.'/', $subject, $matches); } }
if(!function_exists('eregi'))           { function eregi($pattern, $subject, &$matches = array()) { return preg_match('/'.$pattern.'/i', $subject, $matches); } }
if(!function_exists('ereg_replace'))    { function ereg_replace($pattern, $replacement, $string) { return preg_replace('/'.$pattern.'/', $replacement, $string); } }
if(!function_exists('eregi_replace'))   { function eregi_replace($pattern, $replacement, $string) { return preg_replace('/'.$pattern.'/i', $replacement, $string); } }
if(!function_exists('split'))           { function split($pattern, $subject, $limit = -1) { return preg_split('/'.$pattern.'/', $subject, $limit); } }
if(!function_exists('spliti'))          { function spliti($pattern, $subject, $limit = -1) { return preg_split('/'.$pattern.'/i', $subject, $limit); } }









function addproviders($token,$iabid=false,$googleid=false) {

	if (!$token || (!$iabid && !$googleid)) {
	
		return false;
		
	}
	
	
    	$db = new SQLite3('db/tercerosdb');
    	
	if($iabid) { $q = "INSERT INTO terceros (token, iabid) VALUES ('".$token."','".$iabid."')"; }
	
	if($googleid) { $q = "INSERT INTO terceros (token, googleid) VALUES ('".$token."','".$googleid."')"; }
			    
	$resultado = $db->exec($q);
    	

}








function deleteProviders($token,$iabid=false,$googleid=false) {

	if (!$token || (!$iabid && !$googleid)) {
	
		return false;
		
	}
	
	
    	$db = new SQLite3('db/tercerosdb');
    	
	if($iabid) { $q = "DELETE FROM terceros WHERE token LIKE '".$token."' AND iabid LIKE '".$iabid."'"; }
	
	if($googleid) { $q = "DELETE FROM terceros WHERE token LIKE '".$token."' AND googleid LIKE '".$googleid."'"; }
			    
	$resultado = $db->exec($q);
    	

}
























$dbt = new SQLite3('db/tercerosdb');
   

if (ereg('iab_',$_REQUEST['id'])) {

	$iab = str_replace('iab_','',$_REQUEST['id']);
 	
	$q = "SELECT * FROM terceros WHERE token LIKE '".$_REQUEST['token']."' AND iabid LIKE '".$iab."' ";

/*
?>

	<script>
	
	
	alert('DEB: IAB');
	
	</script>
	
<?php
*/

} else if (ereg('google_',$_REQUEST['id'])) { 

	$google = str_replace('google_','',$_REQUEST['id']);
 	
	$q = "SELECT * FROM terceros WHERE token LIKE '".$_REQUEST['token']."' AND googleid LIKE '".$google."' ";


/*
?>

	<script>
	
	
	alert('DEB: Google');
	
	</script>
	
<?php
*/


} else {

?>

	<script>
	
	
	alert('Error del sistema, por favor, contacte con el administrador.');
	
	</script>
	
	
<?php

}



/*
?>

	<script>
	
	
	alert('<?php echo str_replace("'","\'",$q); ?>');
	
	</script>
	
	
<?php
*/





$resultado = $dbt->query($q);




$fetch = false;
while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
						
	$fetch[] = $row;
					  
}

if ($fetch) {





/*
?>

<script>


alert('Valor existente, se debe eliminar. ');

</script>

<?php
*/


	if ($iab) {
	
		deleteProviders($token=$_REQUEST['token'],$iabid=$iab,$googleid=false);

	} else if ($google) {
	
		deleteProviders($token=$_REQUEST['token'],$iabid=false,$googleid=$google);
	
	
	}




} else {


/*
?>



<script>


alert('Valor inexistente, se debe añadir. ');

</script>

<?php
*/

	if ($iab) {
	
		addproviders($token=$_REQUEST['token'],$iabid=$iab,$googleid=false);

	} else if ($google) {
	
		addproviders($token=$_REQUEST['token'],$iabid=false,$googleid=$google);
	
	
	}

}

/*
sleep(5);
*/


?>

<script>

window.top.document.getElementById('<?php echo $_REQUEST['id']; ?>').disabled='';

window.top.document.getElementById('block').style.display='none';


</script>