# How the mailer works

1. `index.php` and `home.php` start the session and call `processMailForm()` from `MailController.php` before any HTML is printed.
2. `processMailForm()` checks, in this order: the form fields (`MailRequest.php`), the attachments (`Attachments.php`), the CSRF token (`Csrf.php`) and the pause between mails (`RateLimit.php`).
3. When everything is fine the page's own sender function builds the mail with `createMailer()` (`Mailer.php`) and sends it through Gmail.
4. Every attempt is written to `sajanmailer/sent.log` (`MailLog.php`).
5. A successful send stores a flash message (`Flash.php`) and redirects, so reloading the page does not send the mail again.

The message body is cleaned by `cleanHtmlBody()` before it is sent: only `b`, `strong`, `i`, `em`, `u`, `p`, `br`, `ul`, `ol`, `li` and `a` survive, and scripts, event handlers and `javascript:` links are removed.

## Settings

| Variable | Default |
| --- | --- |
| `MAIL_HOST` | `smtp.gmail.com` |
| `MAIL_PORT` | `587` |
| `MAIL_SECURE` | `tls` |
| `MAIL_FROM_NAME` | `Learn With Sajan` |

## Limits

- Subject up to 150 characters, message up to 6000.
- Attachments up to 5 MB each and 15 MB together. Executables and scripts (`exe`, `bat`, `cmd`, `com`, `scr`, `js`, `vbs`, `jar`, `msi`) are refused.
- One mail every 20 seconds per visitor.
