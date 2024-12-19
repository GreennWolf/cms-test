<?php

exit();

exit('Por una mejora continua de la privacidad de nustros usuario, anulamos la trazabilidad.');





session_start();

if (!$_COOKIE['client']) $_COOKIE['client'] = sha1($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
	
if (!$_COOKIE['unique']) $_COOKIE['unique'] = sha1(session_id().$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
	

    $db= new SQLite3('../db/consentsdb');
        
	$q = "SELECT token FROM consents WHERE token LIKE '".$_REQUEST['token']."'";
	//$q = "SELECT * FROM clients";
	
	
	
	$resultado = $db->query($q);
	
	while ($row = $resultado->fetchArray(SQLITE3_ASSOC)) {
				
		$fetch = $row;
			  
	}
	
	if (!$fetch['token'])  exit('');

    		$db2= new SQLite3('../db/accesosdb');
    		
    		if ($_REQUEST['default']) {
    			if ($_REQUEST['consent'] == 4) $_REQUEST['consent'] = 'LOAD DEFAULTS: SOME';
    			if ($_REQUEST['consent'] == 3) $_REQUEST['consent'] = 'LOAD DEFAULTS: NECESSARY';
    			if ($_REQUEST['consent'] == 1) $_REQUEST['consent'] = 'LOAD DEFAULTS: STATS';
    			if ($_REQUEST['consent'] == 2) $_REQUEST['consent'] = 'LOAD DEFAULTS: ALL';
    		}
    		elseif ($_REQUEST['load']) {
    			if ($_REQUEST['consent'] == 4) $_REQUEST['consent'] = 'PRELOADED: SOME';
    			if ($_REQUEST['consent'] == 3) $_REQUEST['consent'] = 'PRELOADED: NECESSARY';
    			if ($_REQUEST['consent'] == 1) $_REQUEST['consent'] = 'PRELOADED: STATS';
    			if ($_REQUEST['consent'] == 2) $_REQUEST['consent'] = 'PRELOADED: ALL';
    		}
    		else {
    			if ($_REQUEST['consent'] == 4) $_REQUEST['consent'] = 'ACTION: SOME';
    			if ($_REQUEST['consent'] == 3) $_REQUEST['consent'] = 'ACTION: NECESSARY';
    			if ($_REQUEST['consent'] == 1) $_REQUEST['consent'] = 'ACTION: STATS';
    			if ($_REQUEST['consent'] == 2) $_REQUEST['consent'] = 'ACTION: ALL';
    		}
        
	
		$q = "INSERT INTO accesos (token, ctime, referrer, browser, estado, client, ip, session) VALUES ('".$_REQUEST['token']."', '".time()."', '".$_REQUEST['referrer']."', '".$_SERVER['HTTP_USER_AGENT']."' , '".$_REQUEST['consent']."', '".$_COOKIE['client']."', '".$_SERVER['REMOTE_ADDR']."', '".$_COOKIE['unique']."' )";
		$resultado = $db2->exec($q);
		
	