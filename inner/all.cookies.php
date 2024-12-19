<?php

//echo var_dump($_COOKIE);

?>

<div id="listaCookies" style="display:;">
	<table>
		<tr>
			<td colspan=3><b><h3 style="margin:0;">Cookies</h3></b></td>
		</tr>
		<tr>
			<td colspan=3><hr></td>
		</tr>
		<tr>
			<td><u>Nombre</u></td><td> </td><td><u>Valor</u></td>
		</tr>
		<tr>
			<td colspan=3><hr></td>
		</tr>
		<script>
		
			var listaCookies = document.cookie.split(';');
			for(var i=0; i < listaCookies.length; i++) {
				var nombre = listaCookies[i].split('=')[0];
				var valor = listaCookies[i].split('=')[1].trim();
				document.write('<tr><td>'+nombre +'</td><td> </td><td>'+valor+'</td></tr>');
			}
	
		</script>
	</table>
</div>
<script>
	window.parent.document.getElementById('listaCookies').innerHTML = document.getElementById('listaCookies').innerHTML;
</script>