<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PIMController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\MyInfoController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\BuzzController;
use App\Http\Controllers\ProfileController;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::get('/', function() {
    return redirect()->route('login');
});

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Maintenance routes (requires main auth, then maintenance auth)
Route::middleware('auth.session')->group(function () {
    Route::get('/maintenance/auth', [MaintenanceController::class, 'showAuth'])->name('maintenance.auth');
    Route::post('/maintenance/auth', [MaintenanceController::class, 'authenticate'])->name('maintenance.auth.post');
    
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/purge-employee', [MaintenanceController::class, 'purgeEmployee'])->name('maintenance.purge-employee');
    Route::get('/maintenance/purge-candidate', [MaintenanceController::class, 'purgeCandidate'])->name('maintenance.purge-candidate');
    Route::get('/maintenance/access-records', [MaintenanceController::class, 'accessRecords'])->name('maintenance.access-records');
});

Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin routes
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/admin/job-titles', [AdminController::class, 'jobTitles'])->name('admin.job-titles');
    Route::get('/admin/pay-grades', [AdminController::class, 'payGrades'])->name('admin.pay-grades');
    Route::get('/admin/employment-status', [AdminController::class, 'employmentStatus'])->name('admin.employment-status');
    Route::get('/admin/job-categories', [AdminController::class, 'jobCategories'])->name('admin.job-categories');
    Route::get('/admin/work-shifts', [AdminController::class, 'workShifts'])->name('admin.work-shifts');
    
    // Organization routes
    Route::get('/admin/organization/general-information', [AdminController::class, 'organizationGeneral'])->name('admin.organization.general-information');
    Route::get('/admin/organization/locations', [AdminController::class, 'organizationLocations'])->name('admin.organization.locations');
    Route::get('/admin/organization/structure', [AdminController::class, 'organizationStructure'])->name('admin.organization.structure');
    
    // Qualifications routes
    Route::get('/admin/qualifications/skills', [AdminController::class, 'qualificationsSkills'])->name('admin.qualifications.skills');
    Route::get('/admin/qualifications/education', [AdminController::class, 'qualificationsEducation'])->name('admin.qualifications.education');
    Route::get('/admin/qualifications/licenses', [AdminController::class, 'qualificationsLicenses'])->name('admin.qualifications.licenses');
    Route::get('/admin/qualifications/languages', [AdminController::class, 'qualificationsLanguages'])->name('admin.qualifications.languages');
    Route::get('/admin/qualifications/memberships', [AdminController::class, 'qualificationsMemberships'])->name('admin.qualifications.memberships');
    
    // Nationalities route
    Route::get('/admin/nationalities', [AdminController::class, 'nationalities'])->name('admin.nationalities');
    
    // Corporate Branding route
    Route::get('/admin/corporate-branding', [AdminController::class, 'corporateBranding'])->name('admin.corporate-branding');
    
    // Configuration routes
    Route::get('/admin/configuration/email-configuration', [AdminController::class, 'emailConfiguration'])->name('admin.configuration.email-configuration');
    Route::get('/admin/configuration/email-subscriptions', [AdminController::class, 'emailSubscriptions'])->name('admin.configuration.email-subscriptions');
    Route::get('/admin/configuration/localization', [AdminController::class, 'localization'])->name('admin.configuration.localization');
    Route::get('/admin/configuration/language-packages', [AdminController::class, 'languagePackages'])->name('admin.configuration.language-packages');
    Route::get('/admin/configuration/modules', [AdminController::class, 'moduleConfiguration'])->name('admin.configuration.modules');
    Route::get('/admin/configuration/social-media-authentication', [AdminController::class, 'socialMediaAuthentication'])->name('admin.configuration.social-media-authentication');
    Route::get('/admin/configuration/oauth-client-list', [AdminController::class, 'oauthClientList'])->name('admin.configuration.oauth-client-list');
    Route::get('/admin/configuration/ldap', [AdminController::class, 'ldapConfiguration'])->name('admin.configuration.ldap');
    
    Route::get('/pim', [PIMController::class, 'index'])->name('pim');
    
    // PIM routes
    Route::get('/pim/employee-list', [PIMController::class, 'employeeList'])->name('pim.employee-list');
    Route::get('/pim/add-employee', [PIMController::class, 'addEmployee'])->name('pim.add-employee');
    Route::get('/pim/reports', [PIMController::class, 'reports'])->name('pim.reports');
    
    // PIM Configuration routes
    Route::get('/pim/configuration/optional-fields', [PIMController::class, 'optionalFields'])->name('pim.configuration.optional-fields');
    Route::get('/pim/configuration/custom-fields', [PIMController::class, 'customFields'])->name('pim.configuration.custom-fields');
    Route::get('/pim/configuration/data-import', [PIMController::class, 'dataImport'])->name('pim.configuration.data-import');
    Route::get('/pim/configuration/reporting-methods', [PIMController::class, 'reportingMethods'])->name('pim.configuration.reporting-methods');
    Route::get('/pim/configuration/termination-reasons', [PIMController::class, 'terminationReasons'])->name('pim.configuration.termination-reasons');
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave');
    Route::get('/leave/apply', [LeaveController::class, 'apply'])->name('leave.apply');
    Route::get('/leave/my-leave', [LeaveController::class, 'myLeave'])->name('leave.my-leave');
    Route::get('/leave/leave-list', [LeaveController::class, 'leaveList'])->name('leave.leave-list');
    Route::get('/leave/assign-leave', [LeaveController::class, 'assignLeave'])->name('leave.assign-leave');
    
    // Entitlements
    Route::get('/leave/add-entitlement', [LeaveController::class, 'addEntitlement'])->name('leave.add-entitlement');
    Route::get('/leave/my-entitlements', [LeaveController::class, 'myEntitlements'])->name('leave.my-entitlements');
    Route::get('/leave/employee-entitlements', [LeaveController::class, 'employeeEntitlements'])->name('leave.employee-entitlements');
    
    // Reports
    Route::get('/leave/entitlements-usage-report', [LeaveController::class, 'entitlementsUsageReport'])->name('leave.entitlements-usage-report');
    Route::get('/leave/my-entitlements-usage-report', [LeaveController::class, 'myEntitlementsUsageReport'])->name('leave.my-entitlements-usage-report');
    
    // Configure
    Route::get('/leave/leave-types', [LeaveController::class, 'leaveTypes'])->name('leave.leave-types');
    Route::get('/leave/leave-period', [LeaveController::class, 'leavePeriod'])->name('leave.leave-period');
    Route::get('/leave/work-week', [LeaveController::class, 'workWeek'])->name('leave.work-week');
    Route::get('/leave/holidays', [LeaveController::class, 'holidays'])->name('leave.holidays');
    Route::get('/time', [TimeController::class, 'index'])->name('time');
    Route::get('/time/my-timesheets', [TimeController::class, 'myTimesheets'])->name('time.my-timesheets');
    Route::get('/time/my-timesheets/edit', [TimeController::class, 'editMyTimesheet'])->name('time.my-timesheets.edit');

    // Time - Attendance routes
    Route::get('/time/attendance/my-records', [TimeController::class, 'attendanceMyRecords'])->name('time.attendance.my-records');
    Route::get('/time/attendance/punch-in-out', [TimeController::class, 'attendancePunchInOut'])->name('time.attendance.punch-in-out');
    Route::get('/time/attendance/employee-records', [TimeController::class, 'attendanceEmployeeRecords'])->name('time.attendance.employee-records');
    Route::get('/time/attendance/configuration', [TimeController::class, 'attendanceConfiguration'])->name('time.attendance.configuration');
    
    // Time - Reports routes
    Route::get('/time/reports/project-reports', [TimeController::class, 'projectReports'])->name('time.reports.project-reports');
    Route::get('/time/reports/employee-reports', [TimeController::class, 'employeeReports'])->name('time.reports.employee-reports');
    Route::get('/time/reports/attendance-summary', [TimeController::class, 'attendanceSummary'])->name('time.reports.attendance-summary');
    Route::get('/recruitment', [RecruitmentController::class, 'index'])->name('recruitment');
    Route::get('/recruitment/vacancies', [RecruitmentController::class, 'vacancies'])->name('recruitment.vacancies');
    Route::get('/my-info', [MyInfoController::class, 'index'])->name('myinfo');
    Route::get('/performance', [PerformanceController::class, 'index'])->name('performance');
    Route::get('/performance/my-trackers', [PerformanceController::class, 'myTrackers'])->name('performance.my-trackers');
    Route::get('/performance/employee-trackers', [PerformanceController::class, 'employeeTrackers'])->name('performance.employee-trackers');
    Route::get('/performance/kpis', [PerformanceController::class, 'kpis'])->name('performance.kpis');
    Route::get('/performance/trackers', [PerformanceController::class, 'trackers'])->name('performance.trackers');
    Route::get('/performance/my-reviews', [PerformanceController::class, 'myReviews'])->name('performance.my-reviews');
    Route::get('/performance/employee-reviews', [PerformanceController::class, 'employeeReviews'])->name('performance.employee-reviews');
    Route::get('/directory', [DirectoryController::class, 'index'])->name('directory');
    Route::get('/claim', [ClaimController::class, 'index'])->name('claim');
    Route::get('/claim/submit', [ClaimController::class, 'submit'])->name('claim.submit');
    Route::get('/claim/my-claims', [ClaimController::class, 'myClaims'])->name('claim.my-claims');
    Route::get('/claim/assign', [ClaimController::class, 'assignClaim'])->name('claim.assign');
    Route::get('/claim/configuration/events', [ClaimController::class, 'events'])->name('claim.configuration.events');
    Route::get('/claim/configuration/events/add', [ClaimController::class, 'addEvent'])->name('claim.configuration.events.add');
    Route::get('/claim/configuration/expenses-types', [ClaimController::class, 'expensesTypes'])->name('claim.configuration.expenses-types');
    Route::get('/claim/configuration/expenses-types/add', [ClaimController::class, 'addExpenseType'])->name('claim.configuration.expenses-types.add');
    Route::get('/buzz', [BuzzController::class, 'index'])->name('buzz');
    
    // Profile routes
    Route::get('/profile/about', [ProfileController::class, 'about'])->name('profile.about');
    Route::get('/profile/support', [ProfileController::class, 'support'])->name('profile.support');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});
