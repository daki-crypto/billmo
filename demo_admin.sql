-- Default admin account for E-Billing System
-- Run this SQL in phpMyAdmin or MySQL to create an admin user if none exists

INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Default Admin', 'admin@ebilling.local', 'admin123', 'admin');
