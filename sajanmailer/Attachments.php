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
