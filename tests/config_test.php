<?php
require_once __DIR__ . '/../sajanmailer/config.php';

putenv('MAIL_HOST');
putenv('MAIL_PORT');
$config = mailerConfig();
check('the Gmail host is the default', $config['host'] === 'smtp.gmail.com');
check('the port is a number', $config['port'] === 587);
putenv('MAIL_PORT=2525');
putenv('MAIL_HOST=localhost');
$config = mailerConfig();
check('the environment overrides the host', $config['host'] === 'localhost');
check('the environment overrides the port', $config['port'] === 2525);
putenv('MAIL_HOST');
putenv('MAIL_PORT');
