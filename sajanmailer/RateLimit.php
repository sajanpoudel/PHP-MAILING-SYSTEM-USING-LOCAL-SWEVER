<?php
// A short pause between two mails from the same visitor.

const MIN_SECONDS_BETWEEN_MAILS = 20;

/** How many seconds the visitor still has to wait. 0 means a mail may be sent now. */
function secondsToWait(array $session, $now, $gap = MIN_SECONDS_BETWEEN_MAILS)
{
	if (!isset($session['last_mail_at'])) {
		return 0;
	}
	return max(0, $session['last_mail_at'] + $gap - $now);
}

/** Remembers when the last mail was sent. */
function noteMailSent(array &$session, $now)
{
	$session['last_mail_at'] = $now;
}
