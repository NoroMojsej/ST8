<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::with('sections')->get();
        return response()->json($conferences);
    }

    public function create()
    {
        return view('conferences.create');
    }

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
            'sections' => 'required|array',
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

    public function show($conferenceId)
    {
        try {
            $conference = Conference::with('sections')
                ->findOrFail($conferenceId);

            return response()->json($conference);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Konferencia neexistuje'], 404);
        }
    }

    public function update(Request $request, int $idconference)
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
            'sections' => 'required|array',
            'sections.*' => 'integer|exists:section,idsection',
        ]);

        $validatedData = [
            'abbreviation' => $data['title'], //TOTO VYRIEŠIŤ
            'submissions_from' => $data['submissionFrom'],
            'submissions_to' => $data['submissionTo'],
            'take_place_from' => $data['conferenceFrom'],
            'take_place_to' => $data['conferenceTo'],
            'country_idcountry' => $data['country'],
            'description' => $data['description'],
            'university_iduniversity' => $data['university'],
        ];

        $conference = Conference::findOrFail($idconference);

        $conference->update($validatedData);

        if (isset($data['sections'])) {
            $conference->sections()->sync($data['sections']);
        }

        //NEPOUZIVAT TENTO KOD DOLE, NEFUNGUJE
        /*$conference = Conference::where('idconference', $idconference);
    $conference->update($validatedData);*/

        // Update the sections relationship (many-to-many)
        /*if (isset($data['sections'])) {
        Conference::where('idconference', $idconference)->sections()->sync($data['sections']); // This will update the sections relationship
    }*/

        // Return a response
        /* return response()->json([
        'message' => 'Conference updated successfully.',
        'conference' => $conference->fresh(),
    ]);*/
    }

    public function getActiveConferences()
    {
            $conferences = Conference::select('idconference', 'abbreviation')
                ->where('take_place_to', '>=', now())
                ->get();
        
            return response()->json($conferences);
    }
}
