<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function getDepartments($facultyId)
    {
        $departments = Department::where('faculty_idfaculty', $facultyId)->get();

        return response()->json($departments);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:200',
            'faculty_idfaculty' => 'required|integer',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
        ]);

        $department = Department::create($validated);

        return response()->json(['message' => 'Department created successfully', 'department' => $department], 201);
    }

    public function getById($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        return response()->json($department, 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:200',
            'faculty_idfaculty' => 'required|integer',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
        ]);

        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $department->update($validated);

        return response()->json(['message' => 'Department updated successfully', 'department' => $department], 200);
    }

    public function deleteById($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $department->delete();

        return response()->json(['message' => 'Department deleted successfully'], 200);
    }
}
