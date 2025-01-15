<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    // Fetch all degrees from the database
    public function index()
    {
        // Retrieve all degrees
        $degrees = Degree::all();

        // Return the degrees as a JSON response
        return response()->json($degrees);
    }

    /* // Create a new degree (optional)
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create and save the new degree
        $degree = Degree::create([
            'name' => $validated['name'],
        ]);

        // Return the created degree as JSON
        return response()->json($degree, 201);
    } */
}
