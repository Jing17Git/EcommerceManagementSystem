-- Quick Admin Account Creation
-- Run this directly in Railway MySQL Query Console

-- Create admin account (will update if email already exists)
INSERT INTO users (name, email, email_verified_at, password, role, created_at, updated_at)
VALUES (
    'Richard Bautista',
    'richarddbautista1@gmail.com',
    NOW(),
    '$2y$10$o6dSlStDmAA5QlshaqnlxOcrOj5oI/6OGTXBI1BFd.Su4OKw.sutS',
    'administrator',
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    role = 'administrator',
    password = '$2y$10$o6dSlStDmAA5QlshaqnlxOcrOj5oI/6OGTXBI1BFd.Su4OKw.sutS',
    email_verified_at = NOW(),
    updated_at = NOW();
