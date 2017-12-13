<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

require_once('../class.phpmailer.php');

$mail             = new PHPMailer();

//$body             = file_get_contents('contents.html');
//$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "mail.infomediaservice.com"; // SMTP server
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
$mail->Host       = "mail.infomediaservice.com";      // sets as the SMTP server
$mail->Port       = 25;                   // set the SMTP port for the server
$mail->Username   = "marcela.diaz@infomediaservice.com";  // username
$mail->Password   = "tetra912";            // password

$mail->SetFrom('marcela.diaz@infomediaservice.com', 'Marcela Diaz');

$mail->AddReplyTo('marcela.diaz@infomediaservice.com', 'Marcela Diaz');

$mail->Subject    = "Correo desde Php";

$mail->MsgHTML("Hola, por fin pude enviar correos. Att: Marcela");

$address = "juan.beltran@infomediaservice.com";
$mail->AddAddress($address, "Juan Beltran");
$mail->AddCC("marcela.diaz@infomediaservice.com","Marcela Diaz");
$mail->AddAttachment("images/phpmailer.gif");      // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>