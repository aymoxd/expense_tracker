
-- =========================================
-- Expense Tracker Database
-- =========================================

-- 1. Create database
CREATE DATABASE IF NOT EXISTS expense
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- 2. Select database
USE expense;


-- =========================================
-- 3. Users Table
-- =========================================

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(254) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email),
    KEY idx_users_created_at (created_at)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- =========================================
-- 4. Transactions Table
-- =========================================

CREATE TABLE IF NOT EXISTS transactions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY idx_transactions_user_id_id (user_id, id),
    KEY idx_transactions_user_type (user_id, type),
    KEY idx_transactions_created_at (created_at),

    CONSTRAINT fk_transactions_user
        FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
