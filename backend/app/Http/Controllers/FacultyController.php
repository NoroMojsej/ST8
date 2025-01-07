<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function getFaculties($universityId)
    {
        $faculties = Faculty::where('university_iduniversity', $universityId)->get();
        return response()->json($faculties);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:200',
            'university_iduniversity' => 'required|integer',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
        ]);

        $faculty = Faculty::create($validated);

        return response()->json(['message' => 'Faculty created successfully', 'faculty' => $faculty], 201);
    }

    public function getById($id)
    {
        $faculty = Faculty::find($id);

        if (!$faculty) {
            return response()->json(['message' => 'Faculty not found'], 404);
        }

        return response()->json($faculty, 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:200',
            'university_iduniversity' => 'required|integer',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
        ]);

        $faculty = Faculty::find($id);

        if (!$faculty) {
            return response()->json(['message' => 'Faculty not found'], 404);
        }

        $faculty->update($validated);

        return response()->json(['message' => 'Faculty updated successfully', 'faculty' => $faculty], 200);
    }

    public function deleteById($id)
    {
        $faculty = Faculty::find($id);

        if (!$faculty) {
            return response()->json(['message' => 'Faculty not found'], 404);
        }

        $faculty->delete();

        return response()->json(['message' => 'Faculty deleted successfully'], 200);
    }
}
