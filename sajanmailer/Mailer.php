<?php
// Builds a PHPMailer that is already set up for Gmail SMTP. Both pages use it.

require_once __DIR__ . '/PHPMailerAutoload.php';
require_once __DIR__ . '/credential.php';
require_once __DIR__ . '/HtmlBody.php';
require_once __DIR__ . '/config.php';

function createMailer($recipient, $subject, $htmlBody)
{
	$config = mailerConfig();
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = $config['host'];
	$mail->SMTPAuth = true;
	$mail->Username = EMAIL;
	$mail->Password = PASS;
	$mail->SMTPSecure = $config['secure'];
	$mail->Port = $config['port'];

	$mail->setFrom(EMAIL, $config['from_name']);
	$mail->addAddress(trim($recipient));
	$mail->isHTML(true);
	$mail->Subject = trim($subject);
	$mail->Body = cleanHtmlBody($htmlBody);
	$mail->AltBody = plainTextBody($mail->Body);
	return $mail;
}
