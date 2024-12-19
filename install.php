<?php

session_start();
ini_set('display_errors', FALSE);
if (!$_SESSION['super']) { exit(header('Location: admins.php')); }


	
        
    $db = new SQLite3('db/consentsdb');
	$q = 'CREATE TABLE IF NOT EXISTS consents (token TEXT, ctime TEXT, mail TEXT, dominio TEXT, gads TEXT)';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD CIF TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD gtag TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD clave TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD analytics TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD color TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD background TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD link TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD script TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD position TEXT;';
	$db->exec($q);
	
	
	$q = 'ALTER TABLE consents
		ADD vertical TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD zoom TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD contrast TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD nombre TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD altura TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD enlace TEXT;';
	
	$db->exec($q);
		
	
	$q = 'ALTER TABLE consents
		ADD hiddenid TEXT;';
	
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD cross TEXT;';
		
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD deshabilitado TEXT;';
		
	$db->exec($q);
	
	$q = 'ALTER TABLE consents
		ADD notis TEXT;';
		
	$db->exec($q);
	
	
	
	
    $db = new SQLite3('db/accesosdb');
	$q = 'CREATE TABLE IF NOT EXISTS accesos (token TEXT, ctime TEXT, referrer TEXT, browser TEXT)';
	$db->exec($q);
	
	$q = 'ALTER TABLE accesos
		ADD estado TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE accesos
		ADD client TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE accesos
		ADD ip TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE accesos
		ADD session TEXT;';
	$db->exec($q);
	
	
    $db = new SQLite3('db/cookiesdb');
	$q = 'CREATE TABLE IF NOT EXISTS cookies (nombre TEXT, proveedor TEXT, enlace TEXT, duracion TEXT)';
	$db->exec($q);
	
	$q = 'ALTER TABLE cookies
		ADD info TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE cookies
		ADD idioma TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE cookies
		ADD prioridad TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE cookies
		ADD tipo TEXT;';
	$db->exec($q);
	
	
    $db = new SQLite3('db/idiomasdb');
	$q = 'CREATE TABLE IF NOT EXISTS idiomas (idioma TEXT)';
	
	$db->exec($q);
	
	$q = 'ALTER TABLE idiomas 
		ADD estado TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE idiomas 
		ADD cabeceras TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE idiomas 
		ADD predeterminado TEXT;';
	$db->exec($q);
	
	
	
    $db = new SQLite3('db/idiomadb');
	$q = 'CREATE TABLE IF NOT EXISTS idioma (idioma TEXT, id TEXT, tipo TEXT, valor TEXT)';
	$db->exec($q);
	
	
	
    $db = new SQLite3('db/proveedoresiabdb');
	$q = 'CREATE TABLE IF NOT EXISTS proveedoresiab (id TEXT, nombre TEXT, url TEXT, subdominios TEXT)';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD idioma TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD vendorListVersion TEXT;';
	$db->exec($q);
	
	
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD propositos TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD fullurls TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD scandomain TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD flexiblePurposes TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD specialPurposes TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD features TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD specialFeatures TEXT;';
	$db->exec($q);
	
	$q = 'ALTER TABLE proveedoresiab 
		ADD funcion TEXT;';
	$db->exec($q);
	
	
	
	
    $db = new SQLite3('db/tercerosdb');
	$q = 'CREATE TABLE IF NOT EXISTS terceros (token TEXT, iabid TEXT, googleid TEXT)';
	$db->exec($q);
	
	$q = 'ALTER TABLE terceros 
		ADD manual TEXT;';
	$db->exec($q);
	
	
	
	
    $db = new SQLite3('db/proveedoresgoogledb');
	$q = 'CREATE TABLE IF NOT EXISTS proveedoresgoogle (id TEXT, nombre TEXT, url TEXT, subdominios TEXT)';
	$db->exec($q);
	
?>
<script>

alert('Base de datos instalada correctamente.');
window.location.href="admins.php";

</script>