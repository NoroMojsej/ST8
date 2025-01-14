<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Paper;
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

    public function downloadApprovedPapers($conferenceId)
    {
        $papers = Paper::where('conference_idconference', $conferenceId)
            ->whereNotNull('review_idreview')
            ->get();

        $approvedFiles = [];

        foreach ($papers as $paper) {
            if ($paper->review && $paper->review->review_status_idreview_status === 1) {
                $filePaths = json_decode($paper->path_filesystem, true);
                if (is_array($filePaths)) {
                    $approvedFiles = array_merge($approvedFiles, $filePaths);
                }
            }
        }

        if (empty($approvedFiles)) {
            return response()->json(['message' => 'No approved papers found'], 404);
        }

        $zip = new ZipArchive();
        $zipFileName = 'approved_papers_conference_' . $conferenceId . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            foreach ($approvedFiles as $file) {
                $filePath = storage_path('app/public/' . $file);

                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($file));
                }
            }
            $zip->close();
        } else {
            return response()->json(['message' => 'Unable to create ZIP file'], 500);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend();
    }

    public function downloadRefusedPapers($conferenceId)
    {
        $papers = Paper::where('conference_idconference', $conferenceId)
            ->whereNotNull('review_idreview')
            ->get();

        $refusedFiles = [];

        foreach ($papers as $paper) {
            if ($paper->review && $paper->review->review_status_idreview_status === 0) {
                $filePaths = json_decode($paper->path_filesystem, true);
                if (is_array($filePaths)) {
                    $refusedFiles = array_merge($refusedFiles, $filePaths);
                }
            }
        }

        if (empty($refusedFiles)) {
            return response()->json(['message' => 'No refused papers found'], 404);
        }

        $zip = new ZipArchive();
        $zipFileName = 'refused_papers_conference_' . $conferenceId . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            foreach ($refusedFiles as $file) {
                $filePath = storage_path('app/public/' . $file);

                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($file));
                }
            }
            $zip->close();
        } else {
            return response()->json(['message' => 'Unable to create ZIP file'], 500);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend();
    }

    public function downloadPaperFiles($conferenceId, $paperId)
    {
        $conference = Conference::with('papers')->find($conferenceId);

        if (!$conference) {
            return response()->json(['message' => 'Conference not found'], 404);
        }

        $paper = $conference->papers->where('idpaper', $paperId)->first();

        if (!$paper) {
            return response()->json(['message' => 'Paper not found in the specified conference'], 404);
        }

        $files = json_decode($paper->path_filesystem, true) ?? [];

        if (empty($files)) {
            return response()->json(['message' => 'No files found for the specified paper'], 404);
        }

        $zip = new ZipArchive();
        $zipFileName = "conference_{$conferenceId}_paper_{$paperId}_files.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            return response()->json(['message' => 'Could not create ZIP file'], 500);
        }

        foreach ($files as $filePath) {
            $fullPath = storage_path("app/public/{$filePath}");
            if (file_exists($fullPath)) {
                $zip->addFile($fullPath, basename($filePath));
            }
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
