<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyInfoController extends Controller
{
    public function index()
    {
        $attachments = [
            ['file_name' => 'test.png', 'description' => 'test', 'size' => '53.16 kB', 'type' => 'image/png', 'date_added' => '2024-06-02', 'added_by' => 'Admin'],
            ['file_name' => 'Api (2).txt', 'description' => '', 'size' => '3.01 kB', 'type' => 'text/plain', 'date_added' => '2026-21-01', 'added_by' => 'Admin'],
            ['file_name' => 'API.txt', 'description' => '', 'size' => '3.01 kB', 'type' => 'text/plain', 'date_added' => '2026-21-01', 'added_by' => 'Admin'],
            ['file_name' => 'API_Response.txt', 'description' => '', 'size' => '3.01 kB', 'type' => 'text/plain', 'date_added' => '2026-21-01', 'added_by' => 'Admin'],
            ['file_name' => 'DataTable.txt', 'description' => '', 'size' => '484.00 B', 'type' => 'text/plain', 'date_added' => '2026-21-01', 'added_by' => 'Admin'],
        ];

        return view('myinfo.myinfo', compact('attachments'));
    }
}

