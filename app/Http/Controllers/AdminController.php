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

        return view('admin.index', compact('users'));
    }
}

