<?php
require_once __DIR__ . '/../sajanmailer/Csrf.php';

$session = array();
$token = csrfToken($session);
check('the token is 32 hex characters', preg_match('/^[0-9a-f]{32}$/', $token) === 1);
check('the same session keeps the same token', csrfToken($session) === $token);
check('the right token is accepted', csrfTokenIsValid($session, $token));
check('another token is refused', !csrfTokenIsValid($session, str_repeat('0', 32)));
check('a missing token is refused', !csrfTokenIsValid($session, null));
check('a session without a token refuses everything', !csrfTokenIsValid(array(), 'abc'));
check('the field carries the token', strpos(csrfField($session), $token) !== false);
