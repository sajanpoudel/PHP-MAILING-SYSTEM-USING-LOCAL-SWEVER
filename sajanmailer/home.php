<?php
session_start();
require_once 'MailController.php';
require_once 'Flash.php';
require_once 'Csrf.php';
require_once 'RateLimit.php';

// Builds the mail with PHPMailer and sends it. Returns array(true) or array(false, reason).
function sendSimpleMail($post, $files)
{
	require_once 'Mailer.php';
	$mail = createMailer($post['email'], $post['subject'], $post['message']);
	return $mail->send() ? array(true) : array(false, $mail->ErrorInfo);
}

$result = processMailForm($_POST, $_FILES, $_SESSION, 'sendSimpleMail');
if ($result['sent']) {
	noteMailSent($_SESSION, time());
	setFlash($_SESSION, 'Message has been sent');
	header('Location: home.php');
	exit;
}
$notice = takeFlash($_SESSION);
?>
<!DOCTYPE html>
<html>
<body>
	<?php
	if ($notice !== null) {
		echo '<p style="color:#2e7d32">' . htmlspecialchars($notice) . '</p>';
	}
	foreach ($result['errors'] as $error) {
		echo '<p style="color:#b00020">' . htmlspecialchars($error) . '</p>';
	}
	?>
    <form role="form" method="post" enctype="multipart/form-data">
    <?php echo csrfField($_SESSION); ?>
     <label for="email">To Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" maxlength="50">
     <label for="subject">Subject:</label>
    <input type="text"  id="subject" name="subject" placeholder="Enter subject" maxlength="50">
     <label for="name">Message:</label>
    <textarea  type="textarea" id="message" name="message" placeholder="Your Message Here" maxlength="6000" rows="4"></textarea>
     <button type="submit" name="sendmail">Send</button>
     </form>
<p>Happy Learning</p>
<h3><div>&copy; sajanpoudel</div></h3>
</body>
</html>
