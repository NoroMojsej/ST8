<?php

namespace App\Http\Controllers;

use App\Models\Department;

class DepartmentController extends Controller
{
    public function getDepartments($facultyId)
    {
        $departments = Department::where('faculty_idfaculty', $facultyId)->get();

        return response()->json($departments);
    }
}
