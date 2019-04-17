<?php
// One message that survives a redirect and is shown once.

/** Stores a message for the next page view. */
function setFlash(array &$session, $message)
{
	$session['flash'] = (string) $message;
}

/** Returns the stored message and forgets it. Null when there is none. */
function takeFlash(array &$session)
{
	if (!isset($session['flash'])) {
		return null;
	}
	$message = $session['flash'];
	unset($session['flash']);
	return $message;
}
