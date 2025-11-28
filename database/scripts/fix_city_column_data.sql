-- SQL script to clean city column data in users table before migration
-- Set empty strings or invalid city values to NULL

UPDATE users
SET city = NULL
WHERE city = '' OR city IS NULL OR city NOT REGEXP '^[a-zA-Z0-9 \\-\\'\\.]+$';

-- You can adjust the REGEXP pattern if needed to allow valid city names.

