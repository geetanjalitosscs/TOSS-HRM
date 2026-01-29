-- =========================================================
-- UI REQUIRED SAMPLE DATA SEED (SAFE / PRACTICAL)
-- Generated: 2026-01-28
-- Goal:
--   Fill ONLY those tables that drive visible UI pages (lists/cards)
--   Avoid system/log/session tables (sessions, audit_logs, activity_logs, etc.)
-- Notes:
--   - Run on an EMPTY DB or after TRUNCATE of master/config tables
--   - Uses INSERT ... SELECT ... WHERE NOT EXISTS to avoid duplicates
--   - Keep execution order: parents -> children (FK safe)
-- =========================================================

USE toai_hrm;

-- ----------------------------
-- 1) USERS (login) + ROLE LINK
-- ----------------------------
INSERT INTO users (id, username, email, password_hash, employee_id, is_active, created_at, updated_at)
SELECT 1, 'admin', 'admin@gmail.com', '$2y$10$admin123admin123admin123admin123admin123admin123admin123admin12', NULL, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE id = 1);

INSERT INTO user_roles (user_id, role_id, created_at)
SELECT 1, 1, NOW()
WHERE NOT EXISTS (SELECT 1 FROM user_roles WHERE user_id = 1 AND role_id = 1);

-- ----------------------------
-- 2) ORGANIZATION (Admin → Organization)
-- ----------------------------
INSERT INTO organizations (
  id, name, registration_number, tax_id, phone, fax, email, website,
  address_line1, address_line2, city, state, zip_postal_code, country, notes,
  created_at, updated_at
)
SELECT
  1,
  'TOAI HR Suite Demo',
  'TOAI-REG-001',
  'TAX-001',
  '+1-555-0100',
  '+1-555-0109',
  'hr@toai-demo.test',
  'https://demo.toai-hr.test',
  '538 Teal Plaza',
  'Suite 100',
  'Secaucus',
  'NJ',
  '07094',
  'United States',
  'Seed data for UI demo',
  NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM organizations WHERE id = 1);

-- ----------------------------
-- 3) CONFIG TABLES (Admin → Configuration)
-- ----------------------------
INSERT INTO enabled_modules (module_key, is_enabled, created_at, updated_at)
SELECT t.module_key, 1, NOW(), NOW()
FROM (
  SELECT 'admin' module_key UNION ALL
  SELECT 'pim' UNION ALL
  SELECT 'leave' UNION ALL
  SELECT 'time' UNION ALL
  SELECT 'recruitment' UNION ALL
  SELECT 'performance' UNION ALL
  SELECT 'directory' UNION ALL
  SELECT 'maintenance' UNION ALL
  SELECT 'mobile' UNION ALL
  SELECT 'claim' UNION ALL
  SELECT 'buzz'
) t
WHERE NOT EXISTS (SELECT 1 FROM enabled_modules em WHERE em.module_key = t.module_key);

INSERT INTO language_packages (code, name, is_default, sort_order, is_active, created_at, updated_at)
SELECT t.code, t.name, t.is_default, t.sort_order, 1, NOW(), NOW()
FROM (
  SELECT 'en' code, 'English' name, 1 is_default, 1 sort_order UNION ALL
  SELECT 'hi', 'Hindi', 0, 2 UNION ALL
  SELECT 'es', 'Spanish', 0, 3
) t
WHERE NOT EXISTS (SELECT 1 FROM language_packages lp WHERE lp.code = t.code);

INSERT INTO email_settings (id, mail_from_name, mail_from_address, sending_method, smtp_host, smtp_port, smtp_username, smtp_password, smtp_encryption, sendmail_path, send_test_mail, test_recipient, created_at, updated_at)
SELECT 1, 'TOAI HR', 'no-reply@toai-demo.test', 'smtp', 'smtp.example.test', 587, 'user', 'pass', 'tls', NULL, 0, NULL, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM email_settings WHERE id = 1);

INSERT INTO email_subscriptions (notification_key, name, description, is_enabled, created_at, updated_at)
SELECT t.notification_key, t.name, t.description, 1, NOW(), NOW()
FROM (
  SELECT 'leave_application' notification_key, 'Leave Application' name, 'Leave request notifications' description UNION ALL
  SELECT 'claim_submission', 'Claim Submission', 'Claim request notifications' UNION ALL
  SELECT 'timesheet_submission', 'Timesheet Submission', 'Timesheet notifications' UNION ALL
  SELECT 'performance_review', 'Performance Review', 'Performance notifications'
) t
WHERE NOT EXISTS (SELECT 1 FROM email_subscriptions es WHERE es.notification_key = t.notification_key);

INSERT INTO localization_settings (id, language, date_format, time_format, timezone, created_at, updated_at)
SELECT 1, 'en', 'Y-m-d', 'H:i', 'UTC', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM localization_settings WHERE id = 1);

INSERT INTO ldap_settings (id, enabled, created_at, updated_at)
SELECT 1, 0, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM ldap_settings WHERE id = 1);

INSERT INTO corporate_branding (id, organization_id, primary_color, secondary_color, accent_color, logo_file_id, banner_file_id, dark_mode_enabled, created_at, updated_at)
SELECT 1, 1, '#8B5CF6', '#6D28D9', '#A78BFA', NULL, NULL, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM corporate_branding WHERE id = 1);

-- optional: oauth_clients / social_providers (only for admin pages)
INSERT INTO oauth_clients (name, redirect_uri, is_active, created_at, updated_at)
SELECT 'Demo OAuth Client', 'https://example.test/callback', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM oauth_clients WHERE name = 'Demo OAuth Client');

INSERT INTO social_providers (name, client_id, client_secret, redirect_uri, is_active, created_at, updated_at)
SELECT 'Google', 'demo-client', 'demo-secret', 'https://example.test/auth/callback', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM social_providers WHERE name = 'Google');

-- ----------------------------
-- 4) EMPLOYEES (PIM + Directory + Dashboard)
-- ----------------------------
-- Ensure at least 2 employees exist (IDs 1 and 2 expected by many pages)
INSERT INTO employees (
  id, employee_number, organization_id, first_name, middle_name, last_name, display_name,
  date_of_birth, gender, marital_status, national_id, hire_date, termination_date, status,
  location_id, organization_unit_id, job_title_id, employment_status_id, pay_grade_id, supervisor_id,
  created_at, updated_at, deleted_at
)
SELECT
  1, '0001', 1, 'Manda', 'Akhil', 'User', 'manda akhil user',
  '1995-01-15', 'male', 'single', 'NID-0001', '2020-06-01', NULL, 'active',
  2, 1, 1, 1, NULL, NULL,
  NOW(), NOW(), NULL
WHERE NOT EXISTS (SELECT 1 FROM employees WHERE id = 1);

INSERT INTO employees (
  id, employee_number, organization_id, first_name, middle_name, last_name, display_name,
  date_of_birth, gender, marital_status, national_id, hire_date, termination_date, status,
  location_id, organization_unit_id, job_title_id, employment_status_id, pay_grade_id, supervisor_id,
  created_at, updated_at, deleted_at
)
SELECT
  2, '0002', 1, 'Jane', NULL, 'Doe', 'Jane Doe',
  '1990-03-10', 'female', 'married', 'NID-0002', '2019-03-01', NULL, 'active',
  3, 4, 5, 1, NULL, 1,
  NOW(), NOW(), NULL
WHERE NOT EXISTS (SELECT 1 FROM employees WHERE id = 2);

-- Link admin user to employee 1 if empty (so dashboard/myinfo resolve employee_id)
UPDATE users
SET employee_id = 1
WHERE id = 1 AND (employee_id IS NULL OR employee_id = 0);

-- ----------------------------
-- 5) EMPLOYEE DETAIL TABLES (MyInfo + Dashboard charts)
-- ----------------------------
INSERT INTO employee_personal_details (
  employee_id, nationality_id, other_id, drivers_license, license_expiry, smoker, blood_group,
  address1, address2, city, state, postal_code, country, home_phone, mobile_phone, work_phone,
  work_email, other_email, created_at, updated_at
)
SELECT
  e.id,
  1,
  CONCAT('ID-', LPAD(e.id, 6, '0')),
  CONCAT('DL-', LPAD(e.id, 8, '0')),
  DATE_ADD(CURDATE(), INTERVAL 5 YEAR),
  0,
  'O+',
  CONCAT(e.id * 10, ' Main Street'),
  NULL,
  'Austin',
  'Texas',
  '00000',
  'United States',
  NULL,
  CONCAT('+1-555-', LPAD(1000 + e.id, 4, '0')),
  NULL,
  CONCAT(LOWER(REPLACE(COALESCE(e.display_name, CONCAT(e.first_name,' ',e.last_name)), ' ', '.')), '@company.test'),
  NULL,
  NOW(), NOW()
FROM employees e
WHERE NOT EXISTS (SELECT 1 FROM employee_personal_details epd WHERE epd.employee_id = e.id)
LIMIT 10;

-- Minimal current-job rows for charts (pick current data from employees table)
INSERT INTO employee_job_details (
  employee_id, job_title_id, employment_status_id, organization_unit_id, location_id, supervisor_id, effective_date, end_date, created_at, updated_at
)
SELECT
  e.id, e.job_title_id, e.employment_status_id, e.organization_unit_id, e.location_id, e.supervisor_id,
  e.hire_date, NULL, NOW(), NOW()
FROM employees e
WHERE NOT EXISTS (SELECT 1 FROM employee_job_details ejd WHERE ejd.employee_id = e.id)
LIMIT 10;

-- ----------------------------
-- 6) TIME MODULE (Timesheets + Projects + Attendance)
-- ----------------------------
INSERT INTO time_customers (id, name, description, is_active, created_at, updated_at)
SELECT 1, 'Acme Corp', 'External customer for demo project', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM time_customers WHERE id = 1);

INSERT INTO time_projects (id, customer_id, name, description, is_active, created_at, updated_at)
SELECT 1, 1, 'Acme HR Implementation', 'Implementation project for Acme Corp', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM time_projects WHERE id = 1);

INSERT INTO time_project_assignments (project_id, employee_id, role, hourly_rate, created_at)
SELECT 1, 1, 'Developer', 75.00, NOW()
WHERE NOT EXISTS (SELECT 1 FROM time_project_assignments WHERE project_id = 1 AND employee_id = 1);

-- One approved timesheet for employee 1
INSERT INTO timesheets (id, employee_id, start_date, end_date, status, submitted_at, approved_by, approved_at, remarks, created_at, updated_at)
SELECT 1, 1, DATE_SUB(CURDATE(), INTERVAL 7 DAY), DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'approved', NOW(), 2, NOW(), 'Demo timesheet', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM timesheets WHERE id = 1);

-- Timesheet rows for that timesheet (2 days)
INSERT INTO timesheet_rows (timesheet_id, work_date, project_id, hours_worked, overtime_hours, notes, created_at, updated_at)
SELECT 1, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 1, 8.00, 0.00, 'Feature work', NOW(), NOW()
WHERE NOT EXISTS (
  SELECT 1 FROM timesheet_rows WHERE timesheet_id = 1 AND work_date = DATE_SUB(CURDATE(), INTERVAL 6 DAY)
);

INSERT INTO timesheet_rows (timesheet_id, work_date, project_id, hours_worked, overtime_hours, notes, created_at, updated_at)
SELECT 1, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 1, 8.00, 0.00, 'Bug fixes', NOW(), NOW()
WHERE NOT EXISTS (
  SELECT 1 FROM timesheet_rows WHERE timesheet_id = 1 AND work_date = DATE_SUB(CURDATE(), INTERVAL 5 DAY)
);

-- Attendance records for last 7 days (employee 1)
INSERT INTO attendance_records (employee_id, punch_in_at, punch_out_at, punch_in_ip, punch_out_ip, punch_in_source, punch_out_source, remarks, created_at, updated_at)
SELECT
  1,
  DATE_SUB(NOW(), INTERVAL d.day_offset DAY) + INTERVAL 9 HOUR,
  DATE_SUB(NOW(), INTERVAL d.day_offset DAY) + INTERVAL 17 HOUR,
  '127.0.0.1',
  '127.0.0.1',
  'web',
  'web',
  'Seed attendance',
  NOW(), NOW()
FROM (
  SELECT 0 day_offset UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6
) d
WHERE NOT EXISTS (
  SELECT 1 FROM attendance_records ar
  WHERE ar.employee_id = 1 AND DATE(ar.punch_in_at) = DATE(DATE_SUB(NOW(), INTERVAL d.day_offset DAY))
);

-- ----------------------------
-- 7) LEAVE MODULE (Entitlements + Applications)
-- ----------------------------
-- current leave period must exist (if not)
INSERT INTO leave_periods (id, name, period_start, period_end, is_current, created_at, updated_at)
SELECT 1, CONCAT(YEAR(CURDATE()), ' Leave Period'), MAKEDATE(YEAR(CURDATE()), 1), MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL 1 YEAR - INTERVAL 1 DAY, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM leave_periods WHERE id = 1);

INSERT INTO leave_entitlements (employee_id, leave_type_id, period_start, period_end, days_entitled, days_used, created_at, updated_at)
SELECT 1, 1, MAKEDATE(YEAR(CURDATE()), 1), MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL 1 YEAR - INTERVAL 1 DAY, 24.00, 2.00, NOW(), NOW()
WHERE NOT EXISTS (
  SELECT 1 FROM leave_entitlements
  WHERE employee_id = 1 AND leave_type_id = 1 AND period_start = MAKEDATE(YEAR(CURDATE()), 1)
);

-- one approved leave spanning today (for Dashboard “Employees on Leave Today”)
INSERT INTO leave_applications (employee_id, leave_type_id, start_date, end_date, total_days, status, applied_at, approved_by, approved_at, reason, created_at, updated_at)
SELECT 1, 1, CURDATE(), CURDATE(), 1.00, 'approved', NOW(), 2, NOW(), 'Seed leave for dashboard', NOW(), NOW()
WHERE NOT EXISTS (
  SELECT 1 FROM leave_applications
  WHERE employee_id = 1 AND start_date = CURDATE() AND end_date = CURDATE()
);

-- ----------------------------
-- 8) CLAIM MODULE (Requests)
-- ----------------------------
INSERT INTO claim_requests (employee_id, claim_date, total_amount, currency, status, submitted_at, approved_by, approved_at, paid_at, remarks, created_at, updated_at)
SELECT 1, CURDATE(), 250.00, 'USD', 'approved', NOW(), 2, NOW(), NULL, 'Seed claim', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM claim_requests WHERE employee_id = 1 AND claim_date = CURDATE() AND total_amount = 250.00);

-- ----------------------------
-- 9) RECRUITMENT (Vacancies + Candidate flow)
-- ----------------------------
INSERT INTO vacancies (job_title_id, hiring_manager_id, location_id, name, description, positions, status, posted_date, closing_date, created_at, updated_at)
SELECT 2, 1, 2, 'Senior QA Lead', 'Lead QA for TOAI HR Suite', 1, 'open', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 60 DAY), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM vacancies WHERE name = 'Senior QA Lead');

INSERT INTO candidates (first_name, middle_name, last_name, email, phone, source_id, resume_file_id, notes, created_at, updated_at)
SELECT 'Alex', NULL, 'Smith', 'alex.smith@example.test', '+1-555-0200', 1, NULL, 'Strong QA background.', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM candidates WHERE email = 'alex.smith@example.test');

INSERT INTO candidate_applications (candidate_id, vacancy_id, applied_date, status, current_stage, created_at, updated_at)
SELECT
  (SELECT id FROM candidates WHERE email = 'alex.smith@example.test' LIMIT 1),
  (SELECT id FROM vacancies WHERE name = 'Senior QA Lead' LIMIT 1),
  CURDATE(),
  'shortlisted',
  'Interview Scheduled',
  NOW(), NOW()
WHERE NOT EXISTS (
  SELECT 1 FROM candidate_applications ca
  JOIN candidates c ON ca.candidate_id = c.id
  JOIN vacancies v ON ca.vacancy_id = v.id
  WHERE c.email = 'alex.smith@example.test' AND v.name = 'Senior QA Lead'
);

-- ----------------------------
-- 10) PERFORMANCE (Cycles + Reviews)
-- ----------------------------
INSERT INTO performance_cycles (id, name, start_date, end_date, status, created_at, updated_at)
SELECT 1, CONCAT(YEAR(CURDATE()), ' Annual Review'), MAKEDATE(YEAR(CURDATE()), 1), MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL 1 YEAR - INTERVAL 1 DAY, 'active', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM performance_cycles WHERE id = 1);

INSERT INTO performance_reviews (cycle_id, employee_id, reviewer_id, status, overall_rating, comments, created_at, updated_at)
SELECT 1, 1, 2, 'completed', 4.50, 'Seed review', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM performance_reviews WHERE cycle_id = 1 AND employee_id = 1);

-- ----------------------------
-- 11) BUZZ (Likes / Comments for tabs)
-- ----------------------------
INSERT INTO buzz_post_likes (post_id, user_id, created_at)
SELECT bp.id, 1, NOW()
FROM buzz_posts bp
WHERE NOT EXISTS (SELECT 1 FROM buzz_post_likes bpl WHERE bpl.post_id = bp.id AND bpl.user_id = 1)
LIMIT 5;

INSERT INTO buzz_post_comments (post_id, author_id, body, created_at)
SELECT bp.id, 1, 'Nice update!', NOW()
FROM buzz_posts bp
WHERE NOT EXISTS (SELECT 1 FROM buzz_post_comments bpc WHERE bpc.post_id = bp.id AND bpc.author_id = 1)
LIMIT 3;

-- ----------------------------
-- 12) PIM REPORTS (depends on employee_qualifications)
-- ----------------------------
INSERT INTO employee_qualifications (employee_id, qualification_id, institution, start_date, end_date, grade, created_at, updated_at)
SELECT 1, 4, 'University of Technology', '2012-01-01', '2016-01-01', 'A', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM employee_qualifications WHERE employee_id = 1 AND qualification_id = 4);

-- ----------------------------
-- 13) PIM CONFIG (Custom Fields list page)
-- ----------------------------
INSERT INTO custom_fields (module, name, label, data_type, options_json, is_required, is_active, sort_order, created_at, updated_at)
SELECT 'pim', 'emergency_contact', 'Emergency Contact', 'text', NULL, 0, 1, 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM custom_fields WHERE module = 'pim' AND name = 'emergency_contact');

-- =========================================================
-- QUICK CHECKS (optional)
-- =========================================================
-- SELECT 'attendance_records' tbl, COUNT(*) cnt FROM attendance_records;
-- SELECT 'timesheets' tbl, COUNT(*) cnt FROM timesheets;
-- SELECT 'leave_applications' tbl, COUNT(*) cnt FROM leave_applications;
-- SELECT 'claim_requests' tbl, COUNT(*) cnt FROM claim_requests;
-- SELECT 'candidate_applications' tbl, COUNT(*) cnt FROM candidate_applications;
-- SELECT 'performance_reviews' tbl, COUNT(*) cnt FROM performance_reviews;


