<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
	<?php 
	require_once 'MailRequest.php';
	require_once 'Csrf.php';
	$errors = isset($_POST['sendmail']) ? mailRequestErrors($_POST) : array();
	if (isset($_POST['sendmail']) && !csrfTokenIsValid($_SESSION, isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null)) {
		$errors[] = 'The form has expired. Reload the page and try again.';
	}
	foreach ($errors as $error) {
		echo '<p style="color:#b00020">' . htmlspecialchars($error) . '</p>';
	}
	if(isset($_POST['sendmail']) && !$errors) {
	require_once 'Mailer.php';
	$mail = createMailer($_POST['email'], $_POST['subject'], $_POST['message']);
		if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
	      echo 'Message has been sent';
		}
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
