-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2026 at 02:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toai_hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity_type` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='General user activity tracking.';

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `punch_in_at` datetime NOT NULL,
  `punch_out_at` datetime DEFAULT NULL,
  `punch_in_ip` varchar(45) DEFAULT NULL,
  `punch_out_ip` varchar(45) DEFAULT NULL,
  `punch_in_source` varchar(50) DEFAULT NULL,
  `punch_out_source` varchar(50) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Employee punch in/out records.';

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`id`, `employee_id`, `punch_in_at`, `punch_out_at`, `punch_in_ip`, `punch_out_ip`, `punch_in_source`, `punch_out_source`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-28 21:20:20', '2026-01-29 05:20:20', '127.0.0.1', '127.0.0.1', 'web', 'web', 'Seed attendance', '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(2, 1, '2026-01-27 21:20:20', '2026-01-28 05:20:20', '127.0.0.1', '127.0.0.1', 'web', 'web', 'Seed attendance', '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(3, 1, '2026-01-26 21:20:20', '2026-01-27 05:20:20', '127.0.0.1', '127.0.0.1', 'web', 'web', 'Seed attendance', '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(4, 1, '2026-01-25 21:20:20', '2026-01-26 05:20:20', '127.0.0.1', '127.0.0.1', 'web', 'web', 'Seed attendance', '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(5, 1, '2026-01-24 21:20:20', '2026-01-25 05:20:20', '127.0.0.1', '127.0.0.1', 'web', 'web', 'Seed attendance', '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(6, 1, '2026-01-23 21:20:20', '2026-01-24 05:20:20', '127.0.0.1', '127.0.0.1', 'web', 'web', 'Seed attendance', '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(7, 1, '2026-01-22 21:20:20', '2026-01-23 05:20:20', '127.0.0.1', '127.0.0.1', 'web', 'web', 'Seed attendance', '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_settings`
--

CREATE TABLE `attendance_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_can_change_time` tinyint(1) NOT NULL DEFAULT 1,
  `employee_can_edit_own_records` tinyint(1) NOT NULL DEFAULT 1,
  `supervisor_can_manage_subordinates` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Global attendance configuration flags.';

--
-- Dumping data for table `attendance_settings`
--

INSERT INTO `attendance_settings` (`id`, `employee_can_change_time`, `employee_can_edit_own_records`, `supervisor_can_manage_subordinates`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` enum('create','update','delete','restore') NOT NULL,
  `changes_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes_json`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Auditable changes to important data.';

-- --------------------------------------------------------

--
-- Table structure for table `auth_sessions`
--

CREATE TABLE `auth_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_token` char(64) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `revoked_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Login sessions / tokens.';

-- --------------------------------------------------------

--
-- Table structure for table `buzz_posts`
--

CREATE TABLE `buzz_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `body` text NOT NULL,
  `visibility` enum('public','employees','department') DEFAULT 'employees',
  `organization_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Buzz / announcement posts.';

--
-- Dumping data for table `buzz_posts`
--

INSERT INTO `buzz_posts` (`id`, `author_id`, `title`, `body`, `visibility`, `organization_unit_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Hi All: Linda has been blessed with a baby boy!', 'With love, we welcome your dear new baby to this world. Congratulations!', 'employees', NULL, '2026-01-27 17:06:39', '2026-01-27 17:06:39', NULL),
(2, 1, 'World Championship: Perfect Snooker Player?', '“You need to be mentally strong and have a good technique.” – Mark Selby. “Consistency and practice are key to success.” – John Higgins.', 'employees', NULL, '2026-01-27 17:06:39', '2026-01-27 17:06:39', NULL),
(3, 1, 'Throwback Thursdays!!', 'Throwback Thursdays!!', 'employees', NULL, '2026-01-27 17:06:39', '2026-01-27 17:06:39', NULL),
(4, 1, 'Live SIMPLY Dream BIG', 'Live SIMPLY Dream BIG Be GREATFULL Give LOVE Laugh LOT.......', 'employees', NULL, '2026-01-27 17:06:39', '2026-01-27 17:06:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buzz_post_comments`
--

CREATE TABLE `buzz_post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Comments on posts.';

--
-- Dumping data for table `buzz_post_comments`
--

INSERT INTO `buzz_post_comments` (`id`, `post_id`, `author_id`, `body`, `created_at`, `deleted_at`) VALUES
(2, 1, 1, 'Nice update!', '2026-01-28 12:20:21', NULL),
(3, 2, 1, 'Nice update!', '2026-01-28 12:20:21', NULL),
(4, 3, 1, 'Nice update!', '2026-01-28 12:20:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buzz_post_likes`
--

CREATE TABLE `buzz_post_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Likes/reactions on posts.';

--
-- Dumping data for table `buzz_post_likes`
--

INSERT INTO `buzz_post_likes` (`id`, `post_id`, `user_id`, `created_at`) VALUES
(2, 1, 1, '2026-01-28 12:20:21'),
(3, 2, 1, '2026-01-28 12:20:21'),
(4, 3, 1, '2026-01-28 12:20:21'),
(5, 4, 1, '2026-01-28 12:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `resume_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Candidates applying for vacancies.';

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `source_id`, `resume_file_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Alex', NULL, 'Smith', 'alex.smith@example.test', '+1-555-0200', 1, NULL, 'Strong QA background.', '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_applications`
--

CREATE TABLE `candidate_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `vacancy_id` bigint(20) UNSIGNED NOT NULL,
  `applied_date` date NOT NULL,
  `status` enum('new','shortlisted','interview_scheduled','offered','rejected','hired') DEFAULT 'new',
  `current_stage` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Applications of candidates to specific vacancies.';

--
-- Dumping data for table `candidate_applications`
--

INSERT INTO `candidate_applications` (`id`, `candidate_id`, `vacancy_id`, `applied_date`, `status`, `current_stage`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-01-10', 'shortlisted', 'Interview Scheduled', '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `claim_attachments`
--

CREATE TABLE `claim_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `claim_request_id` bigint(20) UNSIGNED NOT NULL,
  `file_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Additional attachments for claims.';

-- --------------------------------------------------------

--
-- Table structure for table `claim_events`
--

CREATE TABLE `claim_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `max_amount` decimal(15,2) DEFAULT NULL,
  `requires_receipt` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Claim event types / categories.';

--
-- Dumping data for table `claim_events`
--

INSERT INTO `claim_events` (`id`, `name`, `description`, `max_amount`, `requires_receipt`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Travel Allowance', 'Travel related expenses', 1000.00, 1, 1, '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 'Medical Reimbursement', 'Medical expenses', 500.00, 1, 1, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `claim_expense_types`
--

CREATE TABLE `claim_expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Expense types used in claims.';

--
-- Dumping data for table `claim_expense_types`
--

INSERT INTO `claim_expense_types` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Accommodation', 'Hotel and lodging costs', 1, '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 'Meal Allowance', 'Food and meals during travel', 1, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `claim_items`
--

CREATE TABLE `claim_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `claim_request_id` bigint(20) UNSIGNED NOT NULL,
  `claim_event_id` bigint(20) UNSIGNED NOT NULL,
  `item_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency` char(3) NOT NULL DEFAULT 'USD',
  `receipt_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Individual items within a claim request.';

--
-- Dumping data for table `claim_items`
--

INSERT INTO `claim_items` (`id`, `claim_request_id`, `claim_event_id`, `item_date`, `description`, `amount`, `currency`, `receipt_file_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-01-31', 'Flight ticket', 180.00, 'USD', NULL, '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 1, 2, '2026-01-31', 'Clinic visit', 70.00, 'USD', NULL, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `claim_requests`
--

CREATE TABLE `claim_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `claim_date` date NOT NULL,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `currency` char(3) NOT NULL DEFAULT 'USD',
  `status` enum('draft','submitted','approved','rejected','paid','cancelled') DEFAULT 'draft',
  `submitted_at` datetime DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Expense/claim requests.';

--
-- Dumping data for table `claim_requests`
--

INSERT INTO `claim_requests` (`id`, `employee_id`, `claim_date`, `total_amount`, `currency`, `status`, `submitted_at`, `approved_by`, `approved_at`, `paid_at`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-02-01', 250.00, 'USD', 'approved', '2026-01-27 17:06:39', 2, '2026-01-27 17:06:39', NULL, 'Client visit expenses', '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 1, '2026-01-28', 250.00, 'USD', 'approved', '2026-01-28 12:20:20', 2, '2026-01-28 12:20:20', NULL, 'Seed claim', '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `claim_status_history`
--

CREATE TABLE `claim_status_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `claim_request_id` bigint(20) UNSIGNED NOT NULL,
  `old_status` enum('draft','submitted','approved','rejected','paid','cancelled') DEFAULT NULL,
  `new_status` enum('draft','submitted','approved','rejected','paid','cancelled') NOT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `changed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Status change log for claims.';

-- --------------------------------------------------------

--
-- Table structure for table `corporate_branding`
--

CREATE TABLE `corporate_branding` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `primary_color` varchar(20) DEFAULT NULL,
  `secondary_color` varchar(20) DEFAULT NULL,
  `accent_color` varchar(20) DEFAULT NULL,
  `logo_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `banner_file_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dark_mode_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Corporate branding configuration.';

--
-- Dumping data for table `corporate_branding`
--

INSERT INTO `corporate_branding` (`id`, `organization_id`, `primary_color`, `secondary_color`, `accent_color`, `logo_file_id`, `banner_file_id`, `dark_mode_enabled`, `created_at`, `updated_at`) VALUES
(1, 1, '#8B5CF6', '#6D28D9', '#A78BFA', NULL, NULL, 1, '2026-01-27 17:06:38', '2026-01-27 17:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(191) NOT NULL,
  `data_type` enum('string','text','number','date','boolean','select') NOT NULL,
  `options_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options_json`)),
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Configurable custom fields for various modules.';

--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `module`, `name`, `label`, `data_type`, `options_json`, `is_required`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(7, 'pim', 'emergency_contact', 'emergency_contact', 'text', NULL, 0, 1, 0, '2026-01-28 12:31:52', '2026-01-28 12:31:57'),
(8, 'pim', 'emergency_network', 'emergency_network', 'string', NULL, 0, 1, 0, '2026-01-28 12:33:00', '2026-01-28 12:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail_from_name` varchar(191) DEFAULT NULL,
  `mail_from_address` varchar(191) DEFAULT NULL,
  `sending_method` enum('secure_smtp','smtp','sendmail') NOT NULL DEFAULT 'secure_smtp',
  `smtp_host` varchar(191) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT NULL,
  `smtp_username` varchar(191) DEFAULT NULL,
  `smtp_password` varchar(191) DEFAULT NULL,
  `smtp_encryption` enum('none','ssl','tls') DEFAULT 'tls',
  `sendmail_path` varchar(255) DEFAULT NULL,
  `send_test_mail` tinyint(1) NOT NULL DEFAULT 0,
  `test_recipient` varchar(191) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Outgoing email configuration.';

--
-- Dumping data for table `email_settings`
--

INSERT INTO `email_settings` (`id`, `mail_from_name`, `mail_from_address`, `sending_method`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_encryption`, `sendmail_path`, `send_test_mail`, `test_recipient`, `created_at`, `updated_at`) VALUES
(1, 'TOAI HR', 'no-reply@toai-demo.test', 'smtp', 'smtp.example.test', 587, 'user', 'pass', 'tls', NULL, 0, NULL, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `email_subscriptions`
--

CREATE TABLE `email_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification_key` varchar(100) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Notification types for email subscriptions.';

--
-- Dumping data for table `email_subscriptions`
--

INSERT INTO `email_subscriptions` (`id`, `notification_key`, `name`, `description`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'leave_application', 'Leave Application', 'Leave request notifications', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(2, 'claim_submission', 'Claim Submission', 'Claim request notifications', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(3, 'timesheet_submission', 'Timesheet Submission', 'Timesheet notifications', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(4, 'performance_review', 'Performance Review', 'Performance notifications', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_number` varchar(50) NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `display_name` varchar(191) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other','unspecified') DEFAULT 'unspecified',
  `marital_status` enum('single','married','divorced','widowed','other') DEFAULT NULL,
  `national_id` varchar(100) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `termination_date` date DEFAULT NULL,
  `status` enum('active','terminated','on_leave','probation') DEFAULT 'active',
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `organization_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `job_title_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employment_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pay_grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Employee master records.';

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_number`, `organization_id`, `first_name`, `middle_name`, `last_name`, `display_name`, `date_of_birth`, `gender`, `marital_status`, `national_id`, `hire_date`, `termination_date`, `status`, `location_id`, `organization_unit_id`, `job_title_id`, `employment_status_id`, `pay_grade_id`, `supervisor_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '0001', 1, 'Kritika', NULL, 'Singh', 'Kritika Singh', '1995-01-17', 'female', 'single', 'NID-0001', '2020-06-01', NULL, 'active', 2, 1, 1, 1, NULL, 1, '2026-01-27 17:06:38', '2026-01-30 11:03:39', NULL),
(2, '0002', 1, 'Jane', NULL, 'Doe', 'Jane Doe', '1990-03-10', 'female', 'married', 'NID-0002', '2019-03-01', NULL, 'active', 3, 4, 5, 1, NULL, 1, '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(5, '0003', 1, 'hema', NULL, 'sharma', NULL, NULL, 'unspecified', NULL, NULL, '2026-01-30', NULL, 'active', NULL, NULL, 6, 1, NULL, NULL, '2026-01-30 10:23:33', '2026-01-30 10:23:33', NULL),
(10, '0008', 1, 'rahul', NULL, 'kumar', NULL, NULL, 'unspecified', NULL, NULL, '2026-01-30', NULL, 'active', NULL, NULL, 7, 3, NULL, NULL, '2026-01-30 10:43:06', '2026-01-30 10:43:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_custom_field_values`
--

CREATE TABLE `employee_custom_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `custom_field_id` bigint(20) UNSIGNED NOT NULL,
  `value_text` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Values for employee custom fields.';

-- --------------------------------------------------------

--
-- Table structure for table `employee_dependents`
--

CREATE TABLE `employee_dependents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `relationship` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Employee dependents.';

-- --------------------------------------------------------

--
-- Table structure for table `employee_emergency_contacts`
--

CREATE TABLE `employee_emergency_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `home_phone` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(50) DEFAULT NULL,
  `work_phone` varchar(50) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Employee emergency contacts.';

-- --------------------------------------------------------

--
-- Table structure for table `employee_job_details`
--

CREATE TABLE `employee_job_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `job_title_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employment_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `organization_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `effective_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Job assignment history per employee.';

--
-- Dumping data for table `employee_job_details`
--

INSERT INTO `employee_job_details` (`id`, `employee_id`, `job_title_id`, `employment_status_id`, `organization_unit_id`, `location_id`, `supervisor_id`, `effective_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 2, NULL, '2020-06-01', NULL, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(2, 2, 5, 1, 4, 3, 1, '2019-03-01', NULL, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `employee_personal_details`
--

CREATE TABLE `employee_personal_details` (
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `nationality_id` bigint(20) UNSIGNED DEFAULT NULL,
  `other_id` varchar(100) DEFAULT NULL,
  `drivers_license` varchar(100) DEFAULT NULL,
  `license_expiry` date DEFAULT NULL,
  `smoker` tinyint(1) NOT NULL DEFAULT 0,
  `blood_group` varchar(5) DEFAULT NULL,
  `address1` varchar(191) DEFAULT NULL,
  `address2` varchar(191) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `home_phone` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(50) DEFAULT NULL,
  `work_phone` varchar(50) DEFAULT NULL,
  `work_email` varchar(191) DEFAULT NULL,
  `other_email` varchar(191) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Extended personal details for employees.';

--
-- Dumping data for table `employee_personal_details`
--

INSERT INTO `employee_personal_details` (`employee_id`, `nationality_id`, `other_id`, `drivers_license`, `license_expiry`, `smoker`, `blood_group`, `address1`, `address2`, `city`, `state`, `postal_code`, `country`, `home_phone`, `mobile_phone`, `work_phone`, `work_email`, `other_email`, `created_at`, `updated_at`) VALUES
(1, 2, 'ID-000001', 'DL-00000001', '2031-01-29', 0, 'O+', '10 Main Street', NULL, 'Austin', 'Texas', '00000', 'United States', NULL, '+1-555-1001', NULL, 'manda.akhil.user@company.test', NULL, '2026-01-28 12:20:20', '2026-01-29 12:44:41'),
(2, 1, 'ID-000002', 'DL-00000002', '2031-01-28', 0, 'O+', '20 Main Street', NULL, 'Austin', 'Texas', '00000', 'United States', NULL, '+1-555-1002', NULL, 'jane.doe@company.test', NULL, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `employee_qualifications`
--

CREATE TABLE `employee_qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `qualification_id` bigint(20) UNSIGNED NOT NULL,
  `institution` varchar(191) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Employee qualifications & education.';

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary`
--

CREATE TABLE `employee_salary` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `pay_grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pay_frequency` enum('monthly','biweekly','weekly','other') DEFAULT 'monthly',
  `amount` decimal(15,2) NOT NULL,
  `currency` char(3) NOT NULL DEFAULT 'USD',
  `effective_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Salary / compensation history.';

-- --------------------------------------------------------

--
-- Table structure for table `employment_statuses`
--

CREATE TABLE `employment_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Employment status types.';

--
-- Dumping data for table `employment_statuses`
--

INSERT INTO `employment_statuses` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Full-Time Permanent', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(2, 'Full-Time Contract', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(3, 'Part-Time Contract', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(4, 'Intern', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enabled_modules`
--

CREATE TABLE `enabled_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_key` varchar(50) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Which functional modules are enabled.';

--
-- Dumping data for table `enabled_modules`
--

INSERT INTO `enabled_modules` (`id`, `module_key`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'admin', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(2, 'pim', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(3, 'leave', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(4, 'time', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(5, 'recruitment', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(6, 'performance', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(7, 'directory', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(8, 'maintenance', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(9, 'mobile', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(10, 'claim', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(11, 'buzz', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE `file_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stored_name` varchar(191) NOT NULL,
  `original_name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `mime_type` varchar(100) NOT NULL,
  `size_bytes` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Physical files stored on disk/cloud.';

--
-- Dumping data for table `file_uploads`
--

INSERT INTO `file_uploads` (`id`, `stored_name`, `original_name`, `description`, `mime_type`, `size_bytes`, `path`, `uploaded_by`, `uploaded_at`) VALUES
(1, 'b66f049e-15c4-4c18-b890-a4687e85206c.pdf', 'Software Requirement - The Hen\'s Co..pdf', 'Yes', 'application/pdf', 439491, 'private/myinfo/b66f049e-15c4-4c18-b890-a4687e85206c.pdf', 1, '2026-01-28 10:05:22'),
(2, 'd54d1547-f6d7-4ba7-8f84-d29050e671ba.sql', 'toai_hrm.sql', 'Here', 'application/octet-stream', 119202, 'private/myinfo/d54d1547-f6d7-4ba7-8f84-d29050e671ba.sql', 1, '2026-01-28 10:14:28');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `holiday_date` date NOT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `is_full_day` tinyint(1) DEFAULT 1,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Public / company holidays.';

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `name`, `holiday_date`, `is_recurring`, `is_full_day`, `location_id`, `created_at`, `updated_at`) VALUES
(1, 'New Year\'s Day', '2026-01-01', 1, 1, NULL, '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 'Independence Day', '2026-09-25', 1, 1, NULL, '2026-01-27 17:06:39', '2026-01-30 06:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

CREATE TABLE `interviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_application_id` bigint(20) UNSIGNED NOT NULL,
  `interviewer_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 60,
  `location` varchar(191) DEFAULT NULL,
  `status` enum('scheduled','completed','cancelled') DEFAULT 'scheduled',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Scheduled interviews.';

-- --------------------------------------------------------

--
-- Table structure for table `interview_feedback`
--

CREATE TABLE `interview_feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `interview_id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED NOT NULL,
  `rating_overall` tinyint(4) NOT NULL,
  `strengths` text DEFAULT NULL,
  `weaknesses` text DEFAULT NULL,
  `recommendation` enum('hire','hold','reject') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Feedback per interview and reviewer.';

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

CREATE TABLE `job_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Job categories used for classification.';

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Professionals', 'Professional roles', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(2, 'Management', 'Management roles', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_titles`
--

CREATE TABLE `job_titles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Job titles.';

--
-- Dumping data for table `job_titles`
--

INSERT INTO `job_titles` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Software Engineer', 'Builds and maintains software systems.', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(2, 'QA Engineer', 'Ensures product quality.', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(3, 'HR Manager', 'Manages HR operations.', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(4, 'Business Analyst', 'Analyzes business requirements.', '2026-01-27 17:06:38', '2026-01-27 17:15:32', NULL),
(5, 'Project Manager', 'Leads project delivery.', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(6, 'Senior QA Lead', 'Leads the QA team.', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(7, 'Payroll Administrator', 'Manages payroll process.', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kpis`
--

CREATE TABLE `kpis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `weight` decimal(5,2) NOT NULL DEFAULT 1.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Key Performance Indicators definitions.';

--
-- Dumping data for table `kpis`
--

INSERT INTO `kpis` (`id`, `name`, `description`, `weight`, `created_at`, `updated_at`) VALUES
(1, 'Code Quality', 'Static analysis and defect rate', 0.50, '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 'Delivery Timeliness', 'On-time delivery of milestones', 0.50, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `language_packages`
--

CREATE TABLE `language_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Installed language packs.';

--
-- Dumping data for table `language_packages`
--

INSERT INTO `language_packages` (`id`, `code`, `name`, `is_default`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 1, 1, 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(2, 'hi', 'Hindi', 0, 2, 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(3, 'es', 'Spanish', 0, 3, 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `ldap_settings`
--

CREATE TABLE `ldap_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `host` varchar(191) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `encryption` enum('none','ssl','tls') DEFAULT 'none',
  `implementation` varchar(50) DEFAULT NULL,
  `bind_anonymously` tinyint(1) NOT NULL DEFAULT 0,
  `bind_dn` varchar(255) DEFAULT NULL,
  `bind_password` varchar(191) DEFAULT NULL,
  `base_dn` varchar(255) DEFAULT NULL,
  `search_scope` enum('base','one','sub') DEFAULT 'sub',
  `username_attribute` varchar(100) DEFAULT NULL,
  `user_filter` varchar(255) DEFAULT NULL,
  `user_unique_id_attribute` varchar(100) DEFAULT NULL,
  `map_first_name` varchar(100) DEFAULT NULL,
  `map_middle_name` varchar(100) DEFAULT NULL,
  `map_last_name` varchar(100) DEFAULT NULL,
  `map_status` varchar(100) DEFAULT NULL,
  `map_work_email` varchar(100) DEFAULT NULL,
  `map_employee_id` varchar(100) DEFAULT NULL,
  `merge_ldap_users` tinyint(1) NOT NULL DEFAULT 0,
  `sync_interval_minutes` int(11) DEFAULT NULL,
  `warning_message` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='LDAP connection and mapping configuration.';

--
-- Dumping data for table `ldap_settings`
--

INSERT INTO `ldap_settings` (`id`, `enabled`, `host`, `port`, `encryption`, `implementation`, `bind_anonymously`, `bind_dn`, `bind_password`, `base_dn`, `search_scope`, `username_attribute`, `user_filter`, `user_unique_id_attribute`, `map_first_name`, `map_middle_name`, `map_last_name`, `map_status`, `map_work_email`, `map_employee_id`, `merge_ldap_users`, `sync_interval_minutes`, `warning_message`, `created_at`, `updated_at`) VALUES
(1, 0, NULL, NULL, 'none', NULL, 0, NULL, NULL, NULL, 'sub', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` decimal(5,2) NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') DEFAULT 'pending',
  `applied_at` datetime NOT NULL DEFAULT current_timestamp(),
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Leave applications / requests.';

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `employee_id`, `leave_type_id`, `start_date`, `end_date`, `total_days`, `status`, `applied_at`, `approved_by`, `approved_at`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-03-10', '2026-03-11', 2.00, 'approved', '2026-01-27 17:06:39', 2, '2026-01-27 17:06:39', 'Annual vacation', '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 1, 1, '2026-01-28', '2026-01-28', 1.00, 'approved', '2026-01-28 12:20:20', 2, '2026-01-28 12:20:20', 'Seed leave for dashboard', '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(3, 2, 3, '2026-01-30', '2026-01-31', 2.00, 'pending', '2026-01-30 04:56:39', NULL, NULL, NULL, '2026-01-30 04:56:39', '2026-01-30 04:56:39'),
(4, 2, 2, '2026-01-30', '2026-01-30', 1.00, 'pending', '2026-01-30 05:22:51', NULL, NULL, 'he is sick', '2026-01-30 05:22:51', '2026-01-30 05:22:51'),
(5, 2, 1, '2026-01-23', '2026-01-30', 8.00, 'approved', '2026-01-30 05:42:29', NULL, NULL, 'holidays', '2026-01-30 05:42:29', '2026-01-30 05:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `leave_application_days`
--

CREATE TABLE `leave_application_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_application_id` bigint(20) UNSIGNED NOT NULL,
  `leave_date` date NOT NULL,
  `day_part` enum('full','first_half','second_half') DEFAULT 'full',
  `duration_days` decimal(4,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Daily details for leave applications.';

--
-- Dumping data for table `leave_application_days`
--

INSERT INTO `leave_application_days` (`id`, `leave_application_id`, `leave_date`, `day_part`, `duration_days`, `created_at`) VALUES
(1, 1, '2026-03-10', 'full', 1.00, '2026-01-27 17:06:39'),
(2, 1, '2026-03-11', 'full', 1.00, '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `leave_balances`
--

CREATE TABLE `leave_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `balance_date` date NOT NULL,
  `opening_balance` decimal(5,2) NOT NULL,
  `entitled` decimal(5,2) NOT NULL,
  `used` decimal(5,2) NOT NULL,
  `closing_balance` decimal(5,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Snapshot of leave balances for reports.';

-- --------------------------------------------------------

--
-- Table structure for table `leave_entitlements`
--

CREATE TABLE `leave_entitlements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `days_entitled` decimal(5,2) NOT NULL,
  `days_used` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Leave entitlement per employee and period.';

--
-- Dumping data for table `leave_entitlements`
--

INSERT INTO `leave_entitlements` (`id`, `employee_id`, `leave_type_id`, `period_start`, `period_end`, `days_entitled`, `days_used`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-01-01', '2026-12-31', 24.00, 2.00, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `leave_periods`
--

CREATE TABLE `leave_periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Configured leave periods.';

--
-- Dumping data for table `leave_periods`
--

INSERT INTO `leave_periods` (`id`, `name`, `period_start`, `period_end`, `is_current`, `created_at`, `updated_at`) VALUES
(1, '2026 Leave Period', '2026-01-01', '2026-12-31', 1, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `leave_status_history`
--

CREATE TABLE `leave_status_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_application_id` bigint(20) UNSIGNED NOT NULL,
  `old_status` enum('pending','approved','rejected','cancelled') DEFAULT NULL,
  `new_status` enum('pending','approved','rejected','cancelled') NOT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `changed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Leave status change history.';

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 1,
  `requires_approval` tinyint(1) NOT NULL DEFAULT 1,
  `max_per_year` decimal(5,2) DEFAULT NULL,
  `calculate_monthly` tinyint(1) DEFAULT 0,
  `carry_forward` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Types of leave (Annual, Sick, etc.).';

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `code`, `is_paid`, `requires_approval`, `max_per_year`, `calculate_monthly`, `carry_forward`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Annual Leave', 'AL', 1, 1, 5.00, 0, 0, '2026-01-27 17:06:39', '2026-01-30 06:23:14', NULL),
(2, 'Sick Leave', 'SL', 1, 1, 10.00, 0, 0, '2026-01-27 17:06:39', '2026-01-27 17:06:39', NULL),
(3, 'Casual Leave', 'CL', 1, 1, 12.00, 1, 0, '2026-01-27 17:06:39', '2026-01-30 07:52:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `localization_settings`
--

CREATE TABLE `localization_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language` varchar(10) NOT NULL DEFAULT 'en',
  `date_format` varchar(20) NOT NULL DEFAULT 'Y-m-d',
  `time_format` varchar(20) NOT NULL DEFAULT 'H:i',
  `timezone` varchar(100) NOT NULL DEFAULT 'UTC',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='System-wide localization settings.';

--
-- Dumping data for table `localization_settings`
--

INSERT INTO `localization_settings` (`id`, `language`, `date_format`, `time_format`, `timezone`, `created_at`, `updated_at`) VALUES
(1, 'en', 'Y-m-d', 'H:i', 'UTC', '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `address_line1` varchar(191) DEFAULT NULL,
  `address_line2` varchar(191) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Company locations / worksites.';

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `organization_id`, `name`, `address_line1`, `address_line2`, `city`, `state`, `postal_code`, `country`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Unassigned', NULL, NULL, 'N/A', 'N/A', NULL, 'N/A', NULL, '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(2, 1, 'Texas R&D', NULL, NULL, 'Austin', 'Texas', NULL, 'United States', '+1-555-0101', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(3, 1, 'New York Sales', NULL, NULL, 'New York', 'New York', NULL, 'United States', '+1-555-0102', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `success` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Login attempt log for security.';

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `iso_code` char(2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Nationalities master list.';

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`, `iso_code`, `created_at`, `updated_at`) VALUES
(1, 'American', 'US', '2026-01-27 17:06:38', '2026-01-27 17:06:38'),
(2, 'Indian', 'IN', '2026-01-27 17:06:38', '2026-01-27 17:06:38'),
(3, 'Canadian', 'CA', '2026-01-27 17:06:38', '2026-01-27 17:06:38');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) NOT NULL,
  `title` varchar(191) NOT NULL,
  `body` text NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Notification messages.';

-- --------------------------------------------------------

--
-- Table structure for table `notification_user`
--

CREATE TABLE `notification_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Per-user notification status.';

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `redirect_uri` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Registered OAuth clients for SSO / API.';

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `name`, `redirect_uri`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Demo OAuth Client', 'https://example.test/callback', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `registration_number` varchar(100) DEFAULT NULL,
  `tax_id` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `website` varchar(191) DEFAULT NULL,
  `address_line1` varchar(191) DEFAULT NULL,
  `address_line2` varchar(191) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `zip_postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Top-level organization entity.';

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `registration_number`, `tax_id`, `phone`, `fax`, `email`, `website`, `address_line1`, `address_line2`, `city`, `state`, `zip_postal_code`, `country`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'TOAI HR Suite Demo', 'TOAI-REG-001', '120568', '+91 8456213955', 'none', 'hr@toai.com', 'https://demo.toai-hr.test', 'Madan mahal road', 'Shastri bridge road', 'Jabalpur', 'Madhya Pradesh', '482002', 'India', 'This is the best company.', '2026-01-27 17:06:38', '2026-01-30 11:27:10');

-- --------------------------------------------------------

--
-- Table structure for table `organization_units`
--

CREATE TABLE `organization_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Departments / sub-units in org structure.';

--
-- Dumping data for table `organization_units`
--

INSERT INTO `organization_units` (`id`, `organization_id`, `parent_id`, `name`, `code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 'Engineering', 'ENG', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(2, 1, NULL, 'Human Resources', 'HR', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(3, 1, NULL, 'Quality Assurance', 'QA', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(4, 1, NULL, 'Business Development', 'BD', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL),
(5, 1, NULL, 'Management', 'MGMT', '2026-01-27 17:06:38', '2026-01-27 17:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `overtime_entries`
--

CREATE TABLE `overtime_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_id` bigint(20) UNSIGNED DEFAULT NULL,
  `work_date` date NOT NULL,
  `hours` decimal(5,2) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Overtime records linked to attendance or manual.';

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Password reset tokens.';

-- --------------------------------------------------------

--
-- Table structure for table `pay_grades`
--

CREATE TABLE `pay_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `currency` char(3) NOT NULL DEFAULT 'USD',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Pay grades / bands.';

-- --------------------------------------------------------

--
-- Table structure for table `pay_grade_salary_ranges`
--

CREATE TABLE `pay_grade_salary_ranges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pay_grade_id` bigint(20) UNSIGNED NOT NULL,
  `min_salary` decimal(15,2) NOT NULL,
  `max_salary` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Min/max salary by pay grade.';

-- --------------------------------------------------------

--
-- Table structure for table `performance_appraisals`
--

CREATE TABLE `performance_appraisals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `performance_review_id` bigint(20) UNSIGNED NOT NULL,
  `old_salary` decimal(15,2) DEFAULT NULL,
  `new_salary` decimal(15,2) DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Appraisals / compensation changes following reviews.';

-- --------------------------------------------------------

--
-- Table structure for table `performance_cycles`
--

CREATE TABLE `performance_cycles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('planned','active','closed','archived') DEFAULT 'planned',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Review/appraisal cycles.';

--
-- Dumping data for table `performance_cycles`
--

INSERT INTO `performance_cycles` (`id`, `name`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, '2026 Annual Review', '2026-01-01', '2026-12-31', 'active', '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `performance_reviews`
--

CREATE TABLE `performance_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cycle_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('not_started','in_progress','completed','approved') DEFAULT 'not_started',
  `overall_rating` decimal(4,2) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Performance reviews per employee & cycle.';

--
-- Dumping data for table `performance_reviews`
--

INSERT INTO `performance_reviews` (`id`, `cycle_id`, `employee_id`, `reviewer_id`, `status`, `overall_rating`, `comments`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'completed', 4.50, 'Strong performance throughout the year.', '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `performance_review_kpis`
--

CREATE TABLE `performance_review_kpis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `performance_review_id` bigint(20) UNSIGNED NOT NULL,
  `kpi_id` bigint(20) UNSIGNED NOT NULL,
  `rating` decimal(4,2) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Ratings per KPI within a review.';

--
-- Dumping data for table `performance_review_kpis`
--

INSERT INTO `performance_review_kpis` (`id`, `performance_review_id`, `kpi_id`, `rating`, `comments`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4.50, 'Clean code and few defects.', '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 1, 2, 4.50, 'Consistently on time.', '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Permission definitions.';

-- --------------------------------------------------------

--
-- Table structure for table `pim_optional_fields`
--

CREATE TABLE `pim_optional_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_label` varchar(255) NOT NULL,
  `is_required` tinyint(1) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1,
  `screen` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pim_optional_fields`
--

INSERT INTO `pim_optional_fields` (`id`, `field_name`, `field_label`, `is_required`, `is_visible`, `screen`, `created_at`, `updated_at`) VALUES
(1, 'deprecated_fields', 'Show Deprecated Fields', 0, 1, 'personal_details', '2026-01-29 00:16:39', '2026-01-29 00:16:39'),
(2, 'ssn', 'Show SSN field in Personal Details', 0, 1, 'personal_details', '2026-01-29 00:16:39', '2026-01-29 00:16:39'),
(3, 'sin', 'Show SIN field in Personal Details', 0, 0, 'personal_details', '2026-01-29 00:16:39', '2026-01-29 00:16:39'),
(4, 'us_tax_exemptions', 'Show US Tax Exemptions menu', 0, 0, 'personal_details', '2026-01-29 00:16:39', '2026-01-29 00:16:39');

-- --------------------------------------------------------

--
-- Table structure for table `pim_reports`
--

CREATE TABLE `pim_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('education','skill','language','certification','other') NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Qualification master list.';

--
-- Dumping data for table `pim_reports`
--

INSERT INTO `pim_reports` (`id`, `type`, `name`, `description`, `created_at`, `updated_at`) VALUES
(12, 'language', 'Kritika Singh', 'New employee', '2026-01-29 13:42:17', '2026-01-29 13:42:17'),
(13, 'education', 'Jane Doe', 'Old employee', '2026-01-29 13:42:44', '2026-01-29 13:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('education','skill','language','certification','other') NOT NULL COMMENT 'Qualification type',
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Qualifications master list (education, skills, languages, certifications, etc.)';

-- --------------------------------------------------------

--
-- Table structure for table `recruitment_sources`
--

CREATE TABLE `recruitment_sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Candidate source types.';

--
-- Dumping data for table `recruitment_sources`
--

INSERT INTO `recruitment_sources` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Online', '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 'Referral', '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `reporting_methods`
--

CREATE TABLE `reporting_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='How employees report to their supervisors (e.g. Direct, Matrix).';

--
-- Dumping data for table `reporting_methods`
--

INSERT INTO `reporting_methods` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Direct', 'Direct line reporting to a single manager', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13'),
(2, 'Matrix', 'Reports to multiple managers in a matrix structure', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13'),
(3, 'Project Based', 'Reports to project manager for project duration', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13'),
(4, 'Functional', 'Reports to functional head (e.g. HR, Finance)', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13'),
(5, 'Dotted Line', 'Informal / advisory reporting relationship (dotted-line manager)', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Role definitions for RBAC.';

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `is_system`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'System administrator', 1, '2026-01-27 17:06:38', '2026-01-27 17:06:38'),
(2, 'HR', 'hr', 'HR user', 1, '2026-01-27 17:06:38', '2026-01-30 17:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Role to permission mapping.';

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Web session storage.';

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BI1Rb56WxVatwg1VZTAoy3ruyn0tmYs3HZlPaUHA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2hVZ2xRb2FzVXRXald4V0NEOG5tbzYwQ2lwRUpLV2d4Mk5Gd1R6YyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo5OiJhdXRoX3VzZXIiO2E6Mzp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo3OiJIUkBUT1NTIjtzOjg6InVzZXJuYW1lIjtzOjc6IkhSQFRPU1MiO319', 1769777333),
('ejUF0duhQJqAksZggA0H3yMo8ZtIzOeGT4c1jTsN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHRXTFhGN29IaWNIS2V4bUtMdHpxb1lBdzFHZXJud2dNekNybGN5NSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1769778281);

-- --------------------------------------------------------

--
-- Table structure for table `social_providers`
--

CREATE TABLE `social_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `client_id` varchar(191) NOT NULL,
  `client_secret` varchar(191) NOT NULL,
  `redirect_uri` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Social login provider configuration.';

--
-- Dumping data for table `social_providers`
--

INSERT INTO `social_providers` (`id`, `name`, `client_id`, `client_secret`, `redirect_uri`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Google', 'demo-client', 'demo-secret', 'https://example.test/auth/callback', 1, '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `termination_reasons`
--

CREATE TABLE `termination_reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Reasons for employee termination / separation.';

--
-- Dumping data for table `termination_reasons`
--

INSERT INTO `termination_reasons` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Resignation', 'Employee voluntarily resigned from the organization', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13'),
(2, 'End of Contract', 'Employment contract reached its planned end date', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13'),
(3, 'Termination - Cause', 'Employment terminated due to performance or disciplinary reasons', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13'),
(4, 'Retirement', 'Employee retired as per company policy', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13'),
(5, 'Redundancy / Layoff', 'Position made redundant or workforce reduction', 1, '2026-01-27 18:57:13', '2026-01-27 18:57:13');

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('draft','submitted','approved','rejected','locked') DEFAULT 'draft',
  `submitted_at` datetime DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Weekly/monthly timesheet headers.';

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `employee_id`, `start_date`, `end_date`, `status`, `submitted_at`, `approved_by`, `approved_at`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-19', '2026-01-25', 'approved', '2026-01-27 17:06:39', 2, '2026-01-27 17:06:39', 'Week 3 demo timesheet', '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `timesheet_rows`
--

CREATE TABLE `timesheet_rows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `timesheet_id` bigint(20) UNSIGNED NOT NULL,
  `work_date` date NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hours_worked` decimal(5,2) NOT NULL DEFAULT 0.00,
  `overtime_hours` decimal(5,2) NOT NULL DEFAULT 0.00,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Per-day time entries in timesheets.';

--
-- Dumping data for table `timesheet_rows`
--

INSERT INTO `timesheet_rows` (`id`, `timesheet_id`, `work_date`, `project_id`, `hours_worked`, `overtime_hours`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-19', 1, 8.00, 0.00, 'Feature work', '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(2, 1, '2026-01-20', 1, 8.00, 0.00, 'Bug fixes', '2026-01-27 17:06:39', '2026-01-27 17:06:39'),
(3, 1, '2026-01-22', 1, 8.00, 0.00, 'Feature work', '2026-01-28 12:20:20', '2026-01-28 12:20:20'),
(4, 1, '2026-01-23', 1, 8.00, 0.00, 'Bug fixes', '2026-01-28 12:20:20', '2026-01-28 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `time_customers`
--

CREATE TABLE `time_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Customers for project/time tracking.';

--
-- Dumping data for table `time_customers`
--

INSERT INTO `time_customers` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Acme Corp', 'External customer for demo project', 1, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `time_projects`
--

CREATE TABLE `time_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Projects for timesheets.';

--
-- Dumping data for table `time_projects`
--

INSERT INTO `time_projects` (`id`, `customer_id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Acme HR Implementation', 'Implementation project for Acme Corp', 1, '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `time_project_assignments`
--

CREATE TABLE `time_project_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `hourly_rate` decimal(15,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Assignment of employees to projects.';

--
-- Dumping data for table `time_project_assignments`
--

INSERT INTO `time_project_assignments` (`id`, `project_id`, `employee_id`, `role`, `hourly_rate`, `created_at`) VALUES
(1, 1, 1, 'Developer', 75.00, '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_main_user` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Application users (login accounts).';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `employee_id`, `is_active`, `is_main_user`, `created_by`, `last_login_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'HR@TOSS', 'hr@gmail.com', '$2y$12$051MM95qGcbn8bHp05w7dOCnDgsP88Y3SJ8NX0kmi7Vayi5vlOlzG', 1, 1, 1, NULL, NULL, '2026-01-27 17:06:38', '2026-01-30 17:39:14', NULL),
(2, 'neet', 'gg@gmail.com', '$2y$12$cAczoNQdtJBSIs/sU6piguTB0kUdlFAJ/B9fSvVdDVtxsyA/Mrfqa', 5, 0, 0, NULL, NULL, '2026-01-30 11:58:07', '2026-01-30 12:28:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_preferences`
--

CREATE TABLE `user_preferences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `language` varchar(10) DEFAULT NULL,
  `theme` enum('light','dark','system') DEFAULT 'system',
  `sidebar_collapsed` tinyint(1) NOT NULL DEFAULT 0,
  `notifications_email` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Per-user UI and notification preferences.';

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User to role mapping.';

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`, `created_at`) VALUES
(1, 2, '2026-01-30 12:03:21'),
(2, 1, '2026-01-30 12:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `vacancies`
--

CREATE TABLE `vacancies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_title_id` bigint(20) UNSIGNED NOT NULL,
  `hiring_manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `positions` int(11) NOT NULL DEFAULT 1,
  `status` enum('open','on_hold','closed') DEFAULT 'open',
  `posted_date` date DEFAULT NULL,
  `closing_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Job vacancies.';

--
-- Dumping data for table `vacancies`
--

INSERT INTO `vacancies` (`id`, `job_title_id`, `hiring_manager_id`, `location_id`, `name`, `description`, `positions`, `status`, `posted_date`, `closing_date`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 2, 'Senior QA Lead', 'Lead QA for TOAI HR Suite', 1, 'open', '2026-01-01', '2026-03-31', '2026-01-27 17:06:39', '2026-01-27 17:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `work_shifts`
--

CREATE TABLE `work_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `hours_per_day` decimal(4,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Work shift definitions.';

-- --------------------------------------------------------

--
-- Table structure for table `work_weeks`
--

CREATE TABLE `work_weeks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `day_of_week` tinyint(4) NOT NULL,
  `is_working_day` tinyint(1) NOT NULL DEFAULT 1,
  `hours_per_day` decimal(4,2) NOT NULL DEFAULT 8.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Work week definition per location or global.';

--
-- Dumping data for table `work_weeks`
--

INSERT INTO `work_weeks` (`id`, `location_id`, `day_of_week`, `is_working_day`, `hours_per_day`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 1, 8.00, '2026-01-27 17:06:39', '2026-01-30 06:42:33'),
(2, NULL, 2, 1, 8.00, '2026-01-27 17:06:39', '2026-01-30 06:42:33'),
(3, NULL, 3, 1, 8.00, '2026-01-27 17:06:39', '2026-01-30 06:42:33'),
(4, NULL, 4, 1, 8.00, '2026-01-27 17:06:39', '2026-01-30 06:42:33'),
(5, NULL, 5, 1, 8.00, '2026-01-27 17:06:39', '2026-01-30 06:42:33'),
(6, NULL, 6, 1, 8.00, '2026-01-27 17:06:39', '2026-01-30 06:42:33'),
(7, NULL, 7, 0, 0.00, '2026-01-27 17:06:39', '2026-01-30 06:42:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_activity_user` (`user_id`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_attendance_employee_date` (`employee_id`,`punch_in_at`);

--
-- Indexes for table `attendance_settings`
--
ALTER TABLE `attendance_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_audit_user` (`user_id`);

--
-- Indexes for table `auth_sessions`
--
ALTER TABLE `auth_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_auth_sessions_token` (`session_token`),
  ADD KEY `idx_auth_sessions_user` (`user_id`);

--
-- Indexes for table `buzz_posts`
--
ALTER TABLE `buzz_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `organization_unit_id` (`organization_unit_id`);

--
-- Indexes for table `buzz_post_comments`
--
ALTER TABLE `buzz_post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `buzz_post_likes`
--
ALTER TABLE `buzz_post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_post_like` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_candidates_email` (`email`),
  ADD KEY `idx_candidates_source` (`source_id`);

--
-- Indexes for table `candidate_applications`
--
ALTER TABLE `candidate_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_candidate_vacancy` (`candidate_id`,`vacancy_id`),
  ADD KEY `idx_candidate_applications_status` (`status`),
  ADD KEY `fk_candidate_applications_vacancy` (`vacancy_id`);

--
-- Indexes for table `claim_attachments`
--
ALTER TABLE `claim_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_claim_attachments_request` (`claim_request_id`);

--
-- Indexes for table `claim_events`
--
ALTER TABLE `claim_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `claim_expense_types`
--
ALTER TABLE `claim_expense_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_claim_expense_types_name` (`name`);

--
-- Indexes for table `claim_items`
--
ALTER TABLE `claim_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_claim_items_claim` (`claim_request_id`),
  ADD KEY `fk_claim_items_event` (`claim_event_id`);

--
-- Indexes for table `claim_requests`
--
ALTER TABLE `claim_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_claim_requests_employee` (`employee_id`),
  ADD KEY `idx_claim_requests_status` (`status`),
  ADD KEY `fk_claim_requests_approver` (`approved_by`);

--
-- Indexes for table `claim_status_history`
--
ALTER TABLE `claim_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_claim_status_history_request` (`claim_request_id`),
  ADD KEY `fk_claim_status_history_user` (`changed_by`);

--
-- Indexes for table `corporate_branding`
--
ALTER TABLE `corporate_branding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_branding_org` (`organization_id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_subscriptions`
--
ALTER TABLE `email_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email_subscriptions_key` (`notification_key`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_employees_employee_number` (`employee_number`),
  ADD KEY `idx_employees_org` (`organization_id`),
  ADD KEY `idx_employees_unit` (`organization_unit_id`),
  ADD KEY `idx_employees_location` (`location_id`),
  ADD KEY `idx_employees_supervisor` (`supervisor_id`),
  ADD KEY `fk_employees_job_title` (`job_title_id`),
  ADD KEY `fk_employees_emp_status` (`employment_status_id`),
  ADD KEY `fk_employees_pay_grade` (`pay_grade_id`);

--
-- Indexes for table `employee_custom_field_values`
--
ALTER TABLE `employee_custom_field_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_emp_custom_field` (`employee_id`,`custom_field_id`),
  ADD KEY `fk_emp_cf_definition` (`custom_field_id`);

--
-- Indexes for table `employee_dependents`
--
ALTER TABLE `employee_dependents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_dependents_employee` (`employee_id`);

--
-- Indexes for table `employee_emergency_contacts`
--
ALTER TABLE `employee_emergency_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_emergency_employee` (`employee_id`);

--
-- Indexes for table `employee_job_details`
--
ALTER TABLE `employee_job_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_emp_job_employee` (`employee_id`,`effective_date`),
  ADD KEY `fk_emp_job_job_title` (`job_title_id`),
  ADD KEY `fk_emp_job_emp_status` (`employment_status_id`),
  ADD KEY `fk_emp_job_unit` (`organization_unit_id`),
  ADD KEY `fk_emp_job_location` (`location_id`),
  ADD KEY `fk_emp_job_supervisor` (`supervisor_id`);

--
-- Indexes for table `employee_personal_details`
--
ALTER TABLE `employee_personal_details`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `fk_emp_personal_nationality` (`nationality_id`);

--
-- Indexes for table `employee_qualifications`
--
ALTER TABLE `employee_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_emp_qual_employee` (`employee_id`),
  ADD KEY `fk_emp_qual_qualification` (`qualification_id`);

--
-- Indexes for table `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_emp_salary_employee` (`employee_id`,`effective_date`),
  ADD KEY `fk_emp_salary_pay_grade` (`pay_grade_id`);

--
-- Indexes for table `employment_statuses`
--
ALTER TABLE `employment_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_emp_status_name` (`name`);

--
-- Indexes for table `enabled_modules`
--
ALTER TABLE `enabled_modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_enabled_modules_key` (`module_key`);

--
-- Indexes for table `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_holidays_location` (`location_id`);

--
-- Indexes for table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_interviews_application` (`candidate_application_id`),
  ADD KEY `fk_interviews_interviewer` (`interviewer_id`);

--
-- Indexes for table `interview_feedback`
--
ALTER TABLE `interview_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_feedback_interview` (`interview_id`),
  ADD KEY `fk_feedback_reviewer` (`reviewer_id`);

--
-- Indexes for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_job_categories_name` (`name`);

--
-- Indexes for table `job_titles`
--
ALTER TABLE `job_titles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_job_titles_name` (`name`);

--
-- Indexes for table `kpis`
--
ALTER TABLE `kpis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_packages`
--
ALTER TABLE `language_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_language_packages_code` (`code`);

--
-- Indexes for table `ldap_settings`
--
ALTER TABLE `ldap_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_leave_applications_employee` (`employee_id`),
  ADD KEY `idx_leave_applications_status` (`status`),
  ADD KEY `fk_leave_applications_type` (`leave_type_id`),
  ADD KEY `fk_leave_applications_approver` (`approved_by`);

--
-- Indexes for table `leave_application_days`
--
ALTER TABLE `leave_application_days`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_leave_application_day` (`leave_application_id`,`leave_date`,`day_part`);

--
-- Indexes for table `leave_balances`
--
ALTER TABLE `leave_balances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_leave_balances_key` (`employee_id`,`leave_type_id`,`balance_date`),
  ADD KEY `fk_leave_balances_type` (`leave_type_id`);

--
-- Indexes for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_leave_entitlement_period` (`employee_id`,`leave_type_id`,`period_start`,`period_end`),
  ADD KEY `fk_leave_entitlements_type` (`leave_type_id`);

--
-- Indexes for table `leave_periods`
--
ALTER TABLE `leave_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_status_history`
--
ALTER TABLE `leave_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_leave_status_history_app` (`leave_application_id`),
  ADD KEY `fk_leave_status_history_user` (`changed_by`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_leave_types_code` (`code`);

--
-- Indexes for table `localization_settings`
--
ALTER TABLE `localization_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_locations_org` (`organization_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_login_attempts_username` (`username`),
  ADD KEY `idx_login_attempts_ip` (`ip_address`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_nationalities_name` (`name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_user`
--
ALTER TABLE `notification_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notification_user_user` (`user_id`,`is_read`),
  ADD KEY `fk_notification_user_notification` (`notification_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_units`
--
ALTER TABLE `organization_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_org_units_parent` (`parent_id`),
  ADD KEY `fk_org_units_org` (`organization_id`);

--
-- Indexes for table `overtime_entries`
--
ALTER TABLE `overtime_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_overtime_employee_date` (`employee_id`,`work_date`),
  ADD KEY `fk_overtime_attendance` (`attendance_id`),
  ADD KEY `fk_overtime_approver` (`approved_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_password_resets_token` (`token`),
  ADD KEY `idx_password_resets_user` (`user_id`);

--
-- Indexes for table `pay_grades`
--
ALTER TABLE `pay_grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_pay_grades_name` (`name`);

--
-- Indexes for table `pay_grade_salary_ranges`
--
ALTER TABLE `pay_grade_salary_ranges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pg_ranges_grade` (`pay_grade_id`);

--
-- Indexes for table `performance_appraisals`
--
ALTER TABLE `performance_appraisals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_perf_appraisals_review` (`performance_review_id`);

--
-- Indexes for table `performance_cycles`
--
ALTER TABLE `performance_cycles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_review_cycle_employee` (`cycle_id`,`employee_id`),
  ADD KEY `idx_performance_reviews_status` (`status`),
  ADD KEY `fk_perf_reviews_employee` (`employee_id`),
  ADD KEY `fk_perf_reviews_reviewer` (`reviewer_id`);

--
-- Indexes for table `performance_review_kpis`
--
ALTER TABLE `performance_review_kpis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_review_kpi` (`performance_review_id`,`kpi_id`),
  ADD KEY `fk_perf_review_kpis_kpi` (`kpi_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_permissions_slug` (`slug`);

--
-- Indexes for table `pim_optional_fields`
--
ALTER TABLE `pim_optional_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_pim_optional_fields_name` (`field_name`,`screen`);

--
-- Indexes for table `pim_reports`
--
ALTER TABLE `pim_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_name` (`name`);

--
-- Indexes for table `recruitment_sources`
--
ALTER TABLE `recruitment_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reporting_methods`
--
ALTER TABLE `reporting_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_roles_slug` (`slug`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `fk_role_permissions_permission` (`permission_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sessions_user` (`user_id`),
  ADD KEY `idx_sessions_last_activity` (`last_activity`);

--
-- Indexes for table `social_providers`
--
ALTER TABLE `social_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `termination_reasons`
--
ALTER TABLE `termination_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_timesheets_employee_period` (`employee_id`,`start_date`,`end_date`),
  ADD KEY `idx_timesheets_status` (`status`),
  ADD KEY `fk_timesheets_approver` (`approved_by`);

--
-- Indexes for table `timesheet_rows`
--
ALTER TABLE `timesheet_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_timesheet_rows_sheet` (`timesheet_id`),
  ADD KEY `idx_timesheet_rows_date` (`work_date`),
  ADD KEY `fk_timesheet_rows_project` (`project_id`);

--
-- Indexes for table `time_customers`
--
ALTER TABLE `time_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_projects`
--
ALTER TABLE `time_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_time_projects_customer` (`customer_id`);

--
-- Indexes for table `time_project_assignments`
--
ALTER TABLE `time_project_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_time_project_employee` (`project_id`,`employee_id`),
  ADD KEY `fk_time_assignment_employee` (`employee_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_username` (`username`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD KEY `idx_users_employee_id` (`employee_id`),
  ADD KEY `idx_created_by` (`created_by`);

--
-- Indexes for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_preferences_user` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_user_roles_role` (`role_id`);

--
-- Indexes for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vacancies_status` (`status`),
  ADD KEY `fk_vacancies_job_title` (`job_title_id`),
  ADD KEY `fk_vacancies_manager` (`hiring_manager_id`),
  ADD KEY `fk_vacancies_location` (`location_id`);

--
-- Indexes for table `work_shifts`
--
ALTER TABLE `work_shifts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_work_shifts_name` (`name`);

--
-- Indexes for table `work_weeks`
--
ALTER TABLE `work_weeks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_work_weeks_location` (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attendance_settings`
--
ALTER TABLE `attendance_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_sessions`
--
ALTER TABLE `auth_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buzz_posts`
--
ALTER TABLE `buzz_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buzz_post_comments`
--
ALTER TABLE `buzz_post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `buzz_post_likes`
--
ALTER TABLE `buzz_post_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidate_applications`
--
ALTER TABLE `candidate_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `claim_attachments`
--
ALTER TABLE `claim_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `claim_events`
--
ALTER TABLE `claim_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `claim_expense_types`
--
ALTER TABLE `claim_expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `claim_items`
--
ALTER TABLE `claim_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `claim_requests`
--
ALTER TABLE `claim_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `claim_status_history`
--
ALTER TABLE `claim_status_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `corporate_branding`
--
ALTER TABLE `corporate_branding`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_subscriptions`
--
ALTER TABLE `email_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee_custom_field_values`
--
ALTER TABLE `employee_custom_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_dependents`
--
ALTER TABLE `employee_dependents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_emergency_contacts`
--
ALTER TABLE `employee_emergency_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_job_details`
--
ALTER TABLE `employee_job_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_qualifications`
--
ALTER TABLE `employee_qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_salary`
--
ALTER TABLE `employee_salary`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employment_statuses`
--
ALTER TABLE `employment_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enabled_modules`
--
ALTER TABLE `enabled_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interview_feedback`
--
ALTER TABLE `interview_feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_titles`
--
ALTER TABLE `job_titles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kpis`
--
ALTER TABLE `kpis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `language_packages`
--
ALTER TABLE `language_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ldap_settings`
--
ALTER TABLE `ldap_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leave_application_days`
--
ALTER TABLE `leave_application_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_balances`
--
ALTER TABLE `leave_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_periods`
--
ALTER TABLE `leave_periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leave_status_history`
--
ALTER TABLE `leave_status_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `localization_settings`
--
ALTER TABLE `localization_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_user`
--
ALTER TABLE `notification_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organization_units`
--
ALTER TABLE `organization_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `overtime_entries`
--
ALTER TABLE `overtime_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_grades`
--
ALTER TABLE `pay_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_grade_salary_ranges`
--
ALTER TABLE `pay_grade_salary_ranges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance_appraisals`
--
ALTER TABLE `performance_appraisals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance_cycles`
--
ALTER TABLE `performance_cycles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `performance_review_kpis`
--
ALTER TABLE `performance_review_kpis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pim_optional_fields`
--
ALTER TABLE `pim_optional_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pim_reports`
--
ALTER TABLE `pim_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recruitment_sources`
--
ALTER TABLE `recruitment_sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reporting_methods`
--
ALTER TABLE `reporting_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `social_providers`
--
ALTER TABLE `social_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `termination_reasons`
--
ALTER TABLE `termination_reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timesheet_rows`
--
ALTER TABLE `timesheet_rows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `time_customers`
--
ALTER TABLE `time_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time_projects`
--
ALTER TABLE `time_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time_project_assignments`
--
ALTER TABLE `time_project_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_preferences`
--
ALTER TABLE `user_preferences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `work_shifts`
--
ALTER TABLE `work_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_weeks`
--
ALTER TABLE `work_weeks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `fk_attendance_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `auth_sessions`
--
ALTER TABLE `auth_sessions`
  ADD CONSTRAINT `fk_auth_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buzz_posts`
--
ALTER TABLE `buzz_posts`
  ADD CONSTRAINT `buzz_posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buzz_posts_ibfk_2` FOREIGN KEY (`organization_unit_id`) REFERENCES `organization_units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `buzz_post_comments`
--
ALTER TABLE `buzz_post_comments`
  ADD CONSTRAINT `buzz_post_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `buzz_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buzz_post_comments_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `buzz_post_likes`
--
ALTER TABLE `buzz_post_likes`
  ADD CONSTRAINT `buzz_post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `buzz_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `buzz_post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `fk_candidates_source` FOREIGN KEY (`source_id`) REFERENCES `recruitment_sources` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `candidate_applications`
--
ALTER TABLE `candidate_applications`
  ADD CONSTRAINT `fk_candidate_applications_candidate` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_candidate_applications_vacancy` FOREIGN KEY (`vacancy_id`) REFERENCES `vacancies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `claim_attachments`
--
ALTER TABLE `claim_attachments`
  ADD CONSTRAINT `fk_claim_attachments_request` FOREIGN KEY (`claim_request_id`) REFERENCES `claim_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `claim_items`
--
ALTER TABLE `claim_items`
  ADD CONSTRAINT `fk_claim_items_event` FOREIGN KEY (`claim_event_id`) REFERENCES `claim_events` (`id`),
  ADD CONSTRAINT `fk_claim_items_request` FOREIGN KEY (`claim_request_id`) REFERENCES `claim_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `claim_requests`
--
ALTER TABLE `claim_requests`
  ADD CONSTRAINT `fk_claim_requests_approver` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_claim_requests_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `claim_status_history`
--
ALTER TABLE `claim_status_history`
  ADD CONSTRAINT `fk_claim_status_history_request` FOREIGN KEY (`claim_request_id`) REFERENCES `claim_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_claim_status_history_user` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `corporate_branding`
--
ALTER TABLE `corporate_branding`
  ADD CONSTRAINT `fk_branding_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_emp_status` FOREIGN KEY (`employment_status_id`) REFERENCES `employment_statuses` (`id`),
  ADD CONSTRAINT `fk_employees_job_title` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `fk_employees_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `fk_employees_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`),
  ADD CONSTRAINT `fk_employees_pay_grade` FOREIGN KEY (`pay_grade_id`) REFERENCES `pay_grades` (`id`),
  ADD CONSTRAINT `fk_employees_supervisor` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_employees_unit` FOREIGN KEY (`organization_unit_id`) REFERENCES `organization_units` (`id`);

--
-- Constraints for table `employee_custom_field_values`
--
ALTER TABLE `employee_custom_field_values`
  ADD CONSTRAINT `fk_emp_cf_definition` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_emp_cf_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_dependents`
--
ALTER TABLE `employee_dependents`
  ADD CONSTRAINT `fk_dependents_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_emergency_contacts`
--
ALTER TABLE `employee_emergency_contacts`
  ADD CONSTRAINT `fk_emergency_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_job_details`
--
ALTER TABLE `employee_job_details`
  ADD CONSTRAINT `fk_emp_job_emp_status` FOREIGN KEY (`employment_status_id`) REFERENCES `employment_statuses` (`id`),
  ADD CONSTRAINT `fk_emp_job_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_emp_job_job_title` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `fk_emp_job_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `fk_emp_job_supervisor` FOREIGN KEY (`supervisor_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_emp_job_unit` FOREIGN KEY (`organization_unit_id`) REFERENCES `organization_units` (`id`);

--
-- Constraints for table `employee_personal_details`
--
ALTER TABLE `employee_personal_details`
  ADD CONSTRAINT `fk_emp_personal_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_emp_personal_nationality` FOREIGN KEY (`nationality_id`) REFERENCES `nationalities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_qualifications`
--
ALTER TABLE `employee_qualifications`
  ADD CONSTRAINT `fk_emp_qual_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_emp_qual_qualification` FOREIGN KEY (`qualification_id`) REFERENCES `pim_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD CONSTRAINT `fk_emp_salary_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_emp_salary_pay_grade` FOREIGN KEY (`pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD CONSTRAINT `file_uploads_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `holidays`
--
ALTER TABLE `holidays`
  ADD CONSTRAINT `fk_holidays_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `fk_interviews_application` FOREIGN KEY (`candidate_application_id`) REFERENCES `candidate_applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_interviews_interviewer` FOREIGN KEY (`interviewer_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interview_feedback`
--
ALTER TABLE `interview_feedback`
  ADD CONSTRAINT `fk_feedback_interview` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_feedback_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD CONSTRAINT `fk_leave_applications_approver` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_leave_applications_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_leave_applications_type` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_application_days`
--
ALTER TABLE `leave_application_days`
  ADD CONSTRAINT `fk_leave_app_days_application` FOREIGN KEY (`leave_application_id`) REFERENCES `leave_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_balances`
--
ALTER TABLE `leave_balances`
  ADD CONSTRAINT `fk_leave_balances_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_leave_balances_type` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_entitlements`
--
ALTER TABLE `leave_entitlements`
  ADD CONSTRAINT `fk_leave_entitlements_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_leave_entitlements_type` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_status_history`
--
ALTER TABLE `leave_status_history`
  ADD CONSTRAINT `fk_leave_status_history_app` FOREIGN KEY (`leave_application_id`) REFERENCES `leave_applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_leave_status_history_user` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `fk_locations_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_user`
--
ALTER TABLE `notification_user`
  ADD CONSTRAINT `fk_notification_user_notification` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notification_user_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `organization_units`
--
ALTER TABLE `organization_units`
  ADD CONSTRAINT `fk_org_units_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_org_units_parent` FOREIGN KEY (`parent_id`) REFERENCES `organization_units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `overtime_entries`
--
ALTER TABLE `overtime_entries`
  ADD CONSTRAINT `fk_overtime_approver` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_overtime_attendance` FOREIGN KEY (`attendance_id`) REFERENCES `attendance_records` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_overtime_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_password_resets_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pay_grade_salary_ranges`
--
ALTER TABLE `pay_grade_salary_ranges`
  ADD CONSTRAINT `fk_pg_ranges_grade` FOREIGN KEY (`pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `performance_appraisals`
--
ALTER TABLE `performance_appraisals`
  ADD CONSTRAINT `fk_perf_appraisals_review` FOREIGN KEY (`performance_review_id`) REFERENCES `performance_reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `performance_reviews`
--
ALTER TABLE `performance_reviews`
  ADD CONSTRAINT `fk_perf_reviews_cycle` FOREIGN KEY (`cycle_id`) REFERENCES `performance_cycles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_perf_reviews_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_perf_reviews_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `performance_review_kpis`
--
ALTER TABLE `performance_review_kpis`
  ADD CONSTRAINT `fk_perf_review_kpis_kpi` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_perf_review_kpis_review` FOREIGN KEY (`performance_review_id`) REFERENCES `performance_reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `fk_role_permissions_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_role_permissions_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD CONSTRAINT `fk_timesheets_approver` FOREIGN KEY (`approved_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_timesheets_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timesheet_rows`
--
ALTER TABLE `timesheet_rows`
  ADD CONSTRAINT `fk_timesheet_rows_project` FOREIGN KEY (`project_id`) REFERENCES `time_projects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_timesheet_rows_sheet` FOREIGN KEY (`timesheet_id`) REFERENCES `timesheets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `time_projects`
--
ALTER TABLE `time_projects`
  ADD CONSTRAINT `fk_time_projects_customer` FOREIGN KEY (`customer_id`) REFERENCES `time_customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `time_project_assignments`
--
ALTER TABLE `time_project_assignments`
  ADD CONSTRAINT `fk_time_assignment_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_time_assignment_project` FOREIGN KEY (`project_id`) REFERENCES `time_projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD CONSTRAINT `fk_user_preferences_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_user_roles_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_roles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vacancies`
--
ALTER TABLE `vacancies`
  ADD CONSTRAINT `fk_vacancies_job_title` FOREIGN KEY (`job_title_id`) REFERENCES `job_titles` (`id`),
  ADD CONSTRAINT `fk_vacancies_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_vacancies_manager` FOREIGN KEY (`hiring_manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `work_weeks`
--
ALTER TABLE `work_weeks`
  ADD CONSTRAINT `fk_work_weeks_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
