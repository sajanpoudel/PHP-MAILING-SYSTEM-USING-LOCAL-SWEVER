# PHP-MAILING-SYSTEM-USING-LOCAL-SWEVER

A small PHP mailer that sends email from a local server through Gmail SMTP with PHPMailer. The form takes the recipient, a subject, an HTML message and optional attachments.

## What is in the repo

`sajanmailer.zip` contains the project:

| File | Purpose |
| --- | --- |
| `index.php` | Full form with multiple file attachments |
| `home.php` | Simple form without attachments |
| `credential.php` | Defines the `EMAIL` and `PASS` constants used to sign in to SMTP |
| `PHPMailerAutoload.php` | Loads the PHPMailer classes |
| `phpmailer/` | The PHPMailer library |

## Run it locally

1. Unzip `sajanmailer.zip` into the web root of a local server such as XAMPP (`htdocs`).
2. Edit `credential.php` and set `EMAIL` to your Gmail address and `PASS` to a Gmail app password. Create the app password in your Google account under Security, 2 Step Verification, App passwords. Do not use your normal account password.
3. Start Apache and open `http://localhost/sajanmailer/`.
4. Fill in the form and press Send. The page reports whether the message was sent.

## Keep your credentials private

Never commit a real password in `credential.php`. Use a throwaway app password while testing and revoke it when you are done.

## Troubleshooting

- **Could not authenticate**: check that the app password is correct and that 2 Step Verification is on.
- **Could not connect to SMTP host**: the server must be able to reach `smtp.gmail.com` on port 587.
- **Autoloader cannot find the classes**: `PHPMailerAutoload.php` builds the path with a backslash, so on Linux or macOS replace `'phpmailer\class.'` with `'phpmailer/class.'`.
