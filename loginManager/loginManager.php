<?PHP
@session_start();

if (@file_exists('loginManager/loginManager.php'))	$baseurl = 'loginManager/';
else												$baseurl = '';
?>
<html>


<link rel="shortcut icon" type="image/x-icon" href="favicon.png">
<link rel="stylesheet" type="text/css" href="def.css?<?php echo time(); ?>.css">
	<body>
<?php
if (@$_SESSION['super']) {
?>
		<div id="logOpts">
		<?PHP if ($debug=FALSE) { ?>
		
			<a href='<?PHP echo $baseurl; ?>debug.html' target="loginManager"
							class="normalTip" title="Debug process"><img
			src="<?PHP echo $baseurl; ?>openterm.png" border="0" 
			onMouseOver="return escape('Debug process');"></a>
			&nbsp;&nbsp;
		<?PHP } ?>
		
		
		
		
			 
		
		<!--
			<a href='/index.html?<?php echo time();?>' target="_self"
							class="normalTip" title="Go Home"><img
			 src="favicon.png" border="0"  width=22px 
			 onMouseOver="return escape('Go Home');"></a>
			 
			 
		
			&nbsp;&nbsp;
			-->
		
			 
		
		
			<a href='<?PHP echo $baseurl; ?>../?<?php echo time();?>' target="_self"
							class="normalTip" title="Go Home"><img
			 src="<?PHP echo $baseurl; ?>icons/house_2.png" border="0" 
			 onMouseOver="return escape('Go Home');"></a>
			 
			 
		
			&nbsp;&nbsp;
		
		<!--
			<a href='http://192.168.1.109:7080/Osclass-3.6.0/oc-admin/?page=items' target="_blank"
							class="normalTip" title="Go Home"><img
			 src="<?PHP echo $baseurl; ?>icons/add.png" border="0" 
			 onMouseOver="return escape('Go Home');"></a>
		&nbsp;&nbsp;
		
		-->
			<a href='<?PHP echo $baseurl; ?>formRegister.php' 
							class="normalTip" title="Add/Edit users"
			target="loginManager"><img src="<?PHP echo $baseurl; ?>amsn.png"
			border="0" onMouseOver="return escape('Add users');"></a>
		&nbsp;&nbsp;
		
		<!--
			<a href='<?PHP echo $baseurl; ?>formLogin.html' target="loginManager"
							class="normalTip" title="Re-Login"><img 
			src="<?PHP echo $baseurl; ?>encrypted.png"
			border="0" onMouseOver="return escape('Re-Login');"></a>
			
		&nbsp;&nbsp;
			<a href='<?PHP echo $baseurl; ?>../php_explorer.php' target="_top"
							class="normalTip" title="Files Navigation"><img 
			src="<?PHP echo $baseurl; ?>icons/nav.ico"
			border="0"></a>
			-->
			<?php if ($_SERVER['HTTP_HOST'] == 'localhost') { ?>
			<a href='<?PHP echo $baseurl; ?>../admin.php' target="_top"
							class="normalTip" title="ADMIN"><img 
			src="<?PHP echo $baseurl; ?>configure.png"
			border="0" onMouseOver="return escape('ADMIN');"></a>
		&nbsp;&nbsp;
			<?php } ?>
		<!--
		&nbsp;&nbsp;
			<a href='<?PHP echo $baseurl; ?>../zip.php' target="_top" onclick="return confirm('ZIP Sistem?');"
							class="normalTip" title="Make ZIP"><img 
			src="<?PHP echo $baseurl; ?>icons/make_zip.ico"
			border="0"></a>
			
		&nbsp;&nbsp;
			<a href='<?PHP echo $baseurl; ?>../unZip.php' target="_top"
							class="normalTip" title="Un Zip"><img 
			src="<?PHP echo $baseurl; ?>icons/unZip.ico"
			border="0"></a>
			
			-->
		<!--
		&nbsp;&nbsp;
			<a href='<?PHP echo $baseurl; ?>../syncFTP.php' target="_top"
							class="normalTip" title="Sync for FTPs"><img 
			src="<?PHP echo $baseurl; ?>icons/sync.ico"
			border="0"></a>
			-->
	 <!--
			&nbsp;&nbsp;
    <a href='<?PHP echo $baseurl; ?>../camaras/' target="_blank"
							class="normalTip" title="Camaras"><img
     src="<?PHP echo $baseurl; ?>cam.png" border="0"></a>
	
			&nbsp;&nbsp;
    <a onclick='window.open("<?PHP echo $baseurl; ?>../calc.html","_blank","width=400px");' href='<?PHP echo $baseurl; ?>../calc.html' target="_blank"
							class="normalTip" title="Camaras"><img
     src="<?PHP echo $baseurl; ?>icons/calc.png" width="22px" border="0"></a>
	 
			&nbsp;&nbsp;
    <a href='<?PHP echo $baseurl; ?>../chatsessions/' target="_blank"
							class="normalTip" title="Intranet-Chat"><img
     src="<?PHP echo $baseurl; ?>icons/chat.png" border="0"></a>
 -->
<!--
			&nbsp;&nbsp;
    <a href='javascript:window.parent.location.reload();' target="_blank"
							class="normalTip" title="Recargar pagina"><img
     src="<?PHP echo $baseurl; ?>icons/sync.ico" border="0"></a>


			
			
			
		&nbsp;&nbsp;-->
			<!-- LOG OFF - Last Option INDEX-->
			<a href='<?PHP echo $baseurl; ?>logOff.php' target="loginManager"
							class="normalTip" title="Log off"><img 
			src="<?PHP echo $baseurl; ?>exit.png"
			border="0" onMouseOver="return escape('Log off');"></a>
			<!-- LOG OFF - Last Option END-->
		</div>
		<script>
			if (window.parent.location.href!=window.location.href && !window.parent.document.getElementById('framePrincipal').src) {
				document.getElementById('logOpts').style.display="none";
			}
		</script>
<?PHP
 } else {
?>
    <a href='<?PHP echo $baseurl; ?>../' target="_self"
							class="normalTip" title="Go Home"><img
     src="<?PHP echo $baseurl; ?>icons/house_2.png" border="0" 
	 onMouseOver="return escape('Go Home');"></a>
	 
			&nbsp;&nbsp;
    <a href='<?PHP echo $baseurl; ?>formLogin.php' target="loginManager"
							class="normalTip" title="Login"><img
     src="<?PHP echo $baseurl; ?>configure.png" border="0"></a>
<?PHP
}
?>
<iframe id="loginManager" name="loginManager" style="display:none;" src="about:blank"></iframe>
<script>
	function leerCookie(nombre) {
	   a = document.cookie.substring(document.cookie.indexOf(nombre + '=') + nombre.length + 1,document.cookie.length);
	   if(a.indexOf(';') != -1)a = a.substring(0,a.indexOf(';'))
	   return a; 
	}
	
	//alert(leerCookie('display'));
	if ('table' == leerCookie('display')) {
		document.getElementById('loginManager').style.display = '';
	}
	else {
		document.getElementById('loginManager').style.display	=	'none';
	}
</script>
<?php
	if (FALSE) {
?>
<script src="<?PHP echo $baseurl; ?>wz_tooltip_3_45/wz_tooltip.js"></script>
<?php
	}
?>
	</body>
</html>