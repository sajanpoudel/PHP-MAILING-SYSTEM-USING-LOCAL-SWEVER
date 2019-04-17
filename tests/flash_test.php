<?php
require_once __DIR__ . '/../sajanmailer/Flash.php';

$session = array();
check('nothing is stored at first', takeFlash($session) === null);
setFlash($session, 'Message has been sent');
check('the message is returned once', takeFlash($session) === 'Message has been sent');
check('and then it is gone', takeFlash($session) === null);
