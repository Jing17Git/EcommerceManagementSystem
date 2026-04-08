-- Update Payment Account Details
-- Run this in phpMyAdmin or MySQL command line

-- Update GCash
UPDATE payment_methods 
SET 
    account_name = 'Your Full Name',
    account_number = '09171234567',
    instructions = 'Send payment to the GCash number below and upload screenshot as proof.'
WHERE type = 'gcash' AND name = 'GCash';

-- Update PayMaya
UPDATE payment_methods 
SET 
    account_name = 'Your Full Name',
    account_number = '09181234567',
    instructions = 'Send payment to the PayMaya number below and upload screenshot as proof.'
WHERE type = 'paymaya' AND name = 'PayMaya';

-- Update BDO Bank
UPDATE payment_methods 
SET 
    account_name = 'Your Full Name',
    account_number = '1234567890',
    instructions = 'Transfer to BDO account below and upload deposit slip or online banking screenshot.'
WHERE type = 'bank' AND name = 'Bank Transfer - BDO';

-- Update BPI Bank
UPDATE payment_methods 
SET 
    account_name = 'Your Full Name',
    account_number = '0987654321',
    instructions = 'Transfer to BPI account below and upload deposit slip or online banking screenshot.'
WHERE type = 'bank' AND name = 'Bank Transfer - BPI';

-- View all payment methods to verify
SELECT id, name, type, account_name, account_number, is_active 
FROM payment_methods;
