<script>
    var logUriCheck;
    // Determinar la ruta correcta basada en la ubicación
    if (window.parent.location.href == window.location.href) {
        logUriCheck = 'loginCheck.php';
    } else {
        logUriCheck = 'loginManager/loginCheck.php';
    }
    
    // Crear el formulario
    var source = '<fieldset style="width:300px;"><legend style="color:black;font-weight:bold;">Super Acceso</legend>' +
                '<form name="formLogIn" id="formLogIn" action="' + logUriCheck + '" ' +
                'onSubmit="document.getElementById(\'logSub\').style.display=\'none\';" ' +
                'target="loginManager" enctype="multipart/form-data" method="post">';
    
    source += '<table>' +
              '<tr><td>Usuario: </td><td><input type="text" name="user" id="user" value="" /></td></tr>' +
              '<tr><td>Clave: </td><td><input type="password" name="password" value="" /></td></tr>' +
              '<tr><td colspan=2><input type="submit" name="logSub" value="Entrar" id="logSub" /></td></tr>' +
              '</table>';
    
    source += '</form></fieldset><br><br>';
    
    // Insertar el formulario en la ubicación correcta
    if (window.parent.location.href == window.location.href) {
        document.write(source);
    } else {
        window.parent.document.getElementById('showContents').innerHTML = source;
        window.parent.document.getElementById('user').focus();
    }
</script>