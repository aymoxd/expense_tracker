# Expense Tracker

A simple web application built with **PHP** to manage personal financial transactions.

## Features

* User registration
* User login and logout
* Add a transaction
* Edit a transaction
* Delete a transaction
* Display transactions
* Database connection with MySQL
* Simple CSS and JavaScript

## Technologies

* PHP
* MySQL
* HTML
* CSS
* JavaScript

## Project Structure

```text
expens_tracker/
├── asset/
│   ├── css/
│   │   ├── auth.css
│   │   └── index.css
│   └── scripts/
│       └── main.js
├── auth/
│   ├── login.php
│   ├── logout.php
│   └── register.php
├── config/
│   └── db.php
├── includes/
│   └── header_libraries.php
├── index.php
└── transaction/
    ├── add_transaction.php
    ├── delete_transaction.php
    └── edit_transaction.php
```

## Folder Description

### `asset/`

Contains the frontend resources.

* `css/` → CSS files
* `scripts/` → JavaScript files

### `auth/`

Contains authentication pages.

* `login.php` → User login
* `register.php` → Create a new account
* `logout.php` → Logout

### `config/`

Contains configuration files.

* `db.php` → Database connection

### `includes/`

Contains reusable PHP files.

* `header_libraries.php` → Header libraries used by the project

### `transaction/`

Contains transaction operations.

* `add_transaction.php` → Add a transaction
* `edit_transaction.php` → Edit a transaction
* `delete_transaction.php` → Delete a transaction

### `index.php`

The main page of the application.

## Installation

### 1. Clone or copy the project

Put the project inside your web server directory:

```bash
/var/www/html/
```

### 2. Create the database

Create a MySQL database and the required tables.

### 3. Configure the database

Open:

```text
config/db.php
```

and configure your database credentials.

### 4. Start the web server

Make sure Apache and MySQL are running.

Then open the project in your browser:

```text
http://localhost/expens_tracker/
```

## Author

Created as a PHP learning project.
