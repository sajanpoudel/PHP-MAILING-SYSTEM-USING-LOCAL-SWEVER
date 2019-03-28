<?php
// Rules for the files that can be attached to a mail.

const MAX_ATTACHMENT_BYTES = 5242880;
const MAX_TOTAL_ATTACHMENT_BYTES = 15728640;
const BLOCKED_EXTENSIONS = array('exe', 'bat', 'cmd', 'com', 'scr', 'js', 'vbs', 'jar', 'msi');

/** The lower case extension of a file name, or an empty string. */
function attachmentExtension($name)
{
	return strtolower(pathinfo((string) $name, PATHINFO_EXTENSION));
}

/** True for file types that mail providers reject or that are commonly used to spread malware. */
function isBlockedAttachment($name)
{
	return in_array(attachmentExtension($name), BLOCKED_EXTENSIONS, true);
}

/**
 * The problems with the uploaded files in the shape of $_FILES['file'].
 * Entries that were not uploaded (no file chosen) are ignored.
 */
function attachmentErrors(array $files)
{
	$errors = array();
	$total = 0;
	foreach ($files['name'] as $i => $name) {
		if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) {
			continue;
		}
		if ($files['error'][$i] !== UPLOAD_ERR_OK) {
			$errors[] = "$name could not be uploaded.";
			continue;
		}
		if (isBlockedAttachment($name)) {
			$errors[] = "$name has a file type that cannot be sent.";
		}
		if ($files['size'][$i] > MAX_ATTACHMENT_BYTES) {
			$errors[] = "$name is larger than 5 MB.";
		}
		$total += $files['size'][$i];
	}
	if ($total > MAX_TOTAL_ATTACHMENT_BYTES) {
		$errors[] = 'The files together are larger than 15 MB.';
	}
	return $errors;
}
