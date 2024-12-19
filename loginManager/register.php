<?PHP
	session_start();
	
	$filename 	=	'users/'.$_REQUEST['user'].'.txt';
	
	/*
	if (file_exists($filename)) {
		$Source = 'User already exist<br>';
		include_once('formRegister.php');
		exit();
	}
	else
	*/if (!$_SESSION['super']) {
		$Source = 'Only adminis / Solo administradores pueden agregar usuarios<br>';
		include_once('formLogin.html');
		exit();
	}
	
	else {
		$gestor 	=	fopen($filename, "w");
		fwrite($gestor,sha1($_REQUEST['password']));
		fclose($gestor);
		$Source = 'User added, add more?';
		include_once('formRegister.php');
		exit();
	}
?>