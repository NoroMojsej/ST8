<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function getFaculties($universityId)
    {
        // Retrieve faculties for the selected university
        $faculties = Faculty::where('university_iduniversity', $universityId)->get();

        // Return faculties as a JSON response
        return response()->json($faculties);
    }
}
