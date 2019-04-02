<?php
require_once __DIR__ . '/../sajanmailer/MailRequest.php';

check('a normal address is valid', isValidRecipient('learn@example.com'));
check('surrounding spaces are ignored', isValidRecipient('  learn@example.com '));
check('broken addresses are rejected', !isValidRecipient('') && !isValidRecipient('learn') && !isValidRecipient('a@') && !isValidRecipient('@b.com'));
