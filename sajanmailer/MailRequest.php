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

/** True for a message of 1 to 6000 characters. */
function isValidMessage($message)
{
    $message = trim((string) $message);
    return $message !== '' && strlen($message) <= 6000;
}

/** The problems of a mail form as a list of messages. Empty when the form can be sent. */
function mailRequestErrors(array $form)
{
    $errors = [];
    if (!isValidRecipient($form['email'] ?? '')) {
        $errors[] = 'Enter a valid recipient address.';
    }
    if (!isValidSubject($form['subject'] ?? '')) {
        $errors[] = 'Enter a subject of up to 150 characters.';
    }
    if (!isValidMessage($form['message'] ?? '')) {
        $errors[] = 'Enter a message of up to 6000 characters.';
    }
    return $errors;
}
