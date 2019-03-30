<?php
require_once __DIR__ . '/../sajanmailer/MailRequest.php';

check('a normal address is valid', isValidRecipient('learn@example.com'));
