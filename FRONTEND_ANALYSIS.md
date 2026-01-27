# TOSS-HRM Frontend Analysis

**Analysis Date:** January 27, 2026  
**Project:** TOAI HR Suite - Professional Edition  
**Framework:** Laravel (Blade Templates)

---

## 1. Pages & Components List

### 1.1 Main Layout Components

#### Base Layout
- **`layouts/app.blade.php`** - Main application layout wrapper
  - Used by: All pages
  - Contains: HTML structure, meta tags, theme initialization, global scripts

#### Core Layout Components
- **`components/main-layout.blade.php`** - Main content wrapper
  - Props: `title`, `showSidebarSearch` (default: true)
  - Used by: All authenticated pages
  - Contains: Sidebar, Header, Main content area

- **`components/sidebar.blade.php`** - Fixed sidebar navigation
  - Props: `showSearch` (default: true)
  - Contains: Logo, search bar, navigation menu items
  - Used by: `main-layout.blade.php`

- **`components/header.blade.php`** - Top header bar
  - Props: `title`
  - Contains: Page title, theme toggle, upgrade button, user menu
  - Used by: `main-layout.blade.php`

### 1.2 Reusable UI Components

#### Admin Components (`components/admin/`)
- **`action-buttons.blade.php`** - Search/Reset button pair
  - Used by: Filter forms across multiple pages
- **`add-button.blade.php`** - Add/Create button component
  - Props: `label` (optional)
  - Used by: List pages (Employee List, User List, etc.)
- **`data-table.blade.php`** - Reusable data table wrapper
  - Props: `title`, `records`, `columns`, `addButton`
  - Used by: Employee List, other list pages
- **`form-section.blade.php`** - Form section with edit toggle
  - Props: `title`, `editMode`, `showEditToggle`
  - Used by: Admin configuration pages
- **`form-field.blade.php`** - Standard form field wrapper
- **`search-panel.blade.php`** - Search/filter panel component
- **`table-row.blade.php`** - Table row wrapper
- **`table-cell.blade.php`** - Table cell wrapper
- **`tabs.blade.php`** - Tab navigation component
- **`toggle-switch.blade.php`** - Toggle switch component
  - Props: `id`, `checked`
  - Used by: Configuration pages, attendance configuration
- **`color-picker.blade.php`** - Color picker component

#### Module-Specific Tab Components
- **`components/leave/tabs.blade.php`** - Leave module tabs
  - Props: `activeTab`
  - Tabs: Apply, My Leave, Entitlements (dropdown), Reports (dropdown), Configure (dropdown), Leave List, Assign Leave
- **`components/pim/tabs.blade.php`** - PIM module tabs
  - Props: `activeTab`
  - Tabs: Configuration (dropdown), Employee List, Add Employee, Reports
- **`components/recruitment/tabs.blade.php`** - Recruitment module tabs
- **`components/admin/tabs.blade.php`** - Admin module tabs

#### General Components
- **`components/dropdown-menu.blade.php`** - Dropdown menu component
  - Props: `items` (array with url, label, active), `position`, `width`
  - Used by: Time module navigation, Performance module navigation
- **`components/dropdown-arrow.blade.php`** - Dropdown arrow icon
- **`components/records-found.blade.php`** - Records count display
  - Props: `count`
  - Used by: List pages

### 1.3 Authentication Pages

- **`auth/login.blade.php`** - Login page
  - Route: `/login` (GET, POST)
  - Form Fields:
    - Username (text, required)
    - Password (password, required)
    - Remember me (checkbox, optional)
  - Actions: Login, Forgot password link

### 1.4 Dashboard

- **`dashboard/dashboard.blade.php`** - Main dashboard
  - Route: `/dashboard`
  - Sections:
    - Time at Work card (punch status, weekly hours chart)
    - My Actions card (pending reviews, interviews)
    - Quick Launch card (shortcuts)
    - Buzz Latest Posts
    - Employees on Leave Today
    - Employee Distribution by Sub Unit (pie chart)
    - Employee Distribution by Location (pie chart)

### 1.5 PIM (Personnel Information Management) Module

#### Main Pages
- **`pim/pim.blade.php`** - PIM landing page
  - Route: `/pim`
- **`pim/employee-list.blade.php`** - Employee list with filters
  - Route: `/pim/employee-list`
  - Displays: Employee table with search/filter panel
- **`pim/add-employee.blade.php`** - Add new employee form
  - Route: `/pim/add-employee`
  - Form Fields:
    - Employee Photo (file upload, optional)
    - First Name (text, required)
    - Middle Name (text, optional)
    - Last Name (text, required)
    - Employee Id (text, optional, auto-generated)
    - Create Login Details (toggle, optional)

#### Configuration Pages
- **`pim/configuration/optional-fields.blade.php`** - Optional fields configuration
  - Route: `/pim/configuration/optional-fields`
- **`pim/configuration/custom-fields.blade.php`** - Custom fields configuration
  - Route: `/pim/configuration/custom-fields`
- **`pim/configuration/data-import.blade.php`** - Data import page
  - Route: `/pim/configuration/data-import`
- **`pim/configuration/reporting-methods.blade.php`** - Reporting methods configuration
  - Route: `/pim/configuration/reporting-methods`
- **`pim/configuration/termination-reasons.blade.php`** - Termination reasons configuration
  - Route: `/pim/configuration/termination-reasons`
- **`pim/reports.blade.php`** - PIM reports
  - Route: `/pim/reports`

### 1.6 Leave Module

#### Main Pages
- **`leave/leave.blade.php`** - Leave list page
  - Route: `/leave`
  - Displays: Leave list with filters
- **`leave/apply.blade.php`** - Apply for leave
  - Route: `/leave/apply`
  - Note: Currently shows "No Leave Types with Leave Balance" message
- **`leave/my-leave.blade.php`** - My leave records
  - Route: `/leave/my-leave`
- **`leave/leave-list.blade.php`** - Leave list (admin view)
  - Route: `/leave/leave-list`
  - Filter Fields:
    - From Date (date)
    - To Date (date)
    - Show Leave with Status (select: Pending Approval, Approved, Rejected, Cancelled)
    - Leave Type (select)
    - Employee Name (text, required)
    - Sub Unit (select)
    - Include Past Employees (toggle)
- **`leave/assign-leave.blade.php`** - Assign leave to employee
  - Route: `/leave/assign-leave`
  - Form Fields:
    - Employee Name (text, required)
    - Leave Type (select, required)
    - From Date (date, required)
    - To Date (date, required)
    - Comments (textarea, optional)

#### Entitlements Pages
- **`leave/add-entitlement.blade.php`** - Add leave entitlement
  - Route: `/leave/add-entitlement`
- **`leave/my-entitlements.blade.php`** - My entitlements
  - Route: `/leave/my-entitlements`
- **`leave/employee-entitlements.blade.php`** - Employee entitlements
  - Route: `/leave/employee-entitlements`

#### Reports Pages
- **`leave/entitlements-usage-report.blade.php`** - Entitlements usage report
  - Route: `/leave/entitlements-usage-report`
- **`leave/my-entitlements-usage-report.blade.php`** - My entitlements usage report
  - Route: `/leave/my-entitlements-usage-report`

#### Configuration Pages
- **`leave/leave-types.blade.php`** - Leave types configuration
  - Route: `/leave/leave-types`
- **`leave/leave-period.blade.php`** - Leave period configuration
  - Route: `/leave/leave-period`
- **`leave/work-week.blade.php`** - Work week configuration
  - Route: `/leave/work-week`
- **`leave/holidays.blade.php`** - Holidays configuration
  - Route: `/leave/holidays`

### 1.7 Time Module

#### Timesheets Pages
- **`time/time.blade.php`** - Employee timesheets (admin view)
  - Route: `/time`
  - Filter: Employee Name (required)
  - Displays: Timesheets pending action table
- **`time/my-timesheets.blade.php`** - My timesheets
  - Route: `/time/my-timesheets`
  - Displays: Timesheet grid (Project, Activity, Days of month, Total)
  - Actions: Edit, Submit
- **`time/edit-my-timesheet.blade.php`** - Edit my timesheet
  - Route: `/time/my-timesheets/edit`

#### Attendance Pages
- **`time/attendance/my-records.blade.php`** - My attendance records
  - Route: `/time/attendance/my-records`
- **`time/attendance/punch-in-out.blade.php`** - Punch in/out form
  - Route: `/time/attendance/punch-in-out`
  - Form Fields:
    - Date (date, required)
    - Time (text, required, format: HH:MM AM/PM)
    - Note (textarea, optional)
  - Actions: In button (submit)
- **`time/attendance/employee-records.blade.php`** - Employee attendance records
  - Route: `/time/attendance/employee-records`
  - Filter Fields:
    - Employee Name (text, optional)
    - Date (date, required)
  - Displays: Records table (Employee Name, Total Duration, Actions)
- **`time/attendance/configuration.blade.php`** - Attendance configuration
  - Route: `/time/attendance/configuration`
  - Configuration Options (toggles):
    - Employee can change current time when punching in/out
    - Employee can edit/delete own attendance records
    - Supervisor can add/edit/delete attendance records of subordinates

#### Reports Pages
- **`time/reports/project-reports.blade.php`** - Project reports
  - Route: `/time/reports/project-reports`
- **`time/reports/employee-reports.blade.php`** - Employee reports
  - Route: `/time/reports/employee-reports`
- **`time/reports/attendance-summary.blade.php`** - Attendance summary
  - Route: `/time/reports/attendance-summary`

### 1.8 Performance Module

#### Main Pages
- **`performance/performance.blade.php`** - Manage performance reviews
  - Route: `/performance`
  - Filter Fields:
    - Employee Name (text)
    - Job Title (select)
    - Sub Unit (select)
    - Include (select: Current Employees Only, Past Employees Only, All Employees)
    - Review Status (select: Pending, In Progress, Completed, Cancelled, Activated)
    - Reviewer (text)
    - From Date (date)
    - To Date (date)
  - Displays: Reviews table (Employee, Job Title, Review Period, Due Date, Reviewer, Review Status)
- **`performance/my-reviews.blade.php`** - My reviews
  - Route: `/performance/my-reviews`
- **`performance/employee-reviews.blade.php`** - Employee reviews
  - Route: `/performance/employee-reviews`

#### Trackers Pages
- **`performance/my-trackers.blade.php`** - My trackers
  - Route: `/performance/my-trackers`
- **`performance/employee-trackers.blade.php`** - Employee trackers
  - Route: `/performance/employee-trackers`
- **`performance/trackers.blade.php`** - Trackers management
  - Route: `/performance/trackers`

#### Configuration Pages
- **`performance/kpis.blade.php`** - KPIs configuration
  - Route: `/performance/kpis`

### 1.9 Recruitment Module

- **`recruitment/recruitment.blade.php`** - Candidates list
  - Route: `/recruitment`
  - Filter Fields:
    - Job Title (select)
    - Vacancy (select)
    - Hiring Manager (select)
    - Status (select: Application Initiated, Shortlisted, Rejected, Hired)
    - Candidate Name (text)
    - Keywords (text)
    - Date of Application (date range: From, To)
    - Method of Application (select: Online, Email, Walk-in, Referral)
  - Displays: Candidates table (Vacancy, Candidate, Hiring Manager, Date of Application, Status)
- **`recruitment/vacancies.blade.php`** - Vacancies list
  - Route: `/recruitment/vacancies`

### 1.10 Claim Module

#### Main Pages
- **`claim/claim.blade.php`** - Employee claims list
  - Route: `/claim`
  - Filter Fields:
    - Employee Name (text)
    - Reference Id (text)
    - Event Name (select)
    - Status (select: Initiated, Submitted, Approved, Rejected)
    - From Date (date)
    - To Date (date)
    - Include (select: Current Employees Only, Past Employees Only, All Employees)
  - Displays: Claims table (Reference Id, Employee Name, Event Name, Description, Currency, Submitted Date, Status, Amount)
- **`claim/submit-claim.blade.php`** - Submit claim form
  - Route: `/claim/submit`
  - Form Fields:
    - Event (select, required)
    - Currency (select, required)
    - Remarks (textarea, optional)
- **`claim/my-claims.blade.php`** - My claims
  - Route: `/claim/my-claims`
- **`claim/assign-claim.blade.php`** - Assign claim
  - Route: `/claim/assign`

#### Configuration Pages
- **`claim/configuration/events.blade.php`** - Events configuration
  - Route: `/claim/configuration/events`
- **`claim/configuration/add-event.blade.php`** - Add event
  - Route: `/claim/configuration/events/add`
- **`claim/configuration/expenses-types.blade.php`** - Expense types configuration
  - Route: `/claim/configuration/expenses-types`
- **`claim/configuration/add-expense-type.blade.php`** - Add expense type
  - Route: `/claim/configuration/expenses-types/add`

### 1.11 Admin Module

#### Main Pages
- **`admin/admin.blade.php`** - User management
  - Route: `/admin`
  - Filter Fields:
    - Username (text)
    - User Role (select: Admin, ESS)
    - Employee Name (text)
    - Status (select: Enabled, Disabled)
  - Displays: Users table (Username, User Role, Employee Name, Status)

#### Job Management Pages
- **`admin/job/job-titles.blade.php`** - Job titles
  - Route: `/admin/job-titles`
- **`admin/job/pay-grades.blade.php`** - Pay grades
  - Route: `/admin/pay-grades`
- **`admin/job/employment-status.blade.php`** - Employment status
  - Route: `/admin/employment-status`
- **`admin/job/job-categories.blade.php`** - Job categories
  - Route: `/admin/job-categories`
- **`admin/job/work-shifts.blade.php`** - Work shifts
  - Route: `/admin/work-shifts`

#### Organization Pages
- **`admin/organization/general-information.blade.php`** - General information
  - Route: `/admin/organization/general-information`
- **`admin/organization/locations.blade.php`** - Locations
  - Route: `/admin/organization/locations`
- **`admin/organization/structure.blade.php`** - Organization structure
  - Route: `/admin/organization/structure`

#### Qualifications Pages
- **`admin/qualifications/skills.blade.php`** - Skills
  - Route: `/admin/qualifications/skills`
- **`admin/qualifications/education.blade.php`** - Education
  - Route: `/admin/qualifications/education`
- **`admin/qualifications/licenses.blade.php`** - Licenses
  - Route: `/admin/qualifications/licenses`
- **`admin/qualifications/languages.blade.php`** - Languages
  - Route: `/admin/qualifications/languages`
- **`admin/qualifications/memberships.blade.php`** - Memberships
  - Route: `/admin/qualifications/memberships`

#### Configuration Pages
- **`admin/nationalities.blade.php`** - Nationalities
  - Route: `/admin/nationalities`
- **`admin/corporate-branding.blade.php`** - Corporate branding
  - Route: `/admin/corporate-branding`
- **`admin/configuration/email-configuration.blade.php`** - Email configuration
  - Route: `/admin/configuration/email-configuration`
- **`admin/configuration/email-subscriptions.blade.php`** - Email subscriptions
  - Route: `/admin/configuration/email-subscriptions`
- **`admin/configuration/localization.blade.php`** - Localization
  - Route: `/admin/configuration/localization`
- **`admin/configuration/language-packages.blade.php`** - Language packages
  - Route: `/admin/configuration/language-packages`
- **`admin/configuration/modules.blade.php`** - Module configuration
  - Route: `/admin/configuration/modules`
- **`admin/configuration/social-media-authentication.blade.php`** - Social media authentication
  - Route: `/admin/configuration/social-media-authentication`
- **`admin/configuration/oauth-client-list.blade.php`** - OAuth client list
  - Route: `/admin/configuration/oauth-client-list`
- **`admin/configuration/ldap.blade.php`** - LDAP configuration
  - Route: `/admin/configuration/ldap`

### 1.12 Other Modules

- **`myinfo/myinfo.blade.php`** - My Info page
  - Route: `/my-info`
- **`directory/directory.blade.php`** - Directory
  - Route: `/directory`
- **`buzz/buzz.blade.php`** - Buzz feed
  - Route: `/buzz`
- **`profile/change-password.blade.php`** - Change password
  - Route: `/profile/change-password`
  - Form Fields:
    - Username (text, readonly)
    - Password (password, required)
    - Current Password (password, required)
    - Confirm Password (password, required)
- **`profile/support.blade.php`** - Support
  - Route: `/profile/support`

### 1.13 Maintenance Module

- **`maintenance/auth.blade.php`** - Maintenance authentication
  - Route: `/maintenance/auth`
- **`maintenance/purge-employee.blade.php`** - Purge employee
  - Route: `/maintenance/purge-employee`
- **`maintenance/purge-candidate.blade.php`** - Purge candidate
  - Route: `/maintenance/purge-candidate`
- **`maintenance/access-records.blade.php`** - Access records
  - Route: `/maintenance/access-records`

---

## 2. Navigation & Flow Map

### 2.1 Entry Points

1. **Login Page** (`/login`)
   - Entry point for all users
   - Redirects to `/dashboard` after successful login
   - Redirects to `/login` if not authenticated

2. **Dashboard** (`/dashboard`)
   - Main landing page after login
   - Contains quick links to various modules

### 2.2 Main Navigation (Sidebar)

The sidebar provides navigation to all major modules:
- Dashboard
- My Info
- PIM
- Leave
- Time
- Performance
- Recruitment
- Directory
- Claim
- Buzz
- Admin
- Maintenance

### 2.3 Module Navigation Patterns

#### Time Module Navigation
Uses dropdown menus for sub-sections:
- **Timesheets** dropdown:
  - My Timesheets
  - Employee Timesheets
- **Attendance** dropdown:
  - My Records
  - Punch In/Out
  - Employee Records
  - Configuration
- **Reports** dropdown:
  - Project Reports
  - Employee Reports
  - Attendance Summary
- **Project Info** (no dropdown defined)

#### Leave Module Navigation
Uses tabs with some dropdowns:
- Apply
- My Leave
- **Entitlements** dropdown:
  - My Entitlements
  - Employee Entitlements
  - Add Entitlement
- **Reports** dropdown:
  - My Entitlements Usage Report
  - Entitlements Usage Report
- **Configure** dropdown:
  - Leave Types
  - Leave Period
  - Work Week
  - Holidays
- Leave List
- Assign Leave

#### PIM Module Navigation
Uses tabs:
- **Configuration** dropdown:
  - Optional Fields
  - Custom Fields
  - Data Import
  - Reporting Methods
  - Termination Reasons
- Employee List
- Add Employee
- Reports

#### Performance Module Navigation
Uses dropdown menus:
- **Configure** dropdown:
  - KPIs
  - Trackers
- **Manage Reviews** dropdown:
  - Manage Reviews
  - My Reviews
  - Employee Reviews
- My Trackers
- Employee Trackers

#### Claim Module Navigation
Uses tabs:
- **Configuration** dropdown:
  - Events
  - Expenses Types
- Submit Claim
- My Claims
- Employee Claims
- Assign Claim

### 2.4 Conditional Navigation

- **Role-based access**: Not explicitly defined in frontend (no role checks visible in views)
- **Maintenance access**: Requires separate authentication (`/maintenance/auth`)
- **Active state indicators**: Routes use `request()->routeIs()` to highlight active navigation items

### 2.5 Page Dependencies

- **Employee List → Add Employee**: Direct navigation via "Add" button
- **Timesheets → Edit Timesheet**: Edit button navigates to edit page
- **Leave List → Assign Leave**: Can navigate from dashboard quick launch
- **Claims → Submit Claim**: Direct navigation from tabs
- **Admin → Various Config Pages**: Accessed via Admin tabs/dropdowns

---

## 3. Forms & Inputs Matrix

### 3.1 Authentication Forms

#### Login Form (`auth/login.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| username | text | Yes | - | POST `/login` |
| password | password | Yes | - | POST `/login` |
| remember | checkbox | No | - | Included in POST |

### 3.2 Employee Management Forms

#### Add Employee Form (`pim/add-employee.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| photo | file | No | jpg, png, gif, max 1MB, 200x200px recommended | Create employee |
| first_name | text | Yes | - | Create employee |
| middle_name | text | No | - | Create employee |
| last_name | text | Yes | - | Create employee |
| employee_id | text | No | Auto-generated (default: 0386) | Create employee |
| create_login | toggle | No | - | Create employee with login |

#### Employee Search/Filter Form (`pim/employee-list.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| employee_name | text | No | Type for hints | Filter employees |
| employee_id | text | No | - | Filter employees |
| employment_status | select | No | Options: Full-Time Permanent, Full-Time Contract, Part-Time Contract, Intern | Filter employees |
| include | select | No | Options: Current Employees Only, Past Employees Only, All Employees | Filter employees |
| supervisor_name | text | No | Type for hints | Filter employees |
| job_title | select | No | Options: Software Engineer, QA Engineer, HR Manager, Business Analyst, Project Manager | Filter employees |
| sub_unit | select | No | Options: Engineering, Human Resources, Quality Assurance, Business Development, Management | Filter employees |

### 3.3 Leave Management Forms

#### Assign Leave Form (`leave/assign-leave.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| employee_name | text | Yes | Type for hints | Assign leave |
| leave_type | select | Yes | Options: Annual Leave, Sick Leave, Casual Leave | Assign leave |
| from_date | date | Yes | - | Assign leave |
| to_date | date | Yes | - | Assign leave |
| comments | textarea | No | - | Assign leave |

#### Leave List Filter Form (`leave/leave-list.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| from_date | date | No | Default: 2026-01-16 | Filter leaves |
| to_date | date | No | Default: 2026-12-31 | Filter leaves |
| show_leave_with_status | select | No | Options: Pending Approval, Approved, Rejected, Cancelled | Filter leaves |
| leave_type | select | No | Options: Annual Leave, Sick Leave, Casual Leave, Personal Leave | Filter leaves |
| employee_name | text | Yes | Type for hints | Filter leaves |
| sub_unit | select | No | Options: Engineering, Human Resources, Quality Assurance, Business Development | Filter leaves |
| include_past_employees | toggle | No | - | Filter leaves |

### 3.4 Time & Attendance Forms

#### Punch In/Out Form (`time/attendance/punch-in-out.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| date | date | Yes | - | Punch in |
| time | text | Yes | Pattern: HH:MM AM/PM | Punch in |
| note | textarea | No | - | Punch in |

#### Employee Records Filter Form (`time/attendance/employee-records.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| employee_name | text | No | Type for hints | View records |
| date | date | Yes | - | View records |

#### Timesheet Filter Form (`time/time.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| employee_name | text | Yes | Type for hints | View timesheets |

#### Attendance Configuration Form (`time/attendance/configuration.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| employee_can_change_time | toggle | No | Default: checked | Save configuration |
| employee_can_edit_delete | toggle | No | Default: checked | Save configuration |
| supervisor_can_manage | toggle | No | Default: checked | Save configuration |

### 3.5 Claim Management Forms

#### Submit Claim Form (`claim/submit-claim.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| event | select | Yes | Options from events list | Create claim |
| currency | select | Yes | Options from currencies list | Create claim |
| remarks | textarea | No | - | Create claim |

#### Employee Claims Filter Form (`claim/claim.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| employee_name | text | No | Type for hints | Filter claims |
| reference_id | text | No | Type for hints | Filter claims |
| event_name | select | No | Options: Travel Allowance, Medical Reimbursement, Accommodation, Meal Allowance | Filter claims |
| status | select | No | Options: Initiated, Submitted, Approved, Rejected | Filter claims |
| from_date | date | No | - | Filter claims |
| to_date | date | No | - | Filter claims |
| include | select | No | Options: Current Employees Only, Past Employees Only, All Employees | Filter claims |

### 3.6 Performance Management Forms

#### Performance Reviews Filter Form (`performance/performance.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| employee_name | text | No | Type for hints | Filter reviews |
| job_title | select | No | Options: Software Engineer, QA Engineer, HR Manager, Business Analyst, Project Manager | Filter reviews |
| sub_unit | select | No | Options: Engineering, Human Resources, Quality Assurance, Business Development, Management | Filter reviews |
| include | select | No | Options: Current Employees Only, Past Employees Only, All Employees | Filter reviews |
| review_status | select | No | Options: Pending, In Progress, Completed, Cancelled, Activated | Filter reviews |
| reviewer | text | No | Type for hints | Filter reviews |
| from_date | date | No | Default: 2026-01-01 | Filter reviews |
| to_date | date | No | Default: 2026-12-31 | Filter reviews |

### 3.7 Recruitment Forms

#### Candidate Search Filter Form (`recruitment/recruitment.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| job_title | select | No | Options: Senior QA Lead, Payroll Administrator, Software Engineer, HR Manager | Filter candidates |
| vacancy | select | No | Options: Senior QA Lead, Payroll Administrator | Filter candidates |
| hiring_manager | select | No | Options: manda akhil user, Admin | Filter candidates |
| status | select | No | Options: Application Initiated, Shortlisted, Rejected, Hired | Filter candidates |
| candidate_name | text | No | Type for hints | Filter candidates |
| keywords | text | No | Comma separated words | Filter candidates |
| date_of_application_from | date | No | - | Filter candidates |
| date_of_application_to | date | No | - | Filter candidates |
| method_of_application | select | No | Options: Online, Email, Walk-in, Referral | Filter candidates |

### 3.8 Admin Forms

#### User Management Filter Form (`admin/admin.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| username | text | No | - | Filter users |
| user_role | select | No | Options: Admin, ESS | Filter users |
| employee_name | text | No | Type for hints | Filter users |
| status | select | No | Options: Enabled, Disabled | Filter users |

#### Change Password Form (`profile/change-password.blade.php`)
| Field Name | Type | Required | Validation | Submit Action |
|------------|------|----------|------------|---------------|
| username | text | No | Readonly | POST `/profile/change-password` |
| password | password | Yes | Strong password recommended | Update password |
| current_password | password | Yes | - | Update password |
| password_confirmation | password | Yes | Must match password | Update password |

---

## 4. Displayed Data Structures

### 4.1 Employee List Table (`pim/employee-list.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| ID | text | No | Yes (via filter) | Employee ID |
| First (& Middle) Name | text | No | Yes (via filter) | Full first name |
| Last Name | text | No | Yes (via filter) | Last name |
| Job Title | text | No | Yes (via filter) | Can be null |
| Employment Status | text | No | Yes (via filter) | Can be null |
| Sub Unit | text | No | Yes (via filter) | Can be null |
| Supervisor | text | No | Yes (via filter) | Can be null |
| Actions | buttons | No | No | Edit, Delete |

**Data Structure (from code):**
```php
$employee = [
    'id' => string,
    'first_name' => string,
    'last_name' => string,
    'job_title' => string|null,
    'employment_status' => string|null,
    'sub_unit' => string|null,
    'supervisor' => string|null
]
```

### 4.2 Leave List Table (`leave/leave-list.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| Date | date | No | Yes (via filter) | Leave date |
| Employee Name | text | No | Yes (via filter) | - |
| Leave Type | text | No | Yes (via filter) | - |
| Leave Balance (Days) | number | No | No | - |
| Number of Days | number | No | No | - |
| Status | text | No | Yes (via filter) | - |
| Comments | text | No | No | - |
| Actions | buttons | No | No | Edit, Delete |

**Data Structure:**
```php
$leave = [
    'date' => string,
    'employee_name' => string,
    'leave_type' => string,
    'leave_balance' => string|number,
    'number_of_days' => string|number,
    'status' => string,
    'comments' => string|null
]
```

### 4.3 Timesheets Table (`time/time.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| Employee Name | text | No | Yes (via filter) | - |
| Timesheet Period | text | No | No | - |
| Actions | buttons | No | No | View |

**Data Structure:**
```php
$timesheet = [
    'employee_name' => string,
    'timesheet_period' => string
]
```

### 4.4 My Timesheet Grid (`time/my-timesheets.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| Project | text | No | No | - |
| Activity | text | No | No | - |
| Day 1-31 | number | No | No | Hours per day |
| Total | number | No | No | Sum of hours |

**Data Structure:**
```php
$days = [
    ['day_of_month' => int, 'day_name_short' => string],
    // ... for each day in period
]
$timesheetPeriod = [
    'start' => string,
    'end' => string
]
$status = string // e.g., "Draft", "Submitted"
```

### 4.5 Employee Attendance Records Table (`time/attendance/employee-records.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| Employee Name | text | No | Yes (via filter) | - |
| Total Duration (Hours) | number | No | No | Formatted to 2 decimals |
| Actions | buttons | No | No | View |

**Data Structure:**
```php
$record = [
    'employee_name' => string,
    'total_duration' => float
]
```

### 4.6 Employee Claims Table (`claim/claim.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| Reference Id | text | Yes (arrows shown) | Yes (via filter) | - |
| Employee Name | text | Yes (arrows shown) | Yes (via filter) | - |
| Event Name | text | Yes (arrows shown) | Yes (via filter) | - |
| Description | text | No | No | Can be null |
| Currency | text | Yes (arrows shown) | No | - |
| Submitted Date | date | Yes (arrows shown) | No | - |
| Status | text | Yes (arrows shown) | Yes (via filter) | - |
| Amount | number | Yes (arrows shown) | No | - |
| Actions | buttons | No | No | View Details |

**Data Structure:**
```php
$claim = [
    'reference_id' => string,
    'employee_name' => string,
    'event_name' => string,
    'description' => string|null,
    'currency' => string,
    'submitted_date' => string,
    'status' => string,
    'amount' => string|number
]
```

### 4.7 Performance Reviews Table (`performance/performance.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| Employee | text | Yes (arrows shown) | Yes (via filter) | - |
| Job Title | text | No | Yes (via filter) | - |
| Review Period | text | No | No | - |
| Due Date | date | Yes (arrows shown) | No | - |
| Reviewer | text | No | Yes (via filter) | - |
| Review Status | text | Yes (arrows shown) | Yes (via filter) | - |
| Actions | buttons | No | No | View, Edit |

**Data Structure:**
```php
$review = [
    'employee' => string,
    'job_title' => string,
    'review_period' => string,
    'due_date' => string,
    'reviewer' => string,
    'review_status' => string
]
```

### 4.8 Candidates Table (`recruitment/recruitment.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| Vacancy | text | Yes (arrows shown) | Yes (via filter) | Can be null |
| Candidate | text | Yes (arrows shown) | Yes (via filter) | - |
| Hiring Manager | text | Yes (arrows shown) | Yes (via filter) | - |
| Date of Application | date | Yes (arrows shown) | Yes (via filter) | - |
| Status | badge | Yes (arrows shown) | Yes (via filter) | Color-coded (Shortlisted=green, Rejected=red, else=blue) |
| Actions | buttons | No | No | View, Delete, Download |

**Data Structure:**
```php
$candidate = [
    'vacancy' => string|null,
    'candidate' => string,
    'hiring_manager' => string,
    'date' => string,
    'status' => string // Application Initiated, Shortlisted, Rejected, Hired
]
```

### 4.9 User List Table (`admin/admin.blade.php`)
| Column | Data Type | Sortable | Filterable | Notes |
|--------|-----------|----------|------------|-------|
| Username | text | No | Yes (via filter) | - |
| User Role | text | No | Yes (via filter) | Admin or ESS |
| Employee Name | text | No | Yes (via filter) | - |
| Status | text | No | Yes (via filter) | Enabled or Disabled |
| Actions | buttons | No | No | Edit, Delete |

**Data Structure:**
```php
$user = [
    'username' => string,
    'role' => string, // Admin or ESS
    'employee_name' => string,
    'status' => string // Enabled or Disabled
]
```

### 4.10 Dashboard Cards

#### Time at Work Card
- **Punch Status**: Punched In/Punched Out
- **Punch Time**: Date and time of last punch
- **Today's Duration**: Hours and minutes
- **Weekly Chart**: Bar chart showing hours per day (Mon-Sun)

#### My Actions Card
- **Pending Self Review**: Count and link to performance reviews
- **Candidate to Interview**: Count and link to recruitment

#### Quick Launch Card
- **Shortcuts**: Assign Leave, Leave List, Timesheets, Apply Leave, My Leave, My Timesheet

#### Buzz Latest Posts
- **Post Structure**:
  - Author initials/avatar
  - Author name
  - Timestamp
  - Post content

#### Employee Distribution Charts
- **By Sub Unit**: Pie chart with percentages and counts
- **By Location**: Pie chart with percentages and counts

---

## 5. Observed Entities & Fields

### 5.1 User Entity
**Observed Fields:**
- `username` (text, required)
- `password` (password, hashed)
- `role` (enum: Admin, ESS)
- `status` (enum: Enabled, Disabled)
- `employee_name` (text, relationship to Employee)

**Relationships:**
- One-to-one with Employee (implied, not explicitly defined)

### 5.2 Employee Entity
**Observed Fields:**
- `id` (text/number, unique identifier)
- `first_name` (text, required)
- `middle_name` (text, optional)
- `last_name` (text, required)
- `employee_id` (text, optional, auto-generated)
- `photo` (file, optional, jpg/png/gif, max 1MB)
- `job_title` (text, optional, relationship to JobTitle)
- `employment_status` (text, optional, relationship to EmploymentStatus)
- `sub_unit` (text, optional, relationship to SubUnit)
- `supervisor` (text, optional, relationship to Employee - self-referential)

**Relationships:**
- Many-to-one with JobTitle (implied)
- Many-to-one with EmploymentStatus (implied)
- Many-to-one with SubUnit (implied)
- Many-to-one with Employee (supervisor, self-referential, implied)

### 5.3 Leave Entity
**Observed Fields:**
- `date` (date)
- `employee_name` (text, relationship to Employee)
- `leave_type` (text, relationship to LeaveType)
- `leave_balance` (number, days)
- `number_of_days` (number)
- `status` (enum: Pending Approval, Approved, Rejected, Cancelled)
- `comments` (text, optional)
- `from_date` (date, for date ranges)
- `to_date` (date, for date ranges)

**Relationships:**
- Many-to-one with Employee (implied)
- Many-to-one with LeaveType (implied)

### 5.4 LeaveType Entity
**Observed Values:**
- Annual Leave
- Sick Leave
- Casual Leave
- Personal Leave

**Fields (not explicitly shown, inferred):**
- `name` (text)
- `leave_balance` (number, days)

### 5.5 Attendance Entity
**Observed Fields:**
- `date` (date, required)
- `time` (time, required, format: HH:MM AM/PM)
- `note` (text, optional)
- `employee_name` (text, relationship to Employee)
- `total_duration` (number, hours, calculated)

**Relationships:**
- Many-to-one with Employee (implied)

### 5.6 Timesheet Entity
**Observed Fields:**
- `employee_name` (text, relationship to Employee)
- `timesheet_period` (text, date range)
- `project` (text)
- `activity` (text)
- `hours_per_day` (array of numbers, days 1-31)
- `total_hours` (number, calculated)
- `status` (enum: Draft, Submitted, etc.)

**Relationships:**
- Many-to-one with Employee (implied)
- Many-to-one with Project (implied)

### 5.7 Claim Entity
**Observed Fields:**
- `reference_id` (text, unique identifier)
- `employee_name` (text, relationship to Employee)
- `event_name` (text, relationship to Event)
- `description` (text, optional)
- `currency` (text, relationship to Currency)
- `submitted_date` (date)
- `status` (enum: Initiated, Submitted, Approved, Rejected)
- `amount` (number)

**Relationships:**
- Many-to-one with Employee (implied)
- Many-to-one with Event (implied)
- Many-to-one with Currency (implied)

### 5.8 Event Entity (Claim Events)
**Observed Values:**
- Travel Allowance
- Medical Reimbursement
- Accommodation
- Meal Allowance

**Fields (not explicitly shown, inferred):**
- `name` (text)

### 5.9 Performance Review Entity
**Observed Fields:**
- `employee` (text, relationship to Employee)
- `job_title` (text, relationship to JobTitle)
- `review_period` (text)
- `due_date` (date)
- `reviewer` (text, relationship to Employee)
- `review_status` (enum: Pending, In Progress, Completed, Cancelled, Activated)

**Relationships:**
- Many-to-one with Employee (employee, implied)
- Many-to-one with Employee (reviewer, implied)
- Many-to-one with JobTitle (implied)

### 5.10 Candidate Entity
**Observed Fields:**
- `vacancy` (text, optional, relationship to Vacancy)
- `candidate` (text, name)
- `hiring_manager` (text, relationship to Employee)
- `date` (date, date of application)
- `status` (enum: Application Initiated, Shortlisted, Rejected, Hired)
- `method_of_application` (enum: Online, Email, Walk-in, Referral)

**Relationships:**
- Many-to-one with Vacancy (implied)
- Many-to-one with Employee (hiring_manager, implied)

### 5.11 Vacancy Entity
**Observed Values:**
- Senior QA Lead
- Payroll Administrator

**Fields (not explicitly shown, inferred):**
- `name` (text)
- `job_title` (text, relationship to JobTitle)

### 5.12 JobTitle Entity
**Observed Values:**
- Software Engineer
- QA Engineer
- HR Manager
- Business Analyst
- Project Manager
- Senior QA Lead
- Payroll Administrator

**Fields (not explicitly shown, inferred):**
- `name` (text)

### 5.13 EmploymentStatus Entity
**Observed Values:**
- Full-Time Permanent
- Full-Time Contract
- Part-Time Contract
- Intern

**Fields (not explicitly shown, inferred):**
- `name` (text)

### 5.14 SubUnit Entity
**Observed Values:**
- Engineering
- Human Resources
- Quality Assurance
- Business Development
- Management

**Fields (not explicitly shown, inferred):**
- `name` (text)

### 5.15 Location Entity
**Observed Values:**
- Unassigned
- Texas R&D
- New York Sales

**Fields (not explicitly shown, inferred):**
- `name` (text)

### 5.16 Currency Entity
**Observed Values:**
- Not explicitly shown in UI (populated from backend)

**Fields (not explicitly shown, inferred):**
- `code` (text, e.g., USD, EUR)
- `name` (text, optional)

### 5.17 Configuration Entities

#### Attendance Configuration
- `employee_can_change_time` (boolean)
- `employee_can_edit_delete` (boolean)
- `supervisor_can_manage` (boolean)

---

## 6. Known Connections Between Entities

### 6.1 Explicitly Observed Relationships

1. **User ↔ Employee**
   - Relationship Type: One-to-one (implied)
   - Connection: User has `employee_name` field
   - Status: Relationship not fully defined

2. **Employee ↔ JobTitle**
   - Relationship Type: Many-to-one (implied)
   - Connection: Employee has `job_title` field
   - Status: Relationship not fully defined

3. **Employee ↔ EmploymentStatus**
   - Relationship Type: Many-to-one (implied)
   - Connection: Employee has `employment_status` field
   - Status: Relationship not fully defined

4. **Employee ↔ SubUnit**
   - Relationship Type: Many-to-one (implied)
   - Connection: Employee has `sub_unit` field
   - Status: Relationship not fully defined

5. **Employee ↔ Employee (Supervisor)**
   - Relationship Type: Many-to-one, self-referential (implied)
   - Connection: Employee has `supervisor` field
   - Status: Relationship not fully defined

6. **Leave ↔ Employee**
   - Relationship Type: Many-to-one (implied)
   - Connection: Leave has `employee_name` field
   - Status: Relationship not fully defined

7. **Leave ↔ LeaveType**
   - Relationship Type: Many-to-one (implied)
   - Connection: Leave has `leave_type` field
   - Status: Relationship not fully defined

8. **Attendance ↔ Employee**
   - Relationship Type: Many-to-one (implied)
   - Connection: Attendance has `employee_name` field
   - Status: Relationship not fully defined

9. **Timesheet ↔ Employee**
   - Relationship Type: Many-to-one (implied)
   - Connection: Timesheet has `employee_name` field
   - Status: Relationship not fully defined

10. **Timesheet ↔ Project**
    - Relationship Type: Many-to-one (implied)
    - Connection: Timesheet has `project` field
    - Status: Relationship not fully defined

11. **Claim ↔ Employee**
    - Relationship Type: Many-to-one (implied)
    - Connection: Claim has `employee_name` field
    - Status: Relationship not fully defined

12. **Claim ↔ Event**
    - Relationship Type: Many-to-one (implied)
    - Connection: Claim has `event_name` field
    - Status: Relationship not fully defined

13. **Claim ↔ Currency**
    - Relationship Type: Many-to-one (implied)
    - Connection: Claim has `currency` field
    - Status: Relationship not fully defined

14. **Performance Review ↔ Employee (Employee)**
    - Relationship Type: Many-to-one (implied)
    - Connection: Review has `employee` field
    - Status: Relationship not fully defined

15. **Performance Review ↔ Employee (Reviewer)**
    - Relationship Type: Many-to-one (implied)
    - Connection: Review has `reviewer` field
    - Status: Relationship not fully defined

16. **Performance Review ↔ JobTitle**
    - Relationship Type: Many-to-one (implied)
    - Connection: Review has `job_title` field
    - Status: Relationship not fully defined

17. **Candidate ↔ Vacancy**
    - Relationship Type: Many-to-one (implied)
    - Connection: Candidate has `vacancy` field
    - Status: Relationship not fully defined

18. **Candidate ↔ Employee (Hiring Manager)**
    - Relationship Type: Many-to-one (implied)
    - Connection: Candidate has `hiring_manager` field
    - Status: Relationship not fully defined

### 6.2 Relationship Notes

- **All relationships are implied** from field names and usage patterns
- **No foreign key constraints** are visible in the frontend
- **Many relationships use text fields** (employee_name, job_title) rather than IDs, suggesting either:
  - Denormalized data
  - Lookup tables
  - Or IDs are used in backend but names displayed in frontend

---

## 7. Gaps / Undefined Areas

### 7.1 Missing Entity Definitions

1. **Project Entity**
   - Referenced in: Timesheets, Project Reports
   - Fields: Not defined
   - Relationships: Not defined

2. **Activity Entity**
   - Referenced in: Timesheets
   - Fields: Not defined
   - Relationships: Not defined

3. **PayGrade Entity**
   - Referenced in: Admin routes (`/admin/pay-grades`)
   - Fields: Not defined
   - Relationships: Not defined

4. **JobCategory Entity**
   - Referenced in: Admin routes (`/admin/job-categories`)
   - Fields: Not defined
   - Relationships: Not defined

5. **WorkShift Entity**
   - Referenced in: Admin routes (`/admin/work-shifts`)
   - Fields: Not defined
   - Relationships: Not defined

6. **Organization Entity**
   - Referenced in: Admin routes (`/admin/organization/*`)
   - Fields: Not defined
   - Relationships: Not defined

7. **Location Entity**
   - Referenced in: Dashboard charts, Admin routes
   - Fields: Only name observed
   - Relationships: Not defined

8. **Skill Entity**
   - Referenced in: Admin routes (`/admin/qualifications/skills`)
   - Fields: Not defined
   - Relationships: Not defined

9. **Education Entity**
   - Referenced in: Admin routes (`/admin/qualifications/education`)
   - Fields: Not defined
   - Relationships: Not defined

10. **License Entity**
    - Referenced in: Admin routes (`/admin/qualifications/licenses`)
    - Fields: Not defined
    - Relationships: Not defined

11. **Language Entity**
    - Referenced in: Admin routes (`/admin/qualifications/languages`)
    - Fields: Not defined
    - Relationships: Not defined

12. **Membership Entity**
    - Referenced in: Admin routes (`/admin/qualifications/memberships`)
    - Fields: Not defined
    - Relationships: Not defined

13. **Nationality Entity**
    - Referenced in: Admin routes (`/admin/nationalities`)
    - Fields: Not defined
    - Relationships: Not defined

14. **ExpenseType Entity**
    - Referenced in: Claim configuration routes
    - Fields: Not defined
    - Relationships: Not defined

15. **Leave Entitlement Entity**
    - Referenced in: Leave entitlements pages
    - Fields: Not defined
    - Relationships: Not defined

16. **Leave Period Entity**
    - Referenced in: Leave configuration routes
    - Fields: Not defined
    - Relationships: Not defined

17. **Work Week Entity**
    - Referenced in: Leave configuration routes
    - Fields: Not defined
    - Relationships: Not defined

18. **Holiday Entity**
    - Referenced in: Leave configuration routes
    - Fields: Not defined
    - Relationships: Not defined

19. **KPI Entity**
    - Referenced in: Performance routes (`/performance/kpis`)
    - Fields: Not defined
    - Relationships: Not defined

20. **Tracker Entity**
    - Referenced in: Performance routes (`/performance/trackers`)
    - Fields: Not defined
    - Relationships: Not defined

21. **Buzz Post Entity**
    - Referenced in: Dashboard, Buzz page
    - Fields: Partially observed (author, timestamp, content)
    - Relationships: Not defined

### 7.2 Missing Field Definitions

1. **Employee Entity Missing Fields:**
   - Date of birth
   - Gender
   - Email
   - Phone
   - Address
   - Nationality
   - Marital status
   - Emergency contacts
   - Bank details
   - Tax information
   - Employment start date
   - Employment end date
   - Salary information
   - Skills
   - Education
   - Licenses
   - Languages
   - Memberships

2. **Leave Entity Missing Fields:**
   - Leave request ID
   - Applied date
   - Approved/rejected date
   - Approved/rejected by
   - Leave entitlement ID

3. **Attendance Entity Missing Fields:**
   - Punch in time
   - Punch out time
   - Break duration
   - Overtime hours
   - Location (if applicable)

4. **Timesheet Entity Missing Fields:**
   - Timesheet ID
   - Week/period identifier
   - Submitted date
   - Approved date
   - Approved by

5. **Claim Entity Missing Fields:**
   - Claim items/line items
   - Receipt attachments
   - Approved/rejected date
   - Approved/rejected by
   - Payment date
   - Payment method

6. **Performance Review Entity Missing Fields:**
   - Review ID
   - Review template/form
   - Goals
   - Ratings
   - Comments
   - Self-review content
   - Reviewer comments

### 7.3 Missing Relationship Definitions

1. **Employee ↔ Qualifications**
   - Skills, Education, Licenses, Languages, Memberships
   - Relationship type: Not defined

2. **Employee ↔ Location**
   - Relationship type: Not defined

3. **Employee ↔ PayGrade**
   - Relationship type: Not defined

4. **Employee ↔ WorkShift**
   - Relationship type: Not defined

5. **Timesheet ↔ Activity**
   - Relationship type: Not defined

6. **Leave ↔ Leave Entitlement**
   - Relationship type: Not defined

7. **Claim ↔ ExpenseType**
   - Relationship type: Not defined

### 7.4 Missing Workflow Definitions

1. **Leave Approval Workflow**
   - Approval hierarchy: Not defined
   - Auto-approval rules: Not defined
   - Notification triggers: Not defined

2. **Timesheet Approval Workflow**
   - Approval process: Not defined
   - Submission rules: Not defined

3. **Claim Approval Workflow**
   - Approval hierarchy: Not defined
   - Amount limits: Not defined
   - Auto-approval rules: Not defined

4. **Performance Review Workflow**
   - Review cycle: Not defined
   - Review stages: Not defined
   - Completion criteria: Not defined

5. **Recruitment Workflow**
   - Application stages: Not defined
   - Interview process: Not defined
   - Hiring workflow: Not defined

### 7.5 Missing Configuration Definitions

1. **Role-Based Access Control (RBAC)**
   - Roles: Admin, ESS observed, but permissions not defined
   - Page access rules: Not defined
   - Feature access rules: Not defined

2. **Data Validation Rules**
   - Field validation: Not defined
   - Business rules: Not defined
   - Constraint rules: Not defined

3. **Notification System**
   - Notification types: Not defined
   - Notification triggers: Not defined
   - Notification channels: Not defined

4. **Reporting System**
   - Report definitions: Not defined
   - Report parameters: Not defined
   - Export formats: Not defined

### 7.6 Missing API/Backend Integration Details

1. **API Endpoints**
   - No API endpoint definitions visible in frontend
   - No AJAX/fetch calls observed in views
   - Form submissions use standard POST/GET

2. **Data Fetching**
   - Data passed via controller (Blade `$variable` syntax)
   - No client-side data fetching observed

3. **Real-time Features**
   - No WebSocket connections observed
   - No real-time update mechanisms visible

### 7.7 Missing UI/UX Definitions

1. **Pagination**
   - Pagination UI present but page size not defined
   - Total records calculation: Not defined

2. **Search/Filter**
   - "Type for hints" functionality: Not defined
   - Autocomplete behavior: Not defined
   - Filter persistence: Not defined

3. **Sorting**
   - Sortable columns indicated but sort logic: Not defined
   - Default sort order: Not defined

4. **Export/Import**
   - Export functionality: Not defined
   - Import file formats: Not defined
   - Data mapping: Not defined

---

## 8. Summary

### 8.1 Total Pages Identified
- **110+ Blade template files** found
- **80+ distinct routes** defined
- **13 major modules** identified

### 8.2 Total Components Identified
- **20+ reusable components** in `components/` directory
- **4 module-specific tab components**
- **10+ admin-specific components**

### 8.3 Total Forms Identified
- **30+ distinct forms** across all modules
- **100+ form fields** total

### 8.4 Total Entities Identified
- **21 entities** with observed fields
- **18 relationships** implied (not explicitly defined)
- **20+ entities** referenced but not fully defined

### 8.5 Key Observations

1. **Frontend is primarily server-rendered** using Laravel Blade templates
2. **No client-side state management** observed (no Redux, Vuex, etc.)
3. **Minimal JavaScript** - mostly for UI interactions (dropdowns, toggles, date pickers)
4. **Form submissions** use standard HTML forms with POST/GET
5. **Data relationships** are implied through field names, not explicit foreign keys
6. **Role-based access** is mentioned (Admin, ESS) but not implemented in frontend
7. **Many configuration pages** exist but their forms/fields are not fully analyzed in this document

### 8.6 Recommendations for Database Design

1. **Create explicit foreign key relationships** for all implied relationships
2. **Define all entities** referenced in routes but not fully observed
3. **Add missing fields** to entities based on typical HRM requirements
4. **Define relationship cardinalities** explicitly (one-to-one, one-to-many, many-to-many)
5. **Create lookup/reference tables** for all dropdown options
6. **Define indexes** for frequently filtered/searched fields
7. **Consider audit fields** (created_at, updated_at, created_by, updated_by)
8. **Define soft deletes** for entities that may need restoration

---

**End of Analysis**
