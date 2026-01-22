<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Sample user data
        $users = [
            ['id' => 1, 'username' => 'Abhay1234', 'role' => 'ESS', 'employee_name' => 'Abhay Kasuhik', 'status' => 'Enabled'],
            ['id' => 2, 'username' => 'Admin', 'role' => 'Admin', 'employee_name' => 'FristName LastName', 'status' => 'Enabled'],
            ['id' => 3, 'username' => 'ammu@123', 'role' => 'ESS', 'employee_name' => 'jj jh', 'status' => 'Enabled'],
            ['id' => 4, 'username' => 'autoUser_1768969888535', 'role' => 'ESS', 'employee_name' => 'Ranga Akunuri', 'status' => 'Enabled'],
            ['id' => 5, 'username' => 'FMLName', 'role' => 'ESS', 'employee_name' => 'Qwerty LName', 'status' => 'Enabled'],
            ['id' => 6, 'username' => 'FMLName1', 'role' => 'ESS', 'employee_name' => 'FName LName', 'status' => 'Enabled'],
            ['id' => 7, 'username' => 'gurup', 'role' => 'ESS', 'employee_name' => 'guru poorni', 'status' => 'Enabled'],
            ['id' => 8, 'username' => 'Jobinsam@6742', 'role' => 'ESS', 'employee_name' => 'Jobin Sam', 'status' => 'Enabled'],
            ['id' => 9, 'username' => 'joe12', 'role' => 'ESS', 'employee_name' => 'yedghjb1 90jsnd', 'status' => 'Enabled'],
            ['id' => 10, 'username' => 'johndoe12', 'role' => 'ESS', 'employee_name' => 'Joseph Evans', 'status' => 'Enabled'],
            ['id' => 11, 'username' => 'johndoe13', 'role' => 'ESS', 'employee_name' => 'Joseph Evans', 'status' => 'Enabled'],
            ['id' => 12, 'username' => 'kldakklklk009', 'role' => 'ESS', 'employee_name' => 'Ranga Akunuri', 'status' => 'Enabled'],
            ['id' => 13, 'username' => 'shaikkwhvd2fhv', 'role' => 'ESS', 'employee_name' => 'Shaik Shabana', 'status' => 'Enabled'],
            ['id' => 14, 'username' => 'shaillwhvd2fhv', 'role' => 'ESS', 'employee_name' => 'Shaik Shabana', 'status' => 'Enabled'],
            ['id' => 15, 'username' => 'test_210126094458', 'role' => 'ESS', 'employee_name' => 'Sdwsl lavlg', 'status' => 'Enabled'],
            ['id' => 16, 'username' => 'timoty', 'role' => 'ESS', 'employee_name' => 'Timothy Amiano', 'status' => 'Enabled'],
            ['id' => 17, 'username' => 'user1768969644544', 'role' => 'ESS', 'employee_name' => 'Shaik Shabana', 'status' => 'Enabled'],
            ['id' => 18, 'username' => 'user1768969684526', 'role' => 'ESS', 'employee_name' => 'Shaik Shabana', 'status' => 'Enabled'],
            ['id' => 19, 'username' => 'user1768970117959', 'role' => 'ESS', 'employee_name' => 'amrutha vemula', 'status' => 'Enabled'],
        ];

        return view('admin.admin', compact('users'));
    }

    public function jobTitles()
    {
        $jobTitles = [
            ['id' => 1, 'title' => 'Account Assistant', 'description' => ''],
            ['id' => 2, 'title' => 'Automaton Tester', 'description' => ''],
            ['id' => 3, 'title' => 'Chief Executive Officer', 'description' => ''],
            ['id' => 4, 'title' => 'Finance Manager', 'description' => ''],
            ['id' => 5, 'title' => 'qwer', 'description' => 'hiii'],
            ['id' => 6, 'title' => 'rsjsrii', 'description' => 'dhhdhhddjdjdjjdjdj'],
        ];
        return view('admin.job.job-titles', compact('jobTitles'));
    }

    public function payGrades()
    {
        $payGrades = [
            ['id' => 1, 'name' => 'Grade 1', 'currency' => 'United States Dollar'],
            ['id' => 2, 'name' => 'Grade 2', 'currency' => 'United States Dollar'],
            ['id' => 3, 'name' => 'Grade 3', 'currency' => 'United States Dollar'],
            ['id' => 4, 'name' => 'Grade 4', 'currency' => 'United States Dollar'],
            ['id' => 5, 'name' => 'Grade 5', 'currency' => 'United States Dollar'],
        ];
        return view('admin.job.pay-grades', compact('payGrades'));
    }

    public function employmentStatus()
    {
        $statuses = [
            ['id' => 1, 'name' => 'Freelance'],
            ['id' => 2, 'name' => 'Full-Time Contract'],
            ['id' => 3, 'name' => 'Full-Time Permanent'],
            ['id' => 4, 'name' => 'Full-Time Probation'],
            ['id' => 5, 'name' => 'Part-Time Contract'],
            ['id' => 6, 'name' => 'Part-Time Internship'],
        ];
        return view('admin.job.employment-status', compact('statuses'));
    }

    public function jobCategories()
    {
        $categories = [
            ['id' => 1, 'name' => 'Craft Workers'],
            ['id' => 2, 'name' => 'Laborers and Helpers'],
            ['id' => 3, 'name' => 'Office and Clerical Workers'],
            ['id' => 4, 'name' => 'Officials and Managers'],
            ['id' => 5, 'name' => 'Operatives'],
            ['id' => 6, 'name' => 'Professionals'],
            ['id' => 7, 'name' => 'Sales Workers'],
            ['id' => 8, 'name' => 'Service Workers'],
            ['id' => 9, 'name' => 'Technicians'],
        ];
        return view('admin.job.job-categories', compact('categories'));
    }

    public function workShifts()
    {
        $shifts = [
            ['id' => 1, 'name' => 'General', 'from' => '08:00 AM', 'to' => '05:00 PM', 'hours' => '9.00'],
            ['id' => 2, 'name' => 'Twilight', 'from' => '02:00 PM', 'to' => '11:00 PM', 'hours' => '9.00'],
        ];
        return view('admin.job.work-shifts', compact('shifts'));
    }

    public function organizationGeneral()
    {
        return view('admin.organization.general-information');
    }

    public function organizationLocations()
    {
        $locations = [
            ['id' => 1, 'name' => 'Canadian Regional HQ', 'city' => 'Ottawa', 'country' => 'Canada', 'phone' => '1-876-267-6999', 'num_employees' => 0],
            ['id' => 2, 'name' => 'HQ - CA, USA', 'city' => 'California', 'country' => 'United States', 'phone' => '1-888-452-1508', 'num_employees' => 0],
            ['id' => 3, 'name' => 'New York Sales Office', 'city' => 'New York', 'country' => 'United States', 'phone' => '1 (866) 781-7104', 'num_employees' => 2],
            ['id' => 4, 'name' => 'Texas R&D', 'city' => 'Texas', 'country' => 'United States', 'phone' => '1 (866) 791-7204', 'num_employees' => 4],
        ];
        return view('admin.organization.locations', compact('locations'));
    }

    public function organizationStructure()
    {
        return view('admin.organization.structure');
    }

    public function qualificationsSkills()
    {
        $skills = [
            ['id' => 1, 'name' => 'Content Creation', 'description' => 'Marketing Skill'],
            ['id' => 2, 'name' => 'Copywriting', 'description' => 'Marketing Skill'],
            ['id' => 3, 'name' => 'G Suite', 'description' => 'Productivity Tools'],
            ['id' => 4, 'name' => 'Google Analytics', 'description' => 'Productivity Tools'],
            ['id' => 5, 'name' => 'Java', 'description' => 'Programming Language'],
            ['id' => 6, 'name' => 'JavaScript', 'description' => 'Programming Language'],
            ['id' => 7, 'name' => 'JIRA', 'description' => 'Project Management Tools'],
            ['id' => 8, 'name' => 'Office Suite', 'description' => 'Productivity Tools'],
            ['id' => 9, 'name' => 'Perl', 'description' => 'Programming Language'],
            ['id' => 10, 'name' => 'Photoshop', 'description' => 'Graphic Design'],
            ['id' => 11, 'name' => 'PHP', 'description' => 'Programming Language'],
            ['id' => 12, 'name' => 'Python', 'description' => 'Programming Language'],
            ['id' => 13, 'name' => 'React Native', 'description' => 'Programming Language'],
            ['id' => 14, 'name' => 'Ruby', 'description' => 'Programming Language'],
            ['id' => 15, 'name' => 'Search Engine Optimization (SEO)', 'description' => 'Marketing Skill'],
            ['id' => 16, 'name' => 'Seleniumwebdriver', 'description' => 'Programming Language'],
            ['id' => 17, 'name' => 'SQL', 'description' => 'Programming Language'],
            ['id' => 18, 'name' => 'Swift', 'description' => 'Programming Language'],
            ['id' => 19, 'name' => 'Trello', 'description' => 'Project Management Tools'],
            ['id' => 20, 'name' => 'UI/UX Design', 'description' => 'Graphic Design'],
            ['id' => 21, 'name' => 'Wireframing', 'description' => 'Graphic Design'],
        ];
        return view('admin.qualifications.skills', compact('skills'));
    }

    public function qualificationsEducation()
    {
        $education = [
            ['id' => 1, 'name' => "Bachelor's Degree"],
            ['id' => 2, 'name' => 'College Undergraduate'],
            ['id' => 3, 'name' => 'High School Diploma'],
            ['id' => 4, 'name' => "Master's Degree"],
        ];
        return view('admin.qualifications.education', compact('education'));
    }

    public function qualificationsLicenses()
    {
        $licenses = [
            ['id' => 1, 'name' => 'Certified Digital Marketing Professional (CDMP)'],
            ['id' => 2, 'name' => 'Certified Information Security Manager (CISM)'],
            ['id' => 3, 'name' => 'Cisco Certified Network Associate (CCNA)'],
            ['id' => 4, 'name' => 'Cisco Certified Network Professional (CCNP)'],
            ['id' => 5, 'name' => 'Microsoft Certified Systems Engineer (MCSE)'],
            ['id' => 6, 'name' => 'PMI Agile Certified Practitioner (PMI-ACP)'],
        ];
        return view('admin.qualifications.licenses', compact('licenses'));
    }

    public function qualificationsLanguages()
    {
        $languages = [
            ['id' => 1, 'name' => 'Arabic'],
            ['id' => 2, 'name' => 'Chinese'],
            ['id' => 3, 'name' => 'English'],
            ['id' => 4, 'name' => 'French'],
            ['id' => 5, 'name' => 'Russian'],
            ['id' => 6, 'name' => 'Spanish'],
        ];
        return view('admin.qualifications.languages', compact('languages'));
    }

    public function qualificationsMemberships()
    {
        $memberships = [
            ['id' => 1, 'name' => 'ACCA'],
            ['id' => 2, 'name' => 'British Computer Society (BCS)'],
            ['id' => 3, 'name' => 'Chartered Institute of Marketing (CIM)'],
            ['id' => 4, 'name' => 'CIMA'],
        ];
        return view('admin.qualifications.memberships', compact('memberships'));
    }

    public function nationalities()
    {
        $nationalities = [
            ['id' => 1, 'name' => 'Afghan'], ['id' => 2, 'name' => 'Albanian'], ['id' => 3, 'name' => 'Algerian'],
            ['id' => 4, 'name' => 'American'], ['id' => 5, 'name' => 'Andorran'], ['id' => 6, 'name' => 'Angolan'],
            ['id' => 7, 'name' => 'Antiguans'], ['id' => 8, 'name' => 'Argentinean'], ['id' => 9, 'name' => 'Armenian'],
            ['id' => 10, 'name' => 'Australian'], ['id' => 11, 'name' => 'Austrian'], ['id' => 12, 'name' => 'Azerbaijani'],
            ['id' => 13, 'name' => 'Bahamian'], ['id' => 14, 'name' => 'Bahraini'], ['id' => 15, 'name' => 'Bangladeshi'],
            ['id' => 16, 'name' => 'Barbadian'], ['id' => 17, 'name' => 'Barbudans'], ['id' => 18, 'name' => 'Batswana'],
            ['id' => 19, 'name' => 'Belarusian'], ['id' => 20, 'name' => 'Belgian'], ['id' => 21, 'name' => 'Belizean'],
            ['id' => 22, 'name' => 'Beninese'], ['id' => 23, 'name' => 'Bhutanese'], ['id' => 24, 'name' => 'Bolivian'],
            ['id' => 25, 'name' => 'Bosnian'], ['id' => 26, 'name' => 'Brazilian'], ['id' => 27, 'name' => 'British'],
            ['id' => 28, 'name' => 'Bruneian'], ['id' => 29, 'name' => 'Bulgarian'], ['id' => 30, 'name' => 'Burkinabe'],
            ['id' => 31, 'name' => 'Burmese'], ['id' => 32, 'name' => 'Burundian'], ['id' => 33, 'name' => 'Cambodian'],
            ['id' => 34, 'name' => 'Cameroonian'], ['id' => 35, 'name' => 'Canadian'], ['id' => 36, 'name' => 'Cape Verdean'],
            ['id' => 37, 'name' => 'Central African'], ['id' => 38, 'name' => 'Chadian'], ['id' => 39, 'name' => 'Chilean'],
            ['id' => 40, 'name' => 'Chinese'], ['id' => 41, 'name' => 'Colombian'], ['id' => 42, 'name' => 'Comoran'],
            ['id' => 43, 'name' => 'Congolese'], ['id' => 44, 'name' => 'Costa Rican'], ['id' => 45, 'name' => 'Croatian'],
            ['id' => 46, 'name' => 'Cuban'], ['id' => 47, 'name' => 'Cypriot'], ['id' => 48, 'name' => 'Czech'],
            ['id' => 49, 'name' => 'Danish'], ['id' => 50, 'name' => 'Djibouti'],
        ];
        return view('admin.nationalities', compact('nationalities'));
    }

    public function corporateBranding()
    {
        return view('admin.corporate-branding');
    }

    // Configuration methods
    public function emailConfiguration()
    {
        return view('admin.configuration.email-configuration');
    }

    public function emailSubscriptions()
    {
        $subscriptions = [
            ['id' => 1, 'notification_type' => 'Leave Applications', 'subscribers' => ''],
            ['id' => 2, 'notification_type' => 'Leave Approvals', 'subscribers' => ''],
            ['id' => 3, 'notification_type' => 'Leave Assignments', 'subscribers' => ''],
            ['id' => 4, 'notification_type' => 'Leave Cancellations', 'subscribers' => ''],
            ['id' => 5, 'notification_type' => 'Leave Rejections', 'subscribers' => ''],
        ];
        return view('admin.configuration.email-subscriptions', compact('subscriptions'));
    }

    public function localization()
    {
        return view('admin.configuration.localization');
    }

    public function languagePackages()
    {
        $languages = [
            ['id' => 1, 'name' => 'Chinese (Simplified, China)', 'native' => '中文 (简体, 中国)'],
            ['id' => 2, 'name' => 'Chinese (Traditional, Taiwan)', 'native' => '中文 (繁體, 台灣)'],
            ['id' => 3, 'name' => 'Dutch', 'native' => 'Nederlands'],
            ['id' => 4, 'name' => 'English (United States)', 'native' => 'English (United States)'],
            ['id' => 5, 'name' => 'French', 'native' => 'Français'],
            ['id' => 6, 'name' => 'German', 'native' => 'Deutsch'],
            ['id' => 7, 'name' => 'Spanish (Costa Rica)', 'native' => 'Español (Costa Rica)'],
            ['id' => 8, 'name' => 'Spanish', 'native' => 'Español'],
            ['id' => 9, 'name' => 'Tamil (India)', 'native' => 'தமிழ் (இந்தியா)'],
        ];
        return view('admin.configuration.language-packages', compact('languages'));
    }

    public function moduleConfiguration()
    {
        $modules = [
            ['id' => 1, 'name' => 'Admin Module', 'enabled' => true],
            ['id' => 2, 'name' => 'Pim Module', 'enabled' => true],
            ['id' => 3, 'name' => 'Leave Module', 'enabled' => true],
            ['id' => 4, 'name' => 'Time Module', 'enabled' => true],
            ['id' => 5, 'name' => 'Recruitment Module', 'enabled' => true],
            ['id' => 6, 'name' => 'Performance Module', 'enabled' => true],
            ['id' => 7, 'name' => 'Directory Module', 'enabled' => true],
            ['id' => 8, 'name' => 'Maintenance Module', 'enabled' => true],
            ['id' => 9, 'name' => 'Mobile', 'enabled' => true],
            ['id' => 10, 'name' => 'Claim Module', 'enabled' => true],
            ['id' => 11, 'name' => 'Buzz', 'enabled' => true],
        ];
        return view('admin.configuration.module-configuration', compact('modules'));
    }

    public function socialMediaAuthentication()
    {
        $providers = [];
        return view('admin.configuration.social-media-authentication', compact('providers'));
    }

    public function oauthClientList()
    {
        $oauthClients = [
            ['id' => 1, 'name' => 'OrangeHRM Mobile App', 'redirect_uri' => 'com.orangehrm.opensource://oauthredirect', 'status' => 'Enabled'],
        ];
        return view('admin.configuration.oauth-client-list', compact('oauthClients'));
    }

    public function ldapConfiguration()
    {
        return view('admin.configuration.ldap-configuration');
    }
}

