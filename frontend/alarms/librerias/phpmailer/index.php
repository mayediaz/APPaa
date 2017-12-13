<?php
include("class.phpmailer.php");
include("class.smtp.php");

$mail = new PHPMailer();
//$mail->IsSMTP();
//$mail->SMTPAuth = true;
//$mail->SMTPSecure = "ssl";
$mail->Host = "localhost";
$mail->Port = 25;
//$mail->Username = "marcela";
//$mail->Password = "514";
$mail->From = "marcela514@gmail.com";
$mail->FromName = "Marcela";
$mail->Subject = "Prueba";
$mail->MsgHTML("Hola, te doy mi nuevo numero.");
$mail->AddAttachment("files/files.zip");
$mail->AddAttachment("files/img03.jpg");
$mail->AddAddress("lamayediaz@hotmail.com", "Destinatario");
$mail->IsHTML(true);

if(!$mail->Send()) {
    echo "Error: " . $mail->ErrorInfo;
}else {
    echo "Mensaje enviado correctamente";
}
?>