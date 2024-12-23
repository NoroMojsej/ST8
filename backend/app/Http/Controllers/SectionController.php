<?php

namespace App\Http\Controllers;

use App\Models\Section;


class SectionController extends Controller
{
    public function index()
    {
        // Get all sections from the database
        $sections = Section::all();

        // Return the sections as JSON
        return response()->json($sections);
    }
}