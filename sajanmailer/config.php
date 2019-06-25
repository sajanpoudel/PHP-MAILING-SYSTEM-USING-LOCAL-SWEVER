<?php
// Settings of the mailer. Environment variables win over the defaults so nothing needs editing on a server.

function mailerSetting($name, $default)
{
	$value = getenv($name);
	return ($value === false || $value === '') ? $default : $value;
}

function mailerConfig()
{
	return array(
		'host' => mailerSetting('MAIL_HOST', 'smtp.gmail.com'),
		'port' => (int) mailerSetting('MAIL_PORT', 587),
		'secure' => mailerSetting('MAIL_SECURE', 'tls'),
		'from_name' => mailerSetting('MAIL_FROM_NAME', 'Learn With Sajan'),
	);
}
