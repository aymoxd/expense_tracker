# Expense Tracker

A PHP and MySQL application for managing personal income and expenses. Users can record and review transactions; administrators can view user accounts and application-wide transaction activity.

## Features

- Register, log in, and log out
- Create, edit, delete, search, and filter personal transactions
- View income, expense, and balance totals
- Paginate transaction and user lists
- Admin dashboard with user and transaction summaries
- Session-based authentication and CSRF checks on form submissions

## Technology

- PHP
- MySQL with PDO
- Composer and `vlucas/phpdotenv`
- HTML, CSS, and JavaScript

## Requirements

- XAMPP (Apache, MySQL, and PHP) or an equivalent PHP/MySQL environment
- PHP extensions for PDO MySQL and `mbstring`
- Composer

## Setup

1. Place the `expense_tracker` folder in the web server document root. For XAMPP, this is commonly `C:\xampp\htdocs\expense_tracker`.
2. From the project directory, install PHP dependencies:

	```sh
	composer install
	```

3. Start Apache and MySQL.
4. Create the database and tables by importing [`../database/schema.sql`](../database/schema.sql) in phpMyAdmin, or run it with the MySQL command-line client. The script creates and selects the `expense` database.
5. Create a private `.env` file in the project root and set these variables to your local database values: `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD`. Keep `.env` out of this public repository; never commit real credentials or other secrets.

6. Open the application locally at `http://localhost/expense_tracker/` and use its sign-in or registration page.

> The schema file is currently outside this project folder at `../database/schema.sql`. If you move or package the project separately, keep that schema file available or update the import path.

## Database

The schema defines two InnoDB tables:

### `users`

| Column | Type | Description |
| --- | --- | --- |
| `id` | `INT UNSIGNED` | Auto-incrementing primary key |
| `name` | `VARCHAR(50)` | First name |
| `lastName` | `VARCHAR(50)` | Last name |
| `email` | `VARCHAR(254)` | Unique login email |
| `password` | `VARCHAR(255)` | Password hash |
| `role` | `ENUM('user', 'admin')` | Account role; defaults to `user` |
| `created_at` | `DATETIME` | Account creation time |

### `transactions`

| Column | Type | Description |
| --- | --- | --- |
| `id` | `INT UNSIGNED` | Auto-incrementing primary key |
| `user_id` | `INT UNSIGNED` | Owner; references `users.id` |
| `type` | `ENUM('income', 'expense')` | Transaction category |
| `amount` | `DECIMAL(10,2)` | Positive transaction amount |
| `description` | `VARCHAR(255)` | Transaction details |
| `created_at` | `DATETIME` | Transaction timestamp |

Each user can have many transactions. Deleting a user cascades to that user's transactions. Indexes support user/date listings, type filters, and recent activity. Amounts are displayed in MAD by the interface.

## Security Notes

- Keep `.env` local and private. Use a dedicated MySQL account with only the permissions the application needs; do not use a privileged database account in a deployed environment.
- Never add real passwords, API keys, personal records, production hostnames, or database exports to this public repository.
- Use HTTPS for deployed environments, keep PHP and dependencies updated, and disable detailed error display in production.
- The application uses session-based authentication and CSRF tokens for form submissions. Review authentication, authorization, input validation, and session settings before exposing it to the internet; these measures alone do not constitute a security audit.
- Grant administrator privileges only to trusted accounts, and do so through a controlled administrative process.

## Project Structure

```text
expense_tracker/
├── asset/
│   ├── css/                 # Page and layout styles
│   └── scripts/             # Frontend JavaScript
├── config/
│   └── db.php               # PDO connection using .env values
├── controller/              # Authentication, transaction, and admin actions
├── model/                   # Database queries and persistence functions
├── view/                    # Login, registration, user, and admin templates
├── index.php                # Bootstrap, session setup, and request handling
├── composer.json            # PHP dependency declaration
└── README.md
```

## Troubleshooting

- **Database connection fails:** Confirm MySQL is running and `.env` contains the correct `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` values.
- **Missing dotenv class:** Run `composer install` from the project directory.
- **PDO driver error:** Enable/install PHP's PDO MySQL extension, then restart Apache.
- **Missing `mb_*` function:** Enable/install PHP's `mbstring` extension, then restart Apache.
