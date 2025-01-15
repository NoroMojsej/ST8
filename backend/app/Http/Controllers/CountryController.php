<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getAllcountries()
    {
        $countries = Country::select('idcountry', 'name')->get();
        return response()->json($countries);
    }
}