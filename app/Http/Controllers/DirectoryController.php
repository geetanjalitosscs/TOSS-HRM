<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectoryController extends Controller
{
    public function index()
    {
        $employees = DB::table('employees')
            ->leftJoin('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->select(
                'employees.id',
                DB::raw("COALESCE(employees.display_name, CONCAT(employees.first_name, ' ', employees.last_name)) as name"),
                'job_titles.name as job_title',
                'organization_units.name as department'
            )
            ->orderBy('name')
            ->get()
            ->map(function ($row) {
                $row->has_photo = false;
                return $row;
            });

        return view('directory.directory', compact('employees'));
    }
}

