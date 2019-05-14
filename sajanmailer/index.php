<?php
session_start();
require_once 'MailController.php';
require_once 'Flash.php';
require_once 'Csrf.php';

// Builds the mail with PHPMailer and sends it. Returns array(true) or array(false, reason).
function sendFullMail($post, $files)
{
	require_once 'Mailer.php';
	$mail = createMailer($post['email'], $post['subject'], $post['message']);
	$mail->addReplyTo(EMAIL);
	foreach ($files['file']['tmp_name'] as $i => $tmp) {
		if ($files['file']['error'][$i] === UPLOAD_ERR_OK) {
			$mail->addAttachment($tmp, $files['file']['name'][$i]);
		}
	}
	return $mail->send() ? array(true) : array(false, $mail->ErrorInfo);
}

$result = processMailForm($_POST, $_FILES, $_SESSION, 'sendFullMail');
if ($result['sent']) {
	setFlash($_SESSION, 'Message has been sent');
	header('Location: index.php');
	exit;
}
$notice = takeFlash($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Send mail from PHP using SMTP</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
<h1 class="text-center">Sending Emails in PHP from localhost with SMTP</h1>
<h2 class="text-center">Using PHPMailer with attachments</h2>
<hr>
	<?php
		if ($notice !== null) {
			echo '<div class="alert alert-success">' . htmlspecialchars($notice) . '</div>';
		}
		foreach ($result['errors'] as $error) {
			echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
		}
	?>
	<div class="row">
    <div class="col-md-9 col-md-offset-2">
        <form role="form" method="post" enctype="multipart/form-data">
        	<?php echo csrfField($_SESSION); ?>
        	<div class="row">
                <div class="col-sm-9 form-group">
                    <label for="email">To Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" maxlength="50">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9 form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" maxlength="50">
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-9 form-group">
                    <label for="name">Message:</label>
                    <textarea class="form-control" type="textarea" id="message" name="message" placeholder="Your Message Here" maxlength="6000" rows="4"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9 form-group">
                    <label for="name">File:</label>
                    <input name="file[]" multiple="multiple" class="form-control" type="file" id="file">
                </div>
            </div>
             <div class="row">
                <div class="col-sm-9 form-group">
                    <button type="submit" name="sendmail" class="btn btn-lg btn-success btn-block">Send</button>
                </div>
            </div>
        </form>
	</div>
</div>
<p>
Happy Learning</p>
<h3><div>&copy; sajanpoudel</div></h3>
</body>
</html>
