-- =========================================================
-- MISSING TABLES, COLUMNS, AND SAMPLE DATA
-- Generated: 2026-01-28
-- Purpose: Add missing database elements based on codebase analysis
-- =========================================================

USE toai_hrm;

-- =========================================================
-- PART 1: MISSING COLUMNS IN EXISTING TABLES
-- =========================================================

-- Add missing columns to organizations table
-- Note: These will fail if columns already exist - that's OK, just ignore the errors
-- Or check manually: SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'organizations';

ALTER TABLE `organizations` 
    ADD COLUMN `tax_id` VARCHAR(100) DEFAULT NULL AFTER `registration_number`;

ALTER TABLE `organizations` 
    ADD COLUMN `fax` VARCHAR(50) DEFAULT NULL AFTER `phone`;

ALTER TABLE `organizations` 
    ADD COLUMN `address_line1` VARCHAR(191) DEFAULT NULL AFTER `website`;

ALTER TABLE `organizations` 
    ADD COLUMN `address_line2` VARCHAR(191) DEFAULT NULL AFTER `address_line1`;

ALTER TABLE `organizations` 
    ADD COLUMN `city` VARCHAR(100) DEFAULT NULL AFTER `address_line2`;

ALTER TABLE `organizations` 
    ADD COLUMN `state` VARCHAR(100) DEFAULT NULL AFTER `city`;

ALTER TABLE `organizations` 
    ADD COLUMN `zip_postal_code` VARCHAR(20) DEFAULT NULL AFTER `state`;

ALTER TABLE `organizations` 
    ADD COLUMN `country` VARCHAR(100) DEFAULT NULL AFTER `zip_postal_code`;

ALTER TABLE `organizations` 
    ADD COLUMN `notes` TEXT DEFAULT NULL AFTER `country`;

-- =========================================================
-- PART 2: MISSING SAMPLE DATA
-- =========================================================

-- Insert sample data for employee_job_details (if empty)
INSERT INTO `employee_job_details` (`employee_id`, `job_title_id`, `employment_status_id`, `organization_unit_id`, `location_id`, `supervisor_id`, `effective_date`, `created_at`, `updated_at`)
SELECT 
    e.id as employee_id,
    e.job_title_id,
    e.employment_status_id,
    e.organization_unit_id,
    e.location_id,
    e.supervisor_id,
    e.hire_date as effective_date,
    NOW() as created_at,
    NOW() as updated_at
FROM `employees` e
WHERE NOT EXISTS (
    SELECT 1 FROM `employee_job_details` ejd 
    WHERE ejd.employee_id = e.id
)
LIMIT 10;

-- Insert sample data for employee_personal_details (if missing)
INSERT INTO `employee_personal_details` (`employee_id`, `nationality_id`, `other_id`, `drivers_license`, `license_expiry`, `blood_group`, `address1`, `city`, `state`, `country`, `mobile_phone`, `work_email`, `created_at`, `updated_at`)
SELECT 
    e.id as employee_id,
    (SELECT id FROM `nationalities` ORDER BY RAND() LIMIT 1) as nationality_id,
    CONCAT('ID-', LPAD(e.id, 6, '0')) as other_id,
    CONCAT('DL-', LPAD(e.id, 8, '0')) as drivers_license,
    DATE_ADD(CURDATE(), INTERVAL 5 YEAR) as license_expiry,
    CASE (e.id % 8)
        WHEN 0 THEN 'A+'
        WHEN 1 THEN 'A-'
        WHEN 2 THEN 'B+'
        WHEN 3 THEN 'B-'
        WHEN 4 THEN 'AB+'
        WHEN 5 THEN 'AB-'
        WHEN 6 THEN 'O+'
        ELSE 'O-'
    END as blood_group,
    CONCAT(e.id * 100, ' Main Street') as address1,
    CASE (e.id % 3)
        WHEN 0 THEN 'Austin'
        WHEN 1 THEN 'New York'
        ELSE 'Mumbai'
    END as city,
    CASE (e.id % 3)
        WHEN 0 THEN 'Texas'
        WHEN 1 THEN 'New York'
        ELSE 'Maharashtra'
    END as state,
    CASE (e.id % 3)
        WHEN 0 THEN 'United States'
        WHEN 1 THEN 'United States'
        ELSE 'India'
    END as country,
    CONCAT('+1-555-', LPAD(1000 + e.id, 4, '0')) as mobile_phone,
    CONCAT(LOWER(REPLACE(e.display_name, ' ', '.')), '@company.com') as work_email,
    NOW() as created_at,
    NOW() as updated_at
FROM `employees` e
WHERE NOT EXISTS (
    SELECT 1 FROM `employee_personal_details` epd 
    WHERE epd.employee_id = e.id
)
LIMIT 10;

-- Insert sample data for work_shifts (if empty)
INSERT INTO `work_shifts` (`name`, `start_time`, `end_time`, `hours_per_day`, `created_at`, `updated_at`)
SELECT * FROM (
    SELECT 'Day Shift' as name, '09:00:00' as start_time, '17:00:00' as end_time, 8.00 as hours_per_day, NOW() as created_at, NOW() as updated_at
    UNION ALL
    SELECT 'Night Shift', '21:00:00', '05:00:00', 8.00, NOW(), NOW()
    UNION ALL
    SELECT 'Morning Shift', '06:00:00', '14:00:00', 8.00, NOW(), NOW()
    UNION ALL
    SELECT 'Evening Shift', '14:00:00', '22:00:00', 8.00, NOW(), NOW()
) AS shifts
WHERE NOT EXISTS (SELECT 1 FROM `work_shifts` WHERE `work_shifts`.`name` = shifts.name);

-- Insert sample data for pay_grades (if empty)
INSERT INTO `pay_grades` (`name`, `currency`, `created_at`, `updated_at`)
SELECT * FROM (
    SELECT 'Grade A' as name, 'USD' as currency, NOW() as created_at, NOW() as updated_at
    UNION ALL
    SELECT 'Grade B', 'USD', NOW(), NOW()
    UNION ALL
    SELECT 'Grade C', 'USD', NOW(), NOW()
    UNION ALL
    SELECT 'Grade D', 'USD', NOW(), NOW()
) AS grades
WHERE NOT EXISTS (SELECT 1 FROM `pay_grades` WHERE `pay_grades`.`name` = grades.name);

-- Insert sample data for email_subscriptions (if empty)
INSERT INTO `email_subscriptions` (`notification_key`, `name`, `description`, `is_enabled`, `created_at`, `updated_at`)
SELECT * FROM (
    SELECT 'leave_application' as notification_key, 'Leave Application' as name, 'Notifications for leave applications' as description, 1 as is_enabled, NOW() as created_at, NOW() as updated_at
    UNION ALL
    SELECT 'leave_approval', 'Leave Approval', 'Notifications for leave approvals', 1, NOW(), NOW()
    UNION ALL
    SELECT 'timesheet_submission', 'Timesheet Submission', 'Notifications for timesheet submissions', 1, NOW(), NOW()
    UNION ALL
    SELECT 'claim_submission', 'Claim Submission', 'Notifications for claim submissions', 1, NOW(), NOW()
    UNION ALL
    SELECT 'performance_review', 'Performance Review', 'Notifications for performance reviews', 1, NOW(), NOW()
    UNION ALL
    SELECT 'recruitment_update', 'Recruitment Update', 'Notifications for recruitment updates', 1, NOW(), NOW()
) AS subs
WHERE NOT EXISTS (SELECT 1 FROM `email_subscriptions` WHERE `email_subscriptions`.`notification_key` = subs.notification_key);

-- Insert sample data for language_packages (if empty)
INSERT INTO `language_packages` (`code`, `name`, `is_default`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT * FROM (
    SELECT 'en' as code, 'English' as name, 1 as is_default, 1 as sort_order, 1 as is_active, NOW() as created_at, NOW() as updated_at
    UNION ALL
    SELECT 'es', 'Spanish', 0, 2, 1, NOW(), NOW()
    UNION ALL
    SELECT 'fr', 'French', 0, 3, 1, NOW(), NOW()
    UNION ALL
    SELECT 'de', 'German', 0, 4, 1, NOW(), NOW()
    UNION ALL
    SELECT 'hi', 'Hindi', 0, 5, 1, NOW(), NOW()
) AS langs
WHERE NOT EXISTS (SELECT 1 FROM `language_packages` WHERE `language_packages`.`code` = langs.code);

-- Insert sample data for enabled_modules (if empty)
INSERT INTO `enabled_modules` (`module_key`, `is_enabled`, `created_at`, `updated_at`)
SELECT * FROM (
    SELECT 'admin' as module_key, 1 as is_enabled, NOW() as created_at, NOW() as updated_at
    UNION ALL
    SELECT 'pim', 1, NOW(), NOW()
    UNION ALL
    SELECT 'leave', 1, NOW(), NOW()
    UNION ALL
    SELECT 'time', 1, NOW(), NOW()
    UNION ALL
    SELECT 'recruitment', 1, NOW(), NOW()
    UNION ALL
    SELECT 'performance', 1, NOW(), NOW()
    UNION ALL
    SELECT 'directory', 1, NOW(), NOW()
    UNION ALL
    SELECT 'maintenance', 1, NOW(), NOW()
    UNION ALL
    SELECT 'mobile', 1, NOW(), NOW()
    UNION ALL
    SELECT 'claim', 1, NOW(), NOW()
    UNION ALL
    SELECT 'buzz', 1, NOW(), NOW()
) AS mods
WHERE NOT EXISTS (SELECT 1 FROM `enabled_modules` WHERE `enabled_modules`.`module_key` = mods.module_key);

-- Insert sample data for custom_fields (if empty)
INSERT INTO `custom_fields` (`module`, `name`, `label`, `data_type`, `is_required`, `is_active`, `sort_order`, `created_at`, `updated_at`)
SELECT * FROM (
    SELECT 'pim' as module, 'emergency_contact' as name, 'Emergency Contact' as label, 'text' as data_type, 0 as is_required, 1 as is_active, 1 as sort_order, NOW() as created_at, NOW() as updated_at
    UNION ALL
    SELECT 'pim', 'employee_photo', 'Employee Photo', 'text', 0, 1, 2, NOW(), NOW()
    UNION ALL
    SELECT 'pim', 'additional_notes', 'Additional Notes', 'textarea', 0, 1, 3, NOW(), NOW()
) AS fields
WHERE NOT EXISTS (SELECT 1 FROM `custom_fields` WHERE `custom_fields`.`module` = fields.module AND `custom_fields`.`name` = fields.name);

-- Insert sample data for attendance_records (if empty or minimal)
INSERT INTO `attendance_records` (`employee_id`, `punch_in_at`, `punch_out_at`, `punch_in_ip`, `punch_out_ip`, `remarks`, `created_at`, `updated_at`)
SELECT 
    e.id as employee_id,
    DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 7) DAY) + INTERVAL FLOOR(RAND() * 8 + 9) HOUR as punch_in_at,
    DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 7) DAY) + INTERVAL FLOOR(RAND() * 8 + 17) HOUR as punch_out_at,
    CONCAT('192.168.1.', FLOOR(RAND() * 255)) as punch_in_ip,
    CONCAT('192.168.1.', FLOOR(RAND() * 255)) as punch_out_ip,
    'Regular attendance' as remarks,
    NOW() as created_at,
    NOW() as updated_at
FROM `employees` e
WHERE e.status = 'active'
AND NOT EXISTS (
    SELECT 1 FROM `attendance_records` ar 
    WHERE ar.employee_id = e.id 
    AND DATE(ar.punch_in_at) = DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 7) DAY)
)
LIMIT 20;

-- Insert sample data for timesheet_rows (if timesheet exists but no rows)
INSERT INTO `timesheet_rows` (`timesheet_id`, `work_date`, `project_id`, `hours_worked`, `overtime_hours`, `notes`, `created_at`, `updated_at`)
SELECT 
    t.id as timesheet_id,
    DATE_ADD(t.start_date, INTERVAL (FLOOR(RAND() * DATEDIFF(t.end_date, t.start_date))) DAY) as work_date,
    (SELECT id FROM `time_projects` ORDER BY RAND() LIMIT 1) as project_id,
    8.00 + (RAND() * 2 - 1) as hours_worked,
    0.00 as overtime_hours,
    'Regular work' as notes,
    NOW() as created_at,
    NOW() as updated_at
FROM `timesheets` t
WHERE NOT EXISTS (
    SELECT 1 FROM `timesheet_rows` tr WHERE tr.timesheet_id = t.id
)
LIMIT 50;

-- Insert sample data for buzz_post_likes (if posts exist but no likes)
INSERT INTO `buzz_post_likes` (`post_id`, `user_id`, `created_at`)
SELECT 
    bp.id as post_id,
    u.id as user_id,
    DATE_ADD(bp.created_at, INTERVAL FLOOR(RAND() * 7) DAY) as created_at
FROM `buzz_posts` bp
CROSS JOIN `users` u
WHERE NOT EXISTS (
    SELECT 1 FROM `buzz_post_likes` bpl 
    WHERE bpl.post_id = bp.id AND bpl.user_id = u.id
)
AND RAND() < 0.3  -- 30% chance of like
LIMIT 20;

-- Insert sample data for buzz_post_comments (if posts exist but no comments)
INSERT INTO `buzz_post_comments` (`post_id`, `author_id`, `body`, `created_at`)
SELECT 
    bp.id as post_id,
    u.id as author_id,
    CASE (FLOOR(RAND() * 5))
        WHEN 0 THEN 'Great post!'
        WHEN 1 THEN 'Thanks for sharing.'
        WHEN 2 THEN 'Very informative.'
        WHEN 3 THEN 'I agree with this.'
        ELSE 'Looking forward to more updates.'
    END as body,
    DATE_ADD(bp.created_at, INTERVAL FLOOR(RAND() * 7) DAY) as created_at
FROM `buzz_posts` bp
CROSS JOIN `users` u
WHERE NOT EXISTS (
    SELECT 1 FROM `buzz_post_comments` bpc 
    WHERE bpc.post_id = bp.id AND bpc.author_id = u.id
)
AND RAND() < 0.2  -- 20% chance of comment
LIMIT 10;

-- Insert sample data for employee_qualifications (if empty)
INSERT INTO `employee_qualifications` (`employee_id`, `qualification_id`, `institution`, `start_date`, `end_date`, `grade`, `created_at`, `updated_at`)
SELECT 
    e.id as employee_id,
    q.id as qualification_id,
    CASE (FLOOR(RAND() * 3))
        WHEN 0 THEN 'University of Technology'
        WHEN 1 THEN 'State University'
        ELSE 'Community College'
    END as institution,
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 10 + 5) YEAR) as start_date,
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 5) YEAR) as end_date,
    CASE (FLOOR(RAND() * 5))
        WHEN 0 THEN 'A+'
        WHEN 1 THEN 'A'
        WHEN 2 THEN 'B+'
        WHEN 3 THEN 'B'
        ELSE 'C+'
    END as grade,
    NOW() as created_at,
    NOW() as updated_at
FROM `employees` e
CROSS JOIN `qualifications` q
WHERE q.type IN ('education', 'certification')
AND NOT EXISTS (
    SELECT 1 FROM `employee_qualifications` eq 
    WHERE eq.employee_id = e.id AND eq.qualification_id = q.id
)
AND RAND() < 0.3  -- 30% chance of qualification
LIMIT 15;

-- Update organizations table with sample data if missing
UPDATE `organizations`
SET 
    `tax_id` = COALESCE(`tax_id`, 'TAX-001'),
    `fax` = COALESCE(`fax`, '+1-555-0100'),
    `address_line1` = COALESCE(`address_line1`, '538 Teal Plaza'),
    `address_line2` = COALESCE(`address_line2`, 'Suite 100'),
    `city` = COALESCE(`city`, 'Secaucus'),
    `state` = COALESCE(`state`, 'NJ'),
    `zip_postal_code` = COALESCE(`zip_postal_code`, '07094'),
    `country` = COALESCE(`country`, 'United States'),
    `notes` = COALESCE(`notes`, 'HRM Software Company')
WHERE `id` = 1
AND (`tax_id` IS NULL OR `fax` IS NULL OR `address_line1` IS NULL);

-- =========================================================
-- PART 3: VERIFICATION QUERIES
-- =========================================================

-- Check for tables with no data
SELECT 'Tables with no data:' as check_type;
SELECT 'employee_job_details' as table_name, COUNT(*) as record_count FROM `employee_job_details`
UNION ALL
SELECT 'employee_personal_details', COUNT(*) FROM `employee_personal_details`
UNION ALL
SELECT 'work_shifts', COUNT(*) FROM `work_shifts`
UNION ALL
SELECT 'pay_grades', COUNT(*) FROM `pay_grades`
UNION ALL
SELECT 'email_subscriptions', COUNT(*) FROM `email_subscriptions`
UNION ALL
SELECT 'language_packages', COUNT(*) FROM `language_packages`
UNION ALL
SELECT 'enabled_modules', COUNT(*) FROM `enabled_modules`
UNION ALL
SELECT 'custom_fields', COUNT(*) FROM `custom_fields`
UNION ALL
SELECT 'attendance_records', COUNT(*) FROM `attendance_records`
UNION ALL
SELECT 'buzz_post_likes', COUNT(*) FROM `buzz_post_likes`
UNION ALL
SELECT 'buzz_post_comments', COUNT(*) FROM `buzz_post_comments`
UNION ALL
SELECT 'employee_qualifications', COUNT(*) FROM `employee_qualifications`;

-- =========================================================
-- END OF SCRIPT
-- =========================================================

