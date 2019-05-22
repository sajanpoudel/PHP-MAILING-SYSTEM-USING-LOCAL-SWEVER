<?php
require_once __DIR__ . '/../sajanmailer/RateLimit.php';

$session = array();
check('the first mail needs no wait', secondsToWait($session, 1000) === 0);
noteMailSent($session, 1000);
check('right after a mail the full pause applies', secondsToWait($session, 1000) === MIN_SECONDS_BETWEEN_MAILS);
check('the wait shrinks with time', secondsToWait($session, 1015) === 5);
check('after the pause there is no wait', secondsToWait($session, 1020) === 0);
check('a custom gap is honoured', secondsToWait($session, 1001, 3) === 2);
