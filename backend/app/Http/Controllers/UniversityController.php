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
}
