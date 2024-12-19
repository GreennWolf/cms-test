<?php
session_Start();
 
ini_set('display_errors', FALSE);

if ($_SESSION['super'] && $_REQUEST['token2'] && $_REQUEST['token2'] == $_SESSION['token2']) { /*ok*/ }
else { exit(header('Location: index.php')); }


		
		
		
		
    $db = new SQLite3('db/consentsdb');
    $q = "DELETE FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
    $db->exec($q);
    
    ?>
    
    <script>
    	window.parent.location.href='registros.php';
    </script>