-- ============================================================================
-- MLM Referral Tree - Database Queries & Testing
-- ============================================================================
-- This file contains useful SQL queries for testing, debugging, and 
-- verifying the MLM referral tree implementation.
-- ============================================================================

-- ----------------------------------------------------------------------------
-- 1. VERIFY DATABASE STRUCTURE
-- ----------------------------------------------------------------------------

-- Check if referred_by column exists
DESCRIBE users;

-- Check existing indexes
SHOW INDEX FROM users;

-- Verify index performance
EXPLAIN SELECT * FROM users WHERE referred_by = 1 AND user_type = 3 AND status = 1;

-- ----------------------------------------------------------------------------
-- 2. CREATE TEST DATA (Sample MLM Network)
-- ----------------------------------------------------------------------------

-- Root user (Customer ID: 1)
-- Already exists in your database

-- Level 1: Direct referrals (3 users)
INSERT INTO users (name, email, referred_by, user_type, status, created_at, updated_at) VALUES
('John Doe', 'john.doe@example.com', 1, 3, 1, NOW(), NOW()),
('Jane Smith', 'jane.smith@example.com', 1, 3, 1, NOW(), NOW()),
('Robert Lee', 'robert.lee@example.com', 1, 3, 1, NOW(), NOW());

-- Get the IDs of newly created users (assume 2, 3, 4)
SET @john_id = (SELECT id FROM users WHERE email = 'john.doe@example.com');
SET @jane_id = (SELECT id FROM users WHERE email = 'jane.smith@example.com');
SET @robert_id = (SELECT id FROM users WHERE email = 'robert.lee@example.com');

-- Level 2: Second generation (5 users)
INSERT INTO users (name, email, referred_by, user_type, status, created_at, updated_at) VALUES
('Sarah Wilson', 'sarah.wilson@example.com', @john_id, 3, 1, NOW(), NOW()),
('Mike Chen', 'mike.chen@example.com', @john_id, 3, 1, NOW(), NOW()),
('Alex Brown', 'alex.brown@example.com', @jane_id, 3, 1, NOW(), NOW()),
('Emily Davis', 'emily.davis@example.com', @robert_id, 3, 1, NOW(), NOW()),
('David Kim', 'david.kim@example.com', @robert_id, 3, 1, NOW(), NOW());

-- Get Level 2 IDs
SET @sarah_id = (SELECT id FROM users WHERE email = 'sarah.wilson@example.com');
SET @mike_id = (SELECT id FROM users WHERE email = 'mike.chen@example.com');
SET @alex_id = (SELECT id FROM users WHERE email = 'alex.brown@example.com');

-- Level 3: Third generation (4 users)
INSERT INTO users (name, email, referred_by, user_type, status, created_at, updated_at) VALUES
('Tom Harris', 'tom.harris@example.com', @sarah_id, 3, 1, NOW(), NOW()),
('Lisa Wang', 'lisa.wang@example.com', @sarah_id, 3, 1, NOW(), NOW()),
('Chris Taylor', 'chris.taylor@example.com', @mike_id, 3, 1, NOW(), NOW()),
('Anna Martinez', 'anna.martinez@example.com', @alex_id, 3, 1, NOW(), NOW());

-- ----------------------------------------------------------------------------
-- 3. QUERY REFERRAL TREE DATA
-- ----------------------------------------------------------------------------

-- Get all direct referrals (Level 1) for user ID 1
SELECT 
    id,
    name,
    email,
    referred_by,
    created_at
FROM users
WHERE referred_by = 1
  AND user_type = 3
  AND status = 1
ORDER BY created_at ASC;

-- Get full tree up to 3 levels (manual hierarchical query)
-- Level 0 (Root)
SELECT 
    0 AS level,
    id,
    name,
    email,
    referred_by,
    created_at
FROM users
WHERE id = 1

UNION ALL

-- Level 1
SELECT 
    1 AS level,
    u.id,
    u.name,
    u.email,
    u.referred_by,
    u.created_at
FROM users u
WHERE u.referred_by = 1
  AND u.user_type = 3
  AND u.status = 1

UNION ALL

-- Level 2
SELECT 
    2 AS level,
    u2.id,
    u2.name,
    u2.email,
    u2.referred_by,
    u2.created_at
FROM users u1
JOIN users u2 ON u2.referred_by = u1.id
WHERE u1.referred_by = 1
  AND u1.user_type = 3
  AND u1.status = 1
  AND u2.user_type = 3
  AND u2.status = 1

UNION ALL

-- Level 3
SELECT 
    3 AS level,
    u3.id,
    u3.name,
    u3.email,
    u3.referred_by,
    u3.created_at
FROM users u1
JOIN users u2 ON u2.referred_by = u1.id
JOIN users u3 ON u3.referred_by = u2.id
WHERE u1.referred_by = 1
  AND u1.user_type = 3
  AND u1.status = 1
  AND u2.user_type = 3
  AND u2.status = 1
  AND u3.user_type = 3
  AND u3.status = 1

ORDER BY level, created_at;

-- ----------------------------------------------------------------------------
-- 4. CALCULATE STATISTICS
-- ----------------------------------------------------------------------------

-- Count direct referrals (Level 1)
SELECT COUNT(*) AS direct_referrals
FROM users
WHERE referred_by = 1
  AND user_type = 3
  AND status = 1;

-- Count total network (all 3 levels) - Method 1: Separate counts
SELECT 
    (SELECT COUNT(*) FROM users WHERE referred_by = 1 AND user_type = 3 AND status = 1) AS level_1,
    (SELECT COUNT(*) FROM users u2 
     JOIN users u1 ON u2.referred_by = u1.id 
     WHERE u1.referred_by = 1 AND u1.user_type = 3 AND u1.status = 1 
     AND u2.user_type = 3 AND u2.status = 1) AS level_2,
    (SELECT COUNT(*) FROM users u3
     JOIN users u2 ON u3.referred_by = u2.id
     JOIN users u1 ON u2.referred_by = u1.id
     WHERE u1.referred_by = 1 AND u1.user_type = 3 AND u1.status = 1
     AND u2.user_type = 3 AND u2.status = 1
     AND u3.user_type = 3 AND u3.status = 1) AS level_3;

-- Count total network - Method 2: Recursive CTE (MySQL 8.0+)
WITH RECURSIVE referral_tree AS (
    -- Anchor: Direct referrals (Level 1)
    SELECT id, name, referred_by, 1 AS level
    FROM users
    WHERE referred_by = 1
      AND user_type = 3
      AND status = 1
    
    UNION ALL
    
    -- Recursive: Get children up to level 3
    SELECT u.id, u.name, u.referred_by, rt.level + 1
    FROM users u
    INNER JOIN referral_tree rt ON u.referred_by = rt.id
    WHERE rt.level < 3
      AND u.user_type = 3
      AND u.status = 1
)
SELECT 
    level,
    COUNT(*) AS count
FROM referral_tree
GROUP BY level
ORDER BY level;

-- Total network size
WITH RECURSIVE referral_tree AS (
    SELECT id FROM users WHERE referred_by = 1 AND user_type = 3 AND status = 1
    UNION ALL
    SELECT u.id FROM users u
    INNER JOIN referral_tree rt ON u.referred_by = rt.id
    WHERE u.user_type = 3 AND u.status = 1
)
SELECT COUNT(*) AS total_network FROM referral_tree;

-- ----------------------------------------------------------------------------
-- 5. DEBUGGING QUERIES
-- ----------------------------------------------------------------------------

-- Find users with circular references (should return empty)
WITH RECURSIVE referral_chain AS (
    SELECT id, referred_by, CAST(id AS CHAR(1000)) AS chain, 1 AS depth
    FROM users
    WHERE referred_by IS NOT NULL
    
    UNION ALL
    
    SELECT u.id, u.referred_by, CONCAT(rc.chain, '->', u.id), rc.depth + 1
    FROM users u
    INNER JOIN referral_chain rc ON u.id = rc.referred_by
    WHERE rc.depth < 10
      AND FIND_IN_SET(u.id, REPLACE(rc.chain, '->', ',')) = 0
)
SELECT * FROM referral_chain WHERE FIND_IN_SET(referred_by, REPLACE(chain, '->', ',')) > 0;

-- Find orphaned referrals (referred_by points to non-existent user)
SELECT u1.id, u1.name, u1.referred_by
FROM users u1
LEFT JOIN users u2 ON u1.referred_by = u2.id
WHERE u1.referred_by IS NOT NULL
  AND u2.id IS NULL;

-- Find inactive referrers (user_type != 3 or status != 1)
SELECT 
    u1.id AS referral_id,
    u1.name AS referral_name,
    u2.id AS referrer_id,
    u2.name AS referrer_name,
    u2.user_type,
    u2.status
FROM users u1
JOIN users u2 ON u1.referred_by = u2.id
WHERE u2.user_type != 3 OR u2.status != 1;

-- ----------------------------------------------------------------------------
-- 6. PERFORMANCE TESTING
-- ----------------------------------------------------------------------------

-- Test query performance with EXPLAIN
EXPLAIN SELECT * FROM users WHERE referred_by = 1;

-- Test index usage
EXPLAIN SELECT * FROM users 
WHERE referred_by = 1 
  AND user_type = 3 
  AND status = 1;

-- Benchmark query execution time
SET @start_time = NOW(6);
SELECT COUNT(*) FROM users WHERE referred_by = 1 AND user_type = 3 AND status = 1;
SELECT TIMESTAMPDIFF(MICROSECOND, @start_time, NOW(6)) AS execution_time_microseconds;

-- ----------------------------------------------------------------------------
-- 7. DATA CLEANUP (for testing)
-- ----------------------------------------------------------------------------

-- Delete test data (BE CAREFUL!)
-- DELETE FROM users WHERE email LIKE '%@example.com';

-- Reset auto-increment (if needed)
-- ALTER TABLE users AUTO_INCREMENT = 1;

-- ----------------------------------------------------------------------------
-- 8. VERIFY IMPLEMENTATION
-- ----------------------------------------------------------------------------

-- Check if indexes exist
SELECT 
    TABLE_NAME,
    INDEX_NAME,
    COLUMN_NAME,
    SEQ_IN_INDEX
FROM information_schema.STATISTICS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'users'
  AND INDEX_NAME IN ('idx_referred_by', 'idx_user_type_status', 'idx_referral_tree_lookup')
ORDER BY INDEX_NAME, SEQ_IN_INDEX;

-- Get database table info
SELECT 
    TABLE_NAME,
    TABLE_ROWS,
    AVG_ROW_LENGTH,
    DATA_LENGTH,
    INDEX_LENGTH,
    (DATA_LENGTH + INDEX_LENGTH) AS total_size
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'users';

-- ----------------------------------------------------------------------------
-- 9. USEFUL REPORTS
-- ----------------------------------------------------------------------------

-- Top referrers (users with most direct referrals)
SELECT 
    u.id,
    u.name,
    u.email,
    COUNT(r.id) AS direct_referrals
FROM users u
LEFT JOIN users r ON r.referred_by = u.id AND r.user_type = 3 AND r.status = 1
WHERE u.user_type = 3 AND u.status = 1
GROUP BY u.id, u.name, u.email
HAVING direct_referrals > 0
ORDER BY direct_referrals DESC
LIMIT 10;

-- Network growth over time (last 30 days)
SELECT 
    DATE(created_at) AS date,
    COUNT(*) AS new_referrals
FROM users
WHERE referred_by IS NOT NULL
  AND user_type = 3
  AND status = 1
  AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY DATE(created_at)
ORDER BY date DESC;

-- Level distribution report
SELECT 
    'Level 1' AS level,
    COUNT(*) AS count
FROM users
WHERE referred_by = 1 AND user_type = 3 AND status = 1

UNION ALL

SELECT 
    'Level 2' AS level,
    COUNT(*) AS count
FROM users u2
JOIN users u1 ON u2.referred_by = u1.id
WHERE u1.referred_by = 1 
  AND u1.user_type = 3 AND u1.status = 1
  AND u2.user_type = 3 AND u2.status = 1

UNION ALL

SELECT 
    'Level 3' AS level,
    COUNT(*) AS count
FROM users u3
JOIN users u2 ON u3.referred_by = u2.id
JOIN users u1 ON u2.referred_by = u1.id
WHERE u1.referred_by = 1
  AND u1.user_type = 3 AND u1.status = 1
  AND u2.user_type = 3 AND u2.status = 1
  AND u3.user_type = 3 AND u3.status = 1;

-- ----------------------------------------------------------------------------
-- 10. MAINTENANCE QUERIES
-- ----------------------------------------------------------------------------

-- Optimize table
OPTIMIZE TABLE users;

-- Analyze table (update index statistics)
ANALYZE TABLE users;

-- Check table integrity
CHECK TABLE users;

-- Rebuild indexes (if needed)
-- ALTER TABLE users DROP INDEX idx_referred_by;
-- ALTER TABLE users ADD INDEX idx_referred_by (referred_by);

-- ============================================================================
-- END OF SQL QUERIES
-- ============================================================================
