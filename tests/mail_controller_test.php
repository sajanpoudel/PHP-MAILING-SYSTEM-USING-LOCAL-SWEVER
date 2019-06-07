<?php
require_once __DIR__ . '/../sajanmailer/MailController.php';

$session = array('csrf_token' => 'abc');
$good = array('sendmail' => '1', 'csrf_token' => 'abc', 'email' => 'a@b.com', 'subject' => 'Hi', 'message' => 'Hello');
$ok = function () { return array(true); };
$fails = function () { return array(false, 'SMTP down'); };

$r = processMailForm(array(), array(), $session, $ok);
check('an unsubmitted form does nothing', !$r['submitted'] && !$r['sent'] && $r['errors'] === array());

$r = processMailForm($good, array(), $session, $ok);
check('a good form is sent', $r['sent'] && $r['errors'] === array());

$r = processMailForm(array_merge($good, array('email' => 'nope')), array(), $session, $ok);
check('a bad address blocks the send', !$r['sent'] && count($r['errors']) === 1);

$r = processMailForm(array_merge($good, array('csrf_token' => 'x')), array(), $session, $ok);
check('a wrong token blocks the send', !$r['sent'] && strpos($r['errors'][0], 'expired') !== false);

$r = processMailForm($good, array(), $session, $fails);
check('a sender failure is reported', !$r['sent'] && strpos($r['errors'][0], 'SMTP down') !== false);

$called = false;
processMailForm(array_merge($good, array('subject' => '')), array(), $session, function () use (&$called) { $called = true; return array(true); });
check('the sender is not called for an invalid form', $called === false);

$busy = array('csrf_token' => 'abc', 'last_mail_at' => 1000);
$r = processMailForm($good, array(), $busy, $ok, 1005);
check('a second mail within the pause is refused', !$r['sent'] && strpos($r['errors'][0], 'wait 15 seconds') !== false);
$r = processMailForm($good, array(), $busy, $ok, 1100);
check('a mail after the pause is sent', $r['sent']);
