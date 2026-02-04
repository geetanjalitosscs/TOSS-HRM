# TOAI HR Suite - Professional Edition

A comprehensive, enterprise-grade Human Resource Management System built with Laravel 12 and modern web technologies, featuring a professional lavender-themed UI with complete dark mode support and real database integration.

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-utf8mb4-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="Database">
  <img src="https://img.shields.io/badge/Dark_Mode-Enabled-8B5CF6?style=for-the-badge" alt="Dark Mode">
</p>

## 🎨 Features

### Core Features
- **Enterprise-grade Architecture**: Professional MVC structure with Laravel 12 and PHP 8.2+
- **Real Database Integration**: Complete MySQL database with utf8mb4, InnoDB engine and 3NF normalization
- **Modern Dashboard**: Professional HR dashboard with interactive charts and real-time widgets
- **Complete Dark Mode**: Full dark mode support with theme toggle and localStorage persistence
- **Session-based Authentication**: Secure custom authentication middleware with audit trails
- **Collapsible Sidebar**: Professional sidebar with toggle button, icon-only mode, and persistent state
- **Active State Highlighting**: Visual feedback for current page with distinct active state styling
- **Responsive Design**: Mobile-friendly interface that adapts to all screen sizes
- **Component System**: Reusable Blade components with PHP backing classes

### HR Modules
- **Admin Module**: Comprehensive user management, job titles, pay grades, work shifts, organization structure, qualifications, nationalities, corporate branding, email configuration, localization, modules, social media authentication, OAuth clients, and LDAP configuration
- **PIM (Personal Information Management)**: Complete employee lifecycle management with employee list, add/edit employee, reports, configurable optional fields, custom fields, data import/export, reporting methods, and termination reasons
- **Leave Management**: Full leave management system with apply leave, my leave, leave list, assign leave, entitlements, usage reports, leave types, leave period, work week configuration, and holidays management
- **Time Tracking**: Comprehensive time and attendance system with timesheets, attendance records (punch in/out), employee records, project reports, employee reports, attendance summary, and project info management (customers and projects)
- **Recruitment**: Candidate management and vacancy tracking system
- **Performance Management**: Employee performance reviews with KPIs, trackers, and review management for both self and employee evaluations
- **My Info**: Complete employee self-service portal with personal details, contact details, emergency contacts, dependents, immigration, job information, salary, reporting structure, qualifications (work experience, education, skills, languages, licenses), and memberships
- **Directory**: Employee directory with search and filtering capabilities
- **Claim Management**: Employee claims submission, tracking, approval workflow, and configuration for events and expense types
- **Buzz Feed**: Social feed for company announcements, updates, and interactions
- **Maintenance**: System maintenance utilities with data purge (employee/candidate records) and access records management with additional authentication layer
- **Profile Management**: User profile with about information, support, and password change functionality

### UI/UX Features
- **Interactive Charts**: Beautiful pie charts with hover tooltips and smooth animations
- **Professional Lavender Theme**: Elegant purple/lavender color scheme with CSS variables for consistency
- **Smooth Transitions**: CSS transitions for theme changes and interactions (0.2s-0.3s cubic-bezier)
- **Advanced Dropdown Menus**: Interactive dropdown menus with proper navigation handling
- **Global Search Functionality**: Search bars in sidebar and various modules with filtering
- **Data Tables**: Sortable, filterable data tables with bulk operations
- **Form Validation**: Client and server-side validation with error handling
- **File Upload/Download**: Attachment management with secure file handling
- **Responsive Grid System**: Mobile-first responsive design with breakpoints

## 🏗️ Architecture

This project follows enterprise-grade **MVC (Model-View-Controller)** architectural pattern with modern Laravel 12 features:

### Core Architecture Components
- **Models** (`app/Models/`): Handle data logic and database interactions with Eloquent ORM
- **Views** (`resources/views/`): Present data to users using Blade templates with component system
- **Controllers** (`app/Http/Controllers/`): Handle HTTP requests and coordinate between Models and Views
- **Routes** (`routes/web.php`): Define RESTful URL endpoints with middleware protection
- **Components** (`app/Components/`): Reusable Blade components with PHP backing classes
- **Middleware** (`app/Http/Middleware/`): Custom authentication and request handling

### Database Architecture
- **Database Engine**: MySQL with utf8mb4 character set and InnoDB engine
- **Normalization**: 3NF (Third Normal Form) with proper relationships
- **Schema**: Comprehensive `toai_hrm.sql` with 50+ tables covering all HR modules
- **Migrations**: Laravel migration system for version control
- **Audit Fields**: Created_at, updated_at timestamps and activity logging

### Frontend Architecture
- **CSS Framework**: Tailwind CSS 4.x with custom lavender theme variables
- **JavaScript**: Vanilla JS with Vite build system
- **Component System**: Blade components with dark mode support
- **Responsive Design**: Mobile-first approach with breakpoints
- **Theme System**: CSS variables for consistent light/dark mode

## 🚀 Quick Start

### Prerequisites

- **PHP >= 8.2** (Required)
- **MySQL/MariaDB** (Required for database functionality)
- **Composer** (Required for PHP dependencies)
- **Web Server** (Apache/Nginx or XAMPP)
- **Node.js & NPM** (Optional - only needed for asset development)

### Installation (Production - Recommended)

**✅ Production Ready!** This project includes pre-built assets and can run **without npm** in production!

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd HR
   ```

2. **Install PHP dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup database**
   ```bash
   # Import the database schema
   mysql -u username -p database_name < database/toai_hrm.sql
   
   # Or use phpMyAdmin to import the SQL file
   ```

5. **Configure database connection** in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=toai_hrm
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Start the application**
   ```bash
   php artisan serve
   ```

The `@vite` directive automatically uses the pre-built assets from `public/build/`. All features will work perfectly!

### Installation (Development - With NPM)

For development with hot reload and asset rebuilding:

1. **Install all dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Setup database** (same as production)

4. **Start development servers**
   ```bash
   # Run both Laravel and Vite in parallel
   npm run dev
   
   # Or run separately
   php artisan serve
   npm run dev  # in another terminal
   ```

5. **Build for production**
   ```bash
   npm run build
   ```

## 🔐 Login Credentials

**Login URL**: [http://127.0.0.1:8000/](http://127.0.0.1:8000/) or [http://localhost:8000/](http://localhost:8000/)

**Demo Credentials:**
- **Username**: `admin`
- **Password**: `admin123`

After successful login, you'll be redirected to the dashboard at `/dashboard`.

## 📁 Project Structure (Enterprise MVC Architecture)

```
HR/
├── app/                                    # Application Core (MVC)
│   ├── Components/                         # Blade Components with PHP backing
│   │   ├── Admin/                          # Admin-specific components
│   │   ├── DropdownMenu.php                # Shared dropdown component
│   │   ├── Leave/                          # Leave-specific components
│   │   ├── PIM/                            # PIM-specific components
│   │   └── Recruitment/                    # Recruitment-specific components
│   ├── Http/
│   │   ├── Controllers/                    # Controllers (C)
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php     # Authentication logic
│   │   │   ├── AdminController.php         # Admin panel management
│   │   │   ├── DashboardController.php      # Dashboard data & analytics
│   │   │   ├── PIMController.php           # Personal Info Management
│   │   │   ├── LeaveController.php         # Leave management system
│   │   │   ├── TimeController.php          # Time & attendance tracking
│   │   │   ├── RecruitmentController.php   # Recruitment workflows
│   │   │   ├── MyInfoController.php        # Employee self-service
│   │   │   ├── PerformanceController.php   # Performance reviews
│   │   │   ├── DirectoryController.php     # Employee directory
│   │   │   ├── MaintenanceController.php   # System maintenance
│   │   │   ├── ClaimController.php         # Claims management
│   │   │   ├── BuzzController.php          # Social feed
│   │   │   └── ProfileController.php        # User profiles
│   │   └── Middleware/
│   │       └── AuthSession.php             # Custom session authentication
│   ├── Models/                             # Models (M)
│   │   └── User.php                        # User model with relationships
│   └── Providers/                          # Service providers
├── database/                               # Database Layer
│   ├── migrations/                         # Laravel migrations
│   ├── seeders/                            # Database seeders
│   ├── toai_hrm.sql                        # Complete database schema
│   ├── add_contact_details_columns.sql     # Contact details updates
│   ├── add_emergency_contact_email.sql     # Emergency contact updates
│   └── add_qualifications_tables.sql       # Qualifications schema
├── resources/
│   ├── css/
│   │   └── app.css                        # Main stylesheet with lavender theme
│   ├── js/
│   │   └── app.js                         # JavaScript (theme, sidebar, dropdowns)
│   └── views/                             # Views (V)
│       ├── layouts/
│       │   └── app.blade.php              # Base layout with theme system
│       ├── components/                     # Reusable components
│       │   ├── header.blade.php           # Header with theme toggle
│       │   ├── sidebar.blade.php          # Collapsible navigation
│       │   ├── main-layout.blade.php      # Main layout wrapper
│       │   ├── admin/                     # Admin components
│       │   ├── pim/                       # PIM components
│       │   ├── leave/                     # Leave components
│       │   ├── recruitment/               # Recruitment components
│       │   └── date-picker.blade.php      # Shared date picker
│       ├── auth/
│       │   └── login.blade.php            # Login page
│       ├── dashboard/
│       │   └── dashboard.blade.php        # Dashboard with charts
│       ├── admin/                         # Admin module views (27 files)
│       ├── pim/                           # PIM module views (9 files)
│       ├── leave/                         # Leave module views (14 files)
│       ├── time/                          # Time & attendance views (12 files)
│       ├── recruitment/                   # Recruitment views (2 files)
│       ├── myinfo/                        # Employee self-service (11 files)
│       ├── performance/                   # Performance management (7 files)
│       ├── directory/
│       │   └── directory.blade.php        # Employee directory
│       ├── maintenance/                   # System maintenance (4 files)
│       ├── claim/                         # Claims management (10 files)
│       ├── buzz/
│       │   └── buzz.blade.php             # Social feed
│       └── profile/                       # User profiles (2 files)
├── routes/
│   ├── web.php                            # Application routes (318 lines)
│   └── console.php                         # Console commands
├── public/                                # Public assets
│   ├── build/                             # Pre-built Vite assets
│   ├── images/                            # Static images
│   └── index.php                          # Laravel entry point
├── storage/                               # Application storage
├── bootstrap/                             # Bootstrap files
├── config/                                # Configuration files
├── vendor/                                # Composer dependencies
├── tests/                                 # Test suite
├── artisan                                # Laravel CLI tool
├── composer.json                         # PHP dependencies
├── composer.lock                          # Dependency lock file
├── package.json                           # Node.js dependencies
├── vite.config.js                         # Vite configuration
└── .env.example                           # Environment template
```

## 🎯 Key Routes

### Authentication Routes
- `GET /` - Redirect to login
- `GET /login` - Login page
- `POST /login` - Authentication
- `POST /logout` - Logout
- `GET /logout` - Logout (GET method)

### Protected Routes (Require Authentication)
- `GET /dashboard` - Dashboard with analytics and widgets

#### Admin Module Routes (15+ routes)
- `GET /admin` - Admin panel main page
- `GET|POST /admin/users/*` - User management (CRUD, bulk operations)
- `GET|POST /admin/job-titles/*` - Job title management
- `GET|POST /admin/pay-grades` - Pay grade configuration
- `GET|POST /admin/employment-status/*` - Employment status management
- `GET /admin/job-categories` - Job categories
- `GET /admin/work-shifts` - Work shift configuration
- `GET|POST /admin/organization/*` - Organization management
- `GET /admin/qualifications/*` - Qualifications configuration
- `GET /admin/nationalities` - Nationalities management
- `GET /admin/corporate-branding` - Corporate branding
- `GET /admin/configuration/*` - System configuration (email, localization, modules, etc.)

#### PIM Module Routes (20+ routes)
- `GET /pim` - PIM main page
- `GET|POST /pim/employee-list/*` - Employee management (CRUD, bulk operations)
- `GET /pim/add-employee` - Add new employee
- `GET /pim/add-employee/{id}` - Edit employee
- `GET|POST /pim/reports/*` - Employee reports
- `GET|POST /pim/configuration/*` - PIM configuration (optional fields, custom fields, data import, reporting methods, termination reasons)

#### Leave Module Routes (25+ routes)
- `GET /leave` - Leave main page
- `GET|POST /leave/apply` - Apply for leave
- `GET /leave/my-leave` - Personal leave history
- `GET /leave/leave-list` - All leave records
- `POST /leave/{action}/{id}` - Leave actions (cancel, reject, approve)
- `GET|POST /leave/assign-leave` - Assign leave to employees
- `GET /leave/add-entitlement` - Add leave entitlements
- `GET /leave/my-entitlements` - Personal entitlements
- `GET /leave/employee-entitlements` - Employee entitlements
- `GET /leave/*-report` - Leave reports
- `GET|POST /leave/leave-types/*` - Leave type management
- `GET /leave/leave-period` - Leave period configuration
- `GET|POST /leave/work-week/*` - Work week configuration
- `GET|POST /leave/holidays/*` - Holidays management

#### Time Module Routes (15+ routes)
- `GET /time` - Time main page
- `GET /time/my-timesheets` - Personal timesheets
- `GET /time/my-timesheets/edit` - Edit timesheet
- `GET /time/attendance/*` - Attendance management
- `GET /time/reports/*` - Time reports
- `GET|POST /time/project-info/*` - Project information management

#### Other Module Routes
- `GET /recruitment` - Recruitment management
- `GET|POST /recruitment/vacancies` - Vacancy management
- `GET /my-info` - Employee self-service portal
- `POST /my-info/*` - Update personal information (15+ endpoints)
- `GET /performance` - Performance management
- `GET /performance/*` - Performance features (trackers, KPIs, reviews)
- `GET /directory` - Employee directory
- `GET|POST /claim/*` - Claims management (15+ routes)
- `GET /buzz` - Social feed
- `GET /profile/*` - User profile management

### Maintenance Routes (Require Additional Auth)
- `GET|POST /maintenance/auth` - Maintenance authentication
- `GET /maintenance` - Maintenance dashboard
- `GET /maintenance/purge-employee` - Purge employee records
- `GET /maintenance/purge-candidate` - Purge candidate records
- `GET /maintenance/access-records` - Access records

## 🛠️ Technology Stack

### Backend Technologies
- **Framework**: Laravel 12.x (Latest stable version)
- **Language**: PHP 8.2+ (Modern PHP with strict types)
- **Database**: MySQL/MariaDB with utf8mb4, InnoDB engine
- **Authentication**: Custom session-based middleware with audit trails
- **ORM**: Eloquent ORM with relationships and eager loading
- **Routing**: RESTful routing with middleware protection

### Frontend Technologies
- **CSS Framework**: Tailwind CSS 4.x with custom configuration
- **Build Tool**: Vite 7.x for fast development and building
- **JavaScript**: Vanilla ES6+ (no jQuery dependency)
- **Templating**: Blade templates with component system
- **Icons**: Lucide icons for modern UI

### Development Tools
- **Package Manager**: Composer (PHP), NPM (JavaScript)
- **Code Style**: Laravel Pint for PHP formatting
- **Testing**: PHPUnit for unit and feature tests
- **Asset Pipeline**: Vite with hot module replacement
- **Version Control**: Git with proper .gitignore

### Architecture Patterns
- **MVC Pattern**: Model-View-Controller separation
- **Component System**: Reusable Blade components
- **Middleware**: Custom authentication and request handling
- **Service Providers**: Laravel service container
- **Repository Pattern**: Clean data access layer

## 🎨 Theme & Dark Mode System

The application features a professional lavender/purple color scheme with complete dark mode support using CSS variables:

### Light Theme Colors
- **Primary**: `#8B5CF6` (Lavender Purple)
- **Primary Dark**: `#6D28D9`
- **Primary Soft**: `#A78BFA`
- **Background**: `#F5F3FF` (Light Lavender)
- **Surface**: `#FFFFFF`
- **Text Primary**: `#1E293B` (Dark Slate)
- **Text Muted**: `#64748B`
- **Border**: `#E2E8F0`

### Dark Theme Colors
- **Background Main**: `#0F172A` (Slate-900)
- **Background Surface**: `#111827` (Gray-900)
- **Background Card**: `#1F2937` (Gray-800)
- **Text Primary**: `#E5E7EB` (Gray-200)
- **Text Muted**: `#9CA3AF` (Gray-400)
- **Border**: `#334155` (Slate-700)
- **Primary Accent**: `#8B5CF6` (Purple retained for consistency)

### Theme Features
- **Theme Toggle**: Click the 🌙/☀️ button in the header
- **Persistent Storage**: Theme preference saved in localStorage
- **System Preference**: Automatically detects system dark mode on first visit
- **Smooth Transitions**: All color changes animate smoothly (0.2s-0.3s cubic-bezier)
- **Complete Coverage**: All pages, components, and elements support dark mode
- **CSS Variables**: Centralized theme system for easy maintenance

### Sidebar Features
- **Collapsible Design**: Toggle button positioned at the top-right of sidebar
- **Icon-Only Mode**: When collapsed, shows only icons for clean minimal look
- **Persistent State**: Sidebar collapse state saved in localStorage
- **Active State Highlighting**: Current page highlighted with distinct purple gradient
- **Smooth Animations**: CSS transitions for expand/collapse actions
- **Wildcard Route Matching**: Active state works for sub-routes (e.g., `leave*` matches all leave routes)
- **Responsive Behavior**: Automatically collapses on mobile devices

## 📊 Dashboard Features

The main dashboard provides comprehensive HR analytics and quick access to key functions:

### Analytics Widgets
- **Time at Work**: Real-time tracking of daily and weekly work hours with visual charts
- **My Actions**: Personal dashboard showing pending tasks, approvals, and reviews
- **Quick Launch**: Fast access to common functions (Leave Apply, Timesheets, etc.)
- **Buzz Latest Posts**: Social feed integration showing company announcements

### Employee Analytics
- **Distribution by Sub Unit**: Interactive pie charts showing department-wise distribution
- **Distribution by Location**: Geographic distribution of employees with hover tooltips
- **Employees on Leave**: Real-time status of today's leave approvals and pending requests

### Interactive Features
- **Hover Effects**: All charts and widgets respond to mouse interaction
- **Smooth Animations**: Data transitions animate smoothly
- **Responsive Charts**: Charts adapt to different screen sizes
- **Real-time Updates**: Dashboard data refreshes without page reload
- **Drill-down Capability**: Click on widgets to navigate to detailed modules

## 🎛️ Module Details

### Admin Module (27 views)
- **User Management**: Complete CRUD operations with bulk actions, role management (Admin/ESS), status control
- **Job Management**: Job titles, pay grades, employment status, job categories, work shifts
- **Organization**: General information, locations management, organizational structure
- **Qualifications**: Skills, education, licenses, languages, memberships configuration
- **Configuration**: Email setup, localization, modules, social media auth, OAuth clients, LDAP
- **System**: Nationalities, corporate branding, system-wide settings

### PIM Module (9 views)
- **Employee Lifecycle**: Complete employee management from hire to termination
- **Employee List**: Advanced search, filtering, bulk operations, data export
- **Add/Edit Employee**: Comprehensive employee forms with validation
- **Reports**: Employee reports with customizable fields and filtering
- **Configuration**: Optional fields, custom fields, data import/export, reporting methods, termination reasons
- **Data Management**: Excel import/export with sample templates

### Leave Module (14 views)
- **Leave Management**: Apply leave, my leave history, leave list with approvals
- **Leave Actions**: Approve, reject, cancel leave with workflow management
- **Entitlements**: Add/view entitlements, employee entitlements, usage reports
- **Configuration**: Leave types, leave period, work week, holidays management
- **Reports**: Comprehensive leave analytics and usage reports
- **Assignments**: Assign leave to employees with balance tracking

### Time Module (12 views)
- **Timesheets**: Personal timesheets, editing capabilities, approval workflows
- **Attendance**: Punch in/out, employee records, my records, configuration
- **Reports**: Project reports, employee reports, attendance summary
- **Project Management**: Customer management, project tracking, time allocation
- **Analytics**: Comprehensive time and attendance analytics

### My Info Module (11 views)
- **Personal Details**: Complete personal information management
- **Contact Management**: Contact details, emergency contacts, dependents
- **Professional Info**: Job details, salary information, reporting structure
- **Qualifications**: Work experience, education, skills, languages, licenses, memberships
- **Immigration**: Immigration documents and status tracking
- **Attachments**: Document management with upload/download capabilities

### Performance Module (7 views)
- **Performance Reviews**: My reviews, employee reviews, review cycles
- **Trackers**: Performance trackers for goals and objectives
- **KPIs**: Key Performance Indicator management and tracking
- **Analytics**: Performance analytics and reporting

### Claim Module (10 views)
- **Claims Management**: Submit claims, my claims, claim assignment
- **Approval Workflow**: Approve/reject/cancel claims with audit trail
- **Configuration**: Events setup, expense types management
- **Reports**: Claim analytics and expense tracking

### Other Modules
- **Recruitment**: Candidate management, vacancy tracking (2 views)
- **Directory**: Employee directory with search and filtering
- **Buzz**: Social feed for company announcements and interactions
- **Maintenance**: System utilities, data purge, access records (4 views)
- **Profile**: User profile management, support, password change (2 views)

## 🎯 Recent UI Improvements

### Sidebar Enhancements
- **Collapsible Sidebar**: Professional sidebar with toggle button at the top-right
- **Icon-Only Mode**: When minimized, sidebar shows only icons for space efficiency
- **Active State Styling**: Distinct purple gradient highlighting for current page
- **Wildcard Route Matching**: Active state works for all sub-routes (e.g., `/leave/apply` highlights Leave menu)
- **Persistent State**: Sidebar collapse state saved in browser localStorage
- **Smooth Animations**: CSS transitions for expand/collapse actions

### Navigation Improvements
- **Dropdown Navigation**: Improved dropdown menus with proper link navigation
- **Active Link Feedback**: Immediate visual feedback when clicking sidebar links
- **Route-Based Highlighting**: Server-side route matching with wildcard support

## 🔧 Development

### Production Deployment

The project is optimized for production deployment:

```bash
# Install production dependencies
composer install --optimize-autoloader --no-dev

# Set up environment
cp .env.example .env
php artisan key:generate

# Configure database connection in .env
# Import database schema
mysql -u username -p database_name < database/toai_hrm.sql

# Start application
php artisan serve --host=0.0.0.0 --port=8000
```

### Development Environment

For local development with hot reload:

```bash
# Install all dependencies
composer install
npm install

# Setup environment and database
cp .env.example .env
php artisan key:generate
# Import database schema

# Start development servers
npm run dev  # Runs both Laravel and Vite
```

### Asset Management

**Production**: Uses pre-built assets from `public/build/` - no npm required
**Development**: Use `npm run dev` for hot reload or `npm run build` for production assets

### Database Management

```bash
# Import initial schema
mysql -u username -p database_name < database/toai_hrm.sql

# Run migrations (if using Laravel migration system)
php artisan migrate

# Seed data (if available)
php artisan db:seed
```

### Code Quality

```bash
# Format PHP code
./vendor/bin/pint

# Run tests
php artisan test

# Check code style
php artisan code:analyse  # If installed
```

### Development Guidelines

This project follows enterprise-grade development standards:

#### MVC Architecture
1. **Controllers**: Handle HTTP requests, validate input, call models, return views
   - Location: `app/Http/Controllers/`
   - Naming: `{Module}Controller.php`
   - Methods: RESTful naming (index, store, update, destroy)

2. **Models**: Handle database interactions and business logic
   - Location: `app/Models/`
   - Naming: Singular (e.g., `User.php`)
   - Relationships: Define Eloquent relationships

3. **Views**: Present data to users using Blade templates
   - Location: `resources/views/{module}/`
   - Naming: `{feature}.blade.php`
   - Components: Use reusable Blade components

4. **Routes**: Define RESTful URL endpoints
   - Location: `routes/web.php`
   - Pattern: `Route::resource('/resource', Controller::class)`
   - Middleware: Apply authentication and authorization

5. **Middleware**: Handle cross-cutting concerns
   - Location: `app/Http/Middleware/`
   - Custom: AuthSession for authentication

#### Frontend Standards
- **CSS**: Use Tailwind CSS classes, avoid inline styles
- **JavaScript**: Vanilla ES6+, modular structure
- **Components**: Reusable Blade components with PHP backing
- **Theme**: Use CSS variables for colors, support dark mode
- **Responsive**: Mobile-first design approach

#### Database Standards
- **Normalization**: 3NF with proper relationships
- **Naming**: snake_case for tables/columns, plural for tables
- **Audit Fields**: created_at, updated_at timestamps
- **Charset**: utf8mb4 with InnoDB engine
- **Migrations**: Version control database changes

## 📝 Enterprise Notes

### Production Ready Features
- **Pre-built Assets**: Production deployment without npm/node dependencies
- **Database Integration**: Complete MySQL database with 50+ tables and relationships
- **Session Authentication**: Secure custom middleware with audit trails
- **Responsive Design**: Mobile-first approach with comprehensive breakpoint coverage
- **Dark Mode**: Complete theme system with CSS variables and localStorage persistence
- **Component Architecture**: Reusable Blade components with PHP backing classes

### Performance Optimizations
- **Asset Optimization**: Pre-built and minified CSS/JS in production
- **Database Indexing**: Proper indexing for performance-critical queries
- **Caching Strategy**: Laravel caching system for improved performance
- **Lazy Loading**: Eloquent relationships optimized with eager loading
- **Session Management**: Efficient session handling with database driver

### Security Features
- **Authentication**: Custom session-based authentication with middleware protection
- **CSRF Protection**: Built-in Laravel CSRF token validation
- **Input Validation**: Server-side validation with error handling
- **SQL Injection Prevention**: Eloquent ORM with parameter binding
- **XSS Protection**: Blade template auto-escaping
- **Maintenance Security**: Additional authentication layer for maintenance operations

### Browser Compatibility
- **Modern Browsers**: Full support for Chrome, Firefox, Safari, Edge
- **Mobile Support**: Responsive design for iOS and Android devices
- **Progressive Enhancement**: Core functionality works without JavaScript
- **Accessibility**: Semantic HTML5 with ARIA labels where appropriate

### Development Workflow
- **Version Control**: Git with comprehensive .gitignore
- **Code Quality**: Laravel Pint for PHP code formatting
- **Testing**: PHPUnit test suite included
- **Documentation**: Comprehensive README and inline code comments
- **Environment Management**: Separate .env configurations for dev/staging/production

## 🔒 Security

### Authentication & Authorization
- **Custom Session Middleware**: Secure authentication with configurable session lifetime
- **Role-based Access**: Admin/ESS role system with permission-based access control
- **Maintenance Authentication**: Additional security layer for system maintenance operations
- **Session Management**: Database-driven session storage with secure configuration

### Data Protection
- **Password Security**: Bcrypt hashing with configurable rounds (12 rounds default)
- **CSRF Protection**: Built-in Laravel CSRF token validation on all forms
- **Input Sanitization**: Server-side validation with Laravel validation rules
- **SQL Injection Prevention**: Eloquent ORM with parameterized queries
- **XSS Protection**: Blade template engine with auto-escaping

### System Security
- **Environment Variables**: Sensitive configuration stored in .env files
- **Error Handling**: Secure error pages without information disclosure
- **File Upload Security**: Validated file uploads with type and size restrictions
- **Audit Trail**: Activity logging for user actions and system events
- **Secure Headers**: Proper security headers for web application protection

## 📄 License

This project is open-sourced software licensed under the **MIT License**.

### MIT License Summary
- ✅ Commercial use allowed
- ✅ Modification allowed
- ✅ Distribution allowed
- ✅ Private use allowed
- ⚠️ License and copyright notice required
- ⚠️ Include license file in copies

### Warranty Disclaimer
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.

## 👥 Contributing

We welcome contributions to the TOAI HR Suite! Please follow these guidelines:

### Contribution Guidelines
1. **Fork the Repository**: Create a personal fork of the project
2. **Create Feature Branch**: Use descriptive branch names (e.g., `feature/leave-approval`)
3. **Follow Code Standards**: Use Laravel Pint for code formatting
4. **Write Tests**: Include unit tests for new functionality
5. **Document Changes**: Update README and inline documentation
6. **Submit Pull Request**: Provide clear description of changes

### Development Standards
- **PHP**: Follow PSR-12 coding standards
- **JavaScript**: Use ES6+ with proper error handling
- **CSS**: Use Tailwind CSS classes, avoid inline styles
- **Database**: Follow naming conventions and normalization rules
- **Testing**: Write tests for all new features and bug fixes

### Bug Reports
- Use GitHub Issues for bug reports
- Provide detailed reproduction steps
- Include environment details (PHP version, MySQL version, etc.)
- Add screenshots for UI-related issues

### Feature Requests
- Open GitHub Issues with "Feature Request" label
- Describe the use case and expected behavior
- Consider the impact on existing functionality

---

**Built with ❤️ using Laravel 12 and modern web technologies**

**TOAI HR Suite - New Edition**
*Enterprise-grade Human Resource Management System*

For support and inquiries, please visit our [GitHub Repository](https://github.com/geetanjalitosscs/TOSS-HRM).




