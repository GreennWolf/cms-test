<?php
// No llamamos a session_start() aquí porque ya se llamó en index.php
?>
<h3>
<?php
if (isset($_SESSION['super']) && $_SESSION['super']) { 
    echo 'SuperUsuario: ' . $_SESSION['super']; 
} else {
    echo 'Acceso super usuarios';
}
?>
</h3>

<?php
include_once('loginManager/loginManager.php');
?>

<div id='showContents'></div>
<br><br>