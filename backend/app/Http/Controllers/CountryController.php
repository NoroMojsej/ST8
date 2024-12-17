<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    // Fetch all countries from the database
    public function countries()
    {
        $countries = Country::select('idcountry', 'name')->get(); // Get only necessary fields like id and name
        return response()->json($countries);
    }
}