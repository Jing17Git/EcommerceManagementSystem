-- Create Admin Account for Richard Bautista
-- Email: richarddbautista1@gmail.com
-- Password: shophubph123
-- Role: Administrator

-- First, check if user exists and delete if needed (optional)
-- DELETE FROM users WHERE email = 'richarddbautista1@gmail.com';

-- Insert admin account
INSERT INTO users (name, email, email_verified_at, password, role, remember_token, created_at, updated_at)
VALUES (
    'Richard Bautista',
    'richarddbautista1@gmail.com',
    NOW(),
    '$2y$10$o6dSlStDmAA5QlshaqnlxOcrOj5oI/6OGTXBI1BFd.Su4OKw.sutS', -- This is hashed 'shophubph123'
    'administrator',
    NULL,
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    role = 'administrator',
    password = '$2y$10$o6dSlStDmAA5QlshaqnlxOcrOj5oI/6OGTXBI1BFd.Su4OKw.sutS',
    updated_at = NOW();

-- Verify the admin was created
SELECT id, name, email, role, created_at FROM users WHERE email = 'richarddbautista1@gmail.com';
