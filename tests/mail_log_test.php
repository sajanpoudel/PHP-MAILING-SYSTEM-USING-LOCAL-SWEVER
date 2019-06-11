<?php
require_once __DIR__ . '/../sajanmailer/MailLog.php';

$line = logLine(0, true, "a@b.com", "Hello\nBcc: x@y.com");
check('a log line ends with a newline', substr($line, -1) === "\n");
check('a log line has four columns', count(explode("\t", rtrim($line, "\n"))) === 4);
check('line breaks in the subject are removed', substr_count($line, "\n") === 1);
check('a failure is marked', strpos(logLine(0, false, 'a@b.com', 'Hi'), "\tfailed\t") !== false);

$file = tempnam(sys_get_temp_dir(), 'maillog');
check('the log can be written', writeMailLog($file, 0, true, 'a@b.com', 'One'));
writeMailLog($file, 0, false, 'c@d.com', 'Two');
check('lines are appended', count(file($file)) === 2);
unlink($file);
check('an unwritable path gives false', writeMailLog('/nonexistent-folder/mail.log', 0, true, 'a@b.com', 'x') === false);
