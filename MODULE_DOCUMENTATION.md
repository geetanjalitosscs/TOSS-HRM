# TOAI HR Suite - Complete Module Documentation

**Version:** 1.0  
**Last Updated:** 2025-01-27  
**System:** TOAI HR Suite Professional Edition

---

## Table of Contents

1. [Overview](#overview)
2. [Authentication & Access](#authentication--access)
3. [Dashboard Module](#dashboard-module)
4. [My Info Module](#my-info-module)
5. [PIM Module](#pim-module)
6. [Leave Module](#leave-module)
7. [Time Module](#time-module)
8. [Performance Module](#performance-module)
9. [Recruitment Module](#recruitment-module)
10. [Directory Module](#directory-module)
11. [Claim Module](#claim-module)
12. [Buzz Module](#buzz-module)
13. [Admin Module](#admin-module)
14. [Maintenance Module](#maintenance-module)
15. [Profile Management](#profile-management)
16. [Reusable Components](#reusable-components)

---

## Overview

TOAI HR Suite is a comprehensive Human Resources Management System built with Laravel, featuring a modern lavender/purple theme with full dark mode support. The system follows MVC architecture and uses reusable Blade components for consistent UI/UX across all modules.

### Key Features
- **12 Main Modules** covering all HR operations
- **Professional UI/UX** with theme-aware components
- **Dark Mode Support** across all pages
- **Responsive Design** for all screen sizes
- **Reusable Components** for consistency
- **MVC Architecture** for maintainability

---

## Authentication & Access

### Login Page
- **Route:** `GET /login` or `GET /`
- **View:** `resources/views/auth/login.blade.php`
- **Controller:** `App\Http\Controllers\Auth\LoginController`
- **Features:**
  - Username/Password authentication
  - Always displays in light mode (dark mode disabled)
  - CSRF protection
  - Session-based authentication

### Logout
- **Route:** `POST /logout`
- **Action:** Clears session and redirects to login page
- **Theme Reset:** Removes theme preference from localStorage

---

## Dashboard Module

### Overview
The main landing page after login, providing an overview of key HR metrics and quick access to common functions.

### Route
- **Main Route:** `GET /dashboard`
- **Route Name:** `dashboard`
- **Controller:** `App\Http\Controllers\DashboardController`
- **View:** `resources/views/dashboard/dashboard.blade.php`

### Features
1. **Time at Work Widget**
   - Current time tracking
   - Today's attendance summary
   - Quick time entry

2. **My Actions Widget**
   - Pending approvals
   - Action items
   - Quick task list

3. **Quick Launch Section**
   - Direct links to common functions:
     - Add Employee
     - Employee List
     - Leave List
     - Timesheets
     - Apply Leave
     - Assign Leave
     - My Leave
     - My Timesheets

4. **Buzz Latest Posts**
   - Recent social feed updates
   - Quick access to Buzz module

5. **Employees on Leave Today**
   - Today's leave calendar
   - Leave status overview

6. **Employee Distribution Charts**
   - Distribution by Sub Unit (Pie Chart)
   - Distribution by Location (Pie Chart)
   - Interactive data visualization

---

## My Info Module

### Overview
Employee self-service module allowing employees to view and update their personal information.

### Route
- **Main Route:** `GET /my-info`
- **Route Name:** `myinfo`
- **Controller:** `App\Http\Controllers\MyInfoController`
- **View:** `resources/views/myinfo/myinfo.blade.php`

### Features
1. **Personal Details Section**
   - Employee ID
   - Full Name
   - Job Title
   - Employment Status
   - Sub Unit
   - Supervisor
   - Date of Birth
   - Marital Status
   - Nationality
   - Driver's License Number

2. **Custom Fields Section**
   - Configurable custom fields
   - Dynamic field rendering
   - Field-specific validation

3. **Attachments Section**
   - Document uploads
   - File management
   - Download functionality
   - File type restrictions

### Navigation
- Single page with sub-navigation sidebar
- Left sidebar for section navigation
- Right content area for details

---

## PIM Module

### Overview
Personal Information Management module for comprehensive employee data management.

### Route
- **Main Route:** `GET /pim` (redirects to Employee List)
- **Route Name:** `pim`
- **Controller:** `App\Http\Controllers\PIMController`
- **Default View:** `resources/views/pim/employee-list.blade.php`

### Navigation Tabs
The PIM module uses a tab-based navigation system with the following options:

#### 1. Configuration (Dropdown)
- **Optional Fields**
  - Route: `GET /pim/configuration/optional-fields`
  - Route Name: `pim.configuration.optional-fields`
  - View: `resources/views/pim/configuration/optional-fields.blade.php`
  - Features:
    - Toggle optional fields on/off
    - Country-specific information settings
    - iOS-style toggle switches
    - Save functionality

- **Custom Fields**
  - Route: `GET /pim/configuration/custom-fields`
  - Route Name: `pim.configuration.custom-fields`
  - View: `resources/views/pim/configuration/custom-fields.blade.php`
  - Features:
    - Create custom fields
    - Field type selection
    - Screen assignment
    - Remaining fields counter

- **Data Import**
  - Route: `GET /pim/configuration/data-import`
  - Route Name: `pim.configuration.data-import`
  - View: `resources/views/pim/configuration/data-import.blade.php`
  - Features:
    - CSV file upload
    - Import instructions
    - File validation
    - Import progress tracking

- **Reporting Methods**
  - Route: `GET /pim/configuration/reporting-methods`
  - Route Name: `pim.configuration.reporting-methods`
  - View: `resources/views/pim/configuration/reporting-methods.blade.php`
  - Features:
    - Add/Edit reporting methods
    - Method name management
    - Data table display

- **Termination Reasons**
  - Route: `GET /pim/configuration/termination-reasons`
  - Route Name: `pim.configuration.termination-reasons`
  - View: `resources/views/pim/configuration/termination-reasons.blade.php`
  - Features:
    - Add/Edit termination reasons
    - Reason categorization
    - Data table display

#### 2. Employee List
- **Route:** `GET /pim/employee-list`
- **Route Name:** `pim.employee-list`
- **View:** `resources/views/pim/employee-list.blade.php`
- **Features:**
  - Comprehensive employee listing
  - Search and filter panel
  - Employee Information filters:
    - Employee Name
    - Employee ID
    - Employment Status
    - Job Title
    - Sub Unit
    - Supervisor
    - Include Past Employees toggle
  - Data table with columns:
    - Employee ID
    - First/Last Name
    - Job Title
    - Employment Status
    - Sub Unit
    - Supervisor
  - Reset and Search buttons
  - Add Employee button

#### 3. Add Employee
- **Route:** `GET /pim/add-employee`
- **Route Name:** `pim.add-employee`
- **View:** `resources/views/pim/add-employee.blade.php`
- **Features:**
  - Employee photo upload (circular preview)
  - Name fields (First, Middle, Last)
  - Employee ID assignment
  - Create Login Details toggle
  - Form validation
  - Cancel and Save buttons

#### 4. Reports
- **Route:** `GET /pim/reports`
- **Route Name:** `pim.reports`
- **View:** `resources/views/pim/reports.blade.php`
- **Features:**
  - Employee reports listing
  - Search panel for report filtering
  - Report name display
  - Copy functionality
  - Add Report button

### Component Used
- **Tabs Component:** `x-pim.tabs` (`resources/views/components/pim/tabs.blade.php`)

---

## Leave Module

### Overview
Comprehensive leave management system for employees and administrators.

### Route
- **Main Route:** `GET /leave` (redirects to Leave List)
- **Route Name:** `leave`
- **Controller:** `App\Http\Controllers\LeaveController`
- **Default View:** `resources/views/leave/leave.blade.php` (wrapper that loads lists)

### Navigation Tabs
The Leave module uses a tab-based navigation system (`x-leave.tabs`) with the following options:

#### 1. Apply
- **Route:** `GET /leave/apply`
- **Route Name:** `leave.apply`
- **View:** `resources/views/leave/apply.blade.php`
- **Features:**
  - Leave application form
  - Leave balance display
  - Leave type selection
  - Date range selection
  - Comments field
  - “No Leave Types with Leave Balance” state when no balance available

#### 2. My Leave
- **Route:** `GET /leave/my-leave`
- **Route Name:** `leave.my-leave`
- **View:** `resources/views/leave/my-leave.blade.php`
- **Features:**
  - Personal leave history
  - Search panel with filters:
    - From Date
    - To Date
    - Show Leave with Status (multi-select with tags)
    - Leave Type
  - Status tags (Rejected, Pending Approval, etc.)
  - Data table display
  - Reset and Search buttons

#### 3. Entitlements (Dropdown)
- **My Entitlements**
  - **Route:** `GET /leave/my-entitlements`
  - **Route Name:** `leave.my-entitlements`
  - **View:** `resources/views/leave/my-entitlements.blade.php`

- **Employee Entitlements**
  - **Route:** `GET /leave/employee-entitlements`
  - **Route Name:** `leave.employee-entitlements`
  - **View:** `resources/views/leave/employee-entitlements.blade.php`

#### 4. Reports (Dropdown)
- **Entitlements Usage Report**
  - **Route:** `GET /leave/entitlements-usage-report`
  - **Route Name:** `leave.entitlements-usage-report`
  - **View:** `resources/views/leave/entitlements-usage-report.blade.php`

- **My Entitlements Usage Report**
  - **Route:** `GET /leave/my-entitlements-usage-report`
  - **Route Name:** `leave.my-entitlements-usage-report`
  - **View:** `resources/views/leave/my-entitlements-usage-report.blade.php`

#### 5. Configure (Dropdown)
- **Leave Types**
  - **Route:** `GET /leave/leave-types`
  - **Route Name:** `leave.leave-types`
  - **View:** `resources/views/leave/leave-types.blade.php`

- **Leave Period**
  - **Route:** `GET /leave/leave-period`
  - **Route Name:** `leave.leave-period`
  - **View:** `resources/views/leave/leave-period.blade.php`

- **Work Week**
  - **Route:** `GET /leave/work-week`
  - **Route Name:** `leave.work-week`
  - **View:** `resources/views/leave/work-week.blade.php`

- **Holidays**
  - **Route:** `GET /leave/holidays`
  - **Route Name:** `leave.holidays`
  - **View:** `resources/views/leave/holidays.blade.php`

#### 6. Leave List
- **Route:** `GET /leave/leave-list`
- **Route Name:** `leave.leave-list`
- **View:** `resources/views/leave/leave-list.blade.php`
- **Features:**
  - Comprehensive leave list for administrators
  - Advanced search panel:
    - From Date
    - To Date
    - Show Leave with Status (required field)
    - Leave Type
    - Employee Name (type-ahead)
    - Sub Unit
    - Include Past Employees toggle
  - Status tag management
  - Data table with columns:
    - Date
    - Employee Name
    - Leave Type
    - Leave Balance (Days)
    - Number of Days
    - Status
    - Comments
  - Reset and Search buttons

#### 7. Assign Leave
- **Route:** `GET /leave/assign-leave`
- **Route Name:** `leave.assign-leave`
- **View:** `resources/views/leave/assign-leave.blade.php`
- **Features:**
  - Assign leave to employees
  - Employee name search (type-ahead)
  - Leave type selection
  - Leave balance display
  - From/To date selection
  - Comments field
  - Assign button

### Component Used
- **Tabs Component:** `x-leave.tabs` (`resources/views/components/leave/tabs.blade.php`)

---

## Time Module

### Overview
Time tracking and attendance management module covering timesheets, attendance, project reports, and summaries.

### Main Route
- **Main Route:** `GET /time`
- **Route Name:** `time`
- **Controller:** `App\Http\Controllers\TimeController`
- **Default View:** `resources/views/time/time.blade.php`

### Navigation Structure
The Time module uses top-level tabs and dropdowns (backed by `x-dropdown-menu`) with the following sections:

#### 1. Timesheets
- **My Timesheets**
  - **Route:** `GET /time/my-timesheets`
  - **Route Name:** `time.my-timesheets`
  - **View:** `resources/views/time/my-timesheets.blade.php`

- **Employee Timesheets**
  - **Route:** `GET /time`
  - **Route Name:** `time`
  - **View:** `resources/views/time/time.blade.php`

- **Edit My Timesheet**
  - **Route:** `GET /time/my-timesheets/edit`
  - **Route Name:** `time.my-timesheets.edit`
  - **View:** `resources/views/time/edit-my-timesheet.blade.php`

#### 2. Attendance
- **My Records**
  - **Route:** `GET /time/attendance/my-records`
  - **Route Name:** `time.attendance.my-records`
  - **View:** `resources/views/time/attendance/my-records.blade.php`

- **Punch In/Out**
  - **Route:** `GET /time/attendance/punch-in-out`
  - **Route Name:** `time.attendance.punch-in-out`
  - **View:** `resources/views/time/attendance/punch-in-out.blade.php`

- **Employee Records**
  - **Route:** `GET /time/attendance/employee-records`
  - **Route Name:** `time.attendance.employee-records`
  - **View:** `resources/views/time/attendance/employee-records.blade.php`

- **Configuration**
  - **Route:** `GET /time/attendance/configuration`
  - **Route Name:** `time.attendance.configuration`
  - **View:** `resources/views/time/attendance/configuration.blade.php`

#### 3. Reports
- **Project Reports**
  - **Route:** `GET /time/reports/project-reports`
  - **Route Name:** `time.reports.project-reports`
  - **View:** `resources/views/time/reports/project-reports.blade.php`

- **Employee Reports**
  - **Route:** `GET /time/reports/employee-reports`
  - **Route Name:** `time.reports.employee-reports`
  - **View:** `resources/views/time/reports/employee-reports.blade.php`

- **Attendance Summary**
  - **Route:** `GET /time/reports/attendance-summary`
  - **Route Name:** `time.reports.attendance-summary`
  - **View:** `resources/views/time/reports/attendance-summary.blade.php`

#### 4. Project Info
- **Customers**
  - **Route:** `GET /time/project-info/customers`
  - **Route Name:** `time.project-info.customers`
  - **View:** `resources/views/time/project-info/customers.blade.php`

- **Projects**
  - **Route:** `GET /time/project-info/projects`
  - **Route Name:** `time.project-info.projects`
  - **View:** `resources/views/time/project-info/projects.blade.php`

---

## Performance Module

### Overview
Performance review and evaluation management system including reviews, trackers, and KPIs.

### Main Route
- **Main Route:** `GET /performance`
- **Route Name:** `performance`
- **Controller:** `App\Http\Controllers\PerformanceController`
- **Default View:** `resources/views/performance/performance.blade.php`

### Navigation Structure
The Performance module uses a combination of dropdown menus and direct links:

#### 1. Manage Reviews
- **Manage Reviews**
  - **Route:** `GET /performance`
  - **Route Name:** `performance`
  - **View:** `resources/views/performance/performance.blade.php`

- **My Reviews**
  - **Route:** `GET /performance/my-reviews`
  - **Route Name:** `performance.my-reviews`
  - **View:** `resources/views/performance/my-reviews.blade.php`

- **Employee Reviews**
  - **Route:** `GET /performance/employee-reviews`
  - **Route Name:** `performance.employee-reviews`
  - **View:** `resources/views/performance/employee-reviews.blade.php`

#### 2. Trackers
- **My Trackers**
  - **Route:** `GET /performance/my-trackers`
  - **Route Name:** `performance.my-trackers`
  - **View:** `resources/views/performance/my-trackers.blade.php`

- **Employee Trackers**
  - **Route:** `GET /performance/employee-trackers`
  - **Route Name:** `performance.employee-trackers`
  - **View:** `resources/views/performance/employee-trackers.blade.php`

- **Trackers Configuration**
  - **Route:** `GET /performance/trackers`
  - **Route Name:** `performance.trackers`
  - **View:** `resources/views/performance/trackers.blade.php`

#### 3. KPIs
- **KPIs Configuration**
  - **Route:** `GET /performance/kpis`
  - **Route Name:** `performance.kpis`
  - **View:** `resources/views/performance/kpis.blade.php`

---

## Recruitment Module

### Overview
Recruitment and candidate management system for hiring processes.

### Route
- **Main Route:** `GET /recruitment`
- **Route Name:** `recruitment`
- **Controller:** `App\Http\Controllers\RecruitmentController`
- **Default View:** `resources/views/recruitment/recruitment.blade.php`

### Navigation Tabs
The Recruitment module uses a tab-based navigation system:

#### 1. Candidates
- **Route:** `GET /recruitment`
- **Route Name:** `recruitment`
- **View:** `resources/views/recruitment/recruitment.blade.php`
- **Features:**
  - Candidate listing
  - Search and filter functionality
  - Candidate information:
    - Vacancy
    - Candidate Name
    - Hiring Manager
    - Date of Application
    - Status (Shortlisted, Rejected, Application initiated)
  - Data table display
  - Pagination
  - Reset and Search buttons

#### 2. Vacancies
- **Route:** `GET /recruitment/vacancies`
- **Route Name:** `recruitment.vacancies`
- **View:** `resources/views/recruitment/vacancies.blade.php`
- **Features:**
  - Vacancy listing
  - Search panel with filters:
    - Vacancy
    - Job Title
    - Hiring Manager
    - Status
  - Data table with columns:
    - Vacancy
    - Job Title
    - Hiring Manager
    - Status (Active/Inactive)
  - Add Vacancy button
  - Reset and Search buttons

### Component Used
- **Tabs Component:** `x-recruitment.tabs` (`resources/views/components/recruitment/tabs.blade.php`)

---

## Directory Module

### Overview
Employee directory for searching and viewing employee profiles.

### Route
- **Main Route:** `GET /directory`
- **Route Name:** `directory`
- **Controller:** `App\Http\Controllers\DirectoryController`
- **View:** `resources/views/directory/directory.blade.php`

### Features
- Employee search functionality
- Search by:
  - Name
  - Job Title
  - Location
- Employee profile cards
- Contact information display
- Department filtering

---

## Claim Module

### Overview
Employee claims and expense management system.

### Route
- **Main Route:** `GET /claim`
- **Route Name:** `claim`
- **Controller:** `App\Http\Controllers\ClaimController`
- **View:** `resources/views/claim/claim.blade.php`

### Features
- Employee claims submission
- Claim status tracking
- Claim assignment
- Expense categories
- Approval workflow

### Status
*Note: This module is currently in development. Full documentation will be added as features are implemented.*

---

## Buzz Module

### Overview
Social feed and internal communication platform for announcements and employee engagement.

### Route
- **Main Route:** `GET /buzz`
- **Route Name:** `buzz`
- **Controller:** `App\Http\Controllers\BuzzController`
- **View:** `resources/views/buzz/buzz.blade.php`

### Features

#### 1. Post Creation Widget
- "What's on your mind?" input field
- Share Photos button
- Share Video button
- Post button

#### 2. Filter Tabs
- **Most Recent Posts** (Default)
  - Query Parameter: `?tab=recent`
  - Displays posts sorted by timestamp

- **Most Liked Posts**
  - Query Parameter: `?tab=liked`
  - Displays posts sorted by like count

- **Most Commented Posts**
  - Query Parameter: `?tab=commented`
  - Displays posts sorted by comment count

#### 3. Newsfeed
- Post cards with:
  - User profile picture (gradient background with initial)
  - User name
  - Timestamp
  - Post content
  - Post images (if any)
  - Interaction counts (Likes, Comments, Shares)
  - Like, Comment, Share buttons
  - "Read More" functionality for long posts

#### 4. Upcoming Anniversaries Widget
- Right sidebar widget
- Displays upcoming employee anniversaries
- "No Records Found" state with image

### Data Structure
Posts include:
- User name
- Profile picture/initial
- Timestamp
- Content
- Image (optional)
- Like count
- Comment count
- Share count
- Read more flag

---

## Admin Module

### Overview
Comprehensive administrative module for system configuration and user management.

### Route
- **Main Route:** `GET /admin`
- **Route Name:** `admin`
- **Controller:** `App\Http\Controllers\AdminController`
- **Default View:** `resources/views/admin/admin.blade.php`

### Navigation Tabs
The Admin module uses an extensive tab-based navigation system:

#### 1. User Management
- **Route:** `GET /admin`
- **Route Name:** `admin`
- **View:** `resources/views/admin/admin.blade.php`
- **Features:**
  - User listing with data table
  - Columns:
    - Username
    - User Role (Admin/ESS)
    - Employee Name
    - Status (Enabled/Disabled)
  - Search and filter functionality
  - Add User button
  - Edit and Delete actions

#### 2. Job (Dropdown)
- **Job Titles**
  - Route: `GET /admin/job-titles`
  - Route Name: `admin.job-titles`
  - View: `resources/views/admin/job/job-titles.blade.php`
  - Features:
    - Job title listing
    - Add Job Title button
    - Edit and Delete actions
    - Description field

- **Pay Grades**
  - Route: `GET /admin/pay-grades`
  - Route Name: `admin.pay-grades`
  - View: `resources/views/admin/job/pay-grades.blade.php`
  - Features:
    - Pay grade listing
    - Currency assignment
    - Add Pay Grade button
    - Edit and Delete actions

- **Employment Status**
  - Route: `GET /admin/employment-status`
  - Route Name: `admin.employment-status`
  - View: `resources/views/admin/job/employment-status.blade.php`
  - Features:
    - Employment status listing
    - Add Employment Status button
    - Edit and Delete actions

- **Job Categories**
  - Route: `GET /admin/job-categories`
  - Route Name: `admin.job-categories`
  - View: `resources/views/admin/job/job-categories.blade.php`
  - Features:
    - Job category listing
    - Add Job Category button
    - Edit and Delete actions

- **Work Shifts**
  - Route: `GET /admin/work-shifts`
  - Route Name: `admin.work-shifts`
  - View: `resources/views/admin/job/work-shifts.blade.php`
  - Features:
    - Work shift listing
    - From/To time
    - Hours per day
    - Add Work Shift button
    - Edit and Delete actions

#### 3. Organization (Dropdown)
- **General Information**
  - Route: `GET /admin/organization/general-information`
  - Route Name: `admin.organization.general-information`
  - View: `resources/views/admin/organization/general-information.blade.php`
  - Features:
    - Organization name
    - Tax ID
    - Registration Number
    - Phone
    - Fax
    - Email
    - Address fields
    - Note field
    - Edit toggle switch
    - Save button

- **Locations**
  - Route: `GET /admin/organization/locations`
  - Route Name: `admin.organization.locations`
  - View: `resources/views/admin/organization/locations.blade.php`
  - Features:
    - Location listing
    - Search panel
    - Add Location button
    - Edit and Delete actions
    - Columns:
      - Name
      - Country
      - State/Province
      - City
      - Address
      - Zip/Postal Code
      - Phone
      - Fax
      - Notes

- **Structure**
  - Route: `GET /admin/organization/structure`
  - Route Name: `admin.organization.structure`
  - View: `resources/views/admin/organization/structure.blade.php`
  - Features:
    - Hierarchical organization tree
    - Expandable/collapsible nodes
    - Visual connector lines (CSS pseudo-elements)
    - Edit toggle switch
    - Action buttons (Delete, Edit, Add) visible in edit mode
    - Node expansion/collapse functionality
    - Recursive tree structure

#### 4. Qualifications (Dropdown)
- **Skills**
  - Route: `GET /admin/qualifications/skills`
  - Route Name: `admin.qualifications.skills`
  - View: `resources/views/admin/qualifications/skills.blade.php`
  - Features:
    - Skills listing
    - Add Skill button
    - Edit and Delete actions

- **Education**
  - Route: `GET /admin/qualifications/education`
  - Route Name: `admin.qualifications.education`
  - View: `resources/views/admin/qualifications/education.blade.php`
  - Features:
    - Education level listing
    - Add Education button
    - Edit and Delete actions

- **Licenses**
  - Route: `GET /admin/qualifications/licenses`
  - Route Name: `admin.qualifications.licenses`
  - View: `resources/views/admin/qualifications/licenses.blade.php`
  - Features:
    - License listing
    - Add License button
    - Edit and Delete actions

- **Languages**
  - Route: `GET /admin/qualifications/languages`
  - Route Name: `admin.qualifications.languages`
  - View: `resources/views/admin/qualifications/languages.blade.php`
  - Features:
    - Language listing
    - Add Language button
    - Edit and Delete actions

- **Memberships**
  - Route: `GET /admin/qualifications/memberships`
  - Route Name: `admin.qualifications.memberships`
  - View: `resources/views/admin/qualifications/memberships.blade.php`
  - Features:
    - Membership listing
    - Add Membership button
    - Edit and Delete actions

#### 5. Nationalities
- **Route:** `GET /admin/nationalities`
- **Route Name:** `admin.nationalities`
- **View:** `resources/views/admin/nationalities.blade.php`
- **Features:**
  - Nationality listing (193 countries)
  - Add Nationality button
  - Edit and Delete actions
  - Search functionality

#### 6. Corporate Branding
- **Route:** `GET /admin/corporate-branding`
- **Route Name:** `admin.corporate-branding`
- **View:** `resources/views/admin/corporate-branding.blade.php`
- **Features:**
  - **Color Configuration (2-column grid):**
    - Primary Color (with color picker)
    - Primary Font Color (with color picker)
    - Primary Gradient Color 1 (with color picker)
    - Secondary Color (with color picker)
    - Secondary Font Color (with color picker)
    - Primary Gradient Color 2 (with color picker)
  - **Color Picker Features:**
    - Floating overlay picker
    - 2D color gradient square
    - Hue slider
    - HEX input
    - Live preview
    - Click outside to close
  - **Image Uploads:**
    - Client Logo (with browse button)
    - Client Banner (with browse button)
    - Login Banner (with browse button)
    - File name display
    - Recommended dimensions
  - **Social Media Images Toggle**
  - **Action Buttons:**
    - Reset to Default (outline)
    - Preview (outline)
    - Publish (solid primary)

#### 7. Configuration (Dropdown)
- **Email Configuration**
  - Route: `GET /admin/configuration/email-configuration`
  - Route Name: `admin.configuration.email-configuration`
  - View: `resources/views/admin/configuration/email-configuration.blade.php`
  - Features:
    - Mail Sent As field
    - Path to Sendmail field
    - Sending Method (radio buttons):
      - SECURE SMTP
      - SMTP
      - Sendmail
    - Send Test Mail toggle
    - Reset and Save buttons

- **Email Subscriptions**
  - Route: `GET /admin/configuration/email-subscriptions`
  - Route Name: `admin.configuration.email-subscriptions`
  - View: `resources/views/admin/configuration/email-subscriptions.blade.php`
  - Features:
    - Notification type listing
    - Subscribers column
    - Add Subscriber button per notification
    - Enable/Disable toggle per notification
    - Notification types:
      - Leave Applications
      - Leave Approvals
      - Leave Assignments
      - Leave Cancellations
      - Leave Rejections

- **Localization**
  - Route: `GET /admin/configuration/localization`
  - Route Name: `admin.configuration.localization`
  - View: `resources/views/admin/configuration/localization.blade.php`
  - Features:
    - Language dropdown
    - Date Format dropdown
    - Save button

- **Language Packages**
  - Route: `GET /admin/configuration/language-packages`
  - Route Name: `admin.configuration.language-packages`
  - View: `resources/views/admin/configuration/language-packages.blade.php`
  - Features:
    - Language package listing
    - Upload, Download, Delete icons
    - Up/Down arrow buttons for ordering
    - No action buttons (Edit/Delete) in table rows

- **Modules**
  - Route: `GET /admin/configuration/modules`
  - Route Name: `admin.configuration.modules`
  - View: `resources/views/admin/configuration/module-configuration.blade.php`
  - Features:
    - Module listing with toggle switches:
      - Admin
      - PIM
      - Leave
      - Time
      - Recruitment
      - Performance
      - Directory
      - Maintenance
      - Mobile
      - Claim
      - Buzz
    - Save button

- **Social Media Authentication**
  - Route: `GET /admin/configuration/social-media-authentication`
  - Route Name: `admin.configuration.social-media-authentication`
  - View: `resources/views/admin/configuration/social-media-authentication.blade.php`
  - Features:
    - Social media provider listing
    - Add button
    - Empty state message
    - Table headers (Name, Actions)

- **Register OAuth Client**
  - Route: `GET /admin/configuration/oauth-client-list`
  - Route Name: `admin.configuration.oauth-client-list`
  - View: `resources/views/admin/configuration/oauth-client-list.blade.php`
  - Features:
    - OAuth client listing
    - Columns:
      - Name
      - Redirect URI
      - Status
    - Copy icon (large, right-aligned)
    - No Edit/Delete buttons

- **LDAP Configuration**
  - Route: `GET /admin/configuration/ldap`
  - Route Name: `admin.configuration.ldap`
  - View: `resources/views/admin/configuration/ldap-configuration.blade.php`
  - Features:
    - Enable toggle switch
    - **Server Settings:**
      - Host
      - Port
      - Encryption
      - LDAP Implementation
    - **Bind Settings:**
      - Bind Anonymously toggle
      - Distinguished Name
      - Password
    - **User Lookup Settings:**
      - Base DN
      - Search Scope
      - User Name Attribute
      - User Search Filter
      - User Unique ID Attribute
    - **Data Mapping:**
      - First Name
      - Middle Name
      - Last Name
      - User Status
      - Work Email
      - Employee Id
    - **Additional Settings:**
      - Merge LDAP Users toggle
      - Sync Interval
    - Warning message box
    - Test Connection and Save buttons

### Component Used
- **Tabs Component:** `x-admin.tabs` (`resources/views/components/admin/tabs.blade.php`)

---

## Maintenance Module

### Overview
System maintenance utilities requiring additional administrator authentication.

### Authentication
- **Auth Route:** `GET /maintenance/auth`
- **Route Name:** `maintenance.auth`
- **View:** `resources/views/maintenance/auth.blade.php`
- **Controller:** `App\Http\Controllers\MaintenanceController`
- **Credentials:** `admin` / `admin123`
- **Session:** `maintenance_auth`

### Route
- **Main Route:** `GET /maintenance` (redirects to Purge Employee)
- **Route Name:** `maintenance.index`
- **Controller:** `App\Http\Controllers\MaintenanceController`

### Navigation Tabs
The Maintenance module uses a dropdown-based navigation:

#### 1. Employee Records (Dropdown)
- **Purge Employee Records**
  - Route: `GET /maintenance/purge-employee`
  - Route Name: `maintenance.purge-employee`
  - View: `resources/views/maintenance/purge-employee.blade.php`
  - Features:
    - Employee record deletion
    - Search functionality
    - Confirmation dialogs
    - Data purge warnings

#### 2. Candidate Records (Dropdown)
- **Purge Candidate Records**
  - Route: `GET /maintenance/purge-candidate`
  - Route Name: `maintenance.purge-candidate`
  - View: `resources/views/maintenance/purge-candidate.blade.php`
  - Features:
    - Candidate record deletion
    - Search functionality
    - Confirmation dialogs
    - Data purge warnings

#### 3. Access Records
- **Route:** `GET /maintenance/access-records`
- **Route Name:** `maintenance.access-records`
- **View:** `resources/views/maintenance/access-records.blade.php`
- **Features:**
  - Access log viewing
  - User activity tracking
  - Login history
  - Session management

### Security
- Requires separate authentication beyond main login
- Session-based access control
- Automatic redirect to auth page if not authenticated

---

## Profile Management

### Overview
User profile management accessible from the header dropdown menu.

### Profile Dropdown
Accessible from the header user menu (top-right corner).

### Routes
- **About**
  - Route: `GET /profile/about`
  - Route Name: `profile.about`
  - Controller: `App\Http\Controllers\ProfileController`
  - Action: Displays modal with user information
  - Features:
    - User details
    - System information
    - Version details

- **Support**
  - Route: `GET /profile/support`
  - Route Name: `profile.support`
  - View: `resources/views/profile/support.blade.php`
  - Features:
    - Getting Started guide
    - Customer support contact
    - Support image
    - Help documentation links

- **Change Password**
  - Route: `GET /profile/change-password`
  - Route Name: `profile.change-password`
  - View: `resources/views/profile/change-password.blade.php`
  - Features:
    - Current password field
    - New password field
    - Confirm password field
    - Password strength indicator
    - Cancel and Save buttons
  - Update Route: `POST /profile/change-password`
  - Route Name: `profile.update-password`

- **Logout**
  - Route: `POST /logout`
  - Route Name: `logout`
  - Action: Clears session and redirects to login

### Dropdown Implementation
- Portal-based dropdown (rendered at `<body>` level)
- Fixed positioning using `getBoundingClientRect()`
- Overlaps content (not clipped by parent containers)
- Closes on outside click, scroll, or window resize
- Theme-aware styling

---

## Reusable Components

### Overview
The system uses reusable Blade components for consistency across all modules.

### Admin Components
Located in `resources/views/components/admin/`:

#### 1. Tabs Component (`x-admin.tabs`)
- **File:** `resources/views/components/admin/tabs.blade.php`
- **Props:** `activeTab`
- **Usage:** Navigation tabs for Admin module
- **Features:**
  - Active state highlighting
  - Dropdown menus
  - Theme-aware hover effects
  - Responsive design

#### 2. Data Table Component (`x-admin.data-table`)
- **File:** `resources/views/components/admin/data-table.blade.php`
- **Props:** `title`, `records`, `columns`, `addButton`, `addButtonText`, `showActions`
- **Usage:** Standardized data table display
- **Features:**
  - Dynamic column rendering
  - Sortable headers
  - Add button
  - Action buttons (conditional)
  - Theme-aware styling
  - Dark mode support

#### 3. Table Row Component (`x-admin.table-row`)
- **File:** `resources/views/components/admin/table-row.blade.php`
- **Props:** `record`, `showActions`
- **Usage:** Individual table row
- **Features:**
  - Checkbox selection
  - Action buttons (Delete, Edit)
  - Hover effects
  - Theme-aware styling

#### 4. Table Cell Component (`x-admin.table-cell`)
- **File:** `resources/views/components/admin/table-cell.blade.php`
- **Usage:** Individual table cell
- **Features:**
  - Consistent cell styling
  - Theme-aware text colors

#### 5. Form Field Component (`x-admin.form-field`)
- **File:** `resources/views/components/admin/form-field.blade.php`
- **Props:** `label`, `name`, `value`, `type`, `required`, `readonly`, `placeholder`, `class`
- **Usage:** Standardized form input fields
- **Features:**
  - Label with required indicator
  - Input/Textarea support
  - Readonly state
  - Theme-aware styling
  - Focus states

#### 6. Form Section Component (`x-admin.form-section`)
- **File:** `resources/views/components/admin/form-section.blade.php`
- **Props:** `title`, `editMode`, `showEditToggle`
- **Usage:** Form section with edit toggle
- **Features:**
  - Section title
  - Edit toggle switch
  - Enable/disable form fields
  - Theme-aware styling

#### 7. Search Panel Component (`x-admin.search-panel`)
- **File:** `resources/views/components/admin/search-panel.blade.php`
- **Props:** `title`, `collapsed`
- **Usage:** Collapsible search/filter panel
- **Features:**
  - Toggle expand/collapse
  - Custom title
  - Slot for form fields
  - Theme-aware styling

#### 8. Color Picker Component (`x-admin.color-picker`)
- **File:** `resources/views/components/admin/color-picker.blade.php`
- **Props:** `name`, `label`, `value`, `required`
- **Usage:** Floating color picker for color selection
- **Features:**
  - Circular color swatch
  - HEX input field
  - Floating overlay picker
  - 2D color gradient canvas
  - Hue slider
  - Live preview
  - Click outside to close
  - HSV to HEX conversion
  - Theme-aware styling

### Module-Specific Tab Components

#### PIM Tabs (`x-pim.tabs`)
- **File:** `resources/views/components/pim/tabs.blade.php`
- **Props:** `activeTab`
- **Usage:** Navigation tabs for PIM module

#### Leave Tabs (`x-leave.tabs`)
- **File:** `resources/views/components/leave/tabs.blade.php`
- **Props:** `activeTab`
- **Usage:** Navigation tabs for Leave module

#### Recruitment Tabs (`x-recruitment.tabs`)
- **File:** `resources/views/components/recruitment/tabs.blade.php`
- **Props:** `activeTab`
- **Usage:** Navigation tabs for Recruitment module

### Global Components

#### Dropdown Menu (`x-dropdown-menu`)
- **File:** `resources/views/components/dropdown-menu.blade.php`
- **Props:** `items`, `position`, `width`
- **Usage:** Reusable dropdown menu
- **Features:**
  - Left/Right positioning
  - Custom width
  - Active state highlighting
  - Theme-aware styling
  - Hover effects

#### Main Layout (`x-main-layout`)
- **File:** `resources/views/components/main-layout.blade.php`
- **Props:** `title`
- **Usage:** Main content wrapper
- **Features:**
  - Page title
  - Consistent layout structure

#### Sidebar (`x-sidebar`)
- **File:** `resources/views/components/sidebar.blade.php`
- **Props:** `showSearch`
- **Usage:** Main navigation sidebar
- **Features:**
  - Collapsible sidebar
  - Search functionality
  - Active link highlighting
  - Auto-scroll to active link

#### Header (`x-header`)
- **File:** `resources/views/components/header.blade.php`
- **Usage:** Application header
- **Features:**
  - Theme toggle
  - User menu
  - Profile dropdown trigger
  - Upgrade button
  - Help button

---

## Technical Architecture

### MVC Structure
- **Models:** `app/Models/`
- **Views:** `resources/views/`
- **Controllers:** `app/Http/Controllers/`
- **Routes:** `routes/web.php`

### Theme System
- **CSS Variables:** Defined in `resources/css/app.css`
- **Light/Dark Mode:** Toggle via header button
- **Theme Persistence:** localStorage
- **Login Page:** Always light mode

### Styling
- **Framework:** Tailwind CSS
- **Custom CSS:** `resources/css/app.css`
- **Theme Variables:**
  - `--bg-main`, `--bg-card`, `--bg-surface`
  - `--text-primary`, `--text-secondary`, `--text-muted`
  - `--border-default`, `--border-strong`
  - `--color-hr-primary`, `--color-hr-primary-dark`
  - `--shadow-sm`, `--shadow-md`, `--shadow-lg`

### JavaScript
- **File:** `resources/js/app.js`
- **Features:**
  - Theme toggle
  - Sidebar toggle
  - Dropdown management
  - Profile dropdown portal
  - Auto-scroll to active sidebar link
  - Modal handling

### Icons
- **Library:** FontAwesome 6.5.2
- **CDN:** cdnjs.cloudflare.com
- **Usage:** `<i class="fas fa-*"></i>`

---

## Route Summary

### Authentication Routes
- `GET /` → Redirects to `/login`
- `GET /login` → Login page
- `POST /login` → Authentication
- `POST /logout` → Logout

### Main Module Routes
- `GET /dashboard` → Dashboard
- `GET /my-info` → My Info
- `GET /pim` → PIM (redirects to Employee List)
- `GET /leave` → Leave (redirects to Leave List)
- `GET /time` → Time
- `GET /performance` → Performance
- `GET /recruitment` → Recruitment
- `GET /directory` → Directory
- `GET /claim` → Claim
- `GET /buzz` → Buzz
- `GET /admin` → Admin
- `GET /maintenance/auth` → Maintenance Auth

### Profile Routes
- `GET /profile/about` → About modal
- `GET /profile/support` → Support page
- `GET /profile/change-password` → Change Password
- `POST /profile/change-password` → Update Password

---

## Development Guidelines

### Adding New Pages
1. Create controller method
2. Define route in `routes/web.php`
3. Create view file in appropriate module folder
4. Use reusable components where possible
5. Apply theme variables for styling
6. Test in both light and dark modes

### Component Usage
- Always use existing components when possible
- Follow naming conventions
- Maintain theme consistency
- Test responsive behavior

### Styling Rules
- Use CSS variables for colors
- No hardcoded colors
- Support dark mode
- Use Tailwind utilities
- Custom CSS in `app.css` for complex styles

---

## Version History

### Version 1.0 (2025-01-27)
- Initial comprehensive documentation
- All 12 modules documented
- Complete route listing
- Component documentation
- Navigation structure documented

---

**Document Maintained By:** Development Team  
**For Support:** Contact system administrator  
**Last Review:** 2025-01-27
