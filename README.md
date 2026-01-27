# TOAI HR Suite

A modern, professional Human Resource Management System built with Laravel and Tailwind CSS, featuring a beautiful lavender-themed UI with complete dark mode support.

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Dark_Mode-Enabled-8B5CF6?style=for-the-badge" alt="Dark Mode">
</p>

## 🎨 Features

### Core Features
- **Modern Dashboard**: Professional HR dashboard with interactive charts and widgets
- **Complete Dark Mode**: Full dark mode support with theme toggle and localStorage persistence
- **Session-based Authentication**: Simple and secure login system
- **Collapsible Sidebar**: Professional sidebar with toggle button, icon-only mode, and persistent state
- **Active State Highlighting**: Visual feedback for current page with distinct active state styling
- **Responsive Design**: Mobile-friendly interface that adapts to all screen sizes

### HR Modules
- **Employee Management**: Track employee distribution by sub-units and locations
- **Admin Panel**: User management with role-based access and comprehensive configuration options
- **PIM (Personal Information Management)**: Employee list, information management, and custom fields
- **Leave Management**: Manage leave requests, approvals, tracking, and leave assignments
- **Time Tracking**: Monitor work hours, attendance, timesheets, and time reports
- **Recruitment**: Candidate management, vacancy tracking, and recruitment workflows
- **Performance Management**: Employee performance reviews, tracking, and metrics
- **My Info**: Personal employee information and document management
- **Directory**: Employee directory with search and filtering capabilities
- **Claim Management**: Employee claims submission, tracking, and assignment
- **Buzz Feed**: Social feed for company announcements, updates, and interactions
- **Maintenance**: System maintenance and data purge utilities with additional security

### UI/UX Features
- **Interactive Charts**: Beautiful pie charts with hover tooltips and animations
- **Lavender Theme**: Elegant purple/lavender color scheme throughout the application
- **Smooth Transitions**: CSS transitions for theme changes and interactions
- **Dropdown Menus**: Interactive dropdown menus with proper navigation handling
- **Search Functionality**: Search bars in sidebar and various modules

## 🏗️ Architecture

This project follows the **MVC (Model-View-Controller)** architectural pattern:

- **Models** (`app/Models/`): Handle data logic and database interactions
- **Views** (`resources/views/`): Present data to users (Blade templates)
- **Controllers** (`app/Http/Controllers/`): Handle user requests and coordinate between Models and Views
- **Routes** (`routes/web.php`): Define URL endpoints and map them to controllers

## 🚀 Quick Start

### Prerequisites

- PHP >= 8.2
- Composer
- XAMPP (or any local server environment)
- **Node.js & NPM** (Optional - only needed if you want to rebuild assets)

### Installation (Without NPM - Recommended)

**✅ Good News!** This project already includes pre-built assets and can run **without npm**!

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd HR
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Start the development server** (That's it! No npm needed)
   ```bash
   php artisan serve
   ```

The `@vite` directive automatically uses the pre-built assets from `public/build/`. Your UI and all features will work perfectly!

### Installation (With NPM - Only if you need to rebuild assets)

If you need to modify CSS/JS and rebuild assets:

1. **Install Node dependencies**
   ```bash
   npm install
   ```

2. **Build assets**
   ```bash
   npm run build
   ```

3. **For development with hot reload**
   ```bash
   npm run dev
   ```

## 🔐 Login Credentials

**Login URL**: [http://127.0.0.1:8000/](http://127.0.0.1:8000/) or [http://localhost:8000/](http://localhost:8000/)

**Demo Credentials:**
- **Username**: `admin`
- **Password**: `admin123`

After successful login, you'll be redirected to the dashboard at `/dashboard`.

## 📁 Project Structure (MVC Architecture)

```
HR/
├── app/                                    # Application Core (MVC)
│   ├── Http/
│   │   ├── Controllers/                    # Controllers (C)
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php     # Authentication logic
│   │   │   ├── AdminController.php         # Admin panel management
│   │   │   ├── DashboardController.php      # Dashboard data
│   │   │   ├── PIMController.php           # Personal Info Management
│   │   │   ├── LeaveController.php         # Leave management
│   │   │   ├── TimeController.php          # Time tracking
│   │   │   ├── RecruitmentController.php   # Recruitment management
│   │   │   ├── MyInfoController.php        # Employee self-service
│   │   │   ├── PerformanceController.php   # Performance reviews
│   │   │   ├── DirectoryController.php     # Employee directory
│   │   │   ├── MaintenanceController.php   # System maintenance
│   │   │   ├── ClaimController.php         # Claims management
│   │   │   └── BuzzController.php          # Social feed
│   │   └── Middleware/
│   │       └── AuthSession.php             # Session authentication middleware
│   └── Models/                             # Models (M)
│       └── User.php                        # User model
├── resources/
│   ├── css/
│   │   └── app.css                        # Main stylesheet with lavender theme & dark mode
│   ├── js/
│   │   └── app.js                         # JavaScript (theme toggle, sidebar, dropdowns, active states)
│   └── views/                             # Views (V)
│       ├── auth/
│       │   └── login.blade.php            # Login page
│       ├── components/
│       │   ├── header.blade.php           # Header component with theme toggle
│       │   ├── sidebar.blade.php          # Collapsible sidebar navigation with active states
│       │   ├── main-layout.blade.php      # Main layout wrapper
│       │   ├── admin/                     # Admin-specific components
│       │   ├── pim/                       # PIM-specific components
│       │   ├── leave/                     # Leave-specific components
│       │   ├── recruitment/               # Recruitment-specific components
│       │   └── date-picker.blade.php      # Shared date picker
│       ├── layouts/
│       │   └── app.blade.php              # Base layout
│       ├── dashboard/
│       │   └── dashboard.blade.php        # Dashboard view
│       ├── admin/                         # Admin module views
│       ├── pim/                           # PIM module views
│       ├── leave/                         # Leave module views
│       ├── time/                          # Time & attendance module views
│       ├── recruitment/                   # Recruitment module views
│       ├── myinfo/
│       │   └── myinfo.blade.php           # My Info view
│       ├── performance/                   # Performance module views
│       ├── directory/
│       │   └── directory.blade.php        # Directory view
│       ├── maintenance/
│       │   ├── auth.blade.php             # Maintenance auth
│       │   ├── purge-employee.blade.php   # Purge employee records
│       │   ├── purge-candidate.blade.php  # Purge candidate records
│       │   └── access-records.blade.php   # Access records
│       ├── claim/                         # Claim module views
│       └── buzz/
│           └── buzz.blade.php             # Buzz feed view
├── routes/
│   └── web.php                            # Application routes
├── database/
│   ├── migrations/                        # Database migrations
│   └── seeders/                           # Database seeders
└── public/                                # Public assets
```

## 🎯 Key Routes

### Authentication Routes
- `GET /` - Login page
- `POST /login` - Authentication
- `POST /logout` - Logout

### Protected Routes (Require Authentication)
- `GET /dashboard` - Dashboard (main page)
- `GET /admin` - Admin panel
- `GET /pim` - Personal Information Management
- `GET /leave` - Leave management
- `GET /time` - Time tracking
- `GET /recruitment` - Recruitment management
- `GET /my-info` - Employee self-service
- `GET /performance` - Performance management
- `GET /directory` - Employee directory
- `GET /claim` - Claims management
- `GET /buzz` - Social feed

### Maintenance Routes (Require Additional Auth)
- `GET /maintenance/auth` - Maintenance authentication
- `POST /maintenance/auth` - Maintenance auth submission
- `GET /maintenance` - Maintenance dashboard
- `GET /maintenance/purge-employee` - Purge employee records
- `GET /maintenance/purge-candidate` - Purge candidate records
- `GET /maintenance/access-records` - Access records

## 🛠️ Technology Stack

- **Backend**: Laravel 12.x
- **Frontend**: Tailwind CSS 4.x
- **Build Tool**: Vite 7.x (pre-built assets included)
- **Authentication**: Session-based (custom middleware)
- **Styling**: Custom CSS with lavender theme and CSS variables
- **JavaScript**: Vanilla JS for theme toggle, sidebar interactions, and dropdowns
- **Architecture**: MVC (Model-View-Controller)
- **Package Manager**: Composer (PHP) - NPM optional (only for rebuilding assets)

## 🎨 Theme & Dark Mode

The application features a professional lavender/purple color scheme with complete dark mode support:

### Light Theme Colors
- Primary Color: `#8B5CF6` (Lavender Purple)
- Primary Dark: `#6D28D9`
- Primary Soft: `#A78BFA`
- Background: `#F5F3FF` (Light Lavender)
- Text: `#1E293B` (Dark Slate)

### Dark Theme Colors
- Background Main: `#0F172A` (Slate-900)
- Background Surface: `#111827` (Gray-900)
- Background Card: `#1F2937` (Gray-800)
- Text Primary: `#E5E7EB` (Gray-200)
- Text Muted: `#9CA3AF` (Gray-400)
- Border: `#334155` (Slate-700)
- Primary Accent: `#8B5CF6` (Purple retained)

### Dark Mode Features
- **Theme Toggle**: Click the 🌙/☀️ button in the header
- **Persistent**: Theme preference saved in localStorage
- **System Preference**: Respects system dark mode on first visit
- **Smooth Transitions**: All color changes animate smoothly
- **Complete Coverage**: All pages, components, and elements support dark mode

### Sidebar Features
- **Collapsible Design**: Toggle button positioned at the top-right of sidebar
- **Icon-Only Mode**: When collapsed, shows only icons for a clean, minimal look
- **Persistent State**: Sidebar collapse state saved in localStorage
- **Active State Highlighting**: Current page highlighted with distinct purple gradient
- **Smooth Animations**: Smooth transitions when expanding/collapsing
- **Overlapping Toggle**: Toggle button overlaps sidebar and navbar for easy access
- **Route Matching**: Supports wildcard route matching for sub-routes (e.g., `leave*` matches all leave routes)

## 📊 Dashboard Features

- **Time at Work**: Track daily and weekly work hours with visual charts
- **My Actions**: Pending tasks and reviews
- **Quick Launch**: Quick access to common functions (Leave, Timesheets, etc.)
- **Buzz Latest Posts**: Social feed updates
- **Employee Distribution**: Interactive pie charts showing:
  - Distribution by Sub Unit
  - Distribution by Location
- **Employees on Leave**: Today's leave status

## 🎛️ Module Details

### Admin Module
- User management with roles (Admin/ESS)
- User status management (Enabled/Disabled)
- Search and filter functionality

### PIM Module
- Employee list management
- Employee information tracking
- Search and filter capabilities

### Leave Module
- Leave list management
- Leave status tracking (Pending, Approved, Rejected)
- Leave type management

### Time Module
- Timesheet management
- Employee time tracking
- Pending approvals

### Recruitment Module
- Candidate management
- Vacancy tracking
- Candidate search and filtering

### Performance Module
- Performance reviews
- Review status tracking
- Employee performance metrics

### My Info Module
- Personal details management
- Custom fields
- Document attachments

### Directory Module
- Employee directory
- Search by name, job title, location
- Employee profile cards

### Claim Module
- Employee claims submission
- Claim status tracking
- Claim assignment

### Buzz Module
- Social feed for announcements
- Post creation and interaction
- Upcoming anniversaries widget

### Maintenance Module
- System maintenance utilities
- Data purge (Employee/Candidate records)
- Access records management

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

### Running Without NPM (Default)

The project is configured to run **without npm** by default. Just start the Laravel server:

```bash
php artisan serve
```

Laravel's `@vite` directive automatically detects and uses pre-built assets from `public/build/`. All UI features, dark mode, sidebar, and JavaScript functionality work perfectly without npm.

### Building Assets (Optional - Only if modifying CSS/JS)

If you need to modify CSS or JavaScript files, you'll need npm:

**For production builds:**
```bash
npm install
npm run build
```

**For development with hot reload:**
```bash
npm install
npm run dev
```

**Note:** After building, the assets will be in `public/build/` and you can run without npm again.

### Running Tests

```bash
php artisan test
```

### Code Structure Guidelines

This project follows MVC architecture:

1. **Controllers**: Handle HTTP requests, validate input, call models, return views
   - Location: `app/Http/Controllers/`
   - Naming: `{Module}Controller.php`

2. **Models**: Handle database interactions and business logic
   - Location: `app/Models/`
   - Naming: Singular (e.g., `User.php`)

3. **Views**: Present data to users using Blade templates
   - Location: `resources/views/`
   - Naming: `{module}/index.blade.php`

4. **Routes**: Define URL endpoints
   - Location: `routes/web.php`
   - Pattern: `Route::get('/{path}', [Controller::class, 'method'])->name('route.name');`

5. **Middleware**: Handle cross-cutting concerns (auth, logging, etc.)
   - Location: `app/Http/Middleware/`

## 📝 Notes

- **No NPM Required**: The project includes pre-built assets and runs without npm/node
- The application uses session-based authentication (no database required for basic functionality)
- All assets are pre-compiled and ready to use (located in `public/build/`)
- The UI is fully responsive and optimized for modern browsers
- Dark mode preference persists across sessions
- Sidebar collapse state persists across page reloads
- All components follow the centralized CSS variable system for consistent theming
- Active state highlighting works with wildcard route matching for sub-routes
- JavaScript handles dropdown navigation and sidebar interactions seamlessly
- Laravel's `@vite` directive automatically uses pre-built assets when available

## 🔒 Security

- Session-based authentication with custom middleware
- CSRF protection enabled
- Password hashing for user credentials
- Maintenance module requires additional authentication

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

**Built with ❤️ using Laravel**




