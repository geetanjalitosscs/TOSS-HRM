-- =====================================================
-- TOSS-HRM Database Schema
-- Generated from Frontend Analysis
-- Date: January 24, 2026
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- =====================================================
-- 1. CORE TABLES
-- =====================================================

-- Organizations Table
CREATE TABLE IF NOT EXISTS `organizations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `tax_id` VARCHAR(100) DEFAULT NULL,
  `registration_number` VARCHAR(100) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `fax` VARCHAR(50) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `website` VARCHAR(255) DEFAULT NULL,
  `address_line1` VARCHAR(255) DEFAULT NULL,
  `address_line2` VARCHAR(255) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `state` VARCHAR(100) DEFAULT NULL,
  `zip_code` VARCHAR(20) DEFAULT NULL,
  `country` VARCHAR(100) DEFAULT NULL,
  `note` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_organizations_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Locations Table
CREATE TABLE IF NOT EXISTS `locations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `country` VARCHAR(100) DEFAULT NULL,
  `province` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `zip_code` VARCHAR(20) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `fax` VARCHAR(50) DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_locations_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sub Units Table
CREATE TABLE IF NOT EXISTS `sub_units` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `unit_head_id` BIGINT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_sub_units_name` (`name`),
  INDEX `idx_sub_units_unit_head` (`unit_head_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Nationalities Table
CREATE TABLE IF NOT EXISTS `nationalities` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(10) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nationalities_name` (`name`),
  INDEX `idx_nationalities_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Currencies Table (needed early for pay_grades)
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(3) NOT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  `symbol` VARCHAR(10) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_currencies_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Termination Reasons Table (needed early for employees)
CREATE TABLE IF NOT EXISTS `termination_reasons` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_termination_reasons_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. JOB MANAGEMENT TABLES
-- =====================================================

-- Job Categories Table
CREATE TABLE IF NOT EXISTS `job_categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_job_categories_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Job Titles Table
CREATE TABLE IF NOT EXISTS `job_titles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `job_category_id` BIGINT UNSIGNED DEFAULT NULL,
  `job_specification` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_job_titles_title` (`title`),
  INDEX `idx_job_titles_category` (`job_category_id`),
  CONSTRAINT `fk_job_titles_category` FOREIGN KEY (`job_category_id`) REFERENCES `job_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employment Status Table
CREATE TABLE IF NOT EXISTS `employment_status` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_employment_status_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pay Grades Table
CREATE TABLE IF NOT EXISTS `pay_grades` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `currency_id` BIGINT UNSIGNED DEFAULT NULL,
  `min_salary` DECIMAL(15,2) DEFAULT NULL,
  `max_salary` DECIMAL(15,2) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_pay_grades_name` (`name`),
  INDEX `idx_pay_grades_currency` (`currency_id`),
  CONSTRAINT `fk_pay_grades_currency` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Work Shifts Table
CREATE TABLE IF NOT EXISTS `work_shifts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `hours_per_day` DECIMAL(5,2) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_work_shifts_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. USERS & EMPLOYEES TABLES
-- =====================================================

-- Employees Table
CREATE TABLE IF NOT EXISTS `employees` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` VARCHAR(50) DEFAULT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `middle_name` VARCHAR(255) DEFAULT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `gender` ENUM('Male', 'Female', 'Other') DEFAULT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `marital_status` ENUM('Single', 'Married', 'Divorced', 'Widowed') DEFAULT NULL,
  `nationality_id` BIGINT UNSIGNED DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `mobile` VARCHAR(50) DEFAULT NULL,
  `address_line1` VARCHAR(255) DEFAULT NULL,
  `address_line2` VARCHAR(255) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `state` VARCHAR(100) DEFAULT NULL,
  `zip_code` VARCHAR(20) DEFAULT NULL,
  `country` VARCHAR(100) DEFAULT NULL,
  `job_title_id` BIGINT UNSIGNED DEFAULT NULL,
  `employment_status_id` BIGINT UNSIGNED DEFAULT NULL,
  `sub_unit_id` BIGINT UNSIGNED DEFAULT NULL,
  `location_id` BIGINT UNSIGNED DEFAULT NULL,
  `supervisor_id` BIGINT UNSIGNED DEFAULT NULL,
  `pay_grade_id` BIGINT UNSIGNED DEFAULT NULL,
  `work_shift_id` BIGINT UNSIGNED DEFAULT NULL,
  `joined_date` DATE DEFAULT NULL,
  `terminated_date` DATE DEFAULT NULL,
  `termination_reason_id` BIGINT UNSIGNED DEFAULT NULL,
  `status` ENUM('Active', 'Terminated', 'On Leave') DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_employees_employee_id` (`employee_id`),
  INDEX `idx_employees_name` (`first_name`, `last_name`),
  INDEX `idx_employees_email` (`email`),
  INDEX `idx_employees_job_title` (`job_title_id`),
  INDEX `idx_employees_employment_status` (`employment_status_id`),
  INDEX `idx_employees_sub_unit` (`sub_unit_id`),
  INDEX `idx_employees_location` (`location_id`),
  INDEX `idx_employees_supervisor` (`supervisor_id`),
  INDEX `idx_employees_nationality` (`nationality_id`),
  INDEX `idx_employees_status` (`status`),
  CONSTRAINT `fk_employees_job_title` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_employees_employment_status` FOREIGN KEY (`employment_status_id`) REFERENCES `employment_status` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_employees_sub_unit` FOREIGN KEY (`sub_unit_id`) REFERENCES `sub_units` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_employees_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_employees_supervisor` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_employees_nationality` FOREIGN KEY (`nationality_id`) REFERENCES `nationalities` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_employees_pay_grade` FOREIGN KEY (`pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_employees_work_shift` FOREIGN KEY (`work_shift_id`) REFERENCES `work_shifts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_employees_termination_reason` FOREIGN KEY (`termination_reason_id`) REFERENCES `termination_reasons` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `employee_id` BIGINT UNSIGNED DEFAULT NULL,
  `role` ENUM('Admin', 'ESS') NOT NULL DEFAULT 'ESS',
  `status` ENUM('Enabled', 'Disabled') NOT NULL DEFAULT 'Enabled',
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `last_login_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_users_username` (`username`),
  INDEX `idx_users_employee` (`employee_id`),
  INDEX `idx_users_role` (`role`),
  INDEX `idx_users_status` (`status`),
  CONSTRAINT `fk_users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. LEAVE MANAGEMENT TABLES
-- =====================================================

-- Leave Types Table
CREATE TABLE IF NOT EXISTS `leave_types` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `entitlement_days` DECIMAL(5,2) DEFAULT 0.00,
  `carry_forward` TINYINT(1) DEFAULT 0,
  `max_carry_forward_days` DECIMAL(5,2) DEFAULT NULL,
  `exclude_holidays` TINYINT(1) DEFAULT 1,
  `exclude_weekends` TINYINT(1) DEFAULT 1,
  `status` ENUM('Active', 'Inactive') DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_leave_types_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Leave Periods Table
CREATE TABLE IF NOT EXISTS `leave_periods` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `is_current` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_leave_periods_dates` (`start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Work Week Table
CREATE TABLE IF NOT EXISTS `work_weeks` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `monday` TINYINT(1) DEFAULT 1,
  `tuesday` TINYINT(1) DEFAULT 1,
  `wednesday` TINYINT(1) DEFAULT 1,
  `thursday` TINYINT(1) DEFAULT 1,
  `friday` TINYINT(1) DEFAULT 1,
  `saturday` TINYINT(1) DEFAULT 0,
  `sunday` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Holidays Table
CREATE TABLE IF NOT EXISTS `holidays` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `date` DATE NOT NULL,
  `recurring` TINYINT(1) DEFAULT 0,
  `length` DECIMAL(3,1) DEFAULT 1.0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_holidays_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Leave Entitlements Table
CREATE TABLE IF NOT EXISTS `leave_entitlements` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `leave_type_id` BIGINT UNSIGNED NOT NULL,
  `leave_period_id` BIGINT UNSIGNED NOT NULL,
  `entitlement_days` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `used_days` DECIMAL(5,2) DEFAULT 0.00,
  `pending_days` DECIMAL(5,2) DEFAULT 0.00,
  `balance_days` DECIMAL(5,2) DEFAULT 0.00,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_leave_entitlements_employee` (`employee_id`),
  INDEX `idx_leave_entitlements_leave_type` (`leave_type_id`),
  INDEX `idx_leave_entitlements_period` (`leave_period_id`),
  CONSTRAINT `fk_leave_entitlements_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_leave_entitlements_leave_type` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_leave_entitlements_period` FOREIGN KEY (`leave_period_id`) REFERENCES `leave_periods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Leave Requests Table
CREATE TABLE IF NOT EXISTS `leave_requests` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `leave_type_id` BIGINT UNSIGNED NOT NULL,
  `from_date` DATE NOT NULL,
  `to_date` DATE NOT NULL,
  `number_of_days` DECIMAL(5,2) NOT NULL,
  `comments` TEXT DEFAULT NULL,
  `status` ENUM('Pending Approval', 'Approved', 'Rejected', 'Cancelled') DEFAULT 'Pending Approval',
  `applied_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `approved_by` BIGINT UNSIGNED DEFAULT NULL,
  `approved_date` TIMESTAMP NULL DEFAULT NULL,
  `rejected_by` BIGINT UNSIGNED DEFAULT NULL,
  `rejected_date` TIMESTAMP NULL DEFAULT NULL,
  `rejection_reason` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_leave_requests_employee` (`employee_id`),
  INDEX `idx_leave_requests_leave_type` (`leave_type_id`),
  INDEX `idx_leave_requests_dates` (`from_date`, `to_date`),
  INDEX `idx_leave_requests_status` (`status`),
  INDEX `idx_leave_requests_approved_by` (`approved_by`),
  CONSTRAINT `fk_leave_requests_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_leave_requests_leave_type` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_leave_requests_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_leave_requests_rejected_by` FOREIGN KEY (`rejected_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. TIME & ATTENDANCE TABLES
-- =====================================================

-- Attendance Configuration Table
CREATE TABLE IF NOT EXISTS `attendance_configuration` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_can_change_time` TINYINT(1) DEFAULT 1,
  `employee_can_edit_delete` TINYINT(1) DEFAULT 1,
  `supervisor_can_manage` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Attendance Records Table
CREATE TABLE IF NOT EXISTS `attendance_records` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `date` DATE NOT NULL,
  `punch_in_time` TIMESTAMP NULL DEFAULT NULL,
  `punch_out_time` TIMESTAMP NULL DEFAULT NULL,
  `total_duration` DECIMAL(6,2) DEFAULT 0.00 COMMENT 'Hours',
  `break_duration` DECIMAL(6,2) DEFAULT 0.00 COMMENT 'Hours',
  `overtime_hours` DECIMAL(6,2) DEFAULT 0.00,
  `note` TEXT DEFAULT NULL,
  `location` VARCHAR(255) DEFAULT NULL,
  `created_by` BIGINT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_attendance_employee` (`employee_id`),
  INDEX `idx_attendance_date` (`date`),
  INDEX `idx_attendance_employee_date` (`employee_id`, `date`),
  CONSTRAINT `fk_attendance_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_attendance_created_by` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Projects Table
CREATE TABLE IF NOT EXISTS `projects` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `customer_name` VARCHAR(255) DEFAULT NULL,
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `status` ENUM('Active', 'Inactive', 'Completed') DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_projects_name` (`name`),
  INDEX `idx_projects_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Activities Table
CREATE TABLE IF NOT EXISTS `activities` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `project_id` BIGINT UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_activities_name` (`name`),
  INDEX `idx_activities_project` (`project_id`),
  CONSTRAINT `fk_activities_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Timesheets Table
CREATE TABLE IF NOT EXISTS `timesheets` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `status` ENUM('Draft', 'Submitted', 'Approved', 'Rejected') DEFAULT 'Draft',
  `submitted_date` TIMESTAMP NULL DEFAULT NULL,
  `approved_by` BIGINT UNSIGNED DEFAULT NULL,
  `approved_date` TIMESTAMP NULL DEFAULT NULL,
  `total_hours` DECIMAL(8,2) DEFAULT 0.00,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_timesheets_employee` (`employee_id`),
  INDEX `idx_timesheets_dates` (`start_date`, `end_date`),
  INDEX `idx_timesheets_status` (`status`),
  CONSTRAINT `fk_timesheets_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timesheets_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Timesheet Entries Table
CREATE TABLE IF NOT EXISTS `timesheet_entries` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `timesheet_id` BIGINT UNSIGNED NOT NULL,
  `project_id` BIGINT UNSIGNED NOT NULL,
  `activity_id` BIGINT UNSIGNED NOT NULL,
  `date` DATE NOT NULL,
  `hours` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `comment` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_timesheet_entries_timesheet` (`timesheet_id`),
  INDEX `idx_timesheet_entries_project` (`project_id`),
  INDEX `idx_timesheet_entries_activity` (`activity_id`),
  INDEX `idx_timesheet_entries_date` (`date`),
  CONSTRAINT `fk_timesheet_entries_timesheet` FOREIGN KEY (`timesheet_id`) REFERENCES `timesheets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timesheet_entries_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timesheet_entries_activity` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. PERFORMANCE MANAGEMENT TABLES
-- =====================================================

-- KPIs Table
CREATE TABLE IF NOT EXISTS `kpis` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `job_title_id` BIGINT UNSIGNED DEFAULT NULL,
  `min_rating` DECIMAL(3,1) DEFAULT 0.0,
  `max_rating` DECIMAL(3,1) DEFAULT 5.0,
  `default_kpi` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_kpis_name` (`name`),
  INDEX `idx_kpis_job_title` (`job_title_id`),
  CONSTRAINT `fk_kpis_job_title` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Trackers Table
CREATE TABLE IF NOT EXISTS `trackers` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_trackers_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employee Trackers Table
CREATE TABLE IF NOT EXISTS `employee_trackers` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tracker_id` BIGINT UNSIGNED NOT NULL,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `added_date` DATE NOT NULL,
  `status` ENUM('Active', 'Inactive') DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_employee_trackers_tracker` (`tracker_id`),
  INDEX `idx_employee_trackers_employee` (`employee_id`),
  CONSTRAINT `fk_employee_trackers_tracker` FOREIGN KEY (`tracker_id`) REFERENCES `trackers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_employee_trackers_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Performance Reviews Table
CREATE TABLE IF NOT EXISTS `performance_reviews` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `reviewer_id` BIGINT UNSIGNED NOT NULL,
  `job_title_id` BIGINT UNSIGNED DEFAULT NULL,
  `review_period` VARCHAR(255) NOT NULL,
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `due_date` DATE NOT NULL,
  `review_status` ENUM('Pending', 'In Progress', 'Completed', 'Cancelled', 'Activated') DEFAULT 'Pending',
  `activated_date` TIMESTAMP NULL DEFAULT NULL,
  `completed_date` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_performance_reviews_employee` (`employee_id`),
  INDEX `idx_performance_reviews_reviewer` (`reviewer_id`),
  INDEX `idx_performance_reviews_job_title` (`job_title_id`),
  INDEX `idx_performance_reviews_status` (`review_status`),
  INDEX `idx_performance_reviews_due_date` (`due_date`),
  CONSTRAINT `fk_performance_reviews_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_performance_reviews_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_performance_reviews_job_title` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Review Goals Table
CREATE TABLE IF NOT EXISTS `review_goals` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `review_id` BIGINT UNSIGNED NOT NULL,
  `kpi_id` BIGINT UNSIGNED DEFAULT NULL,
  `goal` TEXT NOT NULL,
  `rating` DECIMAL(3,1) DEFAULT NULL,
  `max_rating` DECIMAL(3,1) DEFAULT 5.0,
  `comment` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_review_goals_review` (`review_id`),
  INDEX `idx_review_goals_kpi` (`kpi_id`),
  CONSTRAINT `fk_review_goals_review` FOREIGN KEY (`review_id`) REFERENCES `performance_reviews` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_review_goals_kpi` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. RECRUITMENT TABLES
-- =====================================================

-- Vacancies Table
CREATE TABLE IF NOT EXISTS `vacancies` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `job_title_id` BIGINT UNSIGNED NOT NULL,
  `hiring_manager_id` BIGINT UNSIGNED NOT NULL,
  `description` TEXT DEFAULT NULL,
  `number_of_positions` INT DEFAULT 1,
  `status` ENUM('Active', 'Closed', 'Cancelled') DEFAULT 'Active',
  `published_date` DATE DEFAULT NULL,
  `closing_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_vacancies_name` (`name`),
  INDEX `idx_vacancies_job_title` (`job_title_id`),
  INDEX `idx_vacancies_hiring_manager` (`hiring_manager_id`),
  INDEX `idx_vacancies_status` (`status`),
  CONSTRAINT `fk_vacancies_job_title` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_vacancies_hiring_manager` FOREIGN KEY (`hiring_manager_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Candidates Table
CREATE TABLE IF NOT EXISTS `candidates` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `middle_name` VARCHAR(255) DEFAULT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `resume` VARCHAR(255) DEFAULT NULL,
  `keywords` TEXT DEFAULT NULL,
  `comment` TEXT DEFAULT NULL,
  `date_of_application` DATE NOT NULL,
  `status` ENUM('Application Initiated', 'Shortlisted', 'Rejected', 'Hired') DEFAULT 'Application Initiated',
  `method_of_application` ENUM('Online', 'Email', 'Walk-in', 'Referral') DEFAULT 'Online',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_candidates_name` (`first_name`, `last_name`),
  INDEX `idx_candidates_email` (`email`),
  INDEX `idx_candidates_status` (`status`),
  INDEX `idx_candidates_date` (`date_of_application`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Job Applications Table
CREATE TABLE IF NOT EXISTS `job_applications` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `candidate_id` BIGINT UNSIGNED NOT NULL,
  `vacancy_id` BIGINT UNSIGNED NOT NULL,
  `status` ENUM('Application Initiated', 'Shortlisted', 'Rejected', 'Hired') DEFAULT 'Application Initiated',
  `applied_date` DATE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_job_applications_candidate` (`candidate_id`),
  INDEX `idx_job_applications_vacancy` (`vacancy_id`),
  INDEX `idx_job_applications_status` (`status`),
  CONSTRAINT `fk_job_applications_candidate` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_job_applications_vacancy` FOREIGN KEY (`vacancy_id`) REFERENCES `vacancies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. CLAIM MANAGEMENT TABLES
-- =====================================================

-- Events Table (Claim Events)
CREATE TABLE IF NOT EXISTS `events` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('Active', 'Inactive') DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_events_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Expense Types Table
CREATE TABLE IF NOT EXISTS `expense_types` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('Active', 'Inactive') DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_expense_types_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Claims Table
CREATE TABLE IF NOT EXISTS `claims` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reference_id` VARCHAR(50) NOT NULL,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `event_id` BIGINT UNSIGNED NOT NULL,
  `currency_id` BIGINT UNSIGNED NOT NULL,
  `description` TEXT DEFAULT NULL,
  `remarks` TEXT DEFAULT NULL,
  `total_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('Initiated', 'Submitted', 'Approved', 'Rejected') DEFAULT 'Initiated',
  `submitted_date` TIMESTAMP NULL DEFAULT NULL,
  `approved_by` BIGINT UNSIGNED DEFAULT NULL,
  `approved_date` TIMESTAMP NULL DEFAULT NULL,
  `rejected_by` BIGINT UNSIGNED DEFAULT NULL,
  `rejected_date` TIMESTAMP NULL DEFAULT NULL,
  `rejection_reason` TEXT DEFAULT NULL,
  `payment_date` DATE DEFAULT NULL,
  `payment_method` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_claims_reference_id` (`reference_id`),
  INDEX `idx_claims_employee` (`employee_id`),
  INDEX `idx_claims_event` (`event_id`),
  INDEX `idx_claims_currency` (`currency_id`),
  INDEX `idx_claims_status` (`status`),
  INDEX `idx_claims_submitted_date` (`submitted_date`),
  CONSTRAINT `fk_claims_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_claims_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_claims_currency` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_claims_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_claims_rejected_by` FOREIGN KEY (`rejected_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Claim Items Table
CREATE TABLE IF NOT EXISTS `claim_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `claim_id` BIGINT UNSIGNED NOT NULL,
  `expense_type_id` BIGINT UNSIGNED NOT NULL,
  `date` DATE NOT NULL,
  `description` TEXT DEFAULT NULL,
  `amount` DECIMAL(15,2) NOT NULL,
  `receipt` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_claim_items_claim` (`claim_id`),
  INDEX `idx_claim_items_expense_type` (`expense_type_id`),
  CONSTRAINT `fk_claim_items_claim` FOREIGN KEY (`claim_id`) REFERENCES `claims` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_claim_items_expense_type` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. QUALIFICATIONS TABLES
-- =====================================================

-- Skills Table
CREATE TABLE IF NOT EXISTS `skills` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_skills_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Education Table
CREATE TABLE IF NOT EXISTS `education` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `level` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_education_level` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Licenses Table
CREATE TABLE IF NOT EXISTS `licenses` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_licenses_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Languages Table
CREATE TABLE IF NOT EXISTS `languages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(10) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_languages_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Memberships Table
CREATE TABLE IF NOT EXISTS `memberships` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_memberships_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employee Skills Table
CREATE TABLE IF NOT EXISTS `employee_skills` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `skill_id` BIGINT UNSIGNED NOT NULL,
  `years_of_experience` INT DEFAULT NULL,
  `comments` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_employee_skills_employee` (`employee_id`),
  INDEX `idx_employee_skills_skill` (`skill_id`),
  CONSTRAINT `fk_employee_skills_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_employee_skills_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employee Education Table
CREATE TABLE IF NOT EXISTS `employee_education` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `education_id` BIGINT UNSIGNED NOT NULL,
  `institute` VARCHAR(255) DEFAULT NULL,
  `major` VARCHAR(255) DEFAULT NULL,
  `year` YEAR DEFAULT NULL,
  `gpa` DECIMAL(3,2) DEFAULT NULL,
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_employee_education_employee` (`employee_id`),
  INDEX `idx_employee_education_education` (`education_id`),
  CONSTRAINT `fk_employee_education_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_employee_education_education` FOREIGN KEY (`education_id`) REFERENCES `education` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employee Licenses Table
CREATE TABLE IF NOT EXISTS `employee_licenses` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `license_id` BIGINT UNSIGNED NOT NULL,
  `license_number` VARCHAR(255) DEFAULT NULL,
  `issued_date` DATE DEFAULT NULL,
  `expiry_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_employee_licenses_employee` (`employee_id`),
  INDEX `idx_employee_licenses_license` (`license_id`),
  CONSTRAINT `fk_employee_licenses_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_employee_licenses_license` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employee Languages Table
CREATE TABLE IF NOT EXISTS `employee_languages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `language_id` BIGINT UNSIGNED NOT NULL,
  `fluency` ENUM('Basic', 'Conversational', 'Fluent', 'Native') DEFAULT NULL,
  `competency` ENUM('Reading', 'Writing', 'Speaking', 'Listening') DEFAULT NULL,
  `comments` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_employee_languages_employee` (`employee_id`),
  INDEX `idx_employee_languages_language` (`language_id`),
  CONSTRAINT `fk_employee_languages_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_employee_languages_language` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employee Memberships Table
CREATE TABLE IF NOT EXISTS `employee_memberships` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `membership_id` BIGINT UNSIGNED NOT NULL,
  `subscription_paid_by` ENUM('Company', 'Individual') DEFAULT NULL,
  `subscription_amount` DECIMAL(10,2) DEFAULT NULL,
  `currency_id` BIGINT UNSIGNED DEFAULT NULL,
  `subscription_commence_date` DATE DEFAULT NULL,
  `subscription_renewal_date` DATE DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_employee_memberships_employee` (`employee_id`),
  INDEX `idx_employee_memberships_membership` (`membership_id`),
  INDEX `idx_employee_memberships_currency` (`currency_id`),
  CONSTRAINT `fk_employee_memberships_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_employee_memberships_membership` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_employee_memberships_currency` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. CONFIGURATION TABLES
-- =====================================================

-- Reporting Methods Table
CREATE TABLE IF NOT EXISTS `reporting_methods` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_reporting_methods_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PIM Optional Fields Configuration Table
CREATE TABLE IF NOT EXISTS `pim_optional_fields` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `field_name` VARCHAR(255) NOT NULL,
  `field_label` VARCHAR(255) NOT NULL,
  `is_required` TINYINT(1) DEFAULT 0,
  `is_visible` TINYINT(1) DEFAULT 1,
  `screen` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_pim_optional_fields_name` (`field_name`, `screen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Custom Fields Table
CREATE TABLE IF NOT EXISTS `custom_fields` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `field_name` VARCHAR(255) NOT NULL,
  `field_label` VARCHAR(255) NOT NULL,
  `field_type` ENUM('Text', 'Number', 'Date', 'Dropdown', 'Textarea') NOT NULL,
  `field_options` TEXT DEFAULT NULL COMMENT 'JSON for dropdown options',
  `screen` VARCHAR(100) DEFAULT NULL,
  `is_required` TINYINT(1) DEFAULT 0,
  `is_visible` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_custom_fields_screen` (`screen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Custom Field Values Table
CREATE TABLE IF NOT EXISTS `custom_field_values` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `custom_field_id` BIGINT UNSIGNED NOT NULL,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `value` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_custom_field_values_field` (`custom_field_id`),
  INDEX `idx_custom_field_values_employee` (`employee_id`),
  CONSTRAINT `fk_custom_field_values_field` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_custom_field_values_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Email Configuration Table
CREATE TABLE IF NOT EXISTS `email_configuration` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail_type` VARCHAR(50) NOT NULL,
  `sent_as` VARCHAR(255) DEFAULT NULL,
  `smtp_host` VARCHAR(255) DEFAULT NULL,
  `smtp_port` INT DEFAULT NULL,
  `smtp_username` VARCHAR(255) DEFAULT NULL,
  `smtp_password` VARCHAR(255) DEFAULT NULL,
  `smtp_auth_type` VARCHAR(50) DEFAULT NULL,
  `smtp_security` VARCHAR(50) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Email Subscriptions Table
CREATE TABLE IF NOT EXISTS `email_subscriptions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `is_enabled` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email_subscriptions_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Module Configuration Table
CREATE TABLE IF NOT EXISTS `module_configuration` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_name` VARCHAR(100) NOT NULL,
  `is_enabled` TINYINT(1) DEFAULT 1,
  `config_data` TEXT DEFAULT NULL COMMENT 'JSON configuration',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_module_configuration_name` (`module_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Localization Table
CREATE TABLE IF NOT EXISTS `localization` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `language` VARCHAR(50) NOT NULL,
  `date_format` VARCHAR(50) DEFAULT NULL,
  `time_format` VARCHAR(50) DEFAULT NULL,
  `currency` VARCHAR(10) DEFAULT NULL,
  `timezone` VARCHAR(100) DEFAULT NULL,
  `is_default` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_localization_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Language Packages Table
CREATE TABLE IF NOT EXISTS `language_packages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(10) NOT NULL,
  `is_installed` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_language_packages_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Corporate Branding Table
CREATE TABLE IF NOT EXISTS `corporate_branding` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `theme_name` VARCHAR(255) DEFAULT NULL,
  `primary_color` VARCHAR(7) DEFAULT NULL,
  `secondary_color` VARCHAR(7) DEFAULT NULL,
  `logo` VARCHAR(255) DEFAULT NULL,
  `favicon` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. OTHER TABLES
-- =====================================================

-- Buzz Posts Table
CREATE TABLE IF NOT EXISTS `buzz_posts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` BIGINT UNSIGNED NOT NULL,
  `content` TEXT NOT NULL,
  `attachment` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_buzz_posts_employee` (`employee_id`),
  INDEX `idx_buzz_posts_created` (`created_at`),
  CONSTRAINT `fk_buzz_posts_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Access Records Table
CREATE TABLE IF NOT EXISTS `access_records` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `action` VARCHAR(100) NOT NULL,
  `module` VARCHAR(100) DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_access_records_user` (`user_id`),
  INDEX `idx_access_records_created` (`created_at`),
  INDEX `idx_access_records_module` (`module`),
  CONSTRAINT `fk_access_records_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 12. ADD CIRCULAR FOREIGN KEY (after employees table exists)
-- =====================================================

-- Add foreign key for sub_units.unit_head_id (circular dependency with employees)
ALTER TABLE `sub_units` 
ADD CONSTRAINT `fk_sub_units_unit_head` 
FOREIGN KEY (`unit_head_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

-- =====================================================
-- END OF SCHEMA
-- =====================================================

-- =====================================================
-- SUMMARY
-- =====================================================
-- Total Tables Created: 59
-- 
-- Core Tables: 5 (organizations, locations, sub_units, nationalities, currencies, termination_reasons)
-- Job Management: 5 (job_categories, job_titles, employment_status, pay_grades, work_shifts)
-- Users & Employees: 2 (employees, users)
-- Leave Management: 6 (leave_types, leave_periods, work_weeks, holidays, leave_entitlements, leave_requests)
-- Time & Attendance: 6 (attendance_configuration, attendance_records, projects, activities, timesheets, timesheet_entries)
-- Performance: 4 (kpis, trackers, employee_trackers, performance_reviews, review_goals)
-- Recruitment: 3 (vacancies, candidates, job_applications)
-- Claims: 4 (events, expense_types, claims, claim_items)
-- Qualifications: 11 (skills, education, licenses, languages, memberships, employee_skills, employee_education, employee_licenses, employee_languages, employee_memberships)
-- Configuration: 9 (reporting_methods, pim_optional_fields, custom_fields, custom_field_values, email_configuration, email_subscriptions, module_configuration, localization, language_packages, corporate_branding)
-- Other: 2 (buzz_posts, access_records)
--
-- All tables include:
-- - Proper data types and constraints
-- - Foreign key relationships
-- - Indexes on frequently queried fields
-- - Timestamps (created_at, updated_at)
-- - Soft deletes where appropriate (deleted_at)
-- =====================================================
