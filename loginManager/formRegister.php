<?PHP
if (!$Source) {
	$Source	=	'Add/Edit user<br>';
}
?>
<script>
	var source;
	source = '<?PHP echo $Source;	?><form action="loginManager/register.php" target="loginManager" enctype="multipart/form-data" method="post">';
	source += 'User: <input type="text" name="user" value="" /><br />';
	source += 'Pass: <input type="password" name="password" value="" /><br />';
	source += '<input type="submit" name="submit" value="Editar / Registrar" />';
	source += '</form>';
	window.parent.document.getElementById('showContents').innerHTML = source;
</script>