# Community Garden Platform

Minimal PHP implementation of the Plant-Hub marketing site.

## Requirements

- PHP 8.1+ with `mysqli` and `openssl` extensions enabled
- MySQL 5.7+ / MariaDB 10.4+
- Optional: PHPMailer library (drop the `PHPMailer` directory inside the project root)

## Environment Variables

The application reads configuration exclusively from environment variables so secrets never have to be checked into the repository.

| Variable | Description |
| --- | --- |
| `DB_HOST`, `DB_PORT` | Database host (defaults: `127.0.0.1`, `3306`) |
| `DB_NAME` | Database/schema name (default `plant_hub`) |
| `DB_USERNAME`, `DB_PASSWORD` | Database credentials |
| `SMTP_HOST`, `SMTP_PORT` | SMTP server details (only required if you plan to send email confirmations) |
| `SMTP_USERNAME`, `SMTP_PASSWORD` | SMTP credentials |
| `SMTP_ENCRYPTION` | `tls` (default) or `ssl` |
| `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` | From address used by the confirmation email |

> Tip: when deploying on shared hosting, you can usually set these values from the hosting dashboard. For local development you can export them before running PHP (e.g. via PowerShell `$env:DB_HOST="127.0.0.1"`).

## Running Locally

1. Create the `organization` table in your database:

```sql
CREATE TABLE organization (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orgname VARCHAR(255) NOT NULL UNIQUE,
    location VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

2. Export the environment variables listed above (or configure them in your web server).
3. Start the PHP built-in server from the project root:
   ```
   php -S 127.0.0.1:8000
   ```
4. Navigate to `http://127.0.0.1:8000/Contact.php`.

If PHPMailer is not installed the form will still work, but the confirmation email is skipped and the reason is logged to the PHP error log.