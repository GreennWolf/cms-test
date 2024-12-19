<?php
// Solo llamamos a session_start() una vez al inicio
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializar las variables de sesión si no existen
if (!isset($_SESSION['super'])) {
    $_SESSION['super'] = false;
}
if (!isset($_SESSION['desarrollador'])) {
    $_SESSION['desarrollador'] = false;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
 
ini_set('display_errors', FALSE);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consent Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="def.css?<?php echo time(); ?>">
</head>
<body>

<?php include_once('idiomas.banner.php'); ?>
<?php include_once('userstatus.php'); ?>

<?php if ($_SESSION['super']): ?>
    <h1>Bienvenido</h1>
    
    <h2>Altas y Gestiones</h2>
    
    <input type="button" onclick="window.open('registros.php','_top');" value="Ver Todos los registros">
    <input type="button" onclick="window.open('nuevo.php','_top');" value="Nuevo registro">
    
    <br><br><br><br><br>
    
    <h2>Configuraciones del programario</h2>
    
    <hr><br>
    
    <input type="button" onclick="window.open('codigo.php','codigo');" value="Ver código de instalación">
    <input type="button" onclick="window.open('example.php','ejemplo');" value="Ver ejemplo del banner">
    <input type="button" onclick="window.open('gestor.example.php','ejemplo-gestor');" value="Ver ejemplo del gestor">
    <input type="button" onclick="window.open('mix.example.php','ejemplo-mix');" value="Ver ejemplo mixto">
    
    <br><hr><br>
    
    <input type="button" onclick="window.open('idiomas.php','_blank');" value="Gestor de idiomas">
    <!--input type="button" onclick="window.open('cookies.php','_blank');" value="Gestor de cookies" -->
    <input type="button" onclick="window.open('importador.php','_self');" value="Importar Socios Proveedores de IAB">
    <input type="button" onclick="window.open('google-import.php','_self');" value="Importar Socios Proveedores de Google">
    <input type="button" onclick="window.open('install.php','_self');" value="Instalar base de datos">
    <input type="button" onclick="window.open('eXt','_blank');" value="Gestor de archivos">
    <input type="button" onclick="window.open('phpLiteAdmin','_blank');" value="Gestor DB">
    <input type="button" onclick="window.open('collect.php','_blank');" value="Collect">
    <input type="button" onclick="window.open('php_explorer.php','_blank');" value="PHP_Explorer">
    <input type="button" onclick="window.open('pruebas.php','pruebas');" value="Desarrollar pruebas">
    <input type="button" onclick="window.open('desarrollador.php','_top');" 
           value="<?php echo $_SESSION['desarrollador'] ? 'Desactivar' : 'Activar'; ?> vista de errores">
    
    <br><hr><br>
    
    <?php 
    $_SESSION['key'] = sha1(time());
    ?>
    
    <input type="button" 
           onclick="if(confirm('Perderá todos los clientes.')) { if(confirm('Seguro?')) { window.open('reset.php?key=<?php echo $_SESSION['key']; ?>','_TOP'); }}" 
           value="Reset" 
           style="background-color:red;color:white;font-weight:bold;">
    
    <br><br><br>

<?php else: ?>
    <script>window.open('/cm/loginManager/formLogin.php','loginManager');</script>
    
    <br><hr><br>
    
    <input type="button" onclick="window.open('index.php','_self');" value="Acceso clientes">
    
    <br>
<?php endif; ?>

</body>
</html>