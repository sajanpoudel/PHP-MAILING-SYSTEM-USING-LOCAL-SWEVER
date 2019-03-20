 <!DOCTYPE html>
<html>
<body>
	<?php 
	if(isset($_POST['sendmail'])) {
	require 'PHPMailerAutoload.php';
	require 'credential.php';
	$mail = new PHPMailer;
	// $mail->SMTPDebug = 4;                            
	$mail->isSMTP();                                      
	$mail->Host = 'smtp.gmail.com';  
	$mail->SMTPAuth = true;                               
	$mail->Username = EMAIL;                
	$mail->Password = PASS;                           
	$mail->SMTPSecure = 'tls';                            
	$mail->Port = 587;                                    
	$mail->setFrom(EMAIL, 'Learn With Sajan');
	$mail->addAddress($_POST['email']);     
	$mail->isHTML(true);                               
	$mail->Subject = $_POST['subject'];
	$mail->Body    = $_POST['message'];
		if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
	      echo 'Message has been sent';
		}
		}
	 ?>
    <form role="form" method="post" enctype="multipart/form-data">
     <label for="email">To Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" maxlength="50">
     <label for="subject">Subject:</label>
    <input type="text"  id="subject" name="subject" placeholder="Enter subject" maxlength="50">
     <label for="name">Message:</label>
    <textarea  type="textarea" id="message" name="message" placeholder="Your Message Here" " rows="4"></textarea>
     <button type="submit" name="sendmail">Send</button>
     </form>
Happy Learning</p>
<h3><div>&copy; sajanpoudel</div></h3>
</body>
</html>
