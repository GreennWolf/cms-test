<?php
session_Start();
 
ini_set('display_errors', FALSE);

if (!_SESSION['super']) {

	header('Location: admins.php');
	exit();
}


?>
<title>DEB</title>

<textarea id="c21_dev_log" style="color:red;width:95%;height:400px;">CARGANDO LOG...

</textarea >

<script  src="//cookie21.com/cm/full?token=demo"></script>

<script  src="//cookie21.com/cm/gestor?token=demo"></script>