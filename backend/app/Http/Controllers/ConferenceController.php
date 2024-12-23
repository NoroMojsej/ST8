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
            'university' => $data['university'],
        ]);

        $conference->sections()->sync($data['sections']);

        return response()->json(['message' => 'Conference created successfully'], 201);
    }

    // Show details of a specific conference
    public function show(Conference $conference)
    {
        return response()->json($conference->load('sections'));
    }

    // Show the form for editing a specific conference
    public function edit(Conference $conference)
    {
        // For web applications, return a view:
        return view('conferences.edit', compact('conference'));
    }

    // Update a specific conference in the database
    public function update(Request $request, Conference $conference)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'submissionDates.from' => 'required|date',
            'submissionDates.to' => 'required|date',
            'conferenceDates.from' => 'required|date',
            'conferenceDates.to' => 'required|date',
            'country' => 'required|string',
            'university' => 'required|string',
            'sections' => 'required|array',
            'sections.*.name' => 'required|string|max:255',
            'sections.*.description' => 'nullable|string|max:255',
        ]);

        $conference->update([
            'name' => $data['name'],
            'submissions_from' => $data['submissionDates']['from'],
            'submissions_to' => $data['submissionDates']['to'],
            'take_place_from' => $data['conferenceDates']['from'],
            'take_place_to' => $data['conferenceDates']['to'],
            'country' => $data['country'],
            'university' => $data['university'],
        ]);

        $conference->sections()->delete(); // Remove old sections
        foreach ($data['sections'] as $section) {
            $conference->sections()->create($section);
        }

        return response()->json(['message' => 'Conference updated successfully']);
    }

    // Delete a specific conference
    public function destroy(Conference $conference)
    {
        $conference->delete();
        return response()->json(['message' => 'Conference deleted successfully']);
    }
}
