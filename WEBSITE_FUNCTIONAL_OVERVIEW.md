# TOAI HR Suite – Functional Overview

This document gives a **functional map of the whole website** – module by module and page by page – so that a new developer or admin can quickly understand:
- What each page does
- Which data it shows (which table)
- What actions a user is expected to perform (create, edit, delete, search, filter, etc.)

> Note: Routes below are based on `routes/web.php`. All authenticated pages use the common layout (`layouts/app.blade.php` → `x-main-layout`) with the left sidebar and top header.

---

## 1. Authentication & Layout

### 1.1 Login
- **Route**: `GET /login`, `POST /login`
- **Purpose**: Authenticate user (username + password).
- **Data**: `users`, `user_roles`, `roles`.
- **Actions**:
  - Enter username/password and login.
  - On success user is redirected to `/dashboard`.

### 1.2 Global Layout
- **Files**: `layouts/app.blade.php`, `components/main-layout.blade.php`, `components/sidebar.blade.php`, `components/header.blade.php`.
- **Purpose**:
  - Common **sidebar** navigation.
  - Common **top header** with theme toggle, Upgrade button, and profile menu.
- **Profile menu**:
  - **About**: opens modal pulling JSON from `GET /profile/about`.
  - **Support**: `GET /profile/support`.
  - **Change Password**: `GET/POST /profile/change-password`.
  - **Logout**: `POST /logout`.

---

## 2. Dashboard

### 2.1 Dashboard Home
- **Route**: `GET /dashboard`
- **Purpose**: Landing page with key HR metrics.
- **Data sources**:
  - Employees counters: `employees` (`status`).
  - “My Actions” (pending self reviews): `performance_reviews`.
  - “Candidates to Interview”: `candidate_applications`.
  - “Latest Buzz”: `buzz_posts` + `users`.
  - “Time at Work”:
    - Today’s punch in/out and hours: `attendance_records`.
    - Weekly bar chart: `attendance_records` grouped by day.
  - “Employees on Leave Today”: `leave_applications`, `employees`, `leave_types`.
  - “Employee Distribution by Sub Unit/Location”: `employees` + `employee_job_details` + `organization_units`/`locations`.
- **Actions**:
  - Read-only dashboard; user can navigate via links/buttons into detail modules (Time, Leave, Buzz, etc.).

---

## 3. My Info

### 3.1 My Info – Personal Details
- **Route**: `GET /my-info`
- **Purpose**: Show logged-in employee’s profile (personal details + attachments).
- **Data**:
  - Logged in user: `users` (resolved from session).
  - Employee base info: `employees`.
  - Personal details: `employee_personal_details` (+ `nationalities`).
  - Attachments: `file_uploads` (joined with `users` as `added_by`).
- **UI Sections**:
  - Avatar + display name.
  - Personal detail form: names, employee ID, other ID, license, nationality, DOB, gender, marital status, blood type.
  - Attachments list (file name, size, type, date added).
- **Actions**:
  - Currently **view-only**; layout has an Edit toggle pattern in other form sections, but real save endpoints are not wired yet.

---

## 4. PIM (Personnel Information Management)

Top-level route: `GET /pim` → redirects to **Employee List**.

### 4.1 Employee List
- **Route**: `GET /pim/employee-list`
- **Purpose**: Master list of employees.
- **Data**: `employees` + `job_titles` + `employment_statuses` + `organization_units` + self-join for supervisor.
- **UI**:
  - Search/filter panel (front-end only today).
  - Table: Employee ID, Name, Job Title, Employment Status, Sub Unit, Supervisor.
- **Actions**:
  - Primarily **view/search**. UI has checkboxes and action buttons but no back-end create/delete for employees yet.

### 4.2 Add Employee
- **Route**: `GET /pim/add-employee`
- **Purpose**: Form to add a new employee record.
- **Data**:
  - Currently only uses static UI; no controller save method.
- **UI**:
  - Upload photo placeholder.
  - Fields: First/Middle/Last Name, Employee ID, toggle for “Create Login Details”.
- **Actions**:
  - Intended: Create employee (insert into `employees` and optionally `users`).
  - Currently: **no POST endpoint** – pressing “Save” does not persist yet.

### 4.3 Reports
- **Route**: `GET /pim/reports`
- **Purpose**: Simple list of employee report names based on qualifications.
- **Data**: `employee_qualifications` + `employees` + `qualifications`.
- **UI**:
  - Search field “Report Name” (front-end filter).
  - **Reports List** table: just `Name` (qualification name).
- **Actions**:
  - View existing derived reports only (no create/delete yet).

### 4.4 Configuration → Optional Fields
- **Route**: `GET /pim/configuration/optional-fields`
- **Purpose**: Toggle which optional fields are enabled/required (pure UI).
- **Data**: Currently static UI (no DB integration).
- **Actions**: Visual toggles only; real persistence not implemented yet.

### 4.5 Configuration → Custom Fields
- **Route**: `GET /pim/configuration/custom-fields`
- **Purpose**: List custom fields and remaining available slots.
- **Data**:
  - `custom_fields` (selected with aliases `screen`, `field_type`).
  - `remainingFields` computed in controller (max 10 − count).
- **UI**:
  - “Remaining number of custom fields: {{ $remainingFields }}”.
  - Table listing **Custom Field Name / Screen / Field Type**.
- **Actions**:
  - Currently read-only list. Add button exists in UI, but create/update/delete endpoints are not wired.

### 4.6 Configuration → Data Import
- **Route**: `GET /pim/configuration/data-import`
- **Purpose**: Explain CSV import rules.
- **Data**: Pure static notes; no DB.
- **Actions**:
  - User reads instructions, upload CSV (future work).

### 4.7 Configuration → Reporting Methods
- **Route**: 
  - `GET /pim/configuration/reporting-methods`
  - `POST /pim/configuration/reporting-methods/store`
  - `POST /pim/configuration/reporting-methods/update/{id}`
  - `POST /pim/configuration/reporting-methods/delete/{id}`
  - `POST /pim/configuration/reporting-methods/bulk-delete`
- **Purpose**: CRUD for reporting relationships (Direct, Matrix, etc.).
- **Data**: `reporting_methods` table (`name`, optional enum field via `$reportingEnumMeta`).
- **UI**:
  - Table with Name (+ optional second column) and row actions.
  - Tooling:
    - Add modal (create).
    - Edit modal (update).
    - Delete modal + bulk delete modal (delete many).
  - “Delete Selected” button with master checkbox.
- **Actions**:
  - **Create**: open Add modal, submit form (POST `store`).
  - **Edit**: click row edit → open Edit modal → POST `update`.
  - **Delete**: single delete or multi-select + bulk delete (POST `delete` / `bulk-delete`).

### 4.8 Configuration → Termination Reasons
- **Route**: `GET /pim/configuration/termination-reasons`
- **Purpose**: List termination reasons (Resignation, Retirement, etc.).
- **Data**: `termination_reasons`.
- **UI/Actions**:
  - Similar to reporting methods (list + UI for add/edit/delete). Back-end mutations follow the same pattern.

---

## 5. Leave Module

### 5.1 Apply Leave
- **Route**: `GET /leave/apply`
- **Purpose**: Show “Apply Leave” screen.
- **Data**: Currently shows a message “No Leave Types with Leave Balance” (no form yet).
- **Actions**: Informational; actual apply workflow not yet wired.

### 5.2 My Leave
- **Route**: `GET /leave/my-leave`
- **Purpose**: Logged-in employee’s leave history.
- **Data**:
  - `leave_applications` + `employees` + `leave_types`.
  - Filtered by `employee_id = 1` for now (to be replaced with real auth).
- **UI**:
  - Search panel (front-end).
  - Table: Date, Employee Name, Leave Type, No. of Days, Balance, Status, Comments.
- **Actions**:
  - Read-only list; future work: cancel/modify requests.

### 5.3 Leave List
- **Route**: `GET /leave/leave-list`
- **Purpose**: All leave records for admins/HR.
- **Data**: Same joins as `myLeave()` but without employee filter.
- **UI**:
  - Rich search panel with filters (date range, status, leave type, employee, sub-unit).
  - Currently bottom section shows “No Records Found” if DB has no data.
- **Actions**:
  - Search & read; no approval/reject buttons yet.

### 5.4 Assign Leave
- **Route**: `GET /leave/assign-leave`
- **Purpose**: HR assigns leave to an employee.
- **Data**: Form only (no DB loaded yet).
- **UI/Actions**:
  - Fields: Employee Name (typeahead text), Leave Type dropdown, From/To dates, Comments, Assign button.
  - Back-end save route not yet implemented.

### 5.5 My Entitlements
- **Route**: `GET /leave/my-entitlements`
- **Purpose**: Show logged-in employee’s entitlement balances.
- **Data**: `leave_entitlements` + `leave_types`.
- **UI/Actions**:
  - Table: Leave Type, Entitled Days, Used, Balance.
  - Read-only; entitlements managed elsewhere.

### 5.6 My Entitlements Usage Report
- **Route**: `GET /leave/my-entitlements-usage-report`
- **Purpose**: Report view of entitlements vs usage.
- **Data**: `leave_entitlements` + `leave_types` + `leave_applications`.
- **UI/Actions**:
  - Table summarising Entitled / Taken / Balance for each leave type.

### 5.7 Leave Types / Period / Work Week / Holidays
- **Routes**:
  - `GET /leave/leave-types` → `leave_types` list.
  - `GET /leave/leave-period` → shows configured `leave_periods` (currently UI-only).
  - `GET /leave/work-week` → `work_weeks` (fallback default if empty).
  - `GET /leave/holidays` → `holidays` table.
- **Purpose**:
  - Configure master data used elsewhere in Leave.
- **Actions**:
  - Today: mostly **list + filters**; UI has Add/Edit buttons, actual POST routes would be future work.

---

## 6. Time Module

### 6.1 Employee Timesheets (main Time page)
- **Route**: `GET /time`
- **Purpose**: List all timesheets for all employees.
- **Data**: `timesheets` + `employees`.
- **UI**:
  - Top tab bar with grouped menus: Timesheets / Attendance / Reports / Project Info.
  - Table: Employee, timesheet period, status.
- **Actions**:
  - View timesheets; potential future actions: edit/approve.

### 6.2 My Timesheets
- **Route**: `GET /time/my-timesheets`
- **Purpose**: Current user’s timesheet period overview.
- **Data**:
  - Latest `timesheet` for `employee_id = 1` (temporary).
  - Derived `$days` array (week days with date + name).
- **Actions**:
  - View current period and status; link to edit screen.

### 6.3 Edit My Timesheet
- **Route**: `GET /time/my-timesheets/edit`
- **Purpose**: Line-item view of a timesheet with hours per day.
- **Data**:
  - `timesheets` + `timesheet_rows` + `time_projects`.
- **UI**:
  - Grid by projects vs days; hours editable in inputs (front-end).
- **Actions**:
  - UI allows editing; save endpoint not implemented yet.

### 6.4 Attendance (My Records / Punch In-Out / Employee Records / Configuration)
- **Routes**:
  - `GET /time/attendance/my-records` → detailed punches for selected date.
  - `GET /time/attendance/punch-in-out` → UI to punch in/out.
  - `GET /time/attendance/employee-records` → summary per employee for a date.
  - `GET /time/attendance/configuration` → global flags (currently UI-only).
- **Data**:
  - All except configuration use `attendance_records` (and join `employees` for employee view).
- **Actions**:
  - My Records / Employee Records: read-only.
  - Punch In/Out: UI-level buttons; actual POST/DB writes to be wired.

### 6.5 Reports & Project Info
- **Routes**:
  - `GET /time/reports/project-reports`, `/employee-reports`, `/attendance-summary` → mostly UI shells.
  - `GET /time/project-info/customers` → `time_customers`.
  - `GET /time/project-info/projects` → `time_projects` + `time_customers` + `time_project_assignments` + `employees`.
- **Actions**:
  - Reports: future; currently static layout.
  - Project Info: list existing customers/projects (no CRUD yet).

---

## 7. Recruitment

### 7.1 Candidates
- **Route**: `GET /recruitment`
- **Purpose**: List all candidate applications.
- **Data**: `candidate_applications` + `candidates` + `vacancies` + `employees` (hiring managers).
- **Actions**:
  - View candidate name, vacancy, hiring manager, date, status.
  - Future: change status, schedule interviews.

### 7.2 Vacancies
- **Route**: `GET /recruitment/vacancies`
- **Purpose**: List job openings.
- **Data**: `vacancies` + `job_titles` + `employees` (hiring managers).
- **Actions**:
  - View vacancy: job title, hiring manager, status.
  - UI has Add/Edit-style controls; create/update/delete endpoints are future work.

---

## 8. Performance

### 8.1 Manage Reviews (Performance Home)
- **Route**: `GET /performance`
- **Purpose**: Overview of performance reviews.
- **Data**: `performance_reviews` + `employees` + `job_titles` + `performance_cycles`.
- **Actions**:
  - View each review’s employee, job, period, due date, reviewer, status.

### 8.2 My Trackers / Employee Trackers / Trackers
- **Routes**:
  - `GET /performance/my-trackers` → employee 1.
  - `GET /performance/employee-trackers` → all employees.
  - `GET /performance/trackers` → variant listing.
- **Data**: `performance_reviews` + `performance_cycles` (+ `employees` as needed).
- **Actions**:
  - Read-only trackers showing when review created/modified.

### 8.3 KPIs
- **Route**: `GET /performance/kpis`
- **Purpose**: List KPI definitions.
- **Data**: `kpis`.
- **Actions**:
  - View KPI name/description/weight; Add/Edit/Delete to be implemented.

### 8.4 My Reviews / Employee Reviews
- **Routes**:
  - `GET /performance/my-reviews` → reviews for employee 1.
  - `GET /performance/employee-reviews` → all employees.
- **Data**:
  - `performance_reviews` + `employees` + `job_titles` + `organization_units` + `performance_cycles`.
- **Actions**:
  - Read-only grid summarizing job, sub-unit, review period, due date, self-eval status, review status.

---

## 9. Directory

### 9.1 Employee Directory
- **Route**: `GET /directory`
- **Purpose**: Quick search of employees.
- **Data**: `employees` + `job_titles` + `organization_units`.
- **UI**:
  - Filters: Job Title, Location (currently static dropdown options).
  - List: employee name, job title, department; flag if profile photo exists.
- **Actions**:
  - Search and browse only.

---

## 10. Claim

### 10.1 Employee Claims List
- **Route**: `GET /claim`
- **Purpose**: View all claim requests.
- **Data**: `claim_requests` + `employees` + `claim_items` + `claim_events`.
- **Actions**:
  - Read-only: reference ID, employee name, event, description, amount, currency, status, submitted date.

### 10.2 Submit Claim
- **Route**: `GET /claim/submit`
- **Purpose**: Create a new claim.
- **Data**:
  - Events: `claim_events` (names via `pluck('name')`).
  - Currencies: static front-end list.
- **Actions**:
  - UI form (event, currency, remarks).  
  - Real POST to save claim is not yet wired.

### 10.3 My Claims
- **Route**: `GET /claim/my-claims`
- **Purpose**: Logged-in user’s own claims.
- **Data**: Same as `index()` but filtered by `employee_id = 1`.
- **Actions**:
  - View only; plus front-end filters.

### 10.4 Configuration → Events / Expense Types
- **Routes**:
  - `GET /claim/configuration/events`, `/events/add`
  - `GET /claim/configuration/expenses-types`, `/expenses-types/add`
- **Data**:
  - `claim_events`, `claim_expense_types`.
- **Actions**:
  - UI for add/edit/delete event types and expense types; back-end save/delete endpoints to be implemented.

---

## 11. Buzz

### 11.1 Buzz Feed
- **Route**: `GET /buzz?tab=recent|liked|commented`
- **Purpose**: Internal social feed / posts.
- **Data**:
  - `buzz_posts` + `users`.
  - For liked/commented tabs: `buzz_post_likes`, `buzz_post_comments`.
- **Actions**:
  - View posts with counts of likes/comments/shares.
  - Posting/liking/commenting currently not persisted (front-end only).

---

## 12. Admin

Admin module has many configuration lists. All share the same pattern:
- Top sticky tabs (`x-admin.tabs`) to switch between User, Job, Organization, Qualifications, Nationalities, Branding, and Configuration.
- Data tables built with `x-admin.data-table`.
- Row actions: Edit/Delete (most are UI-only today).

Key pages:

### 12.1 User Management
- **Route**: `GET /admin`
- **Data**: `users` + `user_roles` + `roles` + `employees`.
- **Purpose**: List login users, show username, role, employee name, status.

### 12.2 Job Titles / Pay Grades / Employment Status / Job Categories / Work Shifts
- **Routes**: `/admin/job-titles`, `/pay-grades`, `/employment-status`, `/job-categories`, `/work-shifts`
- **Data**:
  - `job_titles`, `pay_grades`, `employment_statuses`, `job_categories`, `work_shifts`.
- **Purpose**: Manage job-related master data.
- **Actions**:
  - List and potentially add/edit/remove items (forms to be wired).

### 12.3 Organization → General Info / Locations / Structure
- **Routes**: `/admin/organization/general-information`, `/locations`, `/structure`
- **Data**: `organizations`, `locations`, `organization_units`.
- **Purpose**:
  - Show company information, locations and org chart (structure page mostly UI).

### 12.4 Qualifications → Skills / Education / Licenses / Languages / Memberships
- **Routes**: `/admin/qualifications/*`
- **Data**: `qualifications` filtered by `type`.
- **Purpose**: Manage global qualification lists used by PIM/performance.

### 12.5 Nationalities / Corporate Branding / Configuration (Email, Localization, Languages, Modules, Social Auth, OAuth, LDAP)
- **Routes**: `/admin/nationalities`, `/admin/corporate-branding`, `/admin/configuration/*`
- **Data**: `nationalities`, `corporate_branding`, `email_settings`, `email_subscriptions`, `localization_settings`, `language_packages`, `enabled_modules`, `social_providers`, `oauth_clients`, `ldap_settings`.
- **Actions**:
  - List and configure system-wide settings; many save routes are still to be implemented.

---

## 13. Maintenance

### 13.1 Maintenance Auth + Tools
- **Routes**:
  - `GET/POST /maintenance/auth`
  - `GET /maintenance`
  - `GET /maintenance/purge-employee`
  - `GET /maintenance/purge-candidate`
  - `GET /maintenance/access-records`
- **Purpose**:
  - Secondary auth (maintenance password) and utilities to purge employees/candidates and view access logs.
- **Data**:
  - Purge pages mostly UI shells for now.

---

## 14. Profile

### 14.1 About (JSON API)
- **Route**: `GET /profile/about`
- **Purpose**: Provide app info for About modal.
- **Data**: Counts from `employees` plus static `company_name` and `version`.

### 14.2 Support
- **Route**: `GET /profile/support`
- **Purpose**: Static page with support/contact information.

### 14.3 Change Password
- **Route**: `GET /profile/change-password`, `POST /profile/change-password`
- **Purpose**: Allow user to change password.
- **Data**: `users.password_hash`.
- **Actions**:
  - Validate current password, set new password (controller currently just returns success; actual hash update wiring is pending).

---

## 15. What’s Implemented vs Pending

### Implemented (backed by real DB queries)
- All list pages in **Admin, PIM, Leave, Time, Recruitment, Performance, Buzz, Claim, Directory, My Info, Dashboard**.

### Pending / Partially Implemented
- Create/Update/Delete actions for most master-data tables (Admin, Leave, Time, etc.).
- Transactional create actions:
  - Add Employee (PIM).
  - Apply / Assign Leave.
  - Submit Claim / Assign Claim.
  - Time Punch In/Out.
  - Create Buzz post, like, comment.
  - Performance review lifecycle updates.

This document should be used as the **functional map**: whenever you add a feature, make sure the controller passes data from the right table, and update this file if a page’s responsibilities change.


