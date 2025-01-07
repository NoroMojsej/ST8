<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{

    public function index()
    {
        $universities = University::all();
        return response()->json($universities);
    }

    public function getByCountry($countryId)
    {
        $universities = University::where('country_idcountry', $countryId)->get();

        if ($universities->isEmpty()) {
            return response()->json(['message' => 'No universities found for this country.'], 404);
        }

        return response()->json($universities);
    }

    public function GetById($id)
    {
        $university = University::find($id);

        if (!$university) {
            return response()->json(['message' => 'University not found'], 404);
        }

        return response()->json($university, 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'country_idcountry' => 'required|integer',
            'valid_from' => 'required|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $university = University::find($id);

        if (!$university) {
            return response()->json(['message' => 'University not found'], 404);
        }

        $university->update($validated);

        return response()->json(['message' => 'University updated successfully', 'university' => $university], 200);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'code' => 'required|string|max:20',
            'country_idcountry' => 'required|integer',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $university = University::create($validated);

        return response()->json(['message' => 'University created successfully', 'university' => $university], 201);
    }
}
