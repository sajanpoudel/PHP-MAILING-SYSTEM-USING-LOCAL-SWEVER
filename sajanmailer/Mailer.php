<?php
// Builds a PHPMailer that is already set up for Gmail SMTP. Both pages use it.

require_once __DIR__ . '/PHPMailerAutoload.php';
require_once __DIR__ . '/credential.php';
require_once __DIR__ . '/HtmlBody.php';

function createMailer($recipient, $subject, $htmlBody)
{
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = EMAIL;
	$mail->Password = PASS;
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;

	$mail->setFrom(EMAIL, 'Learn With Sajan');
	$mail->addAddress(trim($recipient));
	$mail->isHTML(true);
	$mail->Subject = trim($subject);
	$mail->Body = cleanHtmlBody($htmlBody);
	$mail->AltBody = plainTextBody($mail->Body);
	return $mail;
}
