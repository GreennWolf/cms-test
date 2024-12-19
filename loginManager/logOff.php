<?PHP
	session_start();
	unset($_SESSION['super']);
	unset($_SESSION);
	session_destroy();
	header('Location: logOffEnd.php');
?>
<meta http-equiv="refresh" content="0;url=logOffEnd.php" />
<script>
	window.parent.location.href	= 'logOffEnd.php';
</script>