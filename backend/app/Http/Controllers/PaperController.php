<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;

class PaperController extends Controller
{
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

    public function getEssayById($id)
    {
        try {
            $essay = Paper::with(['conference', 'section'])
                ->findOrFail($id);

            return response()->json($essay);

            if (!$essay) {
                return response()->json([
                    'message' => 'Essay not found.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the essay.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateEssayByID(Request $request, $essayID)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abstract_lang1' => 'nullable|string',
            'abstract_lang2' => 'nullable|string',
            'keywords_lang1' => 'nullable|string',
            'keywords_lang2' => 'nullable|string',
            'selectedSection' => 'required|exists:section,idsection',
        ]);

        $essay = Paper::findOrFail($essayID);

        $essay->name = $request->input('name');
        $essay->abstract_lang1 = $request->input('abstract_lang1');
        $essay->abstract_lang2 = $request->input('abstract_lang2');
        $essay->keywords_lang1 = $request->input('keywords_lang1');
        $essay->keywords_lang2 = $request->input('keywords_lang2');
        $essay->section_idsection = $request->input('selectedSection');

        $essay->save();

        return response()->json(['message' => 'Essay updated successfully'], 200);
    }

    public function uploadFiles(Request $request, $id)
    {
        $request->validate([
            'file1' => 'required|file|mimes:pdf,docx|max:20048',
            'file2' => 'required|file|mimes:pdf,docx|max:20048',
        ]);

        $essay = Paper::findOrFail($id);

        $filePaths = [];
        foreach (['file1', 'file2'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $filePaths[$fileKey] = $request->file($fileKey)->store('essays', 'public');
            }
        }

        $essay->update([
            'path_filesystem_doc' => $filePaths['file1'] ?? null,
            'path_filesystem_pdf' => $filePaths['file2'] ?? null,
        ]);

        return response()->json(['message' => 'Files uploaded successfully', 'file_paths' => $filePaths]);
    }
}
