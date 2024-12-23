<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    // List all conferences
    public function index()
    {
        $conferences = Conference::with('sections')->get();
        return response()->json($conferences);
    }

    // Show the form for creating a new conference
    public function create()
    {
        // For web applications, return a view:
        return view('conferences.create');
    }

    // Store a newly created conference in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'country' => 'required',
            'university' => 'required',
            'description' => 'required',
            'submissionFrom' => 'required|date',
            'submissionTo' => 'required|date',
            'conferenceFrom' => 'required|date',
            'conferenceTo' => 'required|date',
            'sections' => 'required|array', // Pole ID sekcií
            'sections.*' => 'integer|exists:section,idsection', // Každé ID musí existovať
        ]);

        $conference = Conference::create([
            'abbreviation' => $data['title'], //TOTO VYRIEŠIŤ
            'submissions_from' => $data['submissionFrom'],
            'submissions_to' => $data['submissionTo'],
            'take_place_from' => $data['conferenceFrom'],
            'take_place_to' => $data['conferenceTo'],
            'country_idcountry' => $data['country'],
            'description' => $data['description'],
            'university_iduniversity' => $data['university'],
        ]);

        $conference->sections()->sync($data['sections']);

        return response()->json(['message' => 'Conference created successfully'], 201);
    }
}
