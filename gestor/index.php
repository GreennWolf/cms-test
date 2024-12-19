<?php

@header('Content-Type: application/javascript; charset=utf-8');

session_start();


if (!$_REQUEST['token']) {

	exit('/*NEED A TOKEN*/');

}
?>

//JavaScript Code

var cm21gestor = 'loaded';

<?php

    $db= new SQLite3('../db/consentsdb');
        
	$q = "SELECT * FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
	//$q = "SELECT * FROM clients";
	
	
	
	$resultado = $db->query($q);
	
	$resultados = false;
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
		$fetch = $row;
		
		$resultados = true;
			  
	}
	
	if (!$resultados) {
	
		exit('/*INVALID TOKEN*/');
		
	}
	
	if ($fetch['deshabilitado'] == 'SI') {
	
		exit('/*Deshabilitado*/');
	
	}


?>




if (typeof cm21variables !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {


document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/variables.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
cm21variables = 'loaded';
}

if (typeof cm21head !== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {


document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/head/?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
cm21head = 'loaded';
}

if (typeof cm21proveedores!== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/proveedores.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
cm21proveedores = 'loaded';
}

if (typeof cm21funciones!== 'undefined') { /*CARGADO ANTERIORMENTE*/ } else {

document.write(unescape("%3Cscript src='https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/scripts/funciones.js.php?token=<?php echo $_REQUEST['token']; ?>' type='text/javascript'%3E%3C/script%3E"));
cm21funciones = 'loaded';
}

var c21_precarga = '<img src=https://<?php echo $_SERVER['HTTP_HOST']; ?>/cm/ajax-loader.gif>';

document.write('<div id="listaCookiesGestor">'+c21_precarga+'</div>');

document.write('<div id="c21cm_idiomas_control_gestor" style="z-index:99999999999999999999;position:absolute;"></div>');


let c21_anclaje_gestor = c21_precarga;
	
function c21_actualiza_navegador_gestor() {
	/*
		alert('Comprobando');
		alert(c21_anclaje_gestor);
		alert(document.getElementById("listaCookiesGestor").innerHTML);
	*/
	
		if (document.getElementById("listaCookiesGestor").innerHTML == c21_anclaje_gestor ) {
		
			document.getElementById("listaCookiesGestor").innerHTML = '<br><b>Estamos teniendo dificultades técnicas</b>';
			document.getElementById("listaCookiesGestor").innerHTML += '<br>Parece que su navegador está <b>obsoleto</b>.';
			document.getElementById("listaCookiesGestor").innerHTML += '<br>';
			document.getElementById("listaCookiesGestor").innerHTML += '<br>Si el problema persiste, <b>actualicelo.</b>.';
			document.getElementById("listaCookiesGestor").innerHTML += '<br><br><a href="https://www.google.com/chrome/" target="_blank">Actualizar ahora</a>';
		
		}
	
}



window.addEventListener("load",function(){

	
	if (document.getElementById("c21_dev_log")) { document.getElementById("c21_dev_log").innerHTML += 'GESTOR Cargado'+"\r\n"; }

   	 cookiesExternal();
   	 
	setTimeout("c21_actualiza_navegador_gestor();",19000);
    
},false);

   	 

