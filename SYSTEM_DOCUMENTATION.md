# TOAI HRM Suite - System Documentation

## 📋 Table of Contents

1. [Introduction](#introduction)
2. [System Architecture Overview](#system-architecture-overview)
3. [File Structure & Purpose](#file-structure--purpose)
4. [UI Flow & User Journey](#ui-flow--user-journey)
5. [HRM Module Workflows](#hrm-module-workflows)
6. [Technical Flow Diagrams](#technical-flow-diagrams)
7. [Database Structure](#database-structure)
8. [Authentication & Security Flow](#authentication--security-flow)

---

## Introduction

This document provides a comprehensive guide to understanding the TOAI HRM Suite system structure, file organization, UI flow, and HRM workflows. It is designed for developers, system administrators, and users who want to understand how the system works internally.

### What is TOAI HRM Suite?

TOAI HRM Suite is an enterprise-grade Human Resource Management System built with Laravel 12. It manages all aspects of human resources including employee information, leave management, time tracking, performance reviews, recruitment, and more.

---

## System Architecture Overview

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    User Browser (Frontend)                  │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐    │
│  │   HTML/CSS   │  │  JavaScript   │  │   Blade       │    │
│  │   (Views)    │  │  (app.js)     │  │  Templates   │    │
│  └──────────────┘  └──────────────┘  └──────────────┘    │
└─────────────────────────────────────────────────────────────┘
                          ↕ HTTP Requests
┌─────────────────────────────────────────────────────────────┐
│              Laravel Application (Backend)                  │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐    │
│  │   Routes     │  │ Controllers   │  │  Middleware   │    │
│  │  (web.php)   │  │  (Business    │  │ (Auth, etc.) │    │
│  │              │  │   Logic)      │  │              │    │
│  └──────────────┘  └──────────────┘  └──────────────┘    │
└─────────────────────────────────────────────────────────────┘
                          ↕ Database Queries
┌─────────────────────────────────────────────────────────────┐
│                    MySQL Database                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐    │
│  │   Users      │  │  Employees   │  │   Timesheets  │    │
│  │   Tables     │  │   Tables     │  │   Tables      │    │
│  └──────────────┘  └──────────────┘  └──────────────┘    │
└─────────────────────────────────────────────────────────────┘
```

### MVC Pattern (Model-View-Controller)

The system follows the **MVC (Model-View-Controller)** architectural pattern:

- **Model**: Database tables and data structure (MySQL)
- **View**: Blade templates (`.blade.php` files in `resources/views/`)
- **Controller**: PHP classes handling business logic (`app/Http/Controllers/`)

### Request Flow

```
1. User clicks a link/button
   ↓
2. Browser sends HTTP request to Laravel
   ↓
3. Route (web.php) matches URL to Controller method
   ↓
4. Middleware checks authentication/permissions
   ↓
5. Controller processes request (queries database, validates data)
   ↓
6. Controller returns View with data
   ↓
7. Blade template renders HTML with data
   ↓
8. Browser displays the page
```

---

## File Structure & Purpose

### Root Directory Structure

```
TOAI-HRM/
├── app/                          # Core application code
├── bootstrap/                     # Application bootstrap files
├── config/                        # Configuration files
├── database/                      # Database migrations, seeders, SQL files
├── public/                        # Publicly accessible files (entry point)
├── resources/                     # Views, CSS, JavaScript
├── routes/                        # Route definitions
├── storage/                       # Logs, cache, uploaded files
├── vendor/                        # Composer dependencies
└── .env                          # Environment configuration
```

### 1. Application Core (`app/`)

#### Controllers (`app/Http/Controllers/`)

Controllers handle HTTP requests and contain business logic:

| File | Purpose |
|------|---------|
| `Auth/LoginController.php` | Handles user login, logout, password reset |
| `DashboardController.php` | Main dashboard with analytics and widgets |
| `AdminController.php` | Admin panel - user management, job titles, organization, etc. |
| `PIMController.php` | Employee management (add, edit, delete, reports) |
| `LeaveController.php` | Leave application, approval, entitlements, configuration |
| `TimeController.php` | Timesheets, attendance, project management, reports |
| `RecruitmentController.php` | Job vacancies and candidate management |
| `MyInfoController.php` | Employee self-service portal |
| `PerformanceController.php` | Performance reviews, KPIs, trackers |
| `DirectoryController.php` | Employee directory search |
| `ClaimController.php` | Employee claims submission and approval |
| `BuzzController.php` | Social feed for announcements |
| `MaintenanceController.php` | System maintenance utilities |
| `ProfileController.php` | User profile management |

#### Middleware (`app/Http/Middleware/`)

| File | Purpose |
|------|---------|
| `AuthSession.php` | Checks if user is logged in, loads permissions |

**How it works:**
- Every protected route goes through `AuthSession` middleware
- If user is not logged in → redirects to login page
- If logged in → loads user permissions and shares with views

#### Models (`app/Models/`)

| File | Purpose |
|------|---------|
| `User.php` | User model with relationships |

### 2. Routes (`routes/`)

#### `web.php` - Main Route File

This file defines all URL endpoints and connects them to controllers:

**Route Structure:**
```php
Route::get('/url', [Controller::class, 'method'])->name('route.name');
```

**Key Route Groups:**

1. **Public Routes** (No authentication):
   - `/login` - Login page
   - `/password/forgot` - Password reset

2. **Protected Routes** (Requires authentication):
   - All routes wrapped in `Route::middleware('auth.session')->group()`
   - Includes: Dashboard, Admin, PIM, Leave, Time, etc.

3. **Maintenance Routes** (Requires double authentication):
   - `/maintenance/auth` - Additional security layer
   - `/maintenance/*` - Maintenance operations

### 3. Views (`resources/views/`)

Views are Blade templates that render HTML:

#### Layout Files

| File | Purpose |
|------|---------|
| `layouts/app.blade.php` | Main layout wrapper (header, sidebar, footer) |
| `components/sidebar.blade.php` | Navigation sidebar component |
| `components/header.blade.php` | Top header with theme toggle |
| `components/main-layout.blade.php` | Layout wrapper component |

#### Module Views

| Directory | Purpose |
|-----------|---------|
| `auth/` | Login, password reset pages |
| `dashboard/` | Main dashboard |
| `admin/` | Admin module pages (27+ files) |
| `pim/` | Employee management pages |
| `leave/` | Leave management pages |
| `time/` | Time tracking and attendance pages |
| `myinfo/` | Employee self-service pages |
| `performance/` | Performance review pages |
| `claim/` | Claims management pages |
| `buzz/` | Social feed page |
| `maintenance/` | System maintenance pages |

#### Components (`resources/views/components/`)

Reusable UI components:

| Component | Purpose |
|-----------|---------|
| `admin/*` | Admin-specific components (modals, buttons, etc.) |
| `date-picker.blade.php` | Date input component |
| `dropdown-menu.blade.php` | Dropdown navigation component |
| `records-found.blade.php` | Record count display component |

### 4. Frontend Assets (`resources/`)

#### CSS (`resources/css/`)

| File | Purpose |
|------|---------|
| `app.css` | Main stylesheet with Tailwind CSS |
| `theme.css` | Theme colors and dark mode variables |
| `global-ui.css` | Global UI components styling |
| `components.css` | Component-specific styles |

#### JavaScript (`resources/js/`)

| File | Purpose |
|------|---------|
| `app.js` | Main JavaScript file containing:
  - Theme toggle functionality
  - Sidebar collapse/expand
  - Dropdown menu handling
  - Theme color loading from database
  - Form interactions

### 5. Database (`database/`)

| File/Directory | Purpose |
|----------------|---------|
| `toai_hrm.sql` | Complete database schema (50+ tables) |
| `migrations/` | Laravel migration files for version control |
| `seeders/` | Database seeders for initial data |

**Key Database Tables:**

- `users` - System users (admin, employees)
- `employees` - Employee information
- `timesheets` - Time tracking records
- `leave_requests` - Leave applications
- `projects` - Project information
- `performance_reviews` - Performance evaluation data

### 6. Configuration (`config/`)

| File | Purpose |
|------|---------|
| `app.php` | Application configuration |
| `database.php` | Database connection settings |
| `session.php` | Session configuration |
| `auth.php` | Authentication settings |

### 7. Public Directory (`public/`)

| Directory | Purpose |
|-----------|---------|
| `build/` | Compiled CSS and JavaScript (production) |
| `storage/` | Symlink to storage/app/public (uploaded files) |
| `index.php` | Laravel entry point (all requests go through this) |

---

## UI Flow & User Journey

### 1. Initial Access Flow

```
┌─────────────────┐
│  User visits    │
│  website URL    │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Route: /       │
│  Redirects to   │
│  /login         │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Login Page     │
│  (Dark Theme)   │
│  - Username     │
│  - Password     │
│  - Remember me  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  POST /login    │
│  LoginController│
│  Validates      │
│  credentials    │
└────────┬────────┘
         │
    ┌────┴────┐
    │ Valid?  │
    └────┬────┘
    No   │   Yes
    │    │    │
    │    │    ▼
    │    │ ┌─────────────────┐
    │    │ │ Create Session  │
    │    │ │ Store user info │
    │    │ └────────┬────────┘
    │    │          │
    │    │          ▼
    │    │ ┌─────────────────┐
    │    │ │ Redirect to     │
    │    │ │ /dashboard      │
    │    │ └─────────────────┘
    │    │
    │    ▼
┌─────────────────┐
│  Show Error     │
│  Return to     │
│  Login Page     │
└─────────────────┘
```

### 2. Dashboard Flow

```
┌─────────────────┐
│  User logged in │
│  Redirected to  │
│  /dashboard     │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  AuthSession    │
│  Middleware     │
│  Checks session │
└────────┬────────┘
         │
    ┌────┴────┐
    │ Valid?  │
    └────┬────┘
    No   │   Yes
    │    │    │
    │    │    ▼
    │    │ ┌─────────────────┐
    │    │ │ Dashboard      │
    │    │ │ Controller     │
    │    │ │ Loads data:     │
    │    │ │ - Analytics     │
    │    │ │ - Charts        │
    │    │ │ - Widgets       │
    │    │ └────────┬────────┘
    │    │          │
    │    │          ▼
    │    │ ┌─────────────────┐
    │    │ │ Render Dashboard│
    │    │ │ View with data  │
    │    │ └─────────────────┘
    │    │
    │    ▼
┌─────────────────┐
│  Redirect to    │
│  /login         │
└─────────────────┘
```

### 3. Navigation Flow

```
┌─────────────────┐
│  User clicks     │
│  sidebar link    │
│  (e.g., "Leave") │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Browser sends  │
│  GET /leave     │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Route matches  │
│  web.php        │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  AuthSession    │
│  Middleware     │
│  Validates      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  LeaveController│
│  index() method │
│  Loads leave    │
│  data from DB   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Returns view:  │
│  leave.blade.php│
│  with data      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Browser        │
│  displays page  │
└─────────────────┘
```

### 4. Form Submission Flow

```
┌─────────────────┐
│  User fills form│
│  (e.g., Add     │
│   Employee)     │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  User clicks    │
│  "Save" button  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Browser sends  │
│  POST /pim/     │
│  employee-list  │
│  with form data │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Route matches  │
│  POST route     │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  PIMController  │
│  storeEmployee()│
│  Validates data │
└────────┬────────┘
         │
    ┌────┴────┐
    │ Valid?  │
    └────┬────┘
    No   │   Yes
    │    │    │
    │    │    ▼
    │    │ ┌─────────────────┐
    │    │ │ Insert into DB  │
    │    │ │ Save employee   │
    │    │ └────────┬────────┘
    │    │          │
    │    │          ▼
    │    │ ┌─────────────────┐
    │    │ │ Redirect with   │
    │    │ │ success message │
    │    │ └─────────────────┘
    │    │
    │    ▼
┌─────────────────┐
│  Return to form │
│  with errors     │
└─────────────────┘
```

---

## HRM Module Workflows

### 1. Employee Management (PIM) Workflow

**Purpose**: Manage employee information throughout their lifecycle

**Flow**:
```
1. Admin navigates to PIM → Employee List
   ↓
2. Clicks "Add Employee" button
   ↓
3. Fills employee form:
   - Personal details (name, DOB, etc.)
   - Contact information
   - Job information
   - Qualifications
   ↓
4. Submits form
   ↓
5. System validates data
   ↓
6. Creates employee record in database
   ↓
7. Employee can now:
   - Login to system
   - Access "My Info" portal
   - Apply for leave
   - Submit timesheets
```

**Key Files**:
- Controller: `PIMController.php`
- Views: `resources/views/pim/employee-list.blade.php`, `add-employee.blade.php`
- Routes: `/pim/employee-list`, `/pim/add-employee`

### 2. Leave Management Workflow

**Purpose**: Handle employee leave requests and approvals

**Employee Side**:
```
1. Employee navigates to Leave → Apply Leave
   ↓
2. Selects:
   - Leave type (Annual, Sick, etc.)
   - From date
   - To date
   - Comments
   ↓
3. Submits leave request
   ↓
4. System creates leave_requests record with status "Pending"
   ↓
5. Manager receives notification (if configured)
```

**Manager Side**:
```
1. Manager navigates to Leave → Leave List
   ↓
2. Sees pending leave requests
   ↓
3. Clicks "Approve" or "Reject"
   ↓
4. System updates leave_requests status
   ↓
5. Employee sees updated status in "My Leave"
```

**Key Files**:
- Controller: `LeaveController.php`
- Views: `resources/views/leave/apply.blade.php`, `leave-list.blade.php`
- Routes: `/leave/apply`, `/leave/leave-list`, `/leave/{action}/{id}`

### 3. Time Tracking Workflow

**Purpose**: Track employee work hours and attendance

**Timesheet Entry**:
```
1. Employee navigates to Time → My Timesheets
   ↓
2. Selects date range
   ↓
3. Adds timesheet entries:
   - Project
   - Activity
   - Hours worked
   - Date
   ↓
4. Submits timesheet
   ↓
5. Manager reviews and approves
```

**Attendance (Punch In/Out)**:
```
1. Employee navigates to Time → Attendance → My Records
   ↓
2. Clicks "Punch In" button
   ↓
3. System records:
   - Date and time
   - Location (if GPS enabled)
   ↓
4. Employee clicks "Punch Out" at end of day
   ↓
5. System calculates total hours
```

**Key Files**:
- Controller: `TimeController.php`
- Views: `resources/views/time/my-timesheets.blade.php`, `attendance/my-records.blade.php`
- Routes: `/time/my-timesheets`, `/time/attendance/my-records`

### 4. Performance Review Workflow

**Purpose**: Evaluate employee performance

**Flow**:
```
1. HR/Manager creates performance review cycle
   ↓
2. Assigns review to employee
   ↓
3. Employee fills self-evaluation:
   - Goals achieved
   - Strengths
   - Areas for improvement
   ↓
4. Manager reviews and adds comments
   ↓
5. Final review submitted
   ↓
6. Both employee and manager can view completed review
```

**Key Files**:
- Controller: `PerformanceController.php`
- Views: `resources/views/performance/my-reviews.blade.php`, `employee-reviews.blade.php`
- Routes: `/performance/my-reviews`, `/performance/employee-reviews`

### 5. Recruitment Workflow

**Purpose**: Manage job vacancies and candidates

**Flow**:
```
1. HR creates job vacancy:
   - Job title
   - Description
   - Requirements
   - Closing date
   ↓
2. Vacancy published (visible to candidates)
   ↓
3. Candidates apply (external process)
   ↓
4. HR reviews applications
   ↓
5. HR schedules interviews
   ↓
6. HR updates candidate status:
   - Shortlisted
   - Interviewed
   - Hired
   - Rejected
```

**Key Files**:
- Controller: `RecruitmentController.php`
- Views: `resources/views/recruitment/vacancies.blade.php`
- Routes: `/recruitment/vacancies`

---

## Technical Flow Diagrams

### Authentication Flow

```
┌──────────────┐
│   Browser    │
└──────┬───────┘
       │ GET /login
       ▼
┌──────────────┐
│   Route      │
│  web.php     │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ LoginController│
│   show()     │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│  View:       │
│ login.blade  │
│  .php        │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ User enters  │
│ credentials  │
└──────┬───────┘
       │ POST /login
       ▼
┌──────────────┐
│ LoginController│
│ authenticate()│
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Query DB:    │
│ Check user   │
│ credentials  │
└──────┬───────┘
       │
   ┌───┴───┐
   │ Valid?│
   └───┬───┘
   No  │  Yes
   │   │   │
   │   │   ▼
   │   │ ┌──────────────┐
   │   │ │ Create       │
   │   │ │ Session:     │
   │   │ │ auth_user    │
   │   │ └──────┬───────┘
   │   │        │
   │   │        ▼
   │   │ ┌──────────────┐
   │   │ │ Redirect to  │
   │   │ │ /dashboard   │
   │   │ └──────────────┘
   │   │
   │   ▼
┌──────────────┐
│ Return error │
│ to login     │
└──────────────┘
```

### Protected Route Flow

```
┌──────────────┐
│ User visits  │
│ protected    │
│ route        │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Route checks │
│ middleware   │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ AuthSession  │
│ Middleware   │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Check session│
│ for auth_user │
└──────┬───────┘
       │
   ┌───┴───┐
   │Exists? │
   └───┬───┘
   No  │  Yes
   │   │   │
   │   │   ▼
   │   │ ┌──────────────┐
   │   │ │ Load user    │
   │   │ │ permissions  │
   │   │ └──────┬───────┘
   │   │        │
   │   │        ▼
   │   │ ┌──────────────┐
   │   │ │ Share with   │
   │   │ │ views        │
   │   │ └──────┬───────┘
   │   │        │
   │   │        ▼
   │   │ ┌──────────────┐
   │   │ │ Continue to  │
   │   │ │ Controller   │
   │   │ └──────────────┘
   │   │
   │   ▼
┌──────────────┐
│ Redirect to  │
│ /login       │
└──────────────┘
```

### Theme System Flow

```
┌──────────────┐
│ Page loads   │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ app.blade.php│
│ Head script  │
│ runs first   │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Check        │
│ localStorage │
│ for theme    │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Set data-    │
│ theme attr   │
│ on <html>    │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Fetch theme  │
│ colors from  │
│ database     │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Apply CSS    │
│ variables    │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Page renders │
│ with theme   │
└──────────────┘
```

---

## Database Structure

### Key Tables Overview

| Table | Purpose | Key Fields |
|-------|---------|------------|
| `users` | System users | id, username, password_hash, is_active, page_permissions |
| `employees` | Employee information | id, employee_id, first_name, last_name, email, job_title_id |
| `timesheets` | Time tracking | id, employee_id, status, period_start, period_end |
| `timesheet_entries` | Individual time entries | id, timesheet_id, project_id, work_date, hours |
| `leave_requests` | Leave applications | id, employee_id, leave_type_id, from_date, to_date, status |
| `leave_types` | Leave type configuration | id, name, entitlement_days |
| `time_projects` | Project information | id, name, customer_id, start_date, end_date |
| `performance_reviews` | Performance evaluations | id, employee_id, review_period, status |
| `job_titles` | Job positions | id, name, description |
| `organizations` | Company information | id, name, address |

### Relationships

- **Users** → **Employees**: One user can be linked to one employee
- **Employees** → **Timesheets**: One employee has many timesheets
- **Timesheets** → **Timesheet Entries**: One timesheet has many entries
- **Employees** → **Leave Requests**: One employee has many leave requests
- **Projects** → **Timesheet Entries**: One project has many time entries

---

## Authentication & Security Flow

### Session Management

1. **Login Process**:
   - User enters credentials
   - System validates against `users` table
   - Creates session with `auth_user` data
   - Session stored in database (configurable)

2. **Session Validation**:
   - Every protected route checks session via `AuthSession` middleware
   - If session expired → redirect to login
   - If valid → continue to controller

3. **Logout Process**:
   - Clears session data
   - Invalidates session
   - Redirects to login page

### Permission System

**User Roles**:
- **Admin**: Full access to all modules
- **ESS (Employee Self-Service)**: Limited access, mainly "My Info"

**Permission Storage**:
- Stored in `users.page_permissions` as JSON
- Format: `{"module": ["action1", "action2"]}`
- Example: `{"pim": ["view", "edit"], "leave": ["view"]}`

**Permission Check**:
- Middleware loads permissions
- Shared with views via `view()->share()`
- Sidebar shows/hides menu items based on permissions

---

## Common Development Tasks

### Adding a New Page

1. **Create Route** (`routes/web.php`):
   ```php
   Route::get('/new-page', [Controller::class, 'method'])->name('new.page');
   ```

2. **Add Controller Method** (`app/Http/Controllers/Controller.php`):
   ```php
   public function method() {
       $data = DB::table('table')->get();
       return view('module.new-page', compact('data'));
   }
   ```

3. **Create View** (`resources/views/module/new-page.blade.php`):
   ```blade
   @extends('layouts.app')
   @section('title', 'New Page')
   @section('body')
       <x-main-layout title="New Page">
           <!-- Content here -->
       </x-main-layout>
   @endsection
   ```

4. **Add Sidebar Link** (`resources/views/components/sidebar.blade.php`):
   ```blade
   <a href="{{ route('new.page') }}">New Page</a>
   ```

### Adding a New Form

1. **Create Form Route** (GET):
   ```php
   Route::get('/form', [Controller::class, 'showForm'])->name('form.show');
   ```

2. **Create Submit Route** (POST):
   ```php
   Route::post('/form', [Controller::class, 'submitForm'])->name('form.submit');
   ```

3. **Controller Methods**:
   ```php
   public function showForm() {
       return view('module.form');
   }
   
   public function submitForm(Request $request) {
       $data = $request->validate([...]);
       DB::table('table')->insert($data);
       return redirect()->route('form.show')->with('status', 'Saved!');
   }
   ```

4. **View with Form**:
   ```blade
   <form method="POST" action="{{ route('form.submit') }}">
       @csrf
       <!-- Form fields -->
       <button type="submit">Submit</button>
   </form>
   ```

---

## Troubleshooting Guide

### Common Issues

1. **"Session Expired" Error**:
   - Check `config/session.php` settings
   - Verify database session table exists
   - Check session lifetime configuration

2. **Theme Not Loading**:
   - Check `resources/js/app.js` theme functions
   - Verify theme colors in database
   - Check browser console for errors

3. **Page Not Found (404)**:
   - Verify route exists in `routes/web.php`
   - Check route name matches
   - Clear route cache: `php artisan route:clear`

4. **Database Connection Error**:
   - Check `.env` file database settings
   - Verify MySQL service is running
   - Test connection: `php artisan migrate:status`

5. **Permission Denied**:
   - Check user permissions in `users` table
   - Verify middleware is checking permissions
   - Check `page_permissions` JSON format

---

## Quick Reference

### Important URLs

- **Login**: `/login`
- **Dashboard**: `/dashboard`
- **Admin**: `/admin`
- **PIM**: `/pim`
- **Leave**: `/leave`
- **Time**: `/time`

### Important Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Start server
php artisan serve
```

### Key Configuration Files

- `.env` - Environment variables (database, app settings)
- `config/session.php` - Session configuration
- `config/database.php` - Database connection
- `routes/web.php` - All application routes

---

## Conclusion

This documentation provides a comprehensive overview of the TOAI HRM Suite system structure, file organization, UI flow, and HRM workflows. Use this as a reference when:

- Understanding how the system works
- Adding new features
- Debugging issues
- Onboarding new developers
- Explaining system to stakeholders

For specific implementation details, refer to the actual code files mentioned in each section.

---

**Last Updated**: 2026
**Version**: 1.0
**Maintained By**: TOAI HRM Development Team

