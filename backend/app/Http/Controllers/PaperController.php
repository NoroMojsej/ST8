<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Paper;

class PaperController extends Controller
{

    public function getAllpapers() 
    {
        $papers = Paper::all();

        return response()->json($papers, 200);
    }

    public function getAllPapersAndTheirReview() 
    {
        $papers = Paper::with(['review:idreview'])->get();

        return response()->json($papers, 200);
    }

    public function getPapersByConference($conferenceId)
    {
        $papers = Paper::where('conference_idconference', $conferenceId)->get();
        return response()->json($papers);
    }

    public function getEssaysByStudentAndConference($studentId, $conferenceId)
    {
        // Získať všetky práce priradené študentovi a konferencii, vrátane celého objektu konferencie a sekcie
        $essays = Paper::with(['conference', 'section', 'paper_status'])
            ->where('conference_idconference', $conferenceId)
            ->whereHas('users', function ($query) use ($studentId) {
                $query->where('user_iduser', $studentId);
            })
            ->get();

        if ($essays->isEmpty()) {
            return response()->json(['message' => 'Žiadne práce pre tohto študenta v tejto konferencii sa nenašli'], 404);
        }

        return response()->json($essays, 200);
    }

    public function updatePaper(Request $request, $id, $userId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abstract_lang1' => 'nullable|string',
            'abstract_lang2' => 'nullable|string',
            'keywords_lang1' => 'nullable|string',
            'keywords_lang2' => 'nullable|string',
            'section_id' => 'required',
            'files' => 'required|array|min:2|max:2',
            'files.*' => 'file|mimes:pdf,docx|max:10240',
        ]);

        $paper = Paper::find($id);

        if (!$paper) {
            return response()->json(['message' => 'Paper not found.'], 404);
        }

        $paper->name = $request->name;
        $paper->abstract_lang1 = $request->abstract_lang1;
        $paper->abstract_lang2 = $request->abstract_lang2;
        $paper->keywords_lang1 = $request->keywords_lang1;
        $paper->keywords_lang2 = $request->keywords_lang2;
        $paper->section_idsection = $request->section_id;

        $files = $request->file('files');
        $newFilePaths = [];

        foreach ($files as $file) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$originalName}_user{$userId}_" . uniqid() . ".{$extension}";
            $filePath = $file->storeAs('papers', $newFilename, 'public');
            $newFilePaths[] = $filePath;
        }

        $oldFilePaths = json_decode($paper->path_filesystem, true) ?? [];
        foreach ($oldFilePaths as $oldFilePath) {
            if (Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }
        }

        // Update the database with new file paths (as JSON)
        $paper->path_filesystem = json_encode($newFilePaths);

        $paper->save();

        return response()->json([
            'message' => 'Paper updated successfully.',
            'paper' => $paper,
        ]);
    }

    public function uploadPaper(Request $request, $userId)
    {
    try {
        Log::info('Starting uploadPaper method.');
        Log::info('Request data:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'abstract_lang1' => 'nullable|string',
            'abstract_lang2' => 'nullable|string',
            'keywords_lang1' => 'nullable|string',
            'keywords_lang2' => 'nullable|string',
            'section_id' => 'required',
            'conference_id' => 'required',
            'files' => 'required|array|min:2|max:2',
            'files.*' => 'file|mimes:pdf,docx|max:10240', // zatial max 10mb, mozme zmenit
        ]);

        Log::info('Validation passed.');

        Log::info('Authenticated user ID:', ['user_id' => $userId]);

        if (!$userId) {
            Log::error('User is not authenticated.');
            return response()->json(['message' => 'User not authenticated.'], 401);
        }

        $files = $request->file('files');
        Log::info('Uploaded files:', ['files' => $files]);

        $filePaths = [];

        foreach ($files as $file) {
            // Unique filename
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$originalName}_user{$userId}_" . uniqid() . ".{$extension}";

            Log::info('Generated filename:', ['filename' => $newFilename]);

            // File saving s novým unique menom.
            $filePath = $file->storeAs('papers', $newFilename, 'public');
            if (!$filePath) {
                Log::error('Failed to store file.', ['filename' => $newFilename]);
                return response()->json(['message' => 'Failed to store file.'], 500);
            }

            Log::info('File stored successfully.', ['path' => $filePath]);
            $filePaths[] = $filePath;
        }

        $paper = Paper::create([
            'name' => $request->input('name'),
            'abstract_lang1' => $request->input('abstract_lang1'),
            'abstract_lang2' => $request->input('abstract_lang2'),
            'keywords_lang1' => $request->input('keywords_lang1'),
            'keywords_lang2' => $request->input('keywords_lang2'),
            'section_idsection' => $request->input('section_id'),
            'conference_idconference' => $request->input('conference_id'),
            'paper_status_idpaper_status' => 1, // uploaded
            'path_filesystem' => json_encode($filePaths),
            'upload_datetime' => now(),
        ]);

        Log::info('Paper record created successfully.', ['paper_id' => $paper->idpaper]);

        return response()->json([
            'message' => 'Paper uploaded successfully.',
            'paper_id' => $paper->idpaper,
            'file_paths' => $filePaths,
        ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Unexpected error:', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Unexpected error occurred.', 'error' => $e->getMessage()], 501);
        }
    }

    public function deletePaper($id, $userId) // Mazanie "Papers" (usermode, nie pre adminov)
    {
        $paper = Paper::find($id);

        if (!$paper) {
            return response()->json(['message' => 'Paper not found'], 404);
        }

        $isAuthorized = $paper->users()->where('iduser', $userId)->exists();

        if (!$isAuthorized) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if (!empty($paper->path_filesystem)) {
            $filePaths = json_decode($paper->path_filesystem, true);

            foreach ($filePaths as $filePath) {
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        $paper->delete();

        return response()->json(['message' => 'Paper deleted successfully']);
    }

    public function getPapersByUser($userId)
    {
    $papers = Paper::where('user_id', $userId)->pluck('name', 'idpaper');

    if ($papers->isEmpty()) {
        return response()->json(['message' => 'No papers found for this user.'], 404);
    }

    return response()->json([
        'message' => 'Papers retrieved successfully.',
        'papers' => $papers, // mená a IDčká paperov.
    ]);
    }   

    public function getPaperById($id)
    {
    $paper = Paper::find($id);

    if (!$paper) {
        return response()->json(['message' => 'Paper not found.'], 404);
    }

    return response()->json([
        'message' => 'Paper retrieved successfully.',
        'paper' => $paper, // Celý paper pre editing.
    ]);
    }

    function getPapersByStudent() {
        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        return Paper::with([
                'conference:abbreviation,idconference',
                'section:text,idsection',
                'review.status:status_desc,idreview_status'
            ])
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('user_iduser', $userId);
            })
            ->get()
            ->map(function ($paper) {
                return [
                    'id_paper' => $paper->idpaper,
                    'name' => $paper->name,
                    'keywords_lang1' => $paper->keywords_lang1,
                    'keywords_lang2' => $paper->keywords_lang2,
                    'id_conference' =>  $paper->conference->idconference ?? null,
                    'abbreviation' => $paper->conference->abbreviation ?? null,
                    'text' => $paper->section->text ?? null,
                    'review_status_desc' => $paper->review->status->status_desc ?? null,
                ];
            });
    }

    public function getReviewByPaper($essayID)
{
    $essay = Paper::with(['review.status'])->find($essayID);

    if (!$essay) {
        return response()->json(['error' => 'Essay not found'], 404);
    }

    if (!$essay->review) {
        return response()->json(['error' => 'Review not found'], 404);
    }

    return response()->json([
        'review' => $essay->review,
        'status' => $essay->review->status,
    ], 200);
}

public function getPapersAvailable($sectionID)
{
    $papers = Paper::select('idpaper', 'name')
        ->whereNull('review_idreview')
        ->where('section_idsection', $sectionID)
        ->get();

    return response()->json($papers);
}

}
