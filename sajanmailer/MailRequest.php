<?php
// Checks for the values that come from the mail form. Plain functions, so they are easy to test.

/** True for a plausible recipient address. */
function isValidRecipient($email)
{
    return filter_var(trim((string) $email), FILTER_VALIDATE_EMAIL) !== false;
}

/** True for a subject of 1 to 150 characters without line breaks (they could inject headers). */
function isValidSubject($subject)
{
    $subject = trim((string) $subject);
    return $subject !== '' && strlen($subject) <= 150 && preg_match('/[\r\n]/', $subject) === 0;
}
