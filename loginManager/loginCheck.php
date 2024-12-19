<?php
session_start();
ini_set('display_errors', FALSE);

// Verificar que tenemos usuario y contraseña
if (isset($_REQUEST['user']) && isset($_REQUEST['password'])) {
    $user = $_REQUEST['user'];
    $password = $_REQUEST['password'];
    
    // Intentar diferentes variaciones del nombre de archivo
    $variations = [
        $user,
        ucfirst($user),
        strtolower($user),
        strtoupper($user),
        lcfirst($user)
    ];
    
    $found = false;
    foreach ($variations as $variation) {
        $filename = 'users/' . $variation . '.txt';
        
        if (file_exists($filename)) {
            $found = true;
            $gestor = fopen($filename, "r");
            $contenido = fread($gestor, filesize($filename));
            fclose($gestor);
            
            // Verificar contraseña
            if ($contenido === sha1($password)) {
                $_SESSION['super'] = $user;
                header('Location: check.php');
                exit;
            }
            break;
        }
    }
    
    // Si no se encontró el usuario o la contraseña es incorrecta
    $_SESSION['super'] = false;
    session_destroy();
}

header('Location: check.php');
?>
<meta http-equiv="REFRESH" content="0;url=sharer.php?from=check.php">
<script>window.location.href='check.php';</script>