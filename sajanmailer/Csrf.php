<?php
// A one time token that proves a form was served by this site. It is kept in the session.

/** The token for the current session, created on first use. */
function csrfToken(array &$session)
{
	if (empty($session['csrf_token'])) {
		$session['csrf_token'] = bin2hex(random_bytes(16));
	}
	return $session['csrf_token'];
}

/** True when $submitted is the token of this session. */
function csrfTokenIsValid(array $session, $submitted)
{
	return isset($session['csrf_token'])
		&& is_string($submitted)
		&& hash_equals($session['csrf_token'], $submitted);
}

/** The hidden input to place inside a form. */
function csrfField(array &$session)
{
	return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken($session)) . '">';
}
