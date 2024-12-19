<?php

session_start();

if ($_REQUEST['deb']) {
	
	$_SESSION['smtp']['mail'] = $_REQUEST['deb'];
	$_SESSION['smtp']['Message'] =$_REQUEST['deb'];
	$_SESSION['smtp']['Subject'] = 'Pruebas';
}

if (!$_SESSION['smtp']['mail']  || !$_SESSION['smtp']['Message']) {
	
	exit();
	
}


?>

<!--script>window.parent.document.getElementById('bbSubmit').value="Enviando... Espere...";</script-->

<?php

$_REQUEST['Message'] = '

<html><meta charset="UTF-8">


'.$_SESSION['smtp']['Message'].'

<br>
			
</html>';


$_REQUEST['Subject'] = $_SESSION['smtp']['Subject'];


/*
$_REQUEST['Subject'] = $_REQUEST['Subject'].' - Contacto En Linea - aquiTODO admins';
*/





// example on using PHPMailer with GMAIL
if(function_exists('date_default_timezone_set')) {
	date_default_timezone_set('Europe/Madrid');
}

include("class.phpmailer.php");
include("class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

$mail             = new PHPMailer();



$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "cookie21.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port
//$mail->Port       = 587;

$mail->IsSendmail();  // tell the class to use Sendmail

$mailPass = array();
$mailpass[] = array ('u'=>'registro@cookie21.com','p'=>'Rand12%34@2');


$rdn = rand(0,sizeof($mailpass)-1);
$mail_mail = $mailpass[$rdn]['u'];
$mail_pass = $mailpass[$rdn]['p'];



$mail->Username   = $mail_mail;  // GMAIL username
$mail->Password   = $mail_pass;  // GMAIL password



$mail->From       = $mail_mail;
$mail->FromName   = "Cookie21";
$mail->Subject    = $_REQUEST['Subject'];
$mail->WordWrap   = 50; // set word wrap

$body = $_REQUEST['Message'];

//$mail->Body    = $body;
$mail->MsgHTML($body);
//$mail->IsHTML(true);

//$mail->AddReplyTo("world.sport.mollet@gmail.com","World Sport Mollet"); // Direcci�n de Respuesta
//$mail->AddAttachment("foto.jpg", "foto.jpg");

//$mail->AddAttachment("foto.jpg", "foto.jpg");


/*
$Formulari = 'formRecepMail.'.date('YMD');
include('newReceptaPDF.php');
$mail->AddAttachment($url, $Formulari.'.pdf');
*/

//$mail->AddAddress($_REQUEST['eMail'] ,$_REQUEST['name'] );

if ($_SESSION['smtp']['copy']) {
	$mail->AddBCC($_SESSION['smtp']['copy'], 'Empresa');
	
}

// correo adicional para recibir copia
$mail->AddBCC('info@cookie21.com', 'Nuevo Cliente Registrado');

function mailSendedOk() {
	/*
		Todos Los Mensajes Enviados
		<script>window.parent.document.getElementById('Formulario').innerHTML = '<h3 style="color:green;">Mensaje <b>enviado</b>!</h3>'+window.parent.document.getElementById('Formulario').innerHTML;</script>

		<script>window.parent.document.location.href=window.parent.document.location.href+"#formulario";</script>

		<script>window.parent.document.getElementById('formSend').clear();</script>
		<script>window.parent.document.getElementById('bbSubmit').value="Enviar Otro >";</script>
		<script>window.parent.document.getElementById('bbSubmit').disabled="";</script>
	<?php
	*/
	$_SESSION['smtp'] = false;
}

function mailFailed() {
	
	/*
	?>
		<script>window.parent.document.getElementById('Formulario').innerHTML = '<h3 style="color:red;">Mensaje <b>FALLIDO</b>!</h3>'+window.parent.document.getElementById('Formulario').innerHTML;</script>

		<script>window.parent.document.location.href=window.parent.document.location.href+"#formulario";</script>

		<!--script>window.parent.document.getElementById('formSend').clear();</script-->
		<script>window.parent.document.getElementById('bbSubmit').value="Reintentar >";</script>
		<script>window.parent.document.getElementById('bbSubmit').disabled="";</script>
	<?php
	
	*/
}


//$mail_debug = 1;
$mail_debug = false;

if ($email=$_SESSION['smtp']['mail']) {

	if($mail_debug) echo debug('MAIL: '.$email,$HTML=true);

	$mail->AddAddress($email,ucfirst($name));
	if($r = $mail->Send()) {
	
	/*
	?>
	<script>alert('<?php print($r); ?>');</script>
	<?php
	*/
		/*
	?>
	<script>alert('Mensaje enviado por SMTP');</script>
	<?php
	
	*/
		@mailSendedOk();

	}
	else {
		
		if ($_SESSION['smtp']['copy']) {
			$cabeceras = 'From: ' . $mail_mail . "\r\n" .
			'Reply-To: ' . $mail_mail . "\r\n".
			'BCC: ' . $_SESSION['smtp']['copy'] . "\r\n";
			
		} else {
			$cabeceras = 'From: ' . $mail_mail . "\r\n" .
			'Reply-To: ' . $mail_mail . "\r\n";
		}
		
		if ($mmm = @mail($to=$email,$subject=$_REQUEST['Subject'],$message=$_REQUEST['Message'],$cabeceras)) {
		
		?>
		<script>
			alert('Se envió el mail, sin autentificar. Avise a su proveedor.');
		</script>
		
		<?php
			@mailSendedOk();
			
			/*
			?>
			<script>alert('Mensaje enviado por funcion pphp');</script>
			<?php
			*/
		}
		else {
                        
			include('indexMailerAjax.php');
			@mailFailed();
		}
		
	}
}
else {
	if($mail_debug) echo debug('NOT FOUND ANY MAIL',$HTML=true);
	@mailFailed();
}


?>