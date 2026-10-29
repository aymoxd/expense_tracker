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
5. Create a `.env` file in the project root with the database connection values:

	```dotenv
	DB_HOST=127.0.0.1
	DB_NAME=expense
	DB_USER=root
	DB_PASSWORD=your_mysql_password
	```

	Set `DB_USER` and `DB_PASSWORD` to match your local MySQL account. Do not commit real credentials.

6. Open [http://localhost/expense_tracker/](http://localhost/expense_tracker/) in your browser. The default route is the user dashboard and requires login; use the login or registration links to begin.

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

To grant an account administrator access, register it first, then update its role in MySQL:

```sql
UPDATE users
SET role = 'admin'
WHERE email = 'admin@example.com';
```

## Application Routes

Routes use the `action` query parameter on `index.php`.

| Action | Purpose | Access |
| --- | --- | --- |
| `showLogin` | Display login form | Public |
| `login` | Submit login form | Public, POST |
| `showRegister` | Display registration form | Public |
| `register` | Submit registration form | Public, POST |
| `logout` | End the current session | Logged-in user |
| `dashboard` | View personal totals and recent transactions | Logged-in user |
| `userTransactions` | Browse personal transactions | Logged-in user |
| `create` | Display transaction form | Logged-in user |
| `store` | Create a transaction | Logged-in user, POST |
| `edit&id=...` | Edit a transaction | Logged-in user |
| `update` | Save transaction changes | Logged-in user, POST |
| `delete` | Delete a transaction | Logged-in user, POST |
| `admin` | View admin dashboard | Administrator |
| `adminUsers` | Browse users | Administrator |
| `adminUserDetail&id=...` | View a user | Administrator |
| `adminDeleteUser` | Delete a user | Administrator, POST |

Example: `http://localhost/expense_tracker/index.php?action=showLogin`

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
├── index.php                # Bootstrap, session setup, and action router
├── composer.json            # PHP dependency declaration
└── README.md
```

## Troubleshooting

- **Database connection fails:** Confirm MySQL is running and `.env` contains the correct `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` values.
- **Missing dotenv class:** Run `composer install` from the project directory.
- **PDO driver error:** Enable/install PHP's PDO MySQL extension, then restart Apache.
- **Missing `mb_*` function:** Enable/install PHP's `mbstring` extension, then restart Apache.
