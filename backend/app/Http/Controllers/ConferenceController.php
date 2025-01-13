<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use ZipArchive;

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

    public function updateConference(Request $request, int $idconference)
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
    }

    public function getActiveConferences()
    {
            $conferences = Conference::select('idconference', 'abbreviation')
                ->where('take_place_to', '>=', now())
                ->get();
        
            return response()->json($conferences);
    }

    public function downloadAllFiles($conferenceId)
    {
        $conference = Conference::with('papers')->find($conferenceId);

        if (!$conference) {
            return response()->json(['message' => 'Conference not found'], 404);
        }

        $allFiles = [];
        foreach ($conference->papers as $paper) {
            $files = json_decode($paper->path_filesystem, true) ?? [];
            $allFiles = array_merge($allFiles, $files);
        }

        if (empty($allFiles)) {
            return response()->json(['message' => 'No files found for download'], 404);
        }

        $zip = new ZipArchive();
        $zipFileName = "conference_{$conferenceId}_papers.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            return response()->json(['message' => 'Could not create ZIP file'], 500);
        }

        foreach ($allFiles as $filePath) {
            $fullPath = storage_path("app/public/{$filePath}");
            if (file_exists($fullPath)) {
                $zip->addFile($fullPath, basename($filePath));
            }
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
