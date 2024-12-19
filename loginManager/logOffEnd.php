<?PHP
	@session_start();
?>
<script>
	if (window.parent.location.href	== window.location.href) {
		window.parent.location.href	=	'../';
	}
	else {
		window.parent.location.reload();
	}
</script>