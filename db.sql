-- =========================================================
-- DATABASE
-- =========================================================
-- Drop and recreate the database so this script can be run multiple times
DROP DATABASE IF EXISTS toai_hrm;

CREATE DATABASE IF NOT EXISTS toai_hrm
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE toai_hrm;

-- Ensure default engine
SET default_storage_engine = InnoDB;

-- =========================================================
-- CORE: USERS, ROLES, AUTH, PREFERENCES
-- =========================================================

-- Users (system accounts, may or may not be employees)
CREATE TABLE users (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(100) NOT NULL,
    email           VARCHAR(191) NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    employee_id     BIGINT UNSIGNED NULL,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    last_login_at   DATETIME NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      DATETIME NULL,
    CONSTRAINT uq_users_username UNIQUE (username),
    CONSTRAINT uq_users_email UNIQUE (email),
    INDEX idx_users_employee_id (employee_id)
) ENGINE=InnoDB COMMENT='Application users (login accounts).';

-- Roles (Admin, HR, Manager, Employee, etc.)
CREATE TABLE roles (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(100) NOT NULL,
    description VARCHAR(255) NULL,
    is_system   TINYINT(1) NOT NULL DEFAULT 0,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_roles_slug UNIQUE (slug)
) ENGINE=InnoDB COMMENT='Role definitions for RBAC.';

-- Permissions (fine-grained abilities)
CREATE TABLE permissions (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150) NOT NULL,
    slug        VARCHAR(150) NOT NULL,
    description VARCHAR(255) NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_permissions_slug UNIQUE (slug)
) ENGINE=InnoDB COMMENT='Permission definitions.';

-- Pivot: which roles have which permissions
CREATE TABLE role_permissions (
    role_id       BIGINT UNSIGNED NOT NULL,
    permission_id BIGINT UNSIGNED NOT NULL,
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (role_id, permission_id),
    CONSTRAINT fk_role_permissions_role
        FOREIGN KEY (role_id) REFERENCES roles(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_role_permissions_permission
        FOREIGN KEY (permission_id) REFERENCES permissions(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Role to permission mapping.';

-- Pivot: which users have which roles
CREATE TABLE user_roles (
    user_id   BIGINT UNSIGNED NOT NULL,
    role_id   BIGINT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, role_id),
    CONSTRAINT fk_user_roles_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_user_roles_role
        FOREIGN KEY (role_id) REFERENCES roles(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='User to role mapping.';

-- Authentication sessions (for web / API tokens)
CREATE TABLE auth_sessions (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    session_token   CHAR(64) NOT NULL,
    ip_address      VARCHAR(45) NULL,
    user_agent      VARCHAR(255) NULL,
    expires_at      DATETIME NOT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    revoked_at      DATETIME NULL,
    CONSTRAINT uq_auth_sessions_token UNIQUE (session_token),
    INDEX idx_auth_sessions_user (user_id),
    CONSTRAINT fk_auth_sessions_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Login sessions / tokens.';

-- Laravel-style session storage (used if SESSION_DRIVER=database)
CREATE TABLE sessions (
    id            VARCHAR(255) PRIMARY KEY,
    user_id       BIGINT UNSIGNED NULL,
    ip_address    VARCHAR(45) NULL,
    user_agent    TEXT NULL,
    payload       LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX idx_sessions_user (user_id),
    INDEX idx_sessions_last_activity (last_activity),
    CONSTRAINT fk_sessions_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Web session storage.';

-- Password reset requests
CREATE TABLE password_resets (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     BIGINT UNSIGNED NOT NULL,
    token       CHAR(64) NOT NULL,
    expires_at  DATETIME NOT NULL,
    used_at     DATETIME NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_password_resets_token UNIQUE (token),
    INDEX idx_password_resets_user (user_id),
    CONSTRAINT fk_password_resets_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Password reset tokens.';

-- Login attempts (for rate-limiting, security)
CREATE TABLE login_attempts (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(191) NULL,
    ip_address  VARCHAR(45) NULL,
    success     TINYINT(1) NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_login_attempts_username (username),
    INDEX idx_login_attempts_ip (ip_address)
) ENGINE=InnoDB COMMENT='Login attempt log for security.';

-- User preferences (theme, language, etc.)
CREATE TABLE user_preferences (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    timezone        VARCHAR(100) NULL,
    language        VARCHAR(10)  NULL,
    theme           ENUM('light','dark','system') DEFAULT 'system',
    sidebar_collapsed TINYINT(1) NOT NULL DEFAULT 0,
    notifications_email TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_user_preferences_user UNIQUE (user_id),
    CONSTRAINT fk_user_preferences_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Per-user UI and notification preferences.';

-- =========================================================
-- ADMIN / CONFIGURATION & REFERENCE DATA
-- =========================================================

-- Organization (top-level data)
CREATE TABLE organizations (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(191) NOT NULL,
    registration_number VARCHAR(100) NULL,
    phone       VARCHAR(50) NULL,
    email       VARCHAR(191) NULL,
    website     VARCHAR(191) NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Top-level organization entity.';

-- Organization units (departments, sub-units; hierarchical)
CREATE TABLE organization_units (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organization_id BIGINT UNSIGNED NOT NULL,
    parent_id       BIGINT UNSIGNED NULL,
    name            VARCHAR(191) NOT NULL,
    code            VARCHAR(50) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      DATETIME NULL,
    INDEX idx_org_units_parent (parent_id),
    CONSTRAINT fk_org_units_org
        FOREIGN KEY (organization_id) REFERENCES organizations(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_org_units_parent
        FOREIGN KEY (parent_id) REFERENCES organization_units(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Departments / sub-units in org structure.';

-- Locations
CREATE TABLE locations (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organization_id BIGINT UNSIGNED NOT NULL,
    name            VARCHAR(191) NOT NULL,
    address_line1   VARCHAR(191) NULL,
    address_line2   VARCHAR(191) NULL,
    city            VARCHAR(100) NULL,
    state           VARCHAR(100) NULL,
    postal_code     VARCHAR(20) NULL,
    country         VARCHAR(100) NULL,
    phone           VARCHAR(50) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      DATETIME NULL,
    INDEX idx_locations_org (organization_id),
    CONSTRAINT fk_locations_org
        FOREIGN KEY (organization_id) REFERENCES organizations(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Company locations / worksites.';

-- Job titles
CREATE TABLE job_titles (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(191) NOT NULL,
    description VARCHAR(255) NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at  DATETIME NULL,
    CONSTRAINT uq_job_titles_name UNIQUE (name)
) ENGINE=InnoDB COMMENT='Job titles.';

-- Job categories (Admin → Job Categories)
CREATE TABLE job_categories (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(191) NOT NULL,
    description VARCHAR(255) NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at  DATETIME NULL,
    CONSTRAINT uq_job_categories_name UNIQUE (name)
) ENGINE=InnoDB COMMENT='Job categories used for classification.';

-- Pay grades
CREATE TABLE pay_grades (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    currency    CHAR(3) NOT NULL DEFAULT 'USD',
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at  DATETIME NULL,
    CONSTRAINT uq_pay_grades_name UNIQUE (name)
) ENGINE=InnoDB COMMENT='Pay grades / bands.';

-- Work shifts (Admin → Work Shifts)
CREATE TABLE work_shifts (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL,
    start_time      TIME NOT NULL,
    end_time        TIME NOT NULL,
    hours_per_day   DECIMAL(4,2) NOT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      DATETIME NULL,
    CONSTRAINT uq_work_shifts_name UNIQUE (name)
) ENGINE=InnoDB COMMENT='Work shift definitions.';

-- Salary ranges within pay grade
CREATE TABLE pay_grade_salary_ranges (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pay_grade_id    BIGINT UNSIGNED NOT NULL,
    min_salary      DECIMAL(15,2) NOT NULL,
    max_salary      DECIMAL(15,2) NOT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pg_ranges_grade
        FOREIGN KEY (pay_grade_id) REFERENCES pay_grades(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Min/max salary by pay grade.';

-- Employment statuses (Full-Time, Part-Time, etc.)
CREATE TABLE employment_statuses (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at  DATETIME NULL,
    CONSTRAINT uq_emp_status_name UNIQUE (name)
) ENGINE=InnoDB COMMENT='Employment status types.';

-- Nationalities
CREATE TABLE nationalities (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    iso_code    CHAR(2) NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_nationalities_name UNIQUE (name)
) ENGINE=InnoDB COMMENT='Nationalities master list.';

-- Qualifications (Degree, Certification, Skill categories)
CREATE TABLE qualifications (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type            ENUM('education','skill','language','certification','other') NOT NULL,
    name            VARCHAR(191) NOT NULL,
    description     VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Qualification master list.';

-- Corporate branding (colors, logos, banners)
CREATE TABLE corporate_branding (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organization_id BIGINT UNSIGNED NOT NULL,
    primary_color   VARCHAR(20) NULL,
    secondary_color VARCHAR(20) NULL,
    accent_color    VARCHAR(20) NULL,
    logo_file_id    BIGINT UNSIGNED NULL,
    banner_file_id  BIGINT UNSIGNED NULL,
    dark_mode_enabled TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_branding_org
        FOREIGN KEY (organization_id) REFERENCES organizations(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Corporate branding configuration.';

-- =========================================================
-- ADMIN CONFIGURATION (EMAIL, LOCALIZATION, MODULES, LDAP, OAUTH)
-- =========================================================

-- Outgoing email configuration (Admin → Email Configuration)
CREATE TABLE email_settings (
    id                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mail_from_name    VARCHAR(191) NULL,
    mail_from_address VARCHAR(191) NULL,
    sending_method    ENUM('secure_smtp','smtp','sendmail') NOT NULL DEFAULT 'secure_smtp',
    smtp_host         VARCHAR(191) NULL,
    smtp_port         INT NULL,
    smtp_username     VARCHAR(191) NULL,
    smtp_password     VARCHAR(191) NULL, -- store hashed/encrypted in app
    smtp_encryption   ENUM('none','ssl','tls') DEFAULT 'tls',
    sendmail_path     VARCHAR(255) NULL,
    send_test_mail    TINYINT(1) NOT NULL DEFAULT 0,
    test_recipient    VARCHAR(191) NULL,
    created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Outgoing email configuration.';

-- Email subscription definitions (Admin → Email Subscriptions)
CREATE TABLE email_subscriptions (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    notification_key VARCHAR(100) NOT NULL,  -- e.g., leave_applied
    name            VARCHAR(191) NOT NULL,
    description     VARCHAR(255) NULL,
    is_enabled      TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_email_subscriptions_key UNIQUE (notification_key)
) ENGINE=InnoDB COMMENT='Notification types for email subscriptions.';

-- Localization settings (Admin → Localization)
CREATE TABLE localization_settings (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    language        VARCHAR(10) NOT NULL DEFAULT 'en',
    date_format     VARCHAR(20) NOT NULL DEFAULT 'Y-m-d',
    time_format     VARCHAR(20) NOT NULL DEFAULT 'H:i',
    timezone        VARCHAR(100) NOT NULL DEFAULT 'UTC',
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='System-wide localization settings.';

-- Language packages (Admin → Language Packages)
CREATE TABLE language_packages (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code        VARCHAR(10) NOT NULL,   -- e.g., en, fr, es
    name        VARCHAR(100) NOT NULL,
    is_default  TINYINT(1) NOT NULL DEFAULT 0,
    sort_order  INT NOT NULL DEFAULT 0,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_language_packages_code UNIQUE (code)
) ENGINE=InnoDB COMMENT='Installed language packs.';

-- Module enable/disable configuration (Admin → Modules)
CREATE TABLE enabled_modules (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    module_key  VARCHAR(50) NOT NULL,  -- admin, pim, leave, time, recruitment, performance, directory, maintenance, mobile, claim, buzz
    is_enabled  TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_enabled_modules_key UNIQUE (module_key)
) ENGINE=InnoDB COMMENT='Which functional modules are enabled.';

-- LDAP configuration (Admin → LDAP Configuration)
CREATE TABLE ldap_settings (
    id                      BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    enabled                 TINYINT(1) NOT NULL DEFAULT 0,
    host                    VARCHAR(191) NULL,
    port                    INT NULL,
    encryption              ENUM('none','ssl','tls') DEFAULT 'none',
    implementation          VARCHAR(50) NULL, -- e.g., ad, openldap
    bind_anonymously        TINYINT(1) NOT NULL DEFAULT 0,
    bind_dn                 VARCHAR(255) NULL,
    bind_password           VARCHAR(191) NULL,
    base_dn                 VARCHAR(255) NULL,
    search_scope            ENUM('base','one','sub') DEFAULT 'sub',
    username_attribute      VARCHAR(100) NULL,
    user_filter             VARCHAR(255) NULL,
    user_unique_id_attribute VARCHAR(100) NULL,
    map_first_name          VARCHAR(100) NULL,
    map_middle_name         VARCHAR(100) NULL,
    map_last_name           VARCHAR(100) NULL,
    map_status              VARCHAR(100) NULL,
    map_work_email          VARCHAR(100) NULL,
    map_employee_id         VARCHAR(100) NULL,
    merge_ldap_users        TINYINT(1) NOT NULL DEFAULT 0,
    sync_interval_minutes   INT NULL,
    warning_message         VARCHAR(255) NULL,
    created_at              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at              DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='LDAP connection and mapping configuration.';

-- OAuth clients (Admin → Register OAuth Client)
CREATE TABLE oauth_clients (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(191) NOT NULL,
    redirect_uri    VARCHAR(255) NOT NULL,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Registered OAuth clients for SSO / API.';

-- Social media authentication providers (Admin → Social Media Authentication)
CREATE TABLE social_providers (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL, -- Google, Facebook, etc.
    client_id       VARCHAR(191) NOT NULL,
    client_secret   VARCHAR(191) NOT NULL,
    redirect_uri    VARCHAR(255) NOT NULL,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Social login provider configuration.';

-- =========================================================
-- EMPLOYEE / PIM MODULE
-- =========================================================

-- Employee master record
CREATE TABLE employees (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_number VARCHAR(50) NOT NULL,
    organization_id BIGINT UNSIGNED NOT NULL,
    first_name      VARCHAR(100) NOT NULL,
    middle_name     VARCHAR(100) NULL,
    last_name       VARCHAR(100) NOT NULL,
    display_name    VARCHAR(191) NULL,
    date_of_birth   DATE NULL,
    gender          ENUM('male','female','other','unspecified') DEFAULT 'unspecified',
    marital_status  ENUM('single','married','divorced','widowed','other') NULL,
    national_id     VARCHAR(100) NULL,
    hire_date       DATE NOT NULL,
    termination_date DATE NULL,
    status          ENUM('active','terminated','on_leave','probation') DEFAULT 'active',
    location_id     BIGINT UNSIGNED NULL,
    organization_unit_id BIGINT UNSIGNED NULL,
    job_title_id    BIGINT UNSIGNED NULL,
    employment_status_id BIGINT UNSIGNED NULL,
    pay_grade_id    BIGINT UNSIGNED NULL,
    supervisor_id   BIGINT UNSIGNED NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      DATETIME NULL,
    CONSTRAINT uq_employees_employee_number UNIQUE (employee_number),
    INDEX idx_employees_org (organization_id),
    INDEX idx_employees_unit (organization_unit_id),
    INDEX idx_employees_location (location_id),
    INDEX idx_employees_supervisor (supervisor_id),
    CONSTRAINT fk_employees_org
        FOREIGN KEY (organization_id) REFERENCES organizations(id),
    CONSTRAINT fk_employees_location
        FOREIGN KEY (location_id) REFERENCES locations(id),
    CONSTRAINT fk_employees_unit
        FOREIGN KEY (organization_unit_id) REFERENCES organization_units(id),
    CONSTRAINT fk_employees_job_title
        FOREIGN KEY (job_title_id) REFERENCES job_titles(id),
    CONSTRAINT fk_employees_emp_status
        FOREIGN KEY (employment_status_id) REFERENCES employment_statuses(id),
    CONSTRAINT fk_employees_pay_grade
        FOREIGN KEY (pay_grade_id) REFERENCES pay_grades(id),
    CONSTRAINT fk_employees_supervisor
        FOREIGN KEY (supervisor_id) REFERENCES employees(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Employee master records.';

-- Link user to employee (if not already via users.employee_id)
ALTER TABLE users
    ADD CONSTRAINT fk_users_employee
    FOREIGN KEY (employee_id) REFERENCES employees(id)
    ON DELETE SET NULL;

-- Employee personal details (extended)
CREATE TABLE employee_personal_details (
    employee_id     BIGINT UNSIGNED PRIMARY KEY,
    nationality_id  BIGINT UNSIGNED NULL,
    other_id        VARCHAR(100) NULL,
    drivers_license VARCHAR(100) NULL,
    license_expiry  DATE NULL,
    smoker          TINYINT(1) NOT NULL DEFAULT 0,
    blood_group     VARCHAR(5) NULL,
    address1        VARCHAR(191) NULL,
    address2        VARCHAR(191) NULL,
    city            VARCHAR(100) NULL,
    state           VARCHAR(100) NULL,
    postal_code     VARCHAR(20) NULL,
    country         VARCHAR(100) NULL,
    home_phone      VARCHAR(50) NULL,
    mobile_phone    VARCHAR(50) NULL,
    work_phone      VARCHAR(50) NULL,
    work_email      VARCHAR(191) NULL,
    other_email     VARCHAR(191) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_emp_personal_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_emp_personal_nationality
        FOREIGN KEY (nationality_id) REFERENCES nationalities(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Extended personal details for employees.';

-- Job details history (if you want multiple records, this holds history;
-- current job details can be derived by latest effective_date).
CREATE TABLE employee_job_details (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id         BIGINT UNSIGNED NOT NULL,
    job_title_id        BIGINT UNSIGNED NULL,
    employment_status_id BIGINT UNSIGNED NULL,
    organization_unit_id BIGINT UNSIGNED NULL,
    location_id         BIGINT UNSIGNED NULL,
    supervisor_id       BIGINT UNSIGNED NULL,
    effective_date      DATE NOT NULL,
    end_date            DATE NULL,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_emp_job_employee (employee_id, effective_date),
    CONSTRAINT fk_emp_job_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_emp_job_job_title
        FOREIGN KEY (job_title_id) REFERENCES job_titles(id),
    CONSTRAINT fk_emp_job_emp_status
        FOREIGN KEY (employment_status_id) REFERENCES employment_statuses(id),
    CONSTRAINT fk_emp_job_unit
        FOREIGN KEY (organization_unit_id) REFERENCES organization_units(id),
    CONSTRAINT fk_emp_job_location
        FOREIGN KEY (location_id) REFERENCES locations(id),
    CONSTRAINT fk_emp_job_supervisor
        FOREIGN KEY (supervisor_id) REFERENCES employees(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Job assignment history per employee.';

-- Salary / compensation history
CREATE TABLE employee_salary (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    pay_grade_id    BIGINT UNSIGNED NULL,
    pay_frequency   ENUM('monthly','biweekly','weekly','other') DEFAULT 'monthly',
    amount          DECIMAL(15,2) NOT NULL,
    currency        CHAR(3) NOT NULL DEFAULT 'USD',
    effective_date  DATE NOT NULL,
    end_date        DATE NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_emp_salary_employee (employee_id, effective_date),
    CONSTRAINT fk_emp_salary_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_emp_salary_pay_grade
        FOREIGN KEY (pay_grade_id) REFERENCES pay_grades(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Salary / compensation history.';

-- Emergency contacts
CREATE TABLE employee_emergency_contacts (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    name        VARCHAR(191) NOT NULL,
    relationship VARCHAR(100) NULL,
    home_phone  VARCHAR(50) NULL,
    mobile_phone VARCHAR(50) NULL,
    work_phone  VARCHAR(50) NULL,
    is_primary  TINYINT(1) NOT NULL DEFAULT 0,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_emergency_employee (employee_id),
    CONSTRAINT fk_emergency_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Employee emergency contacts.';

-- Dependents
CREATE TABLE employee_dependents (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id BIGINT UNSIGNED NOT NULL,
    name        VARCHAR(191) NOT NULL,
    relationship VARCHAR(100) NOT NULL,
    date_of_birth DATE NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_dependents_employee (employee_id),
    CONSTRAINT fk_dependents_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Employee dependents.';

-- Custom fields definitions (per module, incl. PIM)
CREATE TABLE custom_fields (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    module          VARCHAR(50) NOT NULL,  -- e.g., 'employee','candidate','claim'
    name            VARCHAR(100) NOT NULL,
    label           VARCHAR(191) NOT NULL,
    data_type       ENUM('string','text','number','date','boolean','select') NOT NULL,
    options_json    JSON NULL,     -- for select options
    is_required     TINYINT(1) NOT NULL DEFAULT 0,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    sort_order      INT NOT NULL DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Configurable custom fields for various modules.';

-- Custom field values for employees
CREATE TABLE employee_custom_field_values (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    custom_field_id BIGINT UNSIGNED NOT NULL,
    value_text      TEXT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_emp_custom_field (employee_id, custom_field_id),
    CONSTRAINT fk_emp_cf_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_emp_cf_definition
        FOREIGN KEY (custom_field_id) REFERENCES custom_fields(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Values for employee custom fields.';

-- Employee qualifications (link table)
CREATE TABLE employee_qualifications (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    qualification_id BIGINT UNSIGNED NOT NULL,
    institution     VARCHAR(191) NULL,
    start_date      DATE NULL,
    end_date        DATE NULL,
    grade           VARCHAR(50) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_emp_qual_employee (employee_id),
    CONSTRAINT fk_emp_qual_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_emp_qual_qualification
        FOREIGN KEY (qualification_id) REFERENCES qualifications(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Employee qualifications & education.';

-- =========================================================
-- ATTENDANCE & TIME
-- =========================================================

-- Punch in/out & attendance records
CREATE TABLE attendance_records (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    punch_in_at     DATETIME NOT NULL,
    punch_out_at    DATETIME NULL,
    punch_in_ip     VARCHAR(45) NULL,
    punch_out_ip    VARCHAR(45) NULL,
    punch_in_source VARCHAR(50) NULL,  -- web, mobile, kiosk, etc.
    punch_out_source VARCHAR(50) NULL,
    remarks         VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_attendance_employee_date (employee_id, punch_in_at),
    CONSTRAINT fk_attendance_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Employee punch in/out records.';

-- Attendance configuration flags (Time → Attendance → Configuration)
CREATE TABLE attendance_settings (
    id                              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_can_change_time        TINYINT(1) NOT NULL DEFAULT 1,
    employee_can_edit_own_records   TINYINT(1) NOT NULL DEFAULT 1,
    supervisor_can_manage_subordinates TINYINT(1) NOT NULL DEFAULT 1,
    created_at                      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at                      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Global attendance configuration flags.';

-- Time tracking customers
CREATE TABLE time_customers (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(191) NOT NULL,
    description TEXT NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Customers for project/time tracking.';

-- Time tracking projects
CREATE TABLE time_projects (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id     BIGINT UNSIGNED NULL,
    name            VARCHAR(191) NOT NULL,
    description     TEXT NULL,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_time_projects_customer
        FOREIGN KEY (customer_id) REFERENCES time_customers(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Projects for timesheets.';

-- Which employees can log time on which projects
CREATE TABLE time_project_assignments (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id      BIGINT UNSIGNED NOT NULL,
    employee_id     BIGINT UNSIGNED NOT NULL,
    role            VARCHAR(100) NULL,
    hourly_rate     DECIMAL(15,2) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_time_project_employee (project_id, employee_id),
    CONSTRAINT fk_time_assignment_project
        FOREIGN KEY (project_id) REFERENCES time_projects(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_time_assignment_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Assignment of employees to projects.';

-- Timesheet header
CREATE TABLE timesheets (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    start_date      DATE NOT NULL,
    end_date        DATE NOT NULL,
    status          ENUM('draft','submitted','approved','rejected','locked') DEFAULT 'draft',
    submitted_at    DATETIME NULL,
    approved_by     BIGINT UNSIGNED NULL,
    approved_at     DATETIME NULL,
    remarks         VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_timesheets_employee_period (employee_id, start_date, end_date),
    INDEX idx_timesheets_status (status),
    CONSTRAINT fk_timesheets_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_timesheets_approver
        FOREIGN KEY (approved_by) REFERENCES employees(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Weekly/monthly timesheet headers.';

-- Timesheet detail rows
CREATE TABLE timesheet_rows (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    timesheet_id    BIGINT UNSIGNED NOT NULL,
    work_date       DATE NOT NULL,
    project_id      BIGINT UNSIGNED NULL,
    hours_worked    DECIMAL(5,2) NOT NULL DEFAULT 0,
    overtime_hours  DECIMAL(5,2) NOT NULL DEFAULT 0,
    notes           VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_timesheet_rows_sheet (timesheet_id),
    INDEX idx_timesheet_rows_date (work_date),
    CONSTRAINT fk_timesheet_rows_sheet
        FOREIGN KEY (timesheet_id) REFERENCES timesheets(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_timesheet_rows_project
        FOREIGN KEY (project_id) REFERENCES time_projects(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Per-day time entries in timesheets.';

-- Overtime entries (can link to attendance or timesheet)
CREATE TABLE overtime_entries (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    attendance_id   BIGINT UNSIGNED NULL,
    work_date       DATE NOT NULL,
    hours           DECIMAL(5,2) NOT NULL,
    status          ENUM('pending','approved','rejected') DEFAULT 'pending',
    approved_by     BIGINT UNSIGNED NULL,
    approved_at     DATETIME NULL,
    remarks         VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_overtime_employee_date (employee_id, work_date),
    CONSTRAINT fk_overtime_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_overtime_attendance
        FOREIGN KEY (attendance_id) REFERENCES attendance_records(id)
        ON DELETE SET NULL,
    CONSTRAINT fk_overtime_approver
        FOREIGN KEY (approved_by) REFERENCES employees(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Overtime records linked to attendance or manual.';

-- =========================================================
-- LEAVE MANAGEMENT
-- =========================================================

-- Leave types
CREATE TABLE leave_types (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL,
    code            VARCHAR(20) NOT NULL,
    is_paid         TINYINT(1) NOT NULL DEFAULT 1,
    requires_approval TINYINT(1) NOT NULL DEFAULT 1,
    max_per_year    DECIMAL(5,2) NULL,
    carry_forward   TINYINT(1) NOT NULL DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      DATETIME NULL,
    CONSTRAINT uq_leave_types_code UNIQUE (code)
) ENGINE=InnoDB COMMENT='Types of leave (Annual, Sick, etc.).';

-- Leave periods configuration (Leave → Leave Period)
CREATE TABLE leave_periods (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL, -- e.g., 2026 Leave Period
    period_start    DATE NOT NULL,
    period_end      DATE NOT NULL,
    is_current      TINYINT(1) NOT NULL DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Configured leave periods.';

-- Work week configuration (Leave → Work Week)
CREATE TABLE work_weeks (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    location_id     BIGINT UNSIGNED NULL,
    day_of_week     TINYINT NOT NULL, -- 1=Mon ... 7=Sun
    is_working_day  TINYINT(1) NOT NULL DEFAULT 1,
    hours_per_day   DECIMAL(4,2) NOT NULL DEFAULT 8.00,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_work_weeks_location
        FOREIGN KEY (location_id) REFERENCES locations(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Work week definition per location or global.';

-- Holidays configuration (Leave → Holidays)
CREATE TABLE holidays (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(191) NOT NULL,
    holiday_date    DATE NOT NULL,
    is_recurring    TINYINT(1) NOT NULL DEFAULT 0,
    location_id     BIGINT UNSIGNED NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_holidays_location
        FOREIGN KEY (location_id) REFERENCES locations(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Public / company holidays.';

-- Leave entitlements (per employee & period)
CREATE TABLE leave_entitlements (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    leave_type_id   BIGINT UNSIGNED NOT NULL,
    period_start    DATE NOT NULL,
    period_end      DATE NOT NULL,
    days_entitled   DECIMAL(5,2) NOT NULL,
    days_used       DECIMAL(5,2) NOT NULL DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_leave_entitlement_period (employee_id, leave_type_id, period_start, period_end),
    CONSTRAINT fk_leave_entitlements_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_leave_entitlements_type
        FOREIGN KEY (leave_type_id) REFERENCES leave_types(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Leave entitlement per employee and period.';

-- Leave applications (header)
CREATE TABLE leave_applications (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    leave_type_id   BIGINT UNSIGNED NOT NULL,
    start_date      DATE NOT NULL,
    end_date        DATE NOT NULL,
    total_days      DECIMAL(5,2) NOT NULL,
    status          ENUM('pending','approved','rejected','cancelled') DEFAULT 'pending',
    applied_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    approved_by     BIGINT UNSIGNED NULL,
    approved_at     DATETIME NULL,
    reason          TEXT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_leave_applications_employee (employee_id),
    INDEX idx_leave_applications_status (status),
    CONSTRAINT fk_leave_applications_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_leave_applications_type
        FOREIGN KEY (leave_type_id) REFERENCES leave_types(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_leave_applications_approver
        FOREIGN KEY (approved_by) REFERENCES employees(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Leave applications / requests.';

-- Per-day breakdown for applications
CREATE TABLE leave_application_days (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    leave_application_id BIGINT UNSIGNED NOT NULL,
    leave_date      DATE NOT NULL,
    day_part        ENUM('full','first_half','second_half') DEFAULT 'full',
    duration_days   DECIMAL(4,2) NOT NULL,  -- 1, 0.5, etc.
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_leave_application_day (leave_application_id, leave_date, day_part),
    CONSTRAINT fk_leave_app_days_application
        FOREIGN KEY (leave_application_id) REFERENCES leave_applications(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Daily details for leave applications.';

-- Leave status history (audit trail)
CREATE TABLE leave_status_history (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    leave_application_id BIGINT UNSIGNED NOT NULL,
    old_status      ENUM('pending','approved','rejected','cancelled') NULL,
    new_status      ENUM('pending','approved','rejected','cancelled') NOT NULL,
    changed_by      BIGINT UNSIGNED NULL, -- user or employee
    changed_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    comment         VARCHAR(255) NULL,
    INDEX idx_leave_status_history_app (leave_application_id),
    CONSTRAINT fk_leave_status_history_app
        FOREIGN KEY (leave_application_id) REFERENCES leave_applications(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_leave_status_history_user
        FOREIGN KEY (changed_by) REFERENCES users(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Leave status change history.';

-- Aggregated balances for fast reporting
CREATE TABLE leave_balances (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    leave_type_id   BIGINT UNSIGNED NOT NULL,
    balance_date    DATE NOT NULL,
    opening_balance DECIMAL(5,2) NOT NULL,
    entitled        DECIMAL(5,2) NOT NULL,
    used            DECIMAL(5,2) NOT NULL,
    closing_balance DECIMAL(5,2) NOT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_leave_balances_key (employee_id, leave_type_id, balance_date),
    CONSTRAINT fk_leave_balances_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_leave_balances_type
        FOREIGN KEY (leave_type_id) REFERENCES leave_types(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Snapshot of leave balances for reports.';

-- =========================================================
-- CLAIMS MODULE
-- =========================================================

-- Claim events/types (Travel, Meal, etc.)
CREATE TABLE claim_events (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(191) NOT NULL,
    description     VARCHAR(255) NULL,
    max_amount      DECIMAL(15,2) NULL,
    requires_receipt TINYINT(1) NOT NULL DEFAULT 1,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Claim event types / categories.';

-- Expense types (Claim → Expense Types configuration)
CREATE TABLE claim_expense_types (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(191) NOT NULL,
    description     VARCHAR(255) NULL,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_claim_expense_types_name UNIQUE (name)
) ENGINE=InnoDB COMMENT='Expense types used in claims.';

-- Claim requests (header)
CREATE TABLE claim_requests (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     BIGINT UNSIGNED NOT NULL,
    claim_date      DATE NOT NULL,
    total_amount    DECIMAL(15,2) NOT NULL DEFAULT 0,
    currency        CHAR(3) NOT NULL DEFAULT 'USD',
    status          ENUM('draft','submitted','approved','rejected','paid','cancelled') DEFAULT 'draft',
    submitted_at    DATETIME NULL,
    approved_by     BIGINT UNSIGNED NULL,
    approved_at     DATETIME NULL,
    paid_at         DATETIME NULL,
    remarks         VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_claim_requests_employee (employee_id),
    INDEX idx_claim_requests_status (status),
    CONSTRAINT fk_claim_requests_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_claim_requests_approver
        FOREIGN KEY (approved_by) REFERENCES employees(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Expense/claim requests.';

-- Claim items (line items)
CREATE TABLE claim_items (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    claim_request_id BIGINT UNSIGNED NOT NULL,
    claim_event_id BIGINT UNSIGNED NOT NULL,
    item_date      DATE NOT NULL,
    description    VARCHAR(255) NULL,
    amount         DECIMAL(15,2) NOT NULL,
    currency       CHAR(3) NOT NULL DEFAULT 'USD',
    receipt_file_id BIGINT UNSIGNED NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_claim_items_claim (claim_request_id),
    CONSTRAINT fk_claim_items_request
        FOREIGN KEY (claim_request_id) REFERENCES claim_requests(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_claim_items_event
        FOREIGN KEY (claim_event_id) REFERENCES claim_events(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB COMMENT='Individual items within a claim request.';

-- Claim status history
CREATE TABLE claim_status_history (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    claim_request_id BIGINT UNSIGNED NOT NULL,
    old_status      ENUM('draft','submitted','approved','rejected','paid','cancelled') NULL,
    new_status      ENUM('draft','submitted','approved','rejected','paid','cancelled') NOT NULL,
    changed_by      BIGINT UNSIGNED NULL,
    changed_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    comment         VARCHAR(255) NULL,
    INDEX idx_claim_status_history_request (claim_request_id),
    CONSTRAINT fk_claim_status_history_request
        FOREIGN KEY (claim_request_id) REFERENCES claim_requests(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_claim_status_history_user
        FOREIGN KEY (changed_by) REFERENCES users(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Status change log for claims.';

-- Claim attachments (generic, but can use file_uploads)
CREATE TABLE claim_attachments (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    claim_request_id BIGINT UNSIGNED NOT NULL,
    file_id         BIGINT UNSIGNED NOT NULL,
    description     VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_claim_attachments_request
        FOREIGN KEY (claim_request_id) REFERENCES claim_requests(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Additional attachments for claims.';

-- =========================================================
-- RECRUITMENT MODULE
-- =========================================================

-- Recruitment sources (Job portal, Referral, etc.)
CREATE TABLE recruitment_sources (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Candidate source types.';

-- Vacancies
CREATE TABLE vacancies (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_title_id    BIGINT UNSIGNED NOT NULL,
    hiring_manager_id BIGINT UNSIGNED NULL,
    location_id     BIGINT UNSIGNED NULL,
    name            VARCHAR(191) NOT NULL,
    description     TEXT NULL,
    positions       INT NOT NULL DEFAULT 1,
    status          ENUM('open','on_hold','closed') DEFAULT 'open',
    posted_date     DATE NULL,
    closing_date    DATE NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_vacancies_status (status),
    CONSTRAINT fk_vacancies_job_title
        FOREIGN KEY (job_title_id) REFERENCES job_titles(id),
    CONSTRAINT fk_vacancies_manager
        FOREIGN KEY (hiring_manager_id) REFERENCES employees(id)
        ON DELETE SET NULL,
    CONSTRAINT fk_vacancies_location
        FOREIGN KEY (location_id) REFERENCES locations(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Job vacancies.';

-- Candidates
CREATE TABLE candidates (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name      VARCHAR(100) NOT NULL,
    middle_name     VARCHAR(100) NULL,
    last_name       VARCHAR(100) NOT NULL,
    email           VARCHAR(191) NOT NULL,
    phone           VARCHAR(50) NULL,
    source_id       BIGINT UNSIGNED NULL,
    resume_file_id  BIGINT UNSIGNED NULL,
    notes           TEXT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_candidates_email UNIQUE (email),
    INDEX idx_candidates_source (source_id),
    CONSTRAINT fk_candidates_source
        FOREIGN KEY (source_id) REFERENCES recruitment_sources(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Candidates applying for vacancies.';

-- Candidate applications (candidate to vacancy)
CREATE TABLE candidate_applications (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_id    BIGINT UNSIGNED NOT NULL,
    vacancy_id      BIGINT UNSIGNED NOT NULL,
    applied_date    DATE NOT NULL,
    status          ENUM('new','shortlisted','interview_scheduled','offered','rejected','hired') DEFAULT 'new',
    current_stage   VARCHAR(100) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_candidate_vacancy (candidate_id, vacancy_id),
    INDEX idx_candidate_applications_status (status),
    CONSTRAINT fk_candidate_applications_candidate
        FOREIGN KEY (candidate_id) REFERENCES candidates(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_candidate_applications_vacancy
        FOREIGN KEY (vacancy_id) REFERENCES vacancies(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Applications of candidates to specific vacancies.';

-- Interviews
CREATE TABLE interviews (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    candidate_application_id BIGINT UNSIGNED NOT NULL,
    interviewer_id      BIGINT UNSIGNED NOT NULL,
    scheduled_at        DATETIME NOT NULL,
    duration_minutes    INT NOT NULL DEFAULT 60,
    location            VARCHAR(191) NULL,
    status              ENUM('scheduled','completed','cancelled') DEFAULT 'scheduled',
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_interviews_application (candidate_application_id),
    CONSTRAINT fk_interviews_application
        FOREIGN KEY (candidate_application_id) REFERENCES candidate_applications(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_interviews_interviewer
        FOREIGN KEY (interviewer_id) REFERENCES employees(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Scheduled interviews.';

-- Interview feedback
CREATE TABLE interview_feedback (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    interview_id    BIGINT UNSIGNED NOT NULL,
    reviewer_id     BIGINT UNSIGNED NOT NULL,
    rating_overall  TINYINT NOT NULL, -- 1-5
    strengths       TEXT NULL,
    weaknesses      TEXT NULL,
    recommendation  ENUM('hire','hold','reject') NOT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_feedback_interview (interview_id),
    CONSTRAINT fk_feedback_interview
        FOREIGN KEY (interview_id) REFERENCES interviews(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_feedback_reviewer
        FOREIGN KEY (reviewer_id) REFERENCES employees(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Feedback per interview and reviewer.';

-- =========================================================
-- PERFORMANCE MODULE
-- =========================================================

-- KPIs
CREATE TABLE kpis (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(191) NOT NULL,
    description     VARCHAR(255) NULL,
    weight          DECIMAL(5,2) NOT NULL DEFAULT 1.0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Key Performance Indicators definitions.';

-- Performance review cycles
CREATE TABLE performance_cycles (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(191) NOT NULL,
    start_date      DATE NOT NULL,
    end_date        DATE NOT NULL,
    status          ENUM('planned','active','closed','archived') DEFAULT 'planned',
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Review/appraisal cycles.';

-- Reviews per employee per cycle
CREATE TABLE performance_reviews (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cycle_id        BIGINT UNSIGNED NOT NULL,
    employee_id     BIGINT UNSIGNED NOT NULL,
    reviewer_id     BIGINT UNSIGNED NULL,
    status          ENUM('not_started','in_progress','completed','approved') DEFAULT 'not_started',
    overall_rating  DECIMAL(4,2) NULL,
    comments        TEXT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_review_cycle_employee (cycle_id, employee_id),
    INDEX idx_performance_reviews_status (status),
    CONSTRAINT fk_perf_reviews_cycle
        FOREIGN KEY (cycle_id) REFERENCES performance_cycles(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_perf_reviews_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_perf_reviews_reviewer
        FOREIGN KEY (reviewer_id) REFERENCES employees(id)
        ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Performance reviews per employee & cycle.';

-- Per-KPI ratings in a review
CREATE TABLE performance_review_kpis (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    performance_review_id BIGINT UNSIGNED NOT NULL,
    kpi_id          BIGINT UNSIGNED NOT NULL,
    rating          DECIMAL(4,2) NULL,
    comments        TEXT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_review_kpi (performance_review_id, kpi_id),
    CONSTRAINT fk_perf_review_kpis_review
        FOREIGN KEY (performance_review_id) REFERENCES performance_reviews(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_perf_review_kpis_kpi
        FOREIGN KEY (kpi_id) REFERENCES kpis(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Ratings per KPI within a review.';

-- Appraisals / salary changes triggered by review
CREATE TABLE performance_appraisals (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    performance_review_id BIGINT UNSIGNED NOT NULL,
    old_salary      DECIMAL(15,2) NULL,
    new_salary      DECIMAL(15,2) NULL,
    effective_date  DATE NULL,
    comments        TEXT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_perf_appraisals_review
        FOREIGN KEY (performance_review_id) REFERENCES performance_reviews(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Appraisals / compensation changes following reviews.';

-- =========================================================
-- SYSTEM / UTILITY: FILES, NOTIFICATIONS, LOGGING
-- =========================================================

-- Generic file uploads (for docs, images, resumes, attachments)
CREATE TABLE file_uploads (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    stored_name     VARCHAR(191) NOT NULL,
    original_name   VARCHAR(191) NOT NULL,
    mime_type       VARCHAR(100) NOT NULL,
    size_bytes      BIGINT UNSIGNED NOT NULL,
    path            VARCHAR(255) NOT NULL,
    uploaded_by     BIGINT UNSIGNED NULL,
    uploaded_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Physical files stored on disk/cloud.';

-- Notifications (generic)
CREATE TABLE notifications (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type            VARCHAR(100) NOT NULL,  -- e.g., leave_approved
    title           VARCHAR(191) NOT NULL,
    body            TEXT NOT NULL,
    link_url        VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Notification messages.';

-- Notification delivery to users
CREATE TABLE notification_user (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    notification_id BIGINT UNSIGNED NOT NULL,
    user_id         BIGINT UNSIGNED NOT NULL,
    is_read         TINYINT(1) NOT NULL DEFAULT 0,
    read_at         DATETIME NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_notification_user_user (user_id, is_read),
    CONSTRAINT fk_notification_user_notification
        FOREIGN KEY (notification_id) REFERENCES notifications(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_notification_user_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Per-user notification status.';

-- Audit logs (data changes)
CREATE TABLE audit_logs (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NULL,
    entity_type     VARCHAR(100) NOT NULL,  -- table/model name
    entity_id       BIGINT UNSIGNED NULL,
    action          ENUM('create','update','delete','restore') NOT NULL,
    changes_json    JSON NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_audit_entity (entity_type, entity_id),
    INDEX idx_audit_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Auditable changes to important data.';

-- Activity logs (user actions, logins, etc.)
CREATE TABLE activity_logs (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NULL,
    activity_type   VARCHAR(100) NOT NULL, -- 'login','view_page','export','download'
    description     VARCHAR(255) NULL,
    ip_address      VARCHAR(45) NULL,
    user_agent      VARCHAR(255) NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_activity_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='General user activity tracking.';

-- =========================================================
-- OTHER / BUZZ / DIRECTORY / GENERIC PAGES (OPTIONAL)
-- =========================================================

-- Buzz: company announcements / posts
CREATE TABLE buzz_posts (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id       BIGINT UNSIGNED NOT NULL,
    title           VARCHAR(191) NOT NULL,
    body            TEXT NOT NULL,
    visibility      ENUM('public','employees','department') DEFAULT 'employees',
    organization_unit_id BIGINT UNSIGNED NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      DATETIME NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (organization_unit_id) REFERENCES organization_units(id) ON DELETE SET NULL
) ENGINE=InnoDB COMMENT='Buzz / announcement posts.';

CREATE TABLE buzz_post_comments (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id     BIGINT UNSIGNED NOT NULL,
    author_id   BIGINT UNSIGNED NOT NULL,
    body        TEXT NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at  DATETIME NULL,
    FOREIGN KEY (post_id) REFERENCES buzz_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Comments on posts.';

CREATE TABLE buzz_post_likes (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id     BIGINT UNSIGNED NOT NULL,
    user_id     BIGINT UNSIGNED NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_post_like (post_id, user_id),
    FOREIGN KEY (post_id) REFERENCES buzz_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB COMMENT='Likes/reactions on posts.';

-- =========================================================
-- DEMO / SEED DATA FOR UI (SAMPLE ONLY)
-- =========================================================

-- Core organization
INSERT INTO organizations (id, name, registration_number, phone, email, website, created_at, updated_at)
VALUES
(1, 'TOAI HR Suite Demo', 'TOAI-REG-001', '+1-555-0100', 'hr@toai-demo.test', 'https://demo.toai-hr.test', NOW(), NOW());

-- Corporate branding defaults for demo org
INSERT INTO corporate_branding (organization_id, primary_color, secondary_color, accent_color, logo_file_id, banner_file_id, dark_mode_enabled, created_at, updated_at)
VALUES
(1, '#8B5CF6', '#6D28D9', '#A78BFA', NULL, NULL, 1, NOW(), NOW());

-- Locations
INSERT INTO locations (id, organization_id, name, city, state, country, phone, created_at, updated_at)
VALUES
(1, 1, 'Unassigned', 'N/A', 'N/A', 'N/A', NULL, NOW(), NOW()),
(2, 1, 'Texas R&D', 'Austin', 'Texas', 'United States', '+1-555-0101', NOW(), NOW()),
(3, 1, 'New York Sales', 'New York', 'New York', 'United States', '+1-555-0102', NOW(), NOW());

-- Organization units (sub-units)
INSERT INTO organization_units (id, organization_id, parent_id, name, code, created_at, updated_at)
VALUES
(1, 1, NULL, 'Engineering', 'ENG', NOW(), NOW()),
(2, 1, NULL, 'Human Resources', 'HR', NOW(), NOW()),
(3, 1, NULL, 'Quality Assurance', 'QA', NOW(), NOW()),
(4, 1, NULL, 'Business Development', 'BD', NOW(), NOW()),
(5, 1, NULL, 'Management', 'MGMT', NOW(), NOW());

-- Job titles
INSERT INTO job_titles (id, name, description, created_at, updated_at)
VALUES
(1, 'Software Engineer', 'Builds and maintains software systems.', NOW(), NOW()),
(2, 'QA Engineer', 'Ensures product quality.', NOW(), NOW()),
(3, 'HR Manager', 'Manages HR operations.', NOW(), NOW()),
(4, 'Business Analyst', 'Analyzes business requirements.', NOW(), NOW()),
(5, 'Project Manager', 'Leads project delivery.', NOW(), NOW()),
(6, 'Senior QA Lead', 'Leads the QA team.', NOW(), NOW()),
(7, 'Payroll Administrator', 'Manages payroll process.', NOW(), NOW());

-- Job categories
INSERT INTO job_categories (id, name, description, created_at, updated_at)
VALUES
(1, 'Professionals', 'Professional roles', NOW(), NOW()),
(2, 'Management', 'Management roles', NOW(), NOW());

-- Employment statuses
INSERT INTO employment_statuses (id, name, created_at, updated_at)
VALUES
(1, 'Full-Time Permanent', NOW(), NOW()),
(2, 'Full-Time Contract', NOW(), NOW()),
(3, 'Part-Time Contract', NOW(), NOW()),
(4, 'Intern', NOW(), NOW());

-- Nationalities (sample)
INSERT INTO nationalities (id, name, iso_code, created_at, updated_at)
VALUES
(1, 'American', 'US', NOW(), NOW()),
(2, 'Indian', 'IN', NOW(), NOW()),
(3, 'Canadian', 'CA', NOW(), NOW());

-- Qualifications (skills, education, licenses, languages, memberships)
INSERT INTO qualifications (id, type, name, description, created_at, updated_at)
VALUES
(1, 'skill', 'PHP', 'PHP development', NOW(), NOW()),
(2, 'skill', 'Laravel', 'Laravel framework', NOW(), NOW()),
(3, 'skill', 'Quality Assurance', 'QA skills', NOW(), NOW()),
(4, 'education', 'BSc Computer Science', 'Bachelor of Science in Computer Science', NOW(), NOW()),
(5, 'education', 'MBA', 'Master of Business Administration', NOW(), NOW()),
(6, 'language', 'English', 'Fluent in English', NOW(), NOW()),
(7, 'language', 'Spanish', 'Fluent in Spanish', NOW(), NOW()),
(8, 'certification', 'ISTQB', 'ISTQB Certified Tester', NOW(), NOW()),
(9, 'other', 'PMI Membership', 'Project Management Institute member', NOW(), NOW());

-- Users & roles
INSERT INTO roles (id, name, slug, description, is_system, created_at, updated_at)
VALUES
(1, 'Administrator', 'admin', 'System administrator', 1, NOW(), NOW()),
(2, 'ESS User', 'ess', 'Employee self-service user', 1, NOW(), NOW());

INSERT INTO users (id, username, email, password_hash, employee_id, is_active, created_at, updated_at)
VALUES
 (1, 'admin', 'admin@gmail.com', '$2y$10$admin123admin123admin123admin123admin123admin123admin123admin12', NULL, 1, NOW(), NOW());

INSERT INTO user_roles (user_id, role_id, created_at)
VALUES
(1, 1, NOW());

-- Employees (match some UI names)
INSERT INTO employees (id, employee_number, organization_id, first_name, middle_name, last_name, display_name,
                       date_of_birth, gender, marital_status, national_id, hire_date, status,
                       location_id, organization_unit_id, job_title_id, employment_status_id, pay_grade_id,
                       supervisor_id, created_at, updated_at)
VALUES
(1, '0001', 1, 'Manda', 'Akhil', 'User', 'manda akhil user',
 '1995-01-15', 'male', 'single', 'NID-0001', '2020-06-01', 'active',
 2, 1, 1, 1, NULL,
 NULL, NOW(), NOW()),
(2, '0002', 1, 'Jane', NULL, 'Doe', 'Jane Doe',
 '1990-03-10', 'female', 'married', 'NID-0002', '2019-03-01', 'active',
 3, 4, 5, 1, NULL,
 1, NOW(), NOW());

-- Link second user to employee muser
UPDATE users SET employee_id = 1 WHERE id = 2;

-- Basic leave types
INSERT INTO leave_types (id, name, code, is_paid, requires_approval, max_per_year, carry_forward, created_at, updated_at)
VALUES
(1, 'Annual Leave', 'AL', 1, 1, 24.00, 1, NOW(), NOW()),
(2, 'Sick Leave', 'SL', 1, 1, 10.00, 0, NOW(), NOW()),
(3, 'Casual Leave', 'CL', 1, 1, 7.00, 0, NOW(), NOW());

-- Current leave period, work week, and holidays
INSERT INTO leave_periods (id, name, period_start, period_end, is_current, created_at, updated_at)
VALUES
(1, '2026 Leave Period', '2026-01-01', '2026-12-31', 1, NOW(), NOW());

INSERT INTO work_weeks (location_id, day_of_week, is_working_day, hours_per_day, created_at, updated_at)
VALUES
(NULL, 1, 1, 8.00, NOW(), NOW()), -- Mon
(NULL, 2, 1, 8.00, NOW(), NOW()), -- Tue
(NULL, 3, 1, 8.00, NOW(), NOW()), -- Wed
(NULL, 4, 1, 8.00, NOW(), NOW()), -- Thu
(NULL, 5, 1, 8.00, NOW(), NOW()), -- Fri
(NULL, 6, 0, 0.00, NOW(), NOW()), -- Sat
(NULL, 7, 0, 0.00, NOW(), NOW()); -- Sun

INSERT INTO holidays (name, holiday_date, is_recurring, location_id, created_at, updated_at)
VALUES
('New Year''s Day', '2026-01-01', 1, NULL, NOW(), NOW()),
('Independence Day', '2026-07-04', 1, NULL, NOW(), NOW());

-- Leave entitlements and a sample application for Manda user
INSERT INTO leave_entitlements (id, employee_id, leave_type_id, period_start, period_end, days_entitled, days_used, created_at, updated_at)
VALUES
(1, 1, 1, '2026-01-01', '2026-12-31', 24.00, 2.00, NOW(), NOW());

INSERT INTO leave_applications (id, employee_id, leave_type_id, start_date, end_date, total_days, status,
                                applied_at, approved_by, approved_at, reason, created_at, updated_at)
VALUES
(1, 1, 1, '2026-03-10', '2026-03-11', 2.00, 'approved',
 NOW(), 2, NOW(), 'Annual vacation', NOW(), NOW());

INSERT INTO leave_application_days (leave_application_id, leave_date, day_part, duration_days, created_at)
VALUES
(1, '2026-03-10', 'full', 1.00, NOW()),
(1, '2026-03-11', 'full', 1.00, NOW());

-- Claim events and expense types
INSERT INTO claim_events (id, name, description, max_amount, requires_receipt, is_active, created_at, updated_at)
VALUES
(1, 'Travel Allowance', 'Travel related expenses', 1000.00, 1, 1, NOW(), NOW()),
(2, 'Medical Reimbursement', 'Medical expenses', 500.00, 1, 1, NOW(), NOW());

INSERT INTO claim_expense_types (id, name, description, is_active, created_at, updated_at)
VALUES
(1, 'Accommodation', 'Hotel and lodging costs', 1, NOW(), NOW()),
(2, 'Meal Allowance', 'Food and meals during travel', 1, NOW(), NOW());

-- Attendance settings defaults
INSERT INTO attendance_settings (employee_can_change_time, employee_can_edit_own_records, supervisor_can_manage_subordinates, created_at, updated_at)
VALUES
(1, 1, 1, NOW(), NOW());

-- Sample claim for Manda user
INSERT INTO claim_requests (id, employee_id, claim_date, total_amount, currency, status,
                            submitted_at, approved_by, approved_at, remarks, created_at, updated_at)
VALUES
(1, 1, '2026-02-01', 250.00, 'USD', 'approved',
 NOW(), 2, NOW(), 'Client visit expenses', NOW(), NOW());

INSERT INTO claim_items (claim_request_id, claim_event_id, item_date, description, amount, currency, receipt_file_id, created_at, updated_at)
VALUES
(1, 1, '2026-01-31', 'Flight ticket', 180.00, 'USD', NULL, NOW(), NOW()),
(1, 2, '2026-01-31', 'Clinic visit', 70.00, 'USD', NULL, NOW(), NOW());

-- Time tracking demo: one customer, project, assignment, timesheet
INSERT INTO time_customers (id, name, description, is_active, created_at, updated_at)
VALUES
(1, 'Acme Corp', 'External customer for demo project', 1, NOW(), NOW());

INSERT INTO time_projects (id, customer_id, name, description, is_active, created_at, updated_at)
VALUES
(1, 1, 'Acme HR Implementation', 'Implementation project for Acme Corp', 1, NOW(), NOW());

INSERT INTO time_project_assignments (id, project_id, employee_id, role, hourly_rate, created_at)
VALUES
(1, 1, 1, 'Developer', 75.00, NOW());

INSERT INTO timesheets (id, employee_id, start_date, end_date, status, submitted_at, approved_by, approved_at, remarks, created_at, updated_at)
VALUES
(1, 1, '2026-01-19', '2026-01-25', 'approved', NOW(), 2, NOW(), 'Week 3 demo timesheet', NOW(), NOW());

INSERT INTO timesheet_rows (timesheet_id, work_date, project_id, hours_worked, overtime_hours, notes, created_at, updated_at)
VALUES
(1, '2026-01-19', 1, 8.0, 0.0, 'Feature work', NOW(), NOW()),
(1, '2026-01-20', 1, 8.0, 0.0, 'Bug fixes', NOW(), NOW());

-- Recruitment demo
INSERT INTO recruitment_sources (id, name, created_at, updated_at)
VALUES
(1, 'Online', NOW(), NOW()),
(2, 'Referral', NOW(), NOW());

INSERT INTO vacancies (id, job_title_id, hiring_manager_id, location_id, name, description, positions, status, posted_date, closing_date, created_at, updated_at)
VALUES
(1, 2, 1, 2, 'Senior QA Lead', 'Lead QA for TOAI HR Suite', 1, 'open', '2026-01-01', '2026-03-31', NOW(), NOW());

INSERT INTO candidates (id, first_name, middle_name, last_name, email, phone, source_id, resume_file_id, notes, created_at, updated_at)
VALUES
(1, 'Alex', NULL, 'Smith', 'alex.smith@example.test', '+1-555-0200', 1, NULL, 'Strong QA background.', NOW(), NOW());

INSERT INTO candidate_applications (id, candidate_id, vacancy_id, applied_date, status, current_stage, created_at, updated_at)
VALUES
(1, 1, 1, '2026-01-10', 'shortlisted', 'Interview Scheduled', NOW(), NOW());

-- Performance demo
INSERT INTO kpis (id, name, description, weight, created_at, updated_at)
VALUES
(1, 'Code Quality', 'Static analysis and defect rate', 0.5, NOW(), NOW()),
(2, 'Delivery Timeliness', 'On-time delivery of milestones', 0.5, NOW(), NOW());

INSERT INTO performance_cycles (id, name, start_date, end_date, status, created_at, updated_at)
VALUES
(1, '2026 Annual Review', '2026-01-01', '2026-12-31', 'active', NOW(), NOW());

INSERT INTO performance_reviews (id, cycle_id, employee_id, reviewer_id, status, overall_rating, comments, created_at, updated_at)
VALUES
(1, 1, 1, 2, 'completed', 4.50, 'Strong performance throughout the year.', NOW(), NOW());

INSERT INTO performance_review_kpis (performance_review_id, kpi_id, rating, comments, created_at, updated_at)
VALUES
(1, 1, 4.5, 'Clean code and few defects.', NOW(), NOW()),
(1, 2, 4.5, 'Consistently on time.', NOW(), NOW());

-- Buzz / posts demo (matches BuzzController sample users)
INSERT INTO buzz_posts (id, author_id, title, body, visibility, organization_unit_id, created_at, updated_at)
VALUES
(1, 1, 'Hi All: Linda has been blessed with a baby boy!', 'With love, we welcome your dear new baby to this world. Congratulations!', 'employees', NULL, NOW(), NOW()),
(2, 1, 'World Championship: Perfect Snooker Player?', '“You need to be mentally strong and have a good technique.” – Mark Selby. “Consistency and practice are key to success.” – John Higgins.', 'employees', NULL, NOW(), NOW()),
(3, 1, 'Throwback Thursdays!!', 'Throwback Thursdays!!', 'employees', NULL, NOW(), NOW()),
(4, 1, 'Live SIMPLY Dream BIG', 'Live SIMPLY Dream BIG Be GREATFULL Give LOVE Laugh LOT.......', 'employees', NULL, NOW(), NOW());

INSERT INTO buzz_post_likes (post_id, user_id, created_at)
VALUES
(2, 2, NOW()),
(4, 2, NOW());

INSERT INTO buzz_post_comments (post_id, author_id, body, created_at)
VALUES
(1, 2, 'Excited to use the new HR system!', NOW());

-- Admin configuration demo defaults
INSERT INTO email_settings (mail_from_name, mail_from_address, sending_method, smtp_host, smtp_port, smtp_username, smtp_password, smtp_encryption, sendmail_path, send_test_mail, test_recipient, created_at, updated_at)
VALUES
('TOAI HR Suite', 'no-reply@toai-demo.test', 'secure_smtp', 'smtp.toai-demo.test', 587, 'no-reply@toai-demo.test', 'demoSmtpPasswordReplace', 'tls', '/usr/sbin/sendmail -bs', 0, NULL, NOW(), NOW());

INSERT INTO email_subscriptions (notification_key, name, description, is_enabled, created_at, updated_at)
VALUES
('leave_applications', 'Leave Applications', 'Notify when a leave application is submitted.', 1, NOW(), NOW()),
('leave_approvals', 'Leave Approvals', 'Notify when a leave application is approved.', 1, NOW(), NOW()),
('leave_assignments', 'Leave Assignments', 'Notify when leave is assigned.', 1, NOW(), NOW()),
('leave_cancellations', 'Leave Cancellations', 'Notify when a leave application is cancelled.', 1, NOW(), NOW()),
('leave_rejections', 'Leave Rejections', 'Notify when a leave application is rejected.', 1, NOW(), NOW());

INSERT INTO localization_settings (language, date_format, time_format, timezone, created_at, updated_at)
VALUES
('en', 'Y-m-d', 'H:i', 'UTC', NOW(), NOW());

INSERT INTO language_packages (id, code, name, is_default, sort_order, is_active, created_at, updated_at)
VALUES
(1, 'en', 'English (Default)', 1, 1, 1, NOW(), NOW());

INSERT INTO enabled_modules (module_key, is_enabled, created_at, updated_at)
VALUES
('admin', 1, NOW(), NOW()),
('pim', 1, NOW(), NOW()),
('leave', 1, NOW(), NOW()),
('time', 1, NOW(), NOW()),
('recruitment', 1, NOW(), NOW()),
('performance', 1, NOW(), NOW()),
('directory', 1, NOW(), NOW()),
('maintenance', 1, NOW(), NOW()),
('mobile', 0, NOW(), NOW()),
('claim', 1, NOW(), NOW()),
('buzz', 1, NOW(), NOW());

-- LDAP settings default (disabled)
INSERT INTO ldap_settings (enabled, created_at, updated_at)
VALUES
(0, NOW(), NOW());

-- Additional demo rows to ensure at least 5 sample rows per seeded table

-- More organizations
INSERT INTO organizations (id, name, registration_number, phone, email, website, created_at, updated_at)
VALUES
(2, 'TOAI HR Europe', 'TOAI-REG-002', '+44-20-0000-0001', 'info-eu@toai-demo.test', 'https://eu.toai-hr.test', NOW(), NOW()),
(3, 'TOAI HR Asia', 'TOAI-REG-003', '+91-11-0000-0001', 'info-asia@toai-demo.test', 'https://asia.toai-hr.test', NOW(), NOW()),
(4, 'TOAI HR Africa', 'TOAI-REG-004', '+27-11-0000-0001', 'info-africa@toai-demo.test', 'https://africa.toai-hr.test', NOW(), NOW()),
(5, 'TOAI HR South America', 'TOAI-REG-005', '+55-11-0000-0001', 'info-sa@toai-demo.test', 'https://sa.toai-hr.test', NOW(), NOW());

-- More corporate branding rows
INSERT INTO corporate_branding (organization_id, primary_color, secondary_color, accent_color, logo_file_id, banner_file_id, dark_mode_enabled, created_at, updated_at)
VALUES
(2, '#0EA5E9', '#0369A1', '#38BDF8', NULL, NULL, 1, NOW(), NOW()),
(3, '#22C55E', '#15803D', '#4ADE80', NULL, NULL, 1, NOW(), NOW()),
(4, '#F97316', '#EA580C', '#FDBA74', NULL, NULL, 1, NOW(), NOW()),
(5, '#EF4444', '#B91C1C', '#FCA5A5', NULL, NULL, 1, NOW(), NOW());

-- More locations
INSERT INTO locations (id, organization_id, name, city, state, country, phone, created_at, updated_at)
VALUES
(4, 1, 'London Office', 'London', 'England', 'United Kingdom', '+44-20-0000-0002', NOW(), NOW()),
(5, 1, 'Bangalore Tech Park', 'Bengaluru', 'Karnataka', 'India', '+91-80-0000-0001', NOW(), NOW());

-- More job categories
INSERT INTO job_categories (id, name, description, created_at, updated_at)
VALUES
(3, 'Technical', 'Technical roles', NOW(), NOW()),
(4, 'Support', 'Support and operations roles', NOW(), NOW()),
(5, 'Executive', 'Executive leadership roles', NOW(), NOW());

-- More employment statuses
INSERT INTO employment_statuses (id, name, created_at, updated_at)
VALUES
(5, 'Consultant', NOW(), NOW());

-- More nationalities
INSERT INTO nationalities (id, name, iso_code, created_at, updated_at)
VALUES
(4, 'British', 'GB', NOW(), NOW()),
(5, 'Brazilian', 'BR', NOW(), NOW());

-- More roles
INSERT INTO roles (id, name, slug, description, is_system, created_at, updated_at)
VALUES
(3, 'Manager', 'manager', 'Line manager role', 0, NOW(), NOW()),
(4, 'HR', 'hr', 'Human Resources role', 0, NOW(), NOW()),
(5, 'Guest', 'guest', 'Read-only guest user', 0, NOW(), NOW());

-- More users
INSERT INTO users (id, username, email, password_hash, employee_id, is_active, created_at, updated_at)
VALUES
(3, 'jdoe', 'jane.doe@toai-demo.test', '$2y$10$demoUser3PasswordHashReplace', 2, 1, NOW(), NOW()),
(4, 'manager1', 'manager1@toai-demo.test', '$2y$10$demoUser4PasswordHashReplace', NULL, 1, NOW(), NOW()),
(5, 'guest1', 'guest1@toai-demo.test', '$2y$10$demoUser5PasswordHashReplace', NULL, 1, NOW(), NOW());

-- More user-role mappings
INSERT INTO user_roles (user_id, role_id, created_at)
VALUES
(3, 2, NOW()),
(4, 3, NOW()),
(5, 5, NOW());

-- More employees
INSERT INTO employees (id, employee_number, organization_id, first_name, middle_name, last_name, display_name,
                       date_of_birth, gender, marital_status, national_id, hire_date, status,
                       location_id, organization_unit_id, job_title_id, employment_status_id, pay_grade_id,
                       supervisor_id, created_at, updated_at)
VALUES
(3, '0003', 1, 'Carlos', NULL, 'Silva', 'Carlos Silva',
 '1988-08-20', 'male', 'married', 'NID-0003', '2021-01-15', 'active',
 5, 4, 5, 1, NULL,
 1, NOW(), NOW()),
(4, '0004', 1, 'Emily', NULL, 'Clark', 'Emily Clark',
 '1992-11-05', 'female', 'single', 'NID-0004', '2022-04-01', 'active',
 4, 3, 2, 2, NULL,
 1, NOW(), NOW()),
(5, '0005', 1, 'Rahul', NULL, 'Verma', 'Rahul Verma',
 '1994-06-18', 'male', 'single', 'NID-0005', '2023-02-10', 'active',
 5, 1, 1, 4, NULL,
 1, NOW(), NOW());

-- More leave types
INSERT INTO leave_types (id, name, code, is_paid, requires_approval, max_per_year, carry_forward, created_at, updated_at)
VALUES
(4, 'Personal Leave', 'PL', 1, 1, 5.00, 0, NOW(), NOW()),
(5, 'Maternity Leave', 'ML', 1, 1, 90.00, 0, NOW(), NOW());

-- More leave periods
INSERT INTO leave_periods (id, name, period_start, period_end, is_current, created_at, updated_at)
VALUES
(2, '2025 Leave Period', '2025-01-01', '2025-12-31', 0, NOW(), NOW()),
(3, '2024 Leave Period', '2024-01-01', '2024-12-31', 0, NOW(), NOW()),
(4, '2023 Leave Period', '2023-01-01', '2023-12-31', 0, NOW(), NOW()),
(5, '2022 Leave Period', '2022-01-01', '2022-12-31', 0, NOW(), NOW());

-- More holidays
INSERT INTO holidays (name, holiday_date, is_recurring, location_id, created_at, updated_at)
VALUES
('Labor Day', '2026-09-07', 1, NULL, NOW(), NOW()),
('Thanksgiving Day', '2026-11-26', 1, NULL, NOW(), NOW()),
('Christmas Day', '2026-12-25', 1, NULL, NOW(), NOW());

-- More leave entitlements
INSERT INTO leave_entitlements (id, employee_id, leave_type_id, period_start, period_end, days_entitled, days_used, created_at, updated_at)
VALUES
(2, 1, 2, '2026-01-01', '2026-12-31', 10.00, 1.00, NOW(), NOW()),
(3, 2, 1, '2026-01-01', '2026-12-31', 24.00, 0.00, NOW(), NOW()),
(4, 3, 1, '2026-01-01', '2026-12-31', 20.00, 0.00, NOW(), NOW()),
(5, 4, 1, '2026-01-01', '2026-12-31', 18.00, 0.00, NOW(), NOW());

-- More leave applications
INSERT INTO leave_applications (id, employee_id, leave_type_id, start_date, end_date, total_days, status,
                                applied_at, approved_by, approved_at, reason, created_at, updated_at)
VALUES
(2, 1, 2, '2026-04-05', '2026-04-05', 1.00, 'approved', NOW(), 2, NOW(), 'Sick leave', NOW(), NOW()),
(3, 2, 1, '2026-05-10', '2026-05-12', 3.00, 'pending', NOW(), NULL, NULL, 'Annual vacation', NOW(), NOW()),
(4, 3, 1, '2026-06-01', '2026-06-03', 3.00, 'approved', NOW(), 1, NOW(), 'Family trip', NOW(), NOW()),
(5, 4, 3, '2026-07-15', '2026-07-15', 1.00, 'rejected', NOW(), 1, NOW(), 'Personal work', NOW(), NOW());

-- More leave application days
INSERT INTO leave_application_days (leave_application_id, leave_date, day_part, duration_days, created_at)
VALUES
(2, '2026-04-05', 'full', 1.00, NOW()),
(3, '2026-05-10', 'full', 1.00, NOW()),
(3, '2026-05-11', 'full', 1.00, NOW()),
(3, '2026-05-12', 'full', 1.00, NOW()),
(4, '2026-06-01', 'full', 1.00, NOW()),
(4, '2026-06-02', 'full', 1.00, NOW()),
(4, '2026-06-03', 'full', 1.00, NOW()),
(5, '2026-07-15', 'full', 1.00, NOW());

-- More claim events
INSERT INTO claim_events (id, name, description, max_amount, requires_receipt, is_active, created_at, updated_at)
VALUES
(3, 'Accommodation', 'Hotel stays', 800.00, 1, 1, NOW(), NOW()),
(4, 'Meal Allowance', 'Meals during business travel', 300.00, 1, 1, NOW(), NOW()),
(5, 'Other Expenses', 'Miscellaneous expenses', 200.00, 0, 1, NOW(), NOW());

-- More claim expense types
INSERT INTO claim_expense_types (id, name, description, is_active, created_at, updated_at)
VALUES
(3, 'Taxi', 'Local transport', 1, NOW(), NOW()),
(4, 'Parking', 'Parking fees', 1, NOW(), NOW()),
(5, 'Conference Fee', 'Event registration', 1, NOW(), NOW());

-- More claim requests
INSERT INTO claim_requests (id, employee_id, claim_date, total_amount, currency, status,
                            submitted_at, approved_by, approved_at, paid_at, remarks, created_at, updated_at)
VALUES
(2, 2, '2026-02-10', 120.00, 'USD', 'submitted', NOW(), NULL, NULL, NULL, 'Taxi and meals', NOW(), NOW()),
(3, 3, '2026-03-05', 300.00, 'USD', 'approved', NOW(), 1, NOW(), NULL, 'Conference trip', NOW(), NOW()),
(4, 4, '2026-03-20', 80.00, 'USD', 'rejected', NOW(), 1, NOW(), NULL, 'Parking fees', NOW(), NOW()),
(5, 1, '2026-04-01', 60.00, 'USD', 'paid', NOW(), 2, NOW(), NOW(), 'Local travel', NOW(), NOW());

-- More claim items
INSERT INTO claim_items (claim_request_id, claim_event_id, item_date, description, amount, currency, receipt_file_id, created_at, updated_at)
VALUES
(2, 4, '2026-02-09', 'Dinner with client', 70.00, 'USD', NULL, NOW(), NOW()),
(2, 3, '2026-02-10', 'Taxi from airport', 50.00, 'USD', NULL, NOW(), NOW()),
(3, 1, '2026-03-04', 'Flight ticket', 220.00, 'USD', NULL, NOW(), NOW()),
(3, 5, '2026-03-05', 'Conference registration', 80.00, 'USD', NULL, NOW(), NOW()),
(4, 4, '2026-03-19', 'Parking fee', 80.00, 'USD', NULL, NOW(), NOW()),
(5, 3, '2026-03-31', 'Taxi to office', 60.00, 'USD', NULL, NOW(), NOW());

-- More time customers
INSERT INTO time_customers (id, name, description, is_active, created_at, updated_at)
VALUES
(2, 'Globex Corporation', 'Enterprise HR customer', 1, NOW(), NOW()),
(3, 'Initech', 'SMB customer', 1, NOW(), NOW()),
(4, 'Umbrella Corp', 'Pharma client', 1, NOW(), NOW()),
(5, 'Wayne Enterprises', 'Demo customer', 1, NOW(), NOW());

-- More time projects
INSERT INTO time_projects (id, customer_id, name, description, is_active, created_at, updated_at)
VALUES
(2, 2, 'Globex Onboarding', 'Onboarding project', 1, NOW(), NOW()),
(3, 3, 'Initech Migration', 'Data migration', 1, NOW(), NOW()),
(4, 4, 'Umbrella Compliance', 'Compliance reporting', 1, NOW(), NOW()),
(5, 5, 'Wayne HR Revamp', 'HR system revamp', 1, NOW(), NOW());

-- More project assignments
INSERT INTO time_project_assignments (id, project_id, employee_id, role, hourly_rate, created_at)
VALUES
(2, 2, 2, 'QA Lead', 80.00, NOW()),
(3, 3, 3, 'Consultant', 90.00, NOW()),
(4, 4, 4, 'Project Manager', 100.00, NOW()),
(5, 5, 5, 'Developer', 70.00, NOW());

-- More timesheets
INSERT INTO timesheets (id, employee_id, start_date, end_date, status, submitted_at, approved_by, approved_at, remarks, created_at, updated_at)
VALUES
(2, 2, '2026-01-19', '2026-01-25', 'submitted', NOW(), NULL, NULL, 'Week 3 QA work', NOW(), NOW()),
(3, 3, '2026-01-19', '2026-01-25', 'approved', NOW(), 1, NOW(), 'Week 3 consulting', NOW(), NOW()),
(4, 4, '2026-01-19', '2026-01-25', 'draft', NULL, NULL, NULL, 'Week 3 PM planning', NOW(), NOW()),
(5, 5, '2026-01-19', '2026-01-25', 'submitted', NOW(), NULL, NULL, 'Week 3 development', NOW(), NOW());

-- More timesheet rows
INSERT INTO timesheet_rows (timesheet_id, work_date, project_id, hours_worked, overtime_hours, notes, created_at, updated_at)
VALUES
(2, '2026-01-19', 2, 8.0, 0.0, 'Test planning', NOW(), NOW()),
(2, '2026-01-20', 2, 8.0, 0.0, 'Regression testing', NOW(), NOW()),
(3, '2026-01-19', 3, 8.0, 0.0, 'Requirements workshop', NOW(), NOW()),
(4, '2026-01-19', 4, 6.0, 0.0, 'Project kick-off', NOW(), NOW()),
(5, '2026-01-19', 5, 8.0, 0.0, 'UI implementation', NOW(), NOW());

-- More recruitment sources
INSERT INTO recruitment_sources (id, name, created_at, updated_at)
VALUES
(3, 'Email', NOW(), NOW()),
(4, 'Walk-in', NOW(), NOW()),
(5, 'Referral Program', NOW(), NOW());

-- More vacancies
INSERT INTO vacancies (id, job_title_id, hiring_manager_id, location_id, name, description, positions, status, posted_date, closing_date, created_at, updated_at)
VALUES
(2, 1, 1, 2, 'Software Engineer', 'Backend engineer role', 2, 'open', '2026-01-05', '2026-03-31', NOW(), NOW()),
(3, 5, 1, 3, 'Project Manager', 'Project manager for HR revamp', 1, 'open', '2026-01-10', '2026-04-15', NOW(), NOW()),
(4, 7, 2, 5, 'Payroll Administrator', 'Payroll operations', 1, 'open', '2026-01-15', '2026-04-30', NOW(), NOW()),
(5, 3, 1, 4, 'HR Manager', 'HR operations lead', 1, 'open', '2026-01-20', '2026-05-01', NOW(), NOW());

-- More candidates
INSERT INTO candidates (id, first_name, middle_name, last_name, email, phone, source_id, resume_file_id, notes, created_at, updated_at)
VALUES
(2, 'Maria', NULL, 'Gonzalez', 'maria.gonzalez@example.test', '+34-555-1000', 3, NULL, 'Experienced PM.', NOW(), NOW()),
(3, 'Liu', NULL, 'Wei', 'liu.wei@example.test', '+86-555-2000', 4, NULL, 'Senior developer.', NOW(), NOW()),
(4, 'Ahmed', NULL, 'Khan', 'ahmed.khan@example.test', '+971-555-3000', 5, NULL, 'HR specialist.', NOW(), NOW()),
(5, 'Sofia', NULL, 'Rossi', 'sofia.rossi@example.test', '+39-555-4000', 2, NULL, 'QA automation engineer.', NOW(), NOW());

-- More candidate applications
INSERT INTO candidate_applications (id, candidate_id, vacancy_id, applied_date, status, current_stage, created_at, updated_at)
VALUES
(2, 2, 3, '2026-01-12', 'new', 'Application Received', NOW(), NOW()),
(3, 3, 2, '2026-01-13', 'shortlisted', 'Interview Scheduled', NOW(), NOW()),
(4, 4, 5, '2026-01-14', 'new', 'Screening', NOW(), NOW()),
(5, 5, 2, '2026-01-15', 'shortlisted', 'Technical Interview', NOW(), NOW());

-- More KPIs
INSERT INTO kpis (id, name, description, weight, created_at, updated_at)
VALUES
(3, 'Customer Satisfaction', 'CSAT scores', 0.3, NOW(), NOW()),
(4, 'Attendance', 'Punctuality and presence', 0.2, NOW(), NOW()),
(5, 'Teamwork', 'Collaboration and teamwork', 0.3, NOW(), NOW());

-- More performance cycles
INSERT INTO performance_cycles (id, name, start_date, end_date, status, created_at, updated_at)
VALUES
(2, '2025 Annual Review', '2025-01-01', '2025-12-31', 'closed', NOW(), NOW()),
(3, '2024 Annual Review', '2024-01-01', '2024-12-31', 'archived', NOW(), NOW()),
(4, '2026 Mid-Year Review', '2026-07-01', '2026-09-30', 'planned', NOW(), NOW()),
(5, '2025 Mid-Year Review', '2025-07-01', '2025-09-30', 'closed', NOW(), NOW());

-- More performance reviews
INSERT INTO performance_reviews (id, cycle_id, employee_id, reviewer_id, status, overall_rating, comments, created_at, updated_at)
VALUES
(2, 1, 2, 1, 'completed', 4.20, 'Strong leadership.', NOW(), NOW()),
(3, 1, 3, 1, 'in_progress', NULL, 'Mid-year review ongoing.', NOW(), NOW()),
(4, 1, 4, 2, 'not_started', NULL, 'Pending review.', NOW(), NOW()),
(5, 1, 5, 2, 'completed', 3.80, 'Good performance overall.', NOW(), NOW());

-- More performance review KPIs
INSERT INTO performance_review_kpis (performance_review_id, kpi_id, rating, comments, created_at, updated_at)
VALUES
(2, 1, 4.0, 'Good code quality.', NOW(), NOW()),
(2, 2, 4.4, 'On-time delivery.', NOW(), NOW()),
(3, 3, 4.2, 'Customers happy.', NOW(), NOW()),
(4, 4, 3.5, 'Attendance acceptable.', NOW(), NOW()),
(5, 5, 4.0, 'Works well with team.', NOW(), NOW());

-- More buzz posts
INSERT INTO buzz_posts (id, author_id, title, body, visibility, organization_unit_id, created_at, updated_at)
VALUES
(2, 1, 'System Maintenance', 'Scheduled maintenance this weekend.', 'employees', NULL, NOW(), NOW()),
(3, 2, 'Welcome New Joiners', 'Let''s welcome our new employees!', 'employees', NULL, NOW(), NOW()),
(4, 2, 'Quarterly Townhall', 'Townhall scheduled next month.', 'employees', NULL, NOW(), NOW()),
(5, 1, 'Policy Update', 'Updated leave policy released.', 'employees', NULL, NOW(), NOW());

-- More buzz post likes
INSERT INTO buzz_post_likes (post_id, user_id, created_at)
VALUES
(2, 1, NOW()),
(2, 2, NOW()),
(3, 1, NOW()),
(4, 2, NOW()),
(5, 1, NOW());

-- More buzz post comments
INSERT INTO buzz_post_comments (post_id, author_id, body, created_at)
VALUES
(2, 1, 'Please plan your work accordingly.', NOW()),
(3, 2, 'Welcome aboard everyone!', NOW()),
(4, 1, 'Looking forward to it.', NOW()),
(5, 2, 'Thanks for the update.', NOW()),
(5, 1, 'Please read the new policy.', NOW());

-- More email settings (alternate configs)
INSERT INTO email_settings (mail_from_name, mail_from_address, sending_method, smtp_host, smtp_port, smtp_username, smtp_password, smtp_encryption, sendmail_path, send_test_mail, test_recipient, created_at, updated_at)
VALUES
('TOAI HR Europe', 'no-reply-eu@toai-demo.test', 'smtp', 'smtp-eu.toai-demo.test', 587, 'no-reply-eu@toai-demo.test', 'demoSmtpPasswordEU', 'tls', '/usr/sbin/sendmail -bs', 0, NULL, NOW(), NOW()),
('TOAI HR Asia', 'no-reply-asia@toai-demo.test', 'smtp', 'smtp-asia.toai-demo.test', 587, 'no-reply-asia@toai-demo.test', 'demoSmtpPasswordASIA', 'tls', '/usr/sbin/sendmail -bs', 0, NULL, NOW(), NOW()),
('TOAI HR Africa', 'no-reply-africa@toai-demo.test', 'smtp', 'smtp-africa.toai-demo.test', 587, 'no-reply-africa@toai-demo.test', 'demoSmtpPasswordAFRICA', 'tls', '/usr/sbin/sendmail -bs', 0, NULL, NOW(), NOW()),
('TOAI HR SA', 'no-reply-sa@toai-demo.test', 'smtp', 'smtp-sa.toai-demo.test', 587, 'no-reply-sa@toai-demo.test', 'demoSmtpPasswordSA', 'tls', '/usr/sbin/sendmail -bs', 0, NULL, NOW(), NOW());

-- More localization settings
INSERT INTO localization_settings (language, date_format, time_format, timezone, created_at, updated_at)
VALUES
('fr', 'd/m/Y', 'H:i', 'Europe/Paris', NOW(), NOW()),
('es', 'd/m/Y', 'H:i', 'Europe/Madrid', NOW(), NOW()),
('de', 'd.m.Y', 'H:i', 'Europe/Berlin', NOW(), NOW()),
('hi', 'd-m-Y', 'H:i', 'Asia/Kolkata', NOW(), NOW());

-- More language packages
INSERT INTO language_packages (id, code, name, is_default, sort_order, is_active, created_at, updated_at)
VALUES
(2, 'fr', 'French', 0, 2, 1, NOW(), NOW()),
(3, 'es', 'Spanish', 0, 3, 1, NOW(), NOW()),
(4, 'de', 'German', 0, 4, 1, NOW(), NOW()),
(5, 'hi', 'Hindi', 0, 5, 1, NOW(), NOW());

-- More LDAP settings (demo environments)
INSERT INTO ldap_settings (enabled, host, port, encryption, implementation, bind_anonymously, created_at, updated_at)
VALUES
(0, 'ldap.test.local', 389, 'none', 'openldap', 1, NOW(), NOW()),
(0, 'ldap-eu.test.local', 636, 'ssl', 'ad', 0, NOW(), NOW()),
(0, 'ldap-asia.test.local', 389, 'tls', 'ad', 0, NOW(), NOW()),
(0, 'ldap-sa.test.local', 389, 'none', 'openldap', 1, NOW(), NOW());

-- =========================================================
-- ADDITIONAL SAMPLE ROWS FOR REMAINING TABLES
-- =========================================================

-- Auth sessions & login attempts (Admin → Security / Sessions)
INSERT INTO auth_sessions (user_id, session_token, ip_address, user_agent, expires_at, created_at)
VALUES
(1, REPEAT('a', 64), '127.0.0.1', 'Demo Browser', DATE_ADD(NOW(), INTERVAL 7 DAY), NOW());

INSERT INTO login_attempts (username, ip_address, success, created_at)
VALUES
('admin', '127.0.0.1', 1, NOW()),
('admin', '127.0.0.1', 0, NOW());

-- User preferences (e.g. dark theme enabled)
INSERT INTO user_preferences (user_id, timezone, language, theme, sidebar_collapsed, notifications_email, created_at, updated_at)
VALUES
(1, 'Asia/Kolkata', 'en', 'dark', 0, 1, NOW(), NOW());

-- Pay grades and salary ranges (Admin → Job → Pay Grades)
INSERT INTO pay_grades (id, name, currency, created_at, updated_at)
VALUES
(1, 'Grade A', 'USD', NOW(), NOW()),
(2, 'Grade B', 'USD', NOW(), NOW());

INSERT INTO pay_grade_salary_ranges (pay_grade_id, min_salary, max_salary, created_at, updated_at)
VALUES
(1, 60000.00, 90000.00, NOW(), NOW()),
(2, 90000.00, 130000.00, NOW(), NOW());

-- Employee personal & job details, salary, contacts & dependents (My Info / PIM)
INSERT INTO employee_personal_details (employee_id, nationality_id, other_id, drivers_license, license_expiry, smoker, blood_group,
                                      address1, city, country, mobile_phone, work_email, created_at, updated_at)
VALUES
(1, 2, 'OID-0001', 'DL-123456', '2030-12-31', 0, 'O+', 'MG Road', 'Bengaluru', 'India', '+91-90000-00001', 'manda.user@example.test', NOW(), NOW());

INSERT INTO employee_job_details (employee_id, job_title_id, employment_status_id, organization_unit_id, location_id, supervisor_id, effective_date, created_at, updated_at)
VALUES
(1, 1, 1, 1, 2, NULL, '2020-06-01', NOW(), NOW());

INSERT INTO employee_salary (employee_id, pay_grade_id, pay_frequency, amount, currency, effective_date, created_at, updated_at)
VALUES
(1, 1, 'monthly', 75000.00, 'USD', '2024-01-01', NOW(), NOW());

INSERT INTO employee_emergency_contacts (employee_id, name, relationship, mobile_phone, is_primary, created_at, updated_at)
VALUES
(1, 'Akhil Emergency Contact', 'Spouse', '+91-90000-00002', 1, NOW(), NOW());

INSERT INTO employee_dependents (employee_id, name, relationship, date_of_birth, created_at, updated_at)
VALUES
(1, 'Baby Linda', 'Child', '2023-07-18', NOW(), NOW());

-- Custom fields and example value (Admin → Custom Fields / PIM)
INSERT INTO custom_fields (module, name, label, data_type, options_json, is_required, is_active, sort_order, created_at, updated_at)
VALUES
('employee', 'shirt_size', 'Shirt Size', 'select', JSON_ARRAY('S','M','L','XL'), 0, 1, 1, NOW(), NOW());

INSERT INTO employee_custom_field_values (employee_id, custom_field_id, value_text, created_at, updated_at)
VALUES
(1, 1, 'L', NOW(), NOW());

-- Employee qualifications (My Info → Qualifications)
INSERT INTO employee_qualifications (employee_id, qualification_id, institution, start_date, end_date, grade, created_at, updated_at)
VALUES
(1, 4, 'Demo University', '2012-06-01', '2016-05-31', 'First Class', NOW(), NOW());

-- Attendance records & overtime (Time → Attendance → My Records)
INSERT INTO attendance_records (employee_id, punch_in_at, punch_out_at, punch_in_ip, punch_out_ip, punch_in_source, punch_out_source, remarks, created_at, updated_at)
VALUES
(1, '2026-01-23 14:36:00', '2026-01-23 14:51:00', '127.0.0.1', '127.0.0.1', 'web', 'web', 'Arrived on time', NOW(), NOW());

INSERT INTO overtime_entries (employee_id, attendance_id, work_date, hours, status, approved_by, approved_at, remarks, created_at, updated_at)
VALUES
(1, 1, '2026-01-23', 0.25, 'approved', 2, NOW(), 'Demo overtime entry', NOW(), NOW());

-- Leave balances snapshot (Leave → Reports)
INSERT INTO leave_balances (employee_id, leave_type_id, balance_date, opening_balance, entitled, used, closing_balance, created_at)
VALUES
(1, 1, '2026-01-01', 24.00, 0.00, 2.00, 22.00, NOW());

-- Claim status history & attachments (Claim → My Claims)
INSERT INTO claim_status_history (claim_request_id, old_status, new_status, changed_by, changed_at, comment)
VALUES
(1, 'submitted', 'approved', 1, NOW(), 'Approved by admin');

INSERT INTO file_uploads (stored_name, original_name, mime_type, size_bytes, path, uploaded_by, uploaded_at)
VALUES
('receipt-demo-1.pdf', 'receipt.pdf', 'application/pdf', 12345, 'claims/2026/receipt-demo-1.pdf', 1, NOW());

INSERT INTO claim_attachments (claim_request_id, file_id, description, created_at)
VALUES
(1, 1, 'Flight ticket receipt', NOW());

-- Recruitment interviews & feedback (Recruitment → Candidates)
INSERT INTO interviews (candidate_application_id, interviewer_id, scheduled_at, duration_minutes, location, status, created_at, updated_at)
VALUES
(1, 1, '2026-01-20 10:00:00', 60, 'Conference Room 1', 'completed', NOW(), NOW());

INSERT INTO interview_feedback (interview_id, reviewer_id, rating_overall, strengths, weaknesses, recommendation, created_at, updated_at)
VALUES
(1, 1, 5, 'Excellent technical skills', 'Needs domain experience', 'hire', NOW(), NOW());

-- Performance appraisals (Performance → My Reviews)
INSERT INTO performance_appraisals (performance_review_id, old_salary, new_salary, effective_date, comments, created_at, updated_at)
VALUES
(1, 70000.00, 75000.00, '2026-04-01', 'Annual increment based on strong performance.', NOW(), NOW());

-- Notifications & logs (Admin → Notifications / Audit)
INSERT INTO notifications (type, title, body, link_url, created_at)
VALUES
('leave_approved', 'Leave Approved', 'Your annual leave from 2026-03-10 to 2026-03-11 has been approved.', '/leave/my-leave', NOW());

INSERT INTO notification_user (notification_id, user_id, is_read, created_at)
VALUES
(1, 1, 0, NOW());

INSERT INTO audit_logs (user_id, entity_type, entity_id, action, changes_json, created_at)
VALUES
(1, 'leave_applications', 1, 'update', JSON_OBJECT('status_from','pending','status_to','approved'), NOW());

INSERT INTO activity_logs (user_id, activity_type, description, ip_address, user_agent, created_at)
VALUES
(1, 'login', 'User logged into the system', '127.0.0.1', 'Demo Browser', NOW());

-- =========================================================
-- PIM Configuration: Reporting Methods
-- =========================================================

CREATE TABLE reporting_methods (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(191) NOT NULL,
    description VARCHAR(255) NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='How employees report to their supervisors (e.g. Direct, Matrix).';

INSERT INTO reporting_methods (id, name, description, is_active, created_at, updated_at) VALUES
    (1, 'Direct',        'Direct line reporting to a single manager',                         1, NOW(), NOW()),
    (2, 'Matrix',        'Reports to multiple managers in a matrix structure',               1, NOW(), NOW()),
    (3, 'Project Based', 'Reports to project manager for project duration',                  1, NOW(), NOW()),
    (4, 'Functional',    'Reports to functional head (e.g. HR, Finance)',                   1, NOW(), NOW()),
    (5, 'Dotted Line',   'Informal / advisory reporting relationship (dotted-line manager)', 1, NOW(), NOW());

-- =========================================================
-- PIM Configuration: Termination Reasons
-- =========================================================

CREATE TABLE termination_reasons (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(191) NOT NULL,
    description VARCHAR(255) NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB COMMENT='Reasons for employee termination / separation.';

INSERT INTO termination_reasons (id, name, description, is_active, created_at, updated_at) VALUES
    (1, 'Resignation',          'Employee voluntarily resigned from the organization',              1, NOW(), NOW()),
    (2, 'End of Contract',      'Employment contract reached its planned end date',                 1, NOW(), NOW()),
    (3, 'Termination - Cause',  'Employment terminated due to performance or disciplinary reasons', 1, NOW(), NOW()),
    (4, 'Retirement',           'Employee retired as per company policy',                           1, NOW(), NOW()),
    (5, 'Redundancy / Layoff',  'Position made redundant or workforce reduction',                   1, NOW(), NOW());