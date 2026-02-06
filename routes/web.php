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
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

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
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::post('/admin/users/{id}', [AdminController::class, 'updateUser'])->whereNumber('id')->name('admin.users.update');
    Route::post('/admin/users/{id}/delete', [AdminController::class, 'deleteUser'])->whereNumber('id')->name('admin.users.delete');
    Route::post('/admin/users/bulk-delete', [AdminController::class, 'bulkDeleteUsers'])->name('admin.users.bulk-delete');
    Route::get('/admin/job-titles', [AdminController::class, 'jobTitles'])->name('admin.job-titles');
    Route::post('/admin/job-titles', [AdminController::class, 'storeJobTitle'])->name('admin.job-titles.store');
    Route::post('/admin/job-titles/{id}', [AdminController::class, 'updateJobTitle'])->whereNumber('id')->name('admin.job-titles.update');
    Route::post('/admin/job-titles/{id}/delete', [AdminController::class, 'deleteJobTitle'])->whereNumber('id')->name('admin.job-titles.delete');
    Route::post('/admin/job-titles/bulk-delete', [AdminController::class, 'bulkDeleteJobTitles'])->name('admin.job-titles.bulk-delete');
    Route::get('/admin/pay-grades', [AdminController::class, 'payGrades'])->name('admin.pay-grades');
    Route::get('/admin/employment-status', [AdminController::class, 'employmentStatus'])->name('admin.employment-status');
    Route::post('/admin/employment-status', [AdminController::class, 'storeEmploymentStatus'])->name('admin.employment-status.store');
    Route::post('/admin/employment-status/{id}', [AdminController::class, 'updateEmploymentStatus'])->whereNumber('id')->name('admin.employment-status.update');
    Route::post('/admin/employment-status/{id}/delete', [AdminController::class, 'deleteEmploymentStatus'])->whereNumber('id')->name('admin.employment-status.delete');
    Route::post('/admin/employment-status/bulk-delete', [AdminController::class, 'bulkDeleteEmploymentStatuses'])->name('admin.employment-status.bulk-delete');
    Route::get('/admin/job-categories', [AdminController::class, 'jobCategories'])->name('admin.job-categories');
    Route::get('/admin/work-shifts', [AdminController::class, 'workShifts'])->name('admin.work-shifts');
    
    // Organization routes
    Route::get('/admin/organization/general-information', [AdminController::class, 'organizationGeneral'])->name('admin.organization.general-information');
    Route::post('/admin/organization/general-information', [AdminController::class, 'updateOrganizationGeneral'])->name('admin.organization.general-information.update');
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
    Route::post('/pim/employee-list', [PIMController::class, 'storeEmployee'])->name('pim.employee-list.store');
    Route::post('/pim/employee-list/bulk-delete', [PIMController::class, 'bulkDeleteEmployees'])->name('pim.employee-list.bulk-delete');
    Route::post('/pim/employee-list/{id}', [PIMController::class, 'updateEmployee'])
        ->whereNumber('id')
        ->name('pim.employee-list.update');
    Route::post('/pim/employee-list/{id}/delete', [PIMController::class, 'deleteEmployee'])
        ->whereNumber('id')
        ->name('pim.employee-list.delete');
    Route::get('/pim/add-employee', [PIMController::class, 'addEmployee'])->name('pim.add-employee');
    Route::get('/pim/add-employee/{id}', [PIMController::class, 'editEmployee'])
        ->whereNumber('id')
        ->name('pim.add-employee.edit');
    Route::get('/pim/reports', [PIMController::class, 'reports'])->name('pim.reports');
    Route::post('/pim/reports', [PIMController::class, 'storeReport'])->name('pim.reports.store');
    Route::post('/pim/reports/bulk-delete', [PIMController::class, 'bulkDeleteReports'])->name('pim.reports.bulk-delete');
    Route::post('/pim/reports/{id}', [PIMController::class, 'updateReport'])
        ->whereNumber('id')
        ->name('pim.reports.update');
    Route::post('/pim/reports/{id}/delete', [PIMController::class, 'deleteReport'])
        ->whereNumber('id')
        ->name('pim.reports.delete');
    
    // PIM Configuration routes
    Route::get('/pim/configuration/optional-fields', [PIMController::class, 'optionalFields'])->name('pim.configuration.optional-fields');
    Route::post('/pim/configuration/optional-fields', [PIMController::class, 'saveOptionalFields'])->name('pim.configuration.optional-fields.save');
    Route::get('/pim/configuration/custom-fields', [PIMController::class, 'customFields'])->name('pim.configuration.custom-fields');
    Route::post('/pim/configuration/custom-fields', [PIMController::class, 'storeCustomField'])->name('pim.configuration.custom-fields.store');
    Route::post('/pim/configuration/custom-fields/bulk-delete', [PIMController::class, 'bulkDeleteCustomFields'])->name('pim.configuration.custom-fields.bulk-delete');
    Route::post('/pim/configuration/custom-fields/{id}', [PIMController::class, 'updateCustomField'])
        ->whereNumber('id')
        ->name('pim.configuration.custom-fields.update');
    Route::post('/pim/configuration/custom-fields/{id}/delete', [PIMController::class, 'deleteCustomField'])
        ->whereNumber('id')
        ->name('pim.configuration.custom-fields.delete');

    Route::get('/pim/configuration/data-import', [PIMController::class, 'dataImport'])->name('pim.configuration.data-import');
    Route::post('/pim/configuration/data-import', [PIMController::class, 'handleDataImport'])->name('pim.configuration.data-import.upload');
    Route::get('/pim/configuration/data-import/sample', [PIMController::class, 'downloadDataImportSample'])->name('pim.configuration.data-import.sample');

    Route::get('/pim/configuration/reporting-methods', [PIMController::class, 'reportingMethods'])->name('pim.configuration.reporting-methods');
    Route::post('/pim/configuration/reporting-methods', [PIMController::class, 'storeReportingMethod'])->name('pim.configuration.reporting-methods.store');
    Route::post('/pim/configuration/reporting-methods/bulk-delete', [PIMController::class, 'bulkDeleteReportingMethods'])->name('pim.configuration.reporting-methods.bulk-delete');
    Route::post('/pim/configuration/reporting-methods/{id}', [PIMController::class, 'updateReportingMethod'])
        ->whereNumber('id')
        ->name('pim.configuration.reporting-methods.update');
    Route::post('/pim/configuration/reporting-methods/{id}/delete', [PIMController::class, 'deleteReportingMethod'])
        ->whereNumber('id')
        ->name('pim.configuration.reporting-methods.delete');

    Route::get('/pim/configuration/termination-reasons', [PIMController::class, 'terminationReasons'])->name('pim.configuration.termination-reasons');
    Route::post('/pim/configuration/termination-reasons', [PIMController::class, 'storeTerminationReason'])->name('pim.configuration.termination-reasons.store');
    Route::post('/pim/configuration/termination-reasons/bulk-delete', [PIMController::class, 'bulkDeleteTerminationReasons'])->name('pim.configuration.termination-reasons.bulk-delete');
    Route::post('/pim/configuration/termination-reasons/{id}', [PIMController::class, 'updateTerminationReason'])
        ->whereNumber('id')
        ->name('pim.configuration.termination-reasons.update');
    Route::post('/pim/configuration/termination-reasons/{id}/delete', [PIMController::class, 'deleteTerminationReason'])
        ->whereNumber('id')
        ->name('pim.configuration.termination-reasons.delete');
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave');
    Route::get('/leave/apply', [LeaveController::class, 'apply'])->name('leave.apply');
    Route::post('/leave/apply', [LeaveController::class, 'store'])->name('leave.store');
    Route::get('/leave/my-leave', [LeaveController::class, 'myLeave'])->name('leave.my-leave');
    Route::get('/leave/leave-list', [LeaveController::class, 'leaveList'])->name('leave.leave-list');
    Route::post('/leave/cancel/{id}', [LeaveController::class, 'cancelLeave'])->whereNumber('id')->name('leave.cancel');
    Route::post('/leave/reject/{id}', [LeaveController::class, 'rejectLeave'])->whereNumber('id')->name('leave.reject');
    Route::post('/leave/approve/{id}', [LeaveController::class, 'approveLeave'])->whereNumber('id')->name('leave.approve');
    Route::get('/leave/get-leave-data/{id}', [LeaveController::class, 'getLeaveData'])->whereNumber('id')->name('leave.get-leave-data');
    Route::post('/leave/update/{id}', [LeaveController::class, 'updateLeave'])->whereNumber('id')->name('leave.update');
    Route::post('/leave/bulk-delete', [LeaveController::class, 'bulkDeleteLeaves'])->name('leave.bulk-delete');
    Route::get('/leave/assign-leave', [LeaveController::class, 'assignLeave'])->name('leave.assign-leave');
    Route::post('/leave/assign-leave', [LeaveController::class, 'storeAssignLeave'])->name('leave.assign-leave.store');
    Route::get('/leave/get-balance', [LeaveController::class, 'getLeaveBalance'])->name('leave.get-balance');
    
    // Entitlements
    Route::get('/leave/add-entitlement', [LeaveController::class, 'addEntitlement'])->name('leave.add-entitlement');
    Route::get('/leave/my-entitlements', [LeaveController::class, 'myEntitlements'])->name('leave.my-entitlements');
    Route::get('/leave/employee-entitlements', [LeaveController::class, 'employeeEntitlements'])->name('leave.employee-entitlements');
    
    // Reports
    Route::get('/leave/entitlements-usage-report', [LeaveController::class, 'entitlementsUsageReport'])->name('leave.entitlements-usage-report');
    Route::get('/leave/my-entitlements-usage-report', [LeaveController::class, 'myEntitlementsUsageReport'])->name('leave.my-entitlements-usage-report');
    
    // Configure
    Route::get('/leave/leave-types', [LeaveController::class, 'leaveTypes'])->name('leave.leave-types');
    Route::post('/leave/leave-types/store', [LeaveController::class, 'storeLeaveType'])->name('leave.leave-types.store');
    Route::post('/leave/leave-types/update/{id}', [LeaveController::class, 'updateLeaveType'])->whereNumber('id')->name('leave.leave-types.update');
    Route::post('/leave/leave-types/delete/{id}', [LeaveController::class, 'deleteLeaveType'])->whereNumber('id')->name('leave.leave-types.delete');
    Route::post('/leave/leave-types/bulk-delete', [LeaveController::class, 'bulkDeleteLeaveTypes'])->name('leave.leave-types.bulk-delete');
    Route::get('/leave/leave-period', [LeaveController::class, 'leavePeriod'])->name('leave.leave-period');
    Route::get('/leave/work-week', [LeaveController::class, 'workWeek'])->name('leave.work-week');
    Route::post('/leave/work-week/store', [LeaveController::class, 'storeWorkWeek'])->name('leave.work-week.store');
    Route::get('/leave/holidays', [LeaveController::class, 'holidays'])->name('leave.holidays');
    Route::post('/leave/holidays', [LeaveController::class, 'storeHoliday'])->name('leave.holidays.store');
    Route::post('/leave/holidays/{id}', [LeaveController::class, 'updateHoliday'])->name('leave.holidays.update');
    Route::post('/leave/holidays/{id}/delete', [LeaveController::class, 'deleteHoliday'])->name('leave.holidays.delete');
    Route::post('/leave/holidays/bulk-delete', [LeaveController::class, 'bulkDeleteHolidays'])->name('leave.holidays.bulk-delete');
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
    
    // Time - Project Info routes
    Route::get('/time/project-info/customers', [TimeController::class, 'projectInfoCustomers'])->name('time.project-info.customers');
    Route::post('/time/project-info/customers/store', [TimeController::class, 'storeCustomer'])->name('time.project-info.customers.store');
    Route::post('/time/project-info/customers/update/{id}', [TimeController::class, 'updateCustomer'])->whereNumber('id')->name('time.project-info.customers.update');
    Route::post('/time/project-info/customers/delete/{id}', [TimeController::class, 'deleteCustomer'])->whereNumber('id')->name('time.project-info.customers.delete');
    Route::post('/time/project-info/customers/bulk-delete', [TimeController::class, 'bulkDeleteCustomers'])->name('time.project-info.customers.bulk-delete');
    Route::get('/time/project-info/projects', [TimeController::class, 'projectInfoProject'])->name('time.project-info.projects');
    Route::post('/time/project-info/projects/store', [TimeController::class, 'storeProject'])->name('time.project-info.projects.store');
    Route::post('/time/project-info/projects/update/{id}', [TimeController::class, 'updateProject'])->whereNumber('id')->name('time.project-info.projects.update');
    Route::post('/time/project-info/projects/delete/{id}', [TimeController::class, 'deleteProject'])->whereNumber('id')->name('time.project-info.projects.delete');
    Route::post('/time/project-info/projects/bulk-delete', [TimeController::class, 'bulkDeleteProjects'])->name('time.project-info.projects.bulk-delete');
    Route::get('/recruitment', [RecruitmentController::class, 'index'])->name('recruitment');
    Route::get('/recruitment/vacancies', [RecruitmentController::class, 'vacancies'])->name('recruitment.vacancies');
    Route::get('/my-info', [MyInfoController::class, 'index'])->name('myinfo');
    Route::get('/my-info/test-session', function() {
        $authUser = session('auth_user');
        return 'Current session: ' . json_encode($authUser);
    });
    Route::get('/my-info/debug-session', function() {
        $authUser = session('auth_user');
        $dbUser = null;
        if ($authUser && isset($authUser['id'])) {
            $dbUser = \DB::table('users')->where('id', $authUser['id'])->first();
        }
        return [
            'session' => $authUser,
            'database' => $dbUser
        ];
    });
    Route::post('/my-info/personal-details', [MyInfoController::class, 'updatePersonalDetails'])->name('myinfo.personal.update');
    Route::post('/my-info/photo', [MyInfoController::class, 'updatePhoto'])->name('myinfo.photo.update');
    Route::post('/my-info/custom-fields', [MyInfoController::class, 'updateCustomFields'])->name('myinfo.custom.update');
    Route::post('/my-info/attachments', [MyInfoController::class, 'storeAttachment'])->name('myinfo.attachments.store');
    Route::post('/my-info/attachments/{id}/update', [MyInfoController::class, 'updateAttachment'])->name('myinfo.attachments.update');
    Route::post('/my-info/attachments/{id}/delete', [MyInfoController::class, 'deleteAttachment'])->name('myinfo.attachments.delete');
    Route::post('/my-info/attachments/bulk-delete', [MyInfoController::class, 'bulkDeleteAttachments'])->name('myinfo.attachments.bulk-delete');
    Route::get('/my-info/attachments/{id}/download', [MyInfoController::class, 'downloadAttachment'])->name('myinfo.attachments.download');
    Route::get('/my-info/contact-details', [MyInfoController::class, 'contactDetails'])->name('myinfo.contact-details');
    Route::post('/my-info/contact-details', [MyInfoController::class, 'updateContactDetails'])->name('myinfo.contact.update');
    Route::get('/my-info/emergency-contacts', [MyInfoController::class, 'emergencyContacts'])->name('myinfo.emergency-contacts');
    Route::post('/my-info/emergency-contacts', [MyInfoController::class, 'storeEmergencyContact'])->name('myinfo.emergency.store');
    Route::put('/my-info/emergency-contacts/{id}', [MyInfoController::class, 'updateEmergencyContact'])->name('myinfo.emergency.update');
    Route::delete('/my-info/emergency-contacts/{id}', [MyInfoController::class, 'deleteEmergencyContact'])->name('myinfo.emergency.delete');
    Route::post('/my-info/emergency-contacts/bulk-delete', [MyInfoController::class, 'bulkDeleteEmergencyContacts'])->name('myinfo.emergency.bulk-delete');
    Route::get('/my-info/dependents', [MyInfoController::class, 'dependents'])->name('myinfo.dependents');
    Route::get('/my-info/immigration', [MyInfoController::class, 'immigration'])->name('myinfo.immigration');
    Route::get('/my-info/job', [MyInfoController::class, 'job'])->name('myinfo.job');
    Route::get('/my-info/salary', [MyInfoController::class, 'salary'])->name('myinfo.salary');
    Route::get('/my-info/report-to', [MyInfoController::class, 'reportTo'])->name('myinfo.report-to');
    Route::get('/my-info/qualifications', [MyInfoController::class, 'qualifications'])->name('myinfo.qualifications');
    Route::get('/my-info/profile-photo', [MyInfoController::class, 'profilePhoto'])->name('myinfo.profile-photo');
    Route::post('/my-info/qualifications/work-experience', [MyInfoController::class, 'storeWorkExperience'])->name('myinfo.qualifications.work-experience.store');
    Route::put('/my-info/qualifications/work-experience/{id}', [MyInfoController::class, 'updateWorkExperience'])->name('myinfo.qualifications.work-experience.update');
    Route::delete('/my-info/qualifications/work-experience/{id}', [MyInfoController::class, 'deleteWorkExperience'])->name('myinfo.qualifications.work-experience.delete');
    Route::post('/my-info/qualifications/work-experience/bulk-delete', [MyInfoController::class, 'bulkDeleteWorkExperience'])->name('myinfo.qualifications.work-experience.bulk-delete');
    Route::post('/my-info/qualifications/education', [MyInfoController::class, 'storeEducation'])->name('myinfo.qualifications.education.store');
    Route::put('/my-info/qualifications/education/{id}', [MyInfoController::class, 'updateEducation'])->name('myinfo.qualifications.education.update');
    Route::delete('/my-info/qualifications/education/{id}', [MyInfoController::class, 'deleteEducation'])->name('myinfo.qualifications.education.delete');
    Route::post('/my-info/qualifications/education/bulk-delete', [MyInfoController::class, 'bulkDeleteEducation'])->name('myinfo.qualifications.education.bulk-delete');
    Route::post('/my-info/qualifications/skills', [MyInfoController::class, 'storeSkill'])->name('myinfo.qualifications.skills.store');
    Route::put('/my-info/qualifications/skills/{id}', [MyInfoController::class, 'updateSkill'])->name('myinfo.qualifications.skills.update');
    Route::delete('/my-info/qualifications/skills/{id}', [MyInfoController::class, 'deleteSkill'])->name('myinfo.qualifications.skills.delete');
    Route::post('/my-info/qualifications/skills/bulk-delete', [MyInfoController::class, 'bulkDeleteSkills'])->name('myinfo.qualifications.skills.bulk-delete');
    Route::post('/my-info/qualifications/languages', [MyInfoController::class, 'storeLanguage'])->name('myinfo.qualifications.languages.store');
    Route::put('/my-info/qualifications/languages/{id}', [MyInfoController::class, 'updateLanguage'])->name('myinfo.qualifications.languages.update');
    Route::delete('/my-info/qualifications/languages/{id}', [MyInfoController::class, 'deleteLanguage'])->name('myinfo.qualifications.languages.delete');
    Route::post('/my-info/qualifications/languages/bulk-delete', [MyInfoController::class, 'bulkDeleteLanguages'])->name('myinfo.qualifications.languages.bulk-delete');
    Route::post('/my-info/qualifications/licenses', [MyInfoController::class, 'storeLicense'])->name('myinfo.qualifications.licenses.store');
    Route::put('/my-info/qualifications/licenses/{id}', [MyInfoController::class, 'updateLicense'])->name('myinfo.qualifications.licenses.update');
    Route::delete('/my-info/qualifications/licenses/{id}', [MyInfoController::class, 'deleteLicense'])->name('myinfo.qualifications.licenses.delete');
    Route::post('/my-info/qualifications/licenses/bulk-delete', [MyInfoController::class, 'bulkDeleteLicenses'])->name('myinfo.qualifications.licenses.bulk-delete');
    Route::post('/my-info/qualifications/attachments', [MyInfoController::class, 'storeQualificationAttachment'])->name('myinfo.qualifications.attachments.store');
    Route::delete('/my-info/qualifications/attachments/{id}', [MyInfoController::class, 'deleteQualificationAttachment'])->name('myinfo.qualifications.attachments.delete');
    Route::get('/my-info/memberships', [MyInfoController::class, 'memberships'])->name('myinfo.memberships');
    Route::get('/performance', [PerformanceController::class, 'index'])->name('performance');
    Route::get('/performance/my-trackers', [PerformanceController::class, 'myTrackers'])->name('performance.my-trackers');
    Route::get('/performance/employee-trackers', [PerformanceController::class, 'employeeTrackers'])->name('performance.employee-trackers');
    Route::get('/performance/kpis', [PerformanceController::class, 'kpis'])->name('performance.kpis');
    Route::get('/performance/trackers', [PerformanceController::class, 'trackers'])->name('performance.trackers');
    Route::get('/performance/my-reviews', [PerformanceController::class, 'myReviews'])->name('performance.my-reviews');
    Route::get('/performance/employee-reviews', [PerformanceController::class, 'employeeReviews'])->name('performance.employee-reviews');
    Route::get('/directory', [DirectoryController::class, 'index'])->name('directory');
    Route::get('/claim', [ClaimController::class, 'index'])->name('claim');
    Route::post('/claim/{id}/cancel', [ClaimController::class, 'cancelClaim'])->whereNumber('id')->name('claim.cancel');
    Route::post('/claim/{id}/reject', [ClaimController::class, 'rejectClaim'])->whereNumber('id')->name('claim.reject');
    Route::post('/claim/{id}/approve', [ClaimController::class, 'approveClaim'])->whereNumber('id')->name('claim.approve');
    Route::post('/claim/bulk-delete', [ClaimController::class, 'bulkDeleteClaims'])->name('claim.bulk-delete');
    Route::get('/claim/submit', [ClaimController::class, 'submit'])->name('claim.submit');
    Route::post('/claim/submit', [ClaimController::class, 'storeSubmitClaim'])->name('claim.submit.store');
    Route::get('/claim/my-claims', [ClaimController::class, 'myClaims'])->name('claim.my-claims');
    Route::get('/claim/assign', [ClaimController::class, 'assignClaim'])->name('claim.assign');
    Route::post('/claim/assign', [ClaimController::class, 'storeAssignClaim'])->name('claim.assign.store');
    Route::get('/claim/configuration/events', [ClaimController::class, 'events'])->name('claim.configuration.events');
    Route::post('/claim/configuration/events', [ClaimController::class, 'storeEvent'])->name('claim.configuration.events.store');
    Route::post('/claim/configuration/events/{id}', [ClaimController::class, 'updateEvent'])->whereNumber('id')->name('claim.configuration.events.update');
    Route::post('/claim/configuration/events/{id}/delete', [ClaimController::class, 'deleteEvent'])->whereNumber('id')->name('claim.configuration.events.delete');
    Route::post('/claim/configuration/events/bulk-delete', [ClaimController::class, 'bulkDeleteEvents'])->name('claim.configuration.events.bulk-delete');
    Route::get('/claim/configuration/events/add', [ClaimController::class, 'addEvent'])->name('claim.configuration.events.add');
    Route::get('/claim/configuration/events/{id}/edit', [ClaimController::class, 'editEvent'])->whereNumber('id')->name('claim.configuration.events.edit');
    Route::get('/claim/configuration/expenses-types', [ClaimController::class, 'expensesTypes'])->name('claim.configuration.expenses-types');
    Route::post('/claim/configuration/expenses-types', [ClaimController::class, 'storeExpenseType'])->name('claim.configuration.expenses-types.store');
    Route::post('/claim/configuration/expenses-types/{id}', [ClaimController::class, 'updateExpenseType'])->whereNumber('id')->name('claim.configuration.expenses-types.update');
    Route::post('/claim/configuration/expenses-types/{id}/delete', [ClaimController::class, 'deleteExpenseType'])->whereNumber('id')->name('claim.configuration.expenses-types.delete');
    Route::post('/claim/configuration/expenses-types/bulk-delete', [ClaimController::class, 'bulkDeleteExpenseTypes'])->name('claim.configuration.expenses-types.bulk-delete');
    Route::get('/claim/configuration/expenses-types/add', [ClaimController::class, 'addExpenseType'])->name('claim.configuration.expenses-types.add');
    Route::get('/claim/configuration/expenses-types/{id}/edit', [ClaimController::class, 'editExpenseType'])->whereNumber('id')->name('claim.configuration.expenses-types.edit');
    Route::get('/buzz', [BuzzController::class, 'index'])->name('buzz');
    
    // Profile routes
    Route::get('/profile/about', [ProfileController::class, 'about'])->name('profile.about');
    Route::get('/profile/support', [ProfileController::class, 'support'])->name('profile.support');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});
