<?php
// Checks for the values that come from the mail form. Plain functions, so they are easy to test.

/** True for a plausible recipient address. */
function isValidRecipient($email)
{
    return filter_var(trim((string) $email), FILTER_VALIDATE_EMAIL) !== false;
}
