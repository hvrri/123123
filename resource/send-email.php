<?php
require 'class.phpmailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Host = "smtp.mandrillapp.com";
$mail->IsHTML(true);

$mail->SMTPAuth = true;
$mail->Username = "Kivat Pelit";
$mail->Password = "EEDY6BycZMMaYy1SSwYqkQ";

//Sender Info
$mail->From = "test@testidomain.xyz";
$mail->FromName = "Oppipuoti";