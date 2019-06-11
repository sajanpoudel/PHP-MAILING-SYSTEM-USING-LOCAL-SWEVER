<?php
// A plain text log of the mails that were sent or failed, one line per mail.

/** The text of one log line: time, outcome, recipient and subject. Line breaks are removed. */
function logLine($time, $sent, $recipient, $subject)
{
	$clean = function ($text) {
		return trim(preg_replace('/\s+/', ' ', (string) $text));
	};
	return date('Y-m-d H:i:s', $time) . "\t" . ($sent ? 'sent' : 'failed') . "\t" . $clean($recipient) . "\t" . $clean($subject) . "\n";
}

/** Appends a line to the log file. Returns false when the file cannot be written. */
function writeMailLog($path, $time, $sent, $recipient, $subject)
{
	return @file_put_contents($path, logLine($time, $sent, $recipient, $subject), FILE_APPEND | LOCK_EX) !== false;
}
