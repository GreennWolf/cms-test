<?php
session_Start();
 
ini_set('display_errors', FALSE);

if ($_SESSION['desarrollador']) {
$_SESSION['desarrollador'] = false;

?>
<script>alert('Se ha desactivado el modo desarrollador');</script>
<?php
}
else {
$_SESSION['desarrollador'] = true;
?>
<script>alert('Se ha activado el modo desarrollador. Verá los errores durante esta sesión o hasta que lo descative.');</script>
<?php
}
?>
<script>window.location.href='admins.php';</script>