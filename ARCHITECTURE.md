# TOAI HR Suite — Codebase Architecture & Structure (Team Project)

This document is a **code-accurate** explanation of how this Laravel project is structured and how it works at runtime. It is written so you can understand and extend the system **without changing the overall folder structure**.

## High-level overview

- **Framework**: Laravel (the codebase is a standard Laravel app; `public/index.php` boots `bootstrap/app.php`).
- **Architecture**: MVC (Controllers return Blade Views, optionally passing data arrays).
- **Frontend build**: Vite + Tailwind CSS (`@vite(['resources/css/app.css', 'resources/js/app.js'])` in the base layout).
- **Auth model**: Custom **session-based** auth using a middleware alias `auth.session` and a session key `auth_user` (not Laravel’s default auth scaffolding).

## Actual versions (from dependency files)

- **PHP**: `^8.2` (`composer.json`)
- **Laravel framework**: `^12.0` (`composer.json`)
- **Vite**: `^7.x` (`package.json`)
- **Tailwind**: `^4.x` (`package.json` via `@tailwindcss/vite`)

Note: `README.md` mentions Laravel 11 / Tailwind 3, but the dependency files indicate newer versions.

## Runtime request flow (HTTP lifecycle)

1. **Web server entrypoint**
   - All requests enter through `public/index.php`.
2. **Laravel bootstrap**
   - `bootstrap/app.php` configures routing and middleware aliases.
3. **Routing**
   - Web routes are defined in `routes/web.php`.
4. **Middleware**
   - Protected routes are grouped with `Route::middleware('auth.session')`.
   - Alias is registered in `bootstrap/app.php`:
     - `'auth.session' => \App\Http\Middleware\AuthSession::class`
5. **Controllers**
   - Controllers live in `app/Http/Controllers`.
   - Most endpoints call `return view('some.path', $data)`.
6. **Views**
   - Views are Blade templates in `resources/views`.
   - Layout uses `resources/views/layouts/app.blade.php`.
7. **Assets**
   - CSS/JS entrypoints are `resources/css/app.css` and `resources/js/app.js`.
   - Vite is configured in `vite.config.js`.

## Authentication and authorization (how it is implemented here)

### Login flow

- **Routes**
  - `GET /login` → `LoginController@show`
  - `POST /login` → `LoginController@authenticate`
  - `POST /logout` → `LoginController@logout`
  - `GET /` redirects to `/login`

- **Where it’s implemented**
  - Controller: `app/Http/Controllers/Auth/LoginController.php`
  - View: `resources/views/auth/login.blade.php`

- **Session contract (important for team consistency)**
  - On successful login, code sets:
    - `session('auth_user') = ['name' => 'Admin', 'username' => 'admin']`
  - The middleware checks:
    - If **no** `auth_user` in session → redirect to `route('login')`

This is **not** Laravel’s default user provider/login; it’s a simplified, project-specific implementation.

### Protected pages

All app pages (dashboard + modules) are behind:

```text
Route::middleware('auth.session')->group(...)
```

Meaning: if `auth_user` isn’t present in the session, the user is redirected to `/login`.

### Maintenance “second authentication”

Maintenance routes are protected twice:

1) Must pass `auth.session` (normal login)  
2) Must also have `session('maintenance_auth')` set

Implementation:

- Controller: `app/Http/Controllers/MaintenanceController.php`
- Session key: `maintenance_auth` (boolean)
- Flow:
  - Visiting `/maintenance/auth` clears existing `maintenance_auth` and shows the maintenance auth form.
  - Successful POST sets `maintenance_auth = true` and redirects into maintenance pages.

## Routing map (module → route → controller → view)

This project organizes UI features as “modules” (Admin, PIM, Leave, etc.). Each module is:

- A **route** in `routes/web.php`
- A **controller** method in `app/Http/Controllers/*Controller.php`
- A **Blade view** in `resources/views/<module>/<module>.blade.php` (pattern used in this codebase)

### Core pages

- **Dashboard**
  - Route: `GET /dashboard`
  - Controller: `DashboardController@index`
  - View: `resources/views/dashboard/dashboard.blade.php`

### Modules (top-level)

- **Admin**
  - Route: `GET /admin`
  - Controller: `AdminController@index`
  - View: `resources/views/admin/admin.blade.php`
  - Also contains many sub-pages like:
    - `/admin/job-titles` → `resources/views/admin/job/job-titles.blade.php`
    - `/admin/organization/locations` → `resources/views/admin/organization/locations.blade.php`
    - `/admin/configuration/*` → `resources/views/admin/configuration/*.blade.php`

- **PIM**
  - Route: `GET /pim`
  - Controller: `PIMController@index`
  - View: `resources/views/pim/pim.blade.php`

- **Leave**
  - Route: `GET /leave`
  - Controller: `LeaveController@index`
  - View: `resources/views/leave/leave.blade.php`

- **Time**
  - Route: `GET /time`
  - Controller: `TimeController@index`
  - View: `resources/views/time/time.blade.php`

- **Recruitment**
  - Route: `GET /recruitment`
  - Controller: `RecruitmentController@index`
  - View: `resources/views/recruitment/recruitment.blade.php`

- **My Info**
  - Route: `GET /my-info`
  - Controller: `MyInfoController@index`
  - View: `resources/views/myinfo/myinfo.blade.php`

- **Performance**
  - Route: `GET /performance`
  - Controller: `PerformanceController@index`
  - View: `resources/views/performance/performance.blade.php`

- **Directory**
  - Route: `GET /directory`
  - Controller: `DirectoryController@index`
  - View: `resources/views/directory/directory.blade.php`

- **Claim**
  - Route: `GET /claim`
  - Controller: `ClaimController@index`
  - View: `resources/views/claim/claim.blade.php`

- **Buzz**
  - Route: `GET /buzz`
  - Controller: `BuzzController@index`
  - View: `resources/views/buzz/buzz.blade.php`

### Profile (header dropdown)

- Support page:
  - Route: `GET /profile/support`
  - View: `resources/views/profile/support.blade.php`
- Change password:
  - `GET /profile/change-password`
  - `POST /profile/change-password` (validates input and redirects back with success)
  - View: `resources/views/profile/change-password.blade.php`
- About:
  - Route: `GET /profile/about`
  - Returns **JSON** (used by the “About” modal in JS)

## UI composition (layouts + Blade components)

### Base HTML layout

- File: `resources/views/layouts/app.blade.php`
- Responsibilities:
  - Loads fonts + FontAwesome
  - Loads Vite bundles (`app.css` + `app.js`)
  - Initializes theme early to reduce “flash”
  - Exposes `@yield('body')` for pages
  - Includes a global dropdown portal container: `<div id="hr-dropdown-portal"></div>`

### Main app shell

Most authenticated pages use the Blade component:

- `resources/views/components/main-layout.blade.php`

It renders:

- `<x-sidebar />` (`resources/views/components/sidebar.blade.php`)
- `<x-header />` (`resources/views/components/header.blade.php`)
- A slot for the page content

This is the “fixed sidebar + fixed header” layout used across modules.

### Blade component code (PHP)

There are PHP-backed Blade components in:

- `app/View/Components/*`

Examples:

- `app/View/Components/DropdownMenu.php`
- `app/View/Components/Admin/ColorPicker.php`

Their matching templates live in:

- `resources/views/components/*`

## Frontend assets (theme, dropdowns, sidebar)

### JS entrypoint

- File: `resources/js/app.js`
- Main responsibilities:
  - Theme toggle and icon switching (stores `hr-theme` in localStorage)
  - Profile dropdown rendered into a portal (`#hr-dropdown-portal`)
  - “About” modal that fetches `/profile/about` and displays JSON data
  - Sidebar collapse state persisted with `hr-sidebar-collapsed`

Important nuance: the login page forces light theme and resets theme to light.

### CSS entrypoint

- File: `resources/css/app.css`
- Uses Tailwind v4 style directives (e.g. `@import 'tailwindcss';`).
- Implements “design tokens” via CSS variables for:
  - Light theme defaults
  - Dark theme overrides (`html[data-theme="dark"]`)
- Provides many project-wide component classes:
  - `.hr-sidebar`, `.hr-header`, `.hr-card`, `.hr-btn-primary`, `.hr-table-wrapper`, etc.

## Data layer status (what exists today)

- Controllers mostly return **static sample arrays** (e.g., Admin users, PIM employees, etc.).
- There are default Laravel migrations in `database/migrations` (users/cache/jobs), but the current module pages are not using Eloquent/database yet.

This means: the UI currently behaves like a **prototype / static demo**. Converting a module to real DB data would typically involve:

- Creating real models in `app/Models`
- Creating migrations/seeders in `database/`
- Replacing hard-coded arrays inside controllers with database queries

## “Don’t change the structure” extension points (safe places to work)

If you must keep the team’s folder structure, these are the safest ways to extend:

- **New page under existing module**
  - Add a new route in `routes/web.php`
  - Add method in the module controller
  - Add new Blade view under `resources/views/<module>/...`

- **Shared UI**
  - Put reusable markup into `resources/views/components/*`
  - If you need logic/props, add a matching PHP component in `app/View/Components/*`

- **Cross-cutting behavior**
  - Add middleware in `app/Http/Middleware`
  - Register alias in `bootstrap/app.php` (same pattern as `auth.session`)

## Common “where do I change X?” quick guide

- **A URL/page mapping**: `routes/web.php`
- **What a page returns / data passed to view**: `app/Http/Controllers/*Controller.php`
- **Actual HTML for a page**: `resources/views/<module>/*.blade.php`
- **Header/sidebar layout**: `resources/views/components/{header,sidebar,main-layout}.blade.php`
- **Theme, dropdown, sidebar collapse**: `resources/js/app.js` and `resources/css/app.css`
- **Vite inputs**: `vite.config.js`

