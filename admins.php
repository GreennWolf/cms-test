<?php
// No llamamos a session_start() aquí porque ya se llamó en index.php
ini_set('display_errors', FALSE);

// Asegurarnos de que la variable de sesión existe
if (!isset($_SESSION['super'])) {
    $_SESSION['super'] = false;
}

if ($_POST['user'] && $_POST['password']) {
    $filename = 'users/'.$_POST['user'].'.txt';
    
    // Intentar diferentes variaciones del nombre de archivo
    if (!file_exists($filename)) {
        $filename = 'users/'.ucfirst($_POST['user']).'.txt';
    }
    if (!file_exists($filename)) {
        $filename = 'users/'.strtolower($_POST['user']).'.txt';
    }
    if (!file_exists($filename)) {
        $filename = 'users/'.strtoupper($_POST['user']).'.txt';
    }
    if (!file_exists($filename)) {
        $filename = 'users/'.lcfirst($_POST['user']).'.txt';
    }
    
    if (file_exists($filename)) {
        $gestor = fopen($filename, "r");
        $contenido = fread($gestor, filesize($filename));
        fclose($gestor);
        
        if ($contenido == sha1($_POST['password'])) {
            $_SESSION['super'] = $_POST['user'];
            header('Location: index.php');
            exit;
        }
    }
    
    $_SESSION['super'] = false;
    echo "<script>alert('Usuario o contraseña incorrectos');</script>";
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

// Si no hay POST y no está autenticado, redirigir
if (!$_SESSION['super']) {
    header('Location: index.php');
    exit;
}
?>