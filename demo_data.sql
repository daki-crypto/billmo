-- Demo users for E-Billing System
-- Password field contains plain text for demo purposes. In production, use password hashing!

INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin@example.com', 'password123', 'admin', NOW(), NOW()),
('John Doe', 'john@example.com', 'password123', 'normal', NOW(), NOW()),
('Jane Smith', 'jane@example.com', 'password123', 'normal', NOW(), NOW());

-- Demo clients (optional - if you don't have any)
INSERT INTO `clients` (`name`, `address`, `meter_number`, `created_at`, `updated_at`) VALUES
('ABC Enterprises', '123 Business Street, Lagos', 'MTR-001-ABC', NOW(), NOW()),
('XYZ Corporation', '456 Commerce Avenue, Lagos', 'MTR-002-XYZ', NOW(), NOW()),
('Tech Solutions Ltd', '789 Innovation Drive, Lagos', 'MTR-003-TECH', NOW(), NOW());
