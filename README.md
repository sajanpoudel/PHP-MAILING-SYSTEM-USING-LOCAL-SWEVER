# PHP-MAILING-SYSTEM-USING-LOCAL-SWEVER

A small PHP mailer that sends email from a local server through Gmail SMTP with PHPMailer. The form takes the recipient, a subject, an HTML message and optional attachments.

## What is in the repo

The project is in `sajanmailer/`. The original `sajanmailer.zip` is kept for reference, but it contains a real `credential.php`, so use the unpacked folder instead.

| File | Purpose |
| --- | --- |
| `index.php` | Full form with multiple file attachments |
| `home.php` | Simple form without attachments |
| `Mailer.php` | `createMailer()` sets up PHPMailer for Gmail SMTP |
| `MailRequest.php` | Checks the recipient, subject and message before anything is sent |
| `credential.example.php` | Template for `credential.php`, which defines `EMAIL` and `PASS` |
| `PHPMailerAutoload.php` | Loads the PHPMailer classes |
| `phpmailer/` | The PHPMailer library |

## Run it locally

1. Copy the `sajanmailer` folder into the web root of a local server such as XAMPP (`htdocs`).
2. Copy `credential.example.php` to `credential.php` and set `EMAIL` to your Gmail address and `PASS` to a Gmail app password. Create the app password in your Google account under Security, 2 Step Verification, App passwords. Do not use your normal account password.
3. Start Apache and open `http://localhost/sajanmailer/`.
4. Fill in the form and press Send. The page reports whether the message was sent.

## Keep your credentials private

`credential.php` is listed in `.gitignore`. Never commit a real password. Use a throwaway app password while testing and revoke it when you are done.

## Troubleshooting

- **Could not authenticate**: check that the app password is correct and that 2 Step Verification is on.
- **Could not connect to SMTP host**: the server must be able to reach `smtp.gmail.com` on port 587.
- **Autoloader cannot find the classes**: the autoloader uses `DIRECTORY_SEPARATOR`, so it works on Windows, Linux and macOS. Check that the `phpmailer/` folder is next to it.

## Tests

The form checks in `MailRequest.php` are plain functions with tests that need nothing but PHP:

```
php tests/run.php
```
