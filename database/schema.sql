-- Checking 1 baseline: all 13 ERD entities, original field names.
-- Import ONLY into a new, empty MySQL/MariaDB database selected by the operator.
-- No CREATE DATABASE, DROP, ALTER, seed accounts, or financial transactions.
-- Existing starter migrations use an incompatible users table. Do not combine them.
SET NAMES utf8mb4;

CREATE TABLE users (
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(254) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(30) NOT NULL,
    account_status VARCHAR(30) NOT NULL,
    INDEX idx_users_lookup_0 (role, account_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE clients (
    client_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    client_number VARCHAR(40) NOT NULL UNIQUE,
    contact_number VARCHAR(30) NULL,
    address TEXT NULL,
    INDEX idx_clients_user_id (user_id),
    CONSTRAINT fk_clients_user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE memorial_plans (
    plan_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    plan_name VARCHAR(120) NOT NULL,
    plan_price DECIMAL(12,2) NOT NULL,
    coverage_details TEXT NOT NULL,
    plan_status VARCHAR(30) NOT NULL,
    INDEX idx_memorial_plans_lookup_0 (plan_status),
    CONSTRAINT chk_memorial_plans_plan_price CHECK (plan_price >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE inquiries (
    inquiry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED NOT NULL,
    responded_by INT UNSIGNED NULL,
    subject VARCHAR(180) NOT NULL,
    message TEXT NOT NULL,
    response TEXT NULL,
    inquiry_status VARCHAR(30) NOT NULL,
    INDEX idx_inquiries_client_id (client_id),
    CONSTRAINT fk_inquiries_client_id FOREIGN KEY (client_id) REFERENCES clients (client_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_inquiries_responded_by (responded_by),
    CONSTRAINT fk_inquiries_responded_by FOREIGN KEY (responded_by) REFERENCES users (user_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_inquiries_lookup_0 (inquiry_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE stored_files (
    file_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED NOT NULL,
    uploaded_by INT UNSIGNED NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    cloud_file_key VARCHAR(512) NOT NULL,
    file_type VARCHAR(100) NOT NULL,
    uploaded_at DATETIME NOT NULL,
    INDEX idx_stored_files_client_id (client_id),
    CONSTRAINT fk_stored_files_client_id FOREIGN KEY (client_id) REFERENCES clients (client_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_stored_files_uploaded_by (uploaded_by),
    CONSTRAINT fk_stored_files_uploaded_by FOREIGN KEY (uploaded_by) REFERENCES users (user_id) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE plan_contracts (
    contract_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED NOT NULL,
    plan_id INT UNSIGNED NOT NULL,
    contract_number VARCHAR(40) NOT NULL UNIQUE,
    enrollment_date DATE NOT NULL,
    contract_amount DECIMAL(12,2) NOT NULL,
    contract_status VARCHAR(30) NOT NULL,
    INDEX idx_plan_contracts_client_id (client_id),
    CONSTRAINT fk_plan_contracts_client_id FOREIGN KEY (client_id) REFERENCES clients (client_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_plan_contracts_plan_id (plan_id),
    CONSTRAINT fk_plan_contracts_plan_id FOREIGN KEY (plan_id) REFERENCES memorial_plans (plan_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_plan_contracts_lookup_0 (contract_status, enrollment_date),
    CONSTRAINT chk_plan_contracts_contract_amount CHECK (contract_amount >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE payment_schedules (
    schedule_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    contract_id INT UNSIGNED NOT NULL,
    due_date DATE NOT NULL,
    amount_due DECIMAL(12,2) NOT NULL,
    payment_status VARCHAR(30) NOT NULL,
    INDEX idx_payment_schedules_contract_id (contract_id),
    CONSTRAINT fk_payment_schedules_contract_id FOREIGN KEY (contract_id) REFERENCES plan_contracts (contract_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_payment_schedules_lookup_0 (due_date, payment_status),
    CONSTRAINT chk_payment_schedules_amount_due CHECK (amount_due >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE payment_methods (
    method_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(80) NOT NULL,
    provider VARCHAR(100) NOT NULL,
    method_status VARCHAR(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE payments (
    payment_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    schedule_id INT UNSIGNED NOT NULL,
    method_id INT UNSIGNED NOT NULL,
    recorded_by INT UNSIGNED NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    payment_date DATETIME NOT NULL,
    payment_status VARCHAR(30) NOT NULL,
    INDEX idx_payments_schedule_id (schedule_id),
    CONSTRAINT fk_payments_schedule_id FOREIGN KEY (schedule_id) REFERENCES payment_schedules (schedule_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_payments_method_id (method_id),
    CONSTRAINT fk_payments_method_id FOREIGN KEY (method_id) REFERENCES payment_methods (method_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_payments_recorded_by (recorded_by),
    CONSTRAINT fk_payments_recorded_by FOREIGN KEY (recorded_by) REFERENCES users (user_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_payments_lookup_0 (payment_date, payment_status),
    CONSTRAINT chk_payments_amount CHECK (amount >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE notifications (
    notification_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    notification_type VARCHAR(50) NOT NULL,
    channel VARCHAR(30) NOT NULL,
    message TEXT NOT NULL,
    delivery_status VARCHAR(30) NOT NULL,
    sent_at DATETIME NULL,
    INDEX idx_notifications_client_id (client_id),
    CONSTRAINT fk_notifications_client_id FOREIGN KEY (client_id) REFERENCES clients (client_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_notifications_user_id (user_id),
    CONSTRAINT fk_notifications_user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_notifications_lookup_0 (delivery_status, sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE digital_receipts (
    receipt_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    payment_id INT UNSIGNED NOT NULL,
    receipt_number VARCHAR(50) NOT NULL UNIQUE,
    cloud_file_key VARCHAR(512) NOT NULL,
    issued_at DATETIME NOT NULL,
    INDEX idx_digital_receipts_payment_id (payment_id),
    CONSTRAINT fk_digital_receipts_payment_id FOREIGN KEY (payment_id) REFERENCES payments (payment_id) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE payment_transactions (
    transaction_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    payment_id INT UNSIGNED NOT NULL,
    gateway_reference VARCHAR(150) NOT NULL UNIQUE,
    transaction_status VARCHAR(30) NOT NULL,
    transaction_date DATETIME NOT NULL,
    INDEX idx_payment_transactions_payment_id (payment_id),
    CONSTRAINT fk_payment_transactions_payment_id FOREIGN KEY (payment_id) REFERENCES payments (payment_id) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE qr_codes (
    qr_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    payment_id INT UNSIGNED NOT NULL,
    qr_reference VARCHAR(150) NOT NULL UNIQUE,
    qr_type VARCHAR(50) NOT NULL,
    qr_status VARCHAR(30) NOT NULL,
    expires_at DATETIME NOT NULL,
    INDEX idx_qr_codes_payment_id (payment_id),
    CONSTRAINT fk_qr_codes_payment_id FOREIGN KEY (payment_id) REFERENCES payments (payment_id) ON UPDATE RESTRICT ON DELETE RESTRICT,
    INDEX idx_qr_codes_lookup_0 (expires_at, qr_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
