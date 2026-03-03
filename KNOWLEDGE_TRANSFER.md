# 📚 TOAI HRM Suite - Knowledge Transfer Document

**Project Name**: TOAI HRM Suite - Professional Edition  
**Version**: 1.0  
**Last Updated**: January 2026  
**Prepared By**: Development Team  
**Document Purpose**: Complete knowledge transfer for new team members, developers, and stakeholders

---

## 📂 Project Overview

### What is TOAI HRM Suite?

TOAI HRM Suite is an **enterprise-grade Human Resource Management System** built with Laravel 12. It is a comprehensive solution for managing all aspects of human resources including:

- **Employee Information Management** (PIM) - Complete employee lifecycle management
- **Leave Management** - Apply, approve, track, and manage employee leave
- **Time & Attendance Tracking** - Timesheets, punch in/out, project time tracking
- **Performance Management** - Reviews, KPIs, trackers, and evaluations
- **Recruitment** - Vacancy posting and candidate management
- **Claims Management** - Expense claims submission and approval workflow
- **Employee Self-Service Portal** (My Info) - Personal information management
- **Administrative Functions** - User management, system configuration, organization structure
- **Buzz Feed** - Social feed for company announcements and interactions
- **Directory** - Employee directory with search and filtering

### Key Characteristics

- **Technology Stack**: Laravel 12, PHP 8.2+, MySQL, Tailwind CSS 4.x
- **Architecture**: MVC (Model-View-Controller) pattern with component-based design
- **UI Theme**: Professional lavender/purple theme with complete dark mode support
- **Database**: MySQL with utf8mb4 encoding, 50+ tables, 3NF normalization
- **Authentication**: Custom session-based authentication with role-based access control
- **Responsive**: Mobile-friendly design with breakpoint optimization
- **Production Ready**: Pre-built assets, no npm required for production deployment

### Project Location

- **Local Development**: `C:\xampp\htdocs\TOAI-HRM` (Windows/XAMPP)
- **Production**: Configured via `.env` file
- **Repository**: (Add Git repository URL if applicable)

### Project Status

- ✅ **Core Features**: Fully implemented and functional
- ✅ **Authentication**: Custom session-based middleware working
- ✅ **All Modules**: 12+ modules fully functional
- ✅ **Database**: Complete schema with 50+ tables
- ⚠️ **Known Issues**: See section below
- 🔄 **Maintenance**: Active development

### System Architecture

**MVC Pattern Implementation:**
- **Models**: `app/Models/` - Data logic and database interactions
- **Views**: `resources/views/` - Blade templates with component system
- **Layout**: `resources/views/layouts/app.blade.php` - Base HTML layout (head, assets, body sections)
- **Controllers**: `app/Http/Controllers/` - HTTP request handling
- **Routes**: `routes/web.php` - RESTful URL endpoints (318+ routes)
- **Components**: `app/Components/` - Reusable Blade components with PHP backing
- **Middleware**: `app/Http/Middleware/AuthSession.php` - Custom authentication

---

## 🛠 Tools & Technologies Used

### Backend Technologies

| Technology | Version | Purpose |
|------------|---------|---------|
| **PHP** | 8.2+ | Server-side programming language |
| **Laravel Framework** | 12.x | MVC framework for web application |
| **MySQL/MariaDB** | Latest | Relational database management system |
| **Composer** | Latest | PHP dependency manager |

### Frontend Technologies

| Technology | Version | Purpose |
|------------|---------|---------|
| **Tailwind CSS** | 4.x | Utility-first CSS framework |
| **JavaScript (Vanilla)** | ES6+ | Client-side interactivity (no jQuery) |
| **Vite** | 7.x | Build tool and dev server with HMR |
| **Blade Templates** | Laravel | Server-side templating engine |
| **Lucide Icons** | Latest | Modern icon library |

### Development Tools

| Tool | Purpose |
|------|---------|
| **XAMPP** | Local development environment (Apache, MySQL, PHP) |
| **phpMyAdmin** | Database management interface |
| **Git** | Version control system |
| **VS Code / PHPStorm** | Code editor/IDE |
| **Laravel Tinker** | Interactive REPL for Laravel |
| **Laravel Pint** | PHP code formatter (PSR-12) |

### Key Packages & Dependencies

**PHP Packages (composer.json):**
- `laravel/framework: ^12.0` - Core Laravel framework
- `laravel/tinker: ^2.10.1` - Interactive shell
- `laravel/pint: ^1.24` - Code formatter
- `phpunit/phpunit: ^11.5.3` - Testing framework

**JavaScript Packages (package.json):**
- `tailwindcss: ^4.0.0` - CSS framework
- `vite: ^7.0.7` - Build tool
- `axios: ^1.11.0` - HTTP client
- `laravel-vite-plugin: ^2.0.0` - Laravel Vite integration
- `@tailwindcss/vite: ^4.0.0` - Tailwind Vite plugin

### System Requirements

**Server Requirements:**
- PHP >= 8.2 with extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath
- MySQL >= 5.7 or MariaDB >= 10.3
- Apache/Nginx web server (or Laravel built-in server)
- Composer installed globally

**Development Requirements:**
- Node.js >= 18.x (for asset compilation)
- NPM >= 9.x
- Git (for version control)

**Production Requirements:**
- PHP >= 8.2
- MySQL/MariaDB
- Web server (Apache/Nginx)
- Composer (for dependency management)
- ⚠️ **Note**: NPM is NOT required for production (pre-built assets included)

---

## 🔐 Access Details

### Application Access

**Local Development URL:**
```
http://127.0.0.1:8000
http://localhost:8000
```

**XAMPP Access:**
```
http://localhost/TOAI-HRM/public
```

**Login Credentials** (Default Admin):
- **Username**: `admin`
- **Password**: `admin123`

⚠️ **CRITICAL SECURITY NOTE**: Change default password in production immediately!

### Database Access

**Database Configuration** (`.env` file):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toai_hrm
DB_USERNAME=root
DB_PASSWORD=        # Empty for XAMPP default
```

**phpMyAdmin Access:**
- URL: `http://localhost/phpmyadmin`
- Username: `root`
- Password: (Empty for XAMPP default)

**Database Schema:**
- Location: `database/toai_hrm.sql`
- Import via: phpMyAdmin or MySQL command line
- Character Set: utf8mb4
- Collation: utf8mb4_unicode_ci
- Engine: InnoDB

### File System Access

**Important Directories:**
- **Project Root**: `C:\xampp\htdocs\TOAI-HRM`
- **Views**: `resources/views/`
- **Controllers**: `app/Http/Controllers/`
- **Models**: `app/Models/`
- **Routes**: `routes/web.php`
- **Database**: `database/toai_hrm.sql`
- **Public Assets**: `public/`
- **Storage**: `storage/app/public/` (linked to `public/storage/`)
- **Logs**: `storage/logs/laravel.log`
- **Components**: `app/Components/`

### Environment Configuration

**`.env` File Location**: Root directory (`C:\xampp\htdocs\TOAI-HRM\.env`)

**Key Environment Variables:**
```env
APP_NAME="TOAI HRM Suite"
APP_ENV=local                    # Use 'production' for production
APP_KEY=base64:...              # Generated via `php artisan key:generate`
APP_DEBUG=true                   # Set to 'false' in production
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toai_hrm
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120             # Session timeout in minutes
```

### SSH/Server Access (Production)

**Production Server Details**: (To be configured)
- **Host**: (Add production server IP/hostname)
- **SSH Port**: (Default: 22)
- **Username**: (Server username)
- **Database Host**: (Production DB host)
- **Database Name**: `toai_hrm`

⚠️ **Security Note**: Never commit `.env` file to version control! It's already in `.gitignore`.

### Authentication System

**Session-Based Authentication:**
- Middleware: `app/Http/Middleware/AuthSession.php`
- Session Storage: Database driver
- Session Lifetime: Configurable via `SESSION_LIFETIME` in `.env`
- Role-Based Access: Admin/ESS roles with page-level permissions
- Maintenance Auth: Additional authentication layer for maintenance operations

**User Roles:**
- **Admin**: Full system access
- **ESS (Employee Self-Service)**: Limited access based on page permissions
- **Main User**: Bypasses page permission checks

---

## 📊 Daily Tasks & Responsibilities

### For Developers

#### Morning Routine

1. **Check Application Status**
   ```bash
   # Verify server is running
   php artisan serve
   
   # Check database connection
   php artisan migrate:status
   
   # Check for errors in logs
   tail -f storage/logs/laravel.log
   ```

2. **Review Pending Tasks**
   - Check issue tracker (if applicable)
   - Review code changes from previous day
   - Check for any error logs in `storage/logs/`
   - Review TODO items in codebase

3. **Pull Latest Changes** (if using Git)
   ```bash
   git pull origin main
   composer install
   npm install  # Only if working on frontend
   ```

#### Development Tasks

**Common Development Workflows:**

1. **Adding a New Feature:**
   ```
   Step 1: Create route in routes/web.php
   Step 2: Add controller method in appropriate controller
   Step 3: Create/update view in resources/views/
   Step 4: Add component if reusable (app/Components/)
   Step 5: Test functionality
   Step 6: Update documentation
   ```

2. **Fixing a Bug:**
   ```
   Step 1: Reproduce the issue
   Step 2: Identify root cause (check logs, database, code)
   Step 3: Fix the issue
   Step 4: Test the fix thoroughly
   Step 5: Document the fix
   ```

3. **Database Changes:**
   ```bash
   # Create migration
   php artisan make:migration add_column_to_table
   
   # Edit migration file in database/migrations/
   
   # Run migration
   php artisan migrate
   
   # Update related models/controllers if needed
   ```

4. **UI Changes:**
   ```bash
   # Modify Blade templates in resources/views/
   # Update CSS in resources/css/app.css
   # Rebuild assets for production
   npm run build
   
   # OR for development with hot reload
   npm run dev
   ```

5. **Adding a New Module:**
   ```
   Step 1: Create controller in app/Http/Controllers/
   Step 2: Add routes in routes/web.php
   Step 3: Create views in resources/views/{module}/
   Step 4: Add sidebar menu item in resources/views/components/sidebar.blade.php
   Step 5: Update middleware permissions if needed
   Step 6: Test all CRUD operations
   ```

#### End of Day Routine

1. **Commit Changes** (if using Git)
   ```bash
   git add .
   git commit -m "Description of changes"
   git push origin main
   ```

2. **Clear Caches** (if needed)
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Document Changes**
   - Update changelog if applicable
   - Note any issues encountered
   - Update this KT document if significant changes

### For System Administrators

#### Daily Tasks

1. **System Health Check**
   - Verify application is accessible
   - Check database connectivity
   - Review error logs: `storage/logs/laravel.log`
   - Monitor server resources (CPU, memory, disk)
   - Check session table size (cleanup if needed)

2. **User Management**
   - Create new user accounts (Admin → Users)
   - Reset passwords if requested
   - Manage user permissions (page-level access)
   - Deactivate inactive users
   - Review access logs

3. **Data Backup**
   ```bash
   # Daily backup (recommended)
   mysqldump -u root -p toai_hrm > backup_$(date +%Y%m%d).sql
   
   # Backup uploaded files
   tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public/
   ```

4. **System Maintenance**
   - Clear old session data (if needed)
   - Monitor storage space
   - Review access records
   - Check for failed jobs (if using queue)

#### Weekly Tasks

1. **Performance Review**
   - Check slow queries
   - Review application logs
   - Optimize database if needed
   - Check for missing indexes

2. **Security Audit**
   - Review user access logs
   - Check for suspicious activities
   - Update passwords if needed
   - Review file uploads for security

3. **Data Cleanup**
   - Archive old records (if applicable)
   - Clean temporary files
   - Optimize database tables

### For HR Administrators

#### Daily Tasks

1. **Employee Management**
   - Add new employees (PIM → Employee List → Add Employee)
   - Update employee information
   - Process employee terminations
   - Manage employee photos and documents

2. **Leave Management**
   - Review pending leave requests (Leave → Leave List)
   - Approve/Reject leave applications
   - Assign leave entitlements (Leave → Assign Leave)
   - Configure holidays (Leave → Holidays)

3. **Time Tracking**
   - Review timesheet submissions (Time → Timesheets)
   - Approve/Reject timesheets
   - Monitor attendance records
   - Manage projects and customers (Time → Project Info)

4. **Reports Generation**
   - Generate employee reports (PIM → Reports)
   - Generate attendance reports (Time → Reports)
   - Generate leave reports (Leave → Reports)
   - Export data for analysis

#### Weekly Tasks

1. **Performance Reviews**
   - Create performance review cycles
   - Assign reviews to employees
   - Review completed evaluations
   - Track KPIs and goals

2. **Recruitment**
   - Post new job vacancies
   - Review candidate applications
   - Update candidate status
   - Schedule interviews

3. **Configuration**
   - Update leave types if needed
   - Configure holidays
   - Update organization structure
   - Manage job titles and pay grades

### For Employees (End Users)

#### Daily Tasks

1. **Attendance**
   - Punch In at start of day (Time → Attendance → Punch In/Out)
   - Punch Out at end of day
   - View attendance records (Time → Attendance → My Records)

2. **Timesheet Entry**
   - Log work hours (Time → My Timesheets)
   - Add project and activity details
   - Submit timesheet for approval

3. **Leave Management**
   - Apply for leave (Leave → Apply Leave)
   - Check leave balance (Leave → My Leave)
   - View leave history and status

4. **Profile Updates**
   - Update personal information (My Info → Personal Details)
   - Update contact details (My Info → Contact Details)
   - Upload documents (My Info → Attachments)
   - Update qualifications (My Info → Qualifications)

5. **Social Feed**
   - View company announcements (Buzz)
   - Like and comment on posts
   - Share posts if permitted

---

## 🧠 Important Issues / Known Bugs

### Critical Issues

**None Currently Known**

All critical bugs have been resolved. The system is stable and production-ready.

### Known Bugs & Workarounds

#### 1. **Session Expiration Issue**
- **Description**: Users may experience "Session Expired" error after inactivity
- **Impact**: Medium - Users need to re-login
- **Workaround**: Increase `SESSION_LIFETIME` in `.env` file (default: 120 minutes)
- **Fix**: Already implemented - session lifetime configurable
- **Location**: `config/session.php`, `.env` file
- **Status**: ✅ **RESOLVED** - Configurable session timeout

#### 2. **Theme Flicker on Login Page**
- **Description**: Login page briefly shows light theme before switching to dark
- **Impact**: Low - Visual only, no functional impact
- **Status**: ✅ **FIXED** - Theme now loads in `<head>` before page render
- **Location**: `resources/views/layouts/app.blade.php`

#### 3. **Database Column Missing Error**
- **Description**: Error "Unknown column 'updated_at' in 'field list'" for `time_project_assignments` table
- **Impact**: High - Prevents project updates
- **Status**: ✅ **FIXED** - Removed `updated_at` from update query
- **Location**: `app/Http/Controllers/TimeController.php` → `updateProject()` method
- **Note**: Table schema doesn't include `updated_at` column

#### 4. **Project Reports Showing "No Project" Entries**
- **Description**: Project reports page showing entries with "No Project" even when filtering
- **Impact**: Medium - Data accuracy issue
- **Status**: ✅ **FIXED** - Added `whereNotNull('timesheet_entries.project_id')` filter
- **Location**: `app/Http/Controllers/TimeController.php` → `projectReports()` method

#### 5. **Search Panel Not Working on Project Reports**
- **Description**: Project name and date range search not filtering correctly
- **Impact**: Medium - Functionality issue
- **Status**: ✅ **FIXED** - Updated search logic to filter by `work_date` instead of project date range
- **Location**: `app/Http/Controllers/TimeController.php` → `projectReports()` method

### TODO Items (Future Enhancements)

#### 1. **Authentication Integration**
- **Location**: `app/Http/Controllers/BuzzController.php:125`
- **TODO**: Get user ID from auth when wired (currently using session fallback)
- **Current Workaround**: Using `session('auth_user')['id'] ?? 1`
- **Priority**: Low - System works with current session-based approach

#### 2. **Leave Controller Enhancements**
- **Location**: `app/Http/Controllers/LeaveController.php:634, 681`
- **TODO**: Resolve employee_id from logged-in user when auth is fully wired
- **Current Workaround**: Using session-based user identification
- **Priority**: Low - Functionality is working

#### 3. **Recruitment Module**
- **Location**: `resources/views/recruitment/recruitment.blade.php:698`
- **TODO**: Fetch candidate details via AJAX and populate modal
- **Priority**: Medium - Feature enhancement

### Performance Considerations

1. **Database Queries**
   - Some reports may be slow with large datasets
   - Consider adding indexes for frequently queried columns
   - Use eager loading for relationships (`with()` method)
   - Monitor slow query log

2. **Asset Loading**
   - Production: Use `npm run build` for optimized assets
   - Development: Use `npm run dev` for hot reload
   - Pre-built assets available in `public/build/`

3. **Session Storage**
   - Currently using database driver
   - Consider Redis for better performance in production
   - Clean up old sessions periodically

4. **File Uploads**
   - Monitor `storage/app/public/` directory size
   - Implement file cleanup for old uploads
   - Consider cloud storage (S3) for production

### Security Considerations

1. **Default Credentials**
   - ⚠️ **CRITICAL**: Change default admin password in production
   - Location: Database `users` table
   - Action Required: Update password immediately after deployment

2. **CSRF Protection**
   - All forms must include `@csrf` token
   - Already implemented in all forms
   - Verify on new form additions

3. **SQL Injection**
   - Using Laravel's Query Builder/Eloquent (parameterized queries)
   - No raw SQL queries without parameter binding
   - Always use Eloquent or Query Builder methods

4. **XSS Protection**
   - Blade templates auto-escape output
   - Use `{!! !!}` only when necessary and data is sanitized
   - Validate all user inputs

5. **File Upload Security**
   - Validate file types and sizes
   - Store uploads outside public directory when possible
   - Scan uploads for malware (consider antivirus integration)

6. **Session Security**
   - Session regeneration on login
   - Secure session cookies (HTTPS in production)
   - Session timeout configuration

---

## 📄 Documentation & Workflows

### Available Documentation

1. **README.md**
   - Project setup instructions
   - Installation guide
   - Feature list
   - Quick start guide
   - Technology stack details

2. **SYSTEM_DOCUMENTATION.md**
   - Complete system architecture
   - File structure explanation
   - UI flow diagrams
   - HRM module workflows
   - Technical flow diagrams
   - Troubleshooting guide

3. **KNOWLEDGE_TRANSFER.md** (This Document)
   - Project overview
   - Tools & technologies
   - Access details
   - Daily tasks
   - Known issues
   - Workflows

### Key Workflows

#### 1. Employee Onboarding Workflow

```
Step 1: Admin creates user account
  → Admin → Users → Add User
  → Enter username, password, role (Admin/ESS)
  → Set page permissions if ESS role

Step 2: Admin adds employee record
  → PIM → Employee List → Add Employee
  → Fill personal details, job information, etc.
  → Upload employee photo (optional)

Step 3: Link user to employee (if needed)
  → Update users table to link user_id to employee_id
  → Or use employee_id field in users table

Step 4: Employee can now login
  → Employee logs in with credentials
  → Accesses "My Info" portal
  → Can apply for leave, submit timesheets, etc.
```

#### 2. Leave Application & Approval Workflow

```
Employee Side:
  1. Employee → Leave → Apply Leave
  2. Select leave type, dates, add comments
  3. Submit request
  4. Status: "Pending"

Manager/Admin Side:
  1. Manager → Leave → Leave List
  2. View pending requests (filter by status)
  3. Click "Approve" or "Reject"
  4. Add comments if rejecting
  5. System updates status and notifies employee

Employee Notification:
  1. Employee sees updated status in "My Leave"
  2. Leave balance updated if approved
  3. Can view approval/rejection comments
```

#### 3. Timesheet Submission Workflow

```
Employee Side:
  1. Employee → Time → My Timesheets
  2. Select date range
  3. Add entries:
     - Project (from Project Info)
     - Activity
     - Hours
     - Date
  4. Submit timesheet
  5. Status: "Submitted"

Manager Side:
  1. Manager → Time → Timesheets
  2. View submitted timesheets
  3. Review entries
  4. Click "Approve" or "Reject"
  5. System updates status
  6. Employee can view status update
```

#### 4. Project Management Workflow

```
Step 1: Create Customer
  → Time → Project Info → Customers → Add Customer
  → Enter customer name, details

Step 2: Create Project
  → Time → Project Info → Projects → Add Project
  → Select customer, enter project name, date range
  → Assign project admin
  → Set project status (Active/Inactive)

Step 3: Assign Employees to Project
  → Time → Project Info → Projects → Assign Employees
  → Select employees who can log time to this project

Step 4: Employees log time
  → Time → My Timesheets
  → Select project and activity
  → Log hours

Step 5: Generate Reports
  → Time → Reports → Project Reports
  → Filter by project, date range
  → View time allocation by project
```

#### 5. Performance Review Workflow

```
Step 1: HR creates review cycle
  → Performance → Trackers → Create Tracker
  → Define review period, goals, KPIs

Step 2: Assign to employee
  → Performance → Employee Reviews
  → Assign review to employee
  → Set review dates

Step 3: Employee self-evaluation
  → Performance → My Reviews
  → Fill self-evaluation form
  → Submit for manager review

Step 4: Manager evaluation
  → Performance → Employee Reviews
  → Review employee self-evaluation
  → Add manager comments and ratings
  → Finalize review

Step 5: Both can view completed review
  → Performance → My Reviews / Employee Reviews
  → View final review with ratings and comments
```

#### 6. Claim Submission & Approval Workflow

```
Employee Side:
  1. Employee → Claim → Submit Claim
  2. Select event type, expense type
  3. Enter amount, date, description
  4. Attach receipts (if applicable)
  5. Submit for approval

Manager Side:
  1. Manager → Claim → My Claims / Claim List
  2. View pending claims
  3. Review details and attachments
  4. Approve/Reject/Cancel claim
  5. Add comments if needed

Employee Notification:
  1. Employee sees updated status
  2. Can view approval/rejection comments
  3. Approved claims reflected in reports
```

### Database Workflows

#### Database Backup Workflow

```bash
# Daily backup (recommended)
mysqldump -u root -p toai_hrm > backup_$(date +%Y%m%d).sql

# Weekly backup with compression
mysqldump -u root -p toai_hrm | gzip > backup_$(date +%Y%m%d).sql.gz

# Restore from backup
mysql -u root -p toai_hrm < backup_20260217.sql

# Restore from compressed backup
gunzip < backup_20260217.sql.gz | mysql -u root -p toai_hrm
```

#### Database Migration Workflow

```bash
# Create new migration
php artisan make:migration add_column_to_table

# Edit migration file in database/migrations/

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# Check migration status
php artisan migrate:status

# Fresh migration (drops all tables and re-runs)
php artisan migrate:fresh
```

#### Database Schema Updates

```bash
# If database schema changes are made directly in SQL:
# 1. Export current schema
mysqldump -u root -p --no-data toai_hrm > schema_backup.sql

# 2. Make changes in database
# 3. Create migration to reflect changes
php artisan make:migration update_schema_changes

# 4. Or update toai_hrm.sql file for new installations
```

### Deployment Workflow

#### Development to Production

```
1. Test all changes locally
2. Run tests (if available): php artisan test
3. Build production assets: npm run build
4. Set APP_ENV=production in .env
5. Set APP_DEBUG=false in .env
6. Clear and cache config:
   php artisan config:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
7. Deploy files to production server
8. Run migrations: php artisan migrate --force
9. Set proper file permissions:
   chmod -R 755 storage bootstrap/cache
10. Verify application is working
11. Monitor logs for errors: tail -f storage/logs/laravel.log
```

#### Production Maintenance

```bash
# Put application in maintenance mode
php artisan down

# Perform maintenance tasks
# (database updates, file changes, etc.)

# Bring application back online
php artisan up

# Clear all caches
php artisan optimize:clear
```

### Troubleshooting Workflows

#### Application Not Loading

```
1. Check if server is running: php artisan serve
2. Check database connection: php artisan migrate:status
3. Check .env file configuration
4. Clear caches:
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
5. Check error logs: storage/logs/laravel.log
6. Check file permissions:
   - storage/ and bootstrap/cache/ should be writable
7. Verify APP_KEY is set: php artisan key:generate
```

#### Database Connection Issues

```
1. Verify MySQL service is running
2. Check .env file database credentials
3. Test connection:
   mysql -u root -p
   USE toai_hrm;
4. Verify database exists:
   SHOW DATABASES;
5. Check Laravel config:
   php artisan config:clear
   php artisan config:cache
6. Verify database user has proper permissions
```

#### Theme/UI Issues

```
1. Clear browser cache (Ctrl+Shift+Delete)
2. Rebuild assets: npm run build
3. Check browser console for errors (F12)
4. Verify theme colors in database:
   SELECT * FROM theme_colors;
5. Check app.js for theme functions
6. Verify CSS file is loading: Check Network tab
7. Check if storage link exists: php artisan storage:link
```

#### Session Issues

```
1. Check session driver in .env: SESSION_DRIVER=database
2. Verify sessions table exists: php artisan migrate
3. Clear old sessions:
   DELETE FROM sessions WHERE last_activity < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY));
4. Check session lifetime: SESSION_LIFETIME in .env
5. Verify session middleware is applied to routes
```

### Code Change Workflow

#### Adding a New Feature

```
1. Create feature branch (if using Git): git checkout -b feature/new-feature
2. Add route in routes/web.php
3. Create/update controller method
4. Create/update view file
5. Add component if reusable
6. Test functionality thoroughly
7. Update documentation
8. Commit changes: git commit -m "Add new feature"
9. Push to repository: git push origin feature/new-feature
10. Create pull request (if applicable)
11. Merge to main branch after review
```

#### Fixing a Bug

```
1. Reproduce the bug
2. Identify root cause:
   - Check logs: storage/logs/laravel.log
   - Check database
   - Review code
   - Use debugger if needed
3. Create fix
4. Test the fix thoroughly
5. Test edge cases
6. Document the fix
7. Commit changes: git commit -m "Fix: Description of bug fix"
8. Deploy fix
9. Monitor for any issues
```

#### Database Schema Changes

```
1. Create migration: php artisan make:migration description_of_change
2. Edit migration file in database/migrations/
3. Test migration on development database
4. Update related models if needed
5. Update controllers/views if needed
6. Run migration: php artisan migrate
7. Update toai_hrm.sql file for new installations
8. Document changes in migration comments
```

---

## 📋 Quick Reference

### Important URLs

- **Login**: `/login`
- **Dashboard**: `/dashboard`
- **Admin**: `/admin`
- **PIM**: `/pim`
- **Leave**: `/leave`
- **Time**: `/time`
- **My Info**: `/my-info`
- **Performance**: `/performance`
- **Recruitment**: `/recruitment`
- **Directory**: `/directory`
- **Claim**: `/claim`
- **Buzz**: `/buzz`
- **Maintenance**: `/maintenance` (requires additional auth)
- **Profile**: `/profile`

### Important Commands

```bash
# Start development server
php artisan serve

# Start with custom port
php artisan serve --port=8001

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear  # Clears all

# Run migrations
php artisan migrate
php artisan migrate:status
php artisan migrate:rollback

# Build assets
npm run build          # Production
npm run dev            # Development with hot reload

# Database backup
mysqldump -u root -p toai_hrm > backup.sql

# Laravel Tinker (interactive shell)
php artisan tinker

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link

# Run tests
php artisan test

# Code formatting
./vendor/bin/pint
```

### Key File Locations

| File/Directory | Purpose |
|---------------|---------|
| `routes/web.php` | All application routes (318+ routes) |
| `resources/views/layouts/app.blade.php` | Base layout used by all pages (includes CSS/JS, Font Awesome) |
| `app/Http/Controllers/` | All controllers (15 controllers) |
| `app/Http/Middleware/AuthSession.php` | Custom authentication middleware |
| `resources/views/` | All Blade templates |
| `resources/css/app.css` | Main stylesheet with theme variables |
| `resources/js/app.js` | Main JavaScript file |
| `.env` | Environment configuration |
| `database/toai_hrm.sql` | Complete database schema |
| `storage/logs/laravel.log` | Application logs |
| `app/Components/` | Reusable Blade components |
| `public/build/` | Pre-built production assets |

### Controller List

1. **Auth\LoginController** - Authentication (login, logout, password reset)
2. **DashboardController** - Dashboard analytics and widgets
3. **AdminController** - Admin panel management (27+ views)
4. **PIMController** - Personal Information Management
5. **LeaveController** - Leave management system
6. **TimeController** - Time & attendance tracking
7. **RecruitmentController** - Recruitment and vacancies
8. **MyInfoController** - Employee self-service portal
9. **PerformanceController** - Performance reviews and KPIs
10. **DirectoryController** - Employee directory
11. **MaintenanceController** - System maintenance utilities
12. **ClaimController** - Claims management
13. **BuzzController** - Social feed
14. **ProfileController** - User profile management

### Module Structure

**Admin Module** (27 views):
- User Management
- Job Titles, Pay Grades, Employment Status
- Organization Structure
- Qualifications (Skills, Education, Licenses, Languages, Memberships)
- Configuration (Email, Localization, Modules, OAuth, LDAP)
- Theme Manager
- Corporate Branding

**PIM Module** (9 views):
- Employee List
- Add/Edit Employee
- Reports
- Configuration (Optional Fields, Custom Fields, Import/Export)

**Leave Module** (14 views):
- Apply Leave
- My Leave
- Leave List
- Assign Leave
- Entitlements
- Leave Types
- Holidays
- Reports

**Time Module** (12 views):
- My Timesheets
- Timesheets (Manager)
- Attendance (Punch In/Out)
- Project Info (Customers, Projects)
- Reports

**Other Modules**:
- My Info (11 views)
- Performance (7 views)
- Recruitment (2 views)
- Claim (10 views)
- Directory (1 view)
- Buzz (1 view)
- Maintenance (4 views)
- Profile (2 views)

### Contact & Support

**Development Team**: (Add contact information)  
**Project Manager**: (Add contact information)  
**Technical Lead**: (Add contact information)

**Support Channels**:
- Email: (Add support email)
- Issue Tracker: (Add issue tracker URL if applicable)
- Documentation: See README.md and SYSTEM_DOCUMENTATION.md

---

## 🎓 Training & Onboarding

### For New Developers

1. **Read Documentation**
   - Start with README.md
   - Review SYSTEM_DOCUMENTATION.md
   - Study this Knowledge Transfer document

2. **Setup Development Environment**
   - Follow README.md setup instructions
   - Install required tools (PHP, MySQL, Composer, Node.js)
   - Configure database
   - Run `composer install` and `npm install`

3. **Explore Codebase**
   - Start with `routes/web.php` to understand URL structure
   - Review controllers to understand business logic
   - Study views to understand UI structure
   - Examine components for reusable patterns

4. **Practice Tasks**
   - Add a simple feature (e.g., new report)
   - Fix a minor bug
   - Modify a view
   - Create a new component

### For New System Administrators

1. **Understand System Architecture**
   - Read SYSTEM_DOCUMENTATION.md
   - Understand database structure
   - Learn about authentication system
   - Review backup procedures

2. **Practice Common Tasks**
   - Create a user account
   - Add an employee
   - Approve a leave request
   - Generate a report
   - Perform database backup

3. **Learn Troubleshooting**
   - Review troubleshooting section
   - Practice common fixes
   - Understand log files
   - Learn to clear caches

### For New HR Users

1. **User Training**
   - Login and navigation
   - Employee management
   - Leave management
   - Time tracking
   - Report generation

2. **Practice Scenarios**
   - Add a new employee
   - Process a leave request
   - Approve a timesheet
   - Generate a report
   - Configure leave types

---

## ✅ Checklist for Handover

### Before Handover

- [ ] All documentation is complete and up-to-date
- [ ] All known issues are documented
- [ ] Access credentials are provided and tested
- [ ] Development environment setup is documented
- [ ] Database backup procedures are documented
- [ ] Deployment procedures are documented
- [ ] Code is properly commented
- [ ] All critical bugs are fixed or documented
- [ ] Test data is available for training
- [ ] Default passwords are changed (production)

### During Handover

- [ ] Walkthrough of all modules
- [ ] Demonstration of key workflows
- [ ] Explanation of database structure
- [ ] Review of code architecture
- [ ] Discussion of known issues
- [ ] Q&A session
- [ ] Access to all systems provided

### After Handover

- [ ] New team member can login and navigate
- [ ] New team member can perform basic tasks
- [ ] New team member understands code structure
- [ ] New team member knows where to find documentation
- [ ] Support contact information is provided
- [ ] Follow-up session scheduled (if needed)

---

## 📝 Notes & Additional Information

### Project History

- **Initial Development**: (Add date if known)
- **Current Version**: 1.0
- **Last Major Update**: January 2026
- **Framework Version**: Laravel 12.x
- **PHP Version**: 8.2+

### Future Roadmap

- (Add planned features/enhancements)
- (Add improvement areas)
- Mobile app development (if planned)
- API development for third-party integrations
- Advanced reporting and analytics
- Multi-language support enhancement

### Important Notes

- Always backup database before making changes
- Test changes in development environment first
- Follow Laravel coding standards (PSR-12)
- Document all code changes
- Keep `.env` file secure and never commit it
- Use migrations for all database changes
- Clear caches after configuration changes
- Monitor logs regularly for errors
- Keep dependencies updated (security patches)

### Development Best Practices

1. **Code Quality**
   - Use Laravel Pint for code formatting
   - Follow PSR-12 coding standards
   - Write meaningful commit messages
   - Add comments for complex logic

2. **Security**
   - Always validate user input
   - Use parameterized queries (Eloquent)
   - Sanitize output when using `{!! !!}`
   - Keep dependencies updated

3. **Performance**
   - Use eager loading for relationships
   - Add database indexes where needed
   - Optimize queries
   - Cache frequently accessed data

4. **Testing**
   - Test all new features
   - Test edge cases
   - Test on different browsers
   - Test responsive design

---

**Document End**

*This Knowledge Transfer document should be updated whenever significant changes are made to the system, new issues are discovered, or new team members join the project.*

**Last Reviewed**: January 2026  
**Next Review Date**: (Set review schedule - recommended quarterly)

---

## 🔗 Additional Resources

- **Laravel Documentation**: https://laravel.com/docs
- **Tailwind CSS Documentation**: https://tailwindcss.com/docs
- **MySQL Documentation**: https://dev.mysql.com/doc/
- **PHP Documentation**: https://www.php.net/docs.php

---

**End of Knowledge Transfer Document**
