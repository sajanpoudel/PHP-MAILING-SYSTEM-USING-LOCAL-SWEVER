<?php
require_once __DIR__ . '/../sajanmailer/MailRequest.php';

check('a normal address is valid', isValidRecipient('learn@example.com'));
check('surrounding spaces are ignored', isValidRecipient('  learn@example.com '));
check('broken addresses are rejected', !isValidRecipient('') && !isValidRecipient('learn') && !isValidRecipient('a@') && !isValidRecipient('@b.com'));
check('header injection is rejected', !isValidRecipient("a@b.com\nBcc: x@y.com"));
check('a short subject is valid', isValidSubject('Weekly notes'));
check('an empty subject is invalid', !isValidSubject('') && !isValidSubject('   '));
check('a subject with a line break is invalid', !isValidSubject("Hi\nBcc: x@y.com"));
