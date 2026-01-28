<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyInfoController extends Controller
{
    public function index()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        
        // Get employee_id from users table
        $employeeId = null;
        $employee = null;
        $personalDetails = null;
        
        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;
            
            if ($employeeId) {
                // Fetch employee basic info
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
                
                // Fetch personal details
                $personalDetails = DB::table('employee_personal_details')
                    ->where('employee_id', $employeeId)
                    ->first();
            }
        }
        
        // Fetch nationalities for dropdown
        $nationalities = DB::table('nationalities')
            ->orderBy('name')
            ->get();

        // Fetch attachments
        $query = DB::table('file_uploads')
            ->leftJoin('users', 'file_uploads.uploaded_by', '=', 'users.id')
            ->select(
                'file_uploads.id',
                'file_uploads.original_name as file_name',
                DB::raw("'' as description"),
                'file_uploads.mime_type as type',
                'file_uploads.size_bytes',
                'file_uploads.uploaded_at',
                DB::raw("COALESCE(users.username, 'System') as added_by")
            )
            ->orderByDesc('file_uploads.uploaded_at');

        if ($userId) {
            $query->where('file_uploads.uploaded_by', $userId);
        }

        $attachments = $query->limit(50)->get()->map(function ($row) {
            $row->size = $row->size_bytes >= 1024
                ? number_format($row->size_bytes / 1024, 2) . ' kB'
                : $row->size_bytes . ' B';
            $row->date_added = optional($row->uploaded_at)->format('Y-m-d');
            return $row;
        });

        return view('myinfo.myinfo', compact(
            'attachments',
            'employee',
            'personalDetails',
            'nationalities'
        ));
    }
}

