<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {
        // Get dropdown options
        $jobTitles = DB::table('job_titles')->select('id', 'name')->orderBy('name')->get();
        $locations = DB::table('locations')->select('id', 'name')->orderBy('name')->get();

        // Build query with search filters
        $query = DB::table('employees')
            ->leftJoin('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->leftJoin('locations', 'employees.location_id', '=', 'locations.id')
            ->select(
                'employees.id',
                DB::raw("COALESCE(employees.display_name, CONCAT(employees.first_name, ' ', employees.last_name)) as name"),
                'job_titles.name as job_title',
                'organization_units.name as department',
                'locations.name as location'
            );

        // Apply search filters
        if ($request->filled('employee_name')) {
            $name = $request->input('employee_name');
            $query->where(function($q) use ($name) {
                $q->where('employees.first_name', 'like', "%{$name}%")
                  ->orWhere('employees.last_name', 'like', "%{$name}%")
                  ->orWhere('employees.display_name', 'like', "%{$name}%");
            });
        }

        if ($request->filled('job_title')) {
            $query->where('employees.job_title_id', $request->input('job_title'));
        }

        if ($request->filled('location')) {
            $query->where('employees.location_id', $request->input('location'));
        }

        $employees = $query->orderBy('name')
            ->get()
            ->map(function ($row) {
                $row->photo_url = $this->getEmployeePhotoUrl($row->id);
                return $row;
            });

        return view('directory.directory', compact('employees', 'jobTitles', 'locations'));
    }

    private function getEmployeePhotoColumn(): ?string
    {
        foreach (['photo_path', 'profile_photo_path', 'photo', 'image_path', 'image'] as $col) {
            if (Schema::hasColumn('employees', $col)) {
                return $col;
            }
        }
        return null;
    }

    private function getEmployeePhotoUrl(?int $employeeId): ?string
    {
        if (!$employeeId) {
            return null;
        }

        $employee = DB::table('employees')->where('id', $employeeId)->first();
        if (!$employee) {
            return null;
        }

        $col = $this->getEmployeePhotoColumn();
        if ($col && !empty($employee->{$col})) {
            return asset('storage/' . ltrim((string) $employee->{$col}, '/'));
        }

        // Fallback: if we stored a file without DB column, try common paths
        foreach (['jpg', 'jpeg', 'png', 'gif', 'webp'] as $ext) {
            $path = "employee_photos/{$employeeId}.{$ext}";
            if (Storage::disk('public')->exists($path)) {
                return asset('storage/' . $path);
            }
        }
        return null;
    }
}

