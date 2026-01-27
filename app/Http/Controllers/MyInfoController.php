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

        return view('myinfo.myinfo', compact('attachments'));
    }
}

