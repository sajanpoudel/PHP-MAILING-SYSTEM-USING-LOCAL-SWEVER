<?php
// The steps behind the mail form, kept apart from the page so they can be tested without a mail server.

require_once __DIR__ . '/MailRequest.php';
require_once __DIR__ . '/Csrf.php';
require_once __DIR__ . '/Attachments.php';
require_once __DIR__ . '/RateLimit.php';
require_once __DIR__ . '/MailLog.php';

/**
 * Handles one submitted form.
 *
 * $sender is called as $sender($post, $files) once the form is valid and must return
 * array(true) or array(false, 'reason'). The result has the keys 'errors' (list of
 * messages), 'sent' (bool) and 'submitted' (bool). $now is the current time and only
 * needs to be given in tests. When $logPath is given every attempt is written to that file.
 */
function processMailForm(array $post, array $files, array $session, callable $sender, $now = null, $logPath = null)
{
	$now = $now === null ? time() : $now;
	$result = array('errors' => array(), 'sent' => false, 'submitted' => isset($post['sendmail']));
	if (!$result['submitted']) {
		return $result;
	}

	$errors = mailRequestErrors($post);
	if (isset($files['file'])) {
		$errors = array_merge($errors, attachmentErrors($files['file']));
	}
	if (!csrfTokenIsValid($session, isset($post['csrf_token']) ? $post['csrf_token'] : null)) {
		$errors[] = 'The form has expired. Reload the page and try again.';
	}
	$wait = secondsToWait($session, $now);
	if ($wait > 0) {
		$errors[] = "Please wait $wait seconds before sending another mail.";
	}
	if ($errors) {
		$result['errors'] = $errors;
		return $result;
	}

	$outcome = $sender($post, $files);
	if ($logPath !== null) {
		writeMailLog($logPath, $now, (bool) $outcome[0], $post['email'], $post['subject']);
	}
	if ($outcome[0]) {
		$result['sent'] = true;
	} else {
		$result['errors'][] = 'Message could not be sent. ' . (isset($outcome[1]) ? $outcome[1] : '');
	}
	return $result;
}
