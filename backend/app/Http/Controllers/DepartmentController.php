<?php

namespace App\Http\Controllers;

use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Get the departments for a specific faculty.
     *
     * @param  int  $facultyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartments($facultyId)
    {
        // Retrieve departments based on the selected faculty
        $departments = Department::where('faculty_idfaculty', $facultyId)->get();

        // Return the departments as a JSON response
        return response()->json($departments);
    }
}
