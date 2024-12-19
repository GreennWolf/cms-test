<?php

if (!$_REQUEST['token']) $_REQUEST['token'] = 'demo';

?>
<html lang="<?php echo $_SESSION['idioma']; ?>">
<head>
<title>Gestor - COOKIE21 CMP</title>


  <meta charset="UTF-8">
  <link rel="stylesheet" href="def.css?<?php echo time(); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<h1>Cookie21 CMP</h1>


<script language="javascript"  type="text/javascript" src="https://cookie21.com/cm/gestor/?token=<?php echo $_REQUEST['token']; ?>"></script>




</body>
</html>
