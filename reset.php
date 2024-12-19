<?php
session_Start();
 
ini_set('display_errors', FALSE);

if (!$_SESSION['super']) { exit(); }


if ($_SESSION['key'] == $_REQUEST['key'] && $_REQUEST['key']) {  }
else { exit('Inavalid key'); }


unlink('db/consentsdb');
unlink('db/accesosdb');

?>

<script>

window.parent.location.href='install.php';

</script>