<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paper;

class PaperController extends Controller
{
    public function uploadPaper(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abstract_lang1' => 'nullable|string',
            'abstract_lang2' => 'nullable|string',
            'keywords_lang1' => 'nullable|string',
            'keywords_lang2' => 'nullable|string',
            'section_id' => 'required|exists:section,idsection',
            'files' => 'required|array|min:2|max:2',
            'files.*' => 'file|mimes:pdf,docx|max:10240', // zatial max 10mb, mozme zmenit
        ]);

        $userId = auth()->id(); // user ID
        $files = $request->file('files');
        $filePaths = [];

        foreach ($files as $file) {
            // unikátny názov aby sme v storage neprepisovali UŽ nahrané práce. Aktuálne používa userID, asi by bolo lepšie nejak implementovať "DATETIME" (zistím jak aby to bolo rozumné.)
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$originalName}_user{$userId}_" . uniqid() . ".{$extension}";

            $filePath = $file->storeAs('papers', $newFilename, 'public');
            $filePaths[] = $filePath;
        }

        $paper = Paper::create([
            'name' => $request->input('name'),
            'abstract_lang1' => $request->input('abstract_lang1'),
            'abstract_lang2' => $request->input('abstract_lang2'),
            'keywords_lang1' => $request->input('keywords_lang1'),
            'keywords_lang2' => $request->input('keywords_lang2'),
            'section_idsection' => $request->input('section_id'),
            'path_filesystem' => json_encode($filePaths), // file paths ako JSON v DB
            'upload_datetime' => now(),
        ]);

        // successful response
        return response()->json([
            'message' => 'Paper uploaded successfully.',
            'paper_id' => $paper->idpaper, // nie moc potrebné ale môže sa zísť neskôr
            'file_paths' => $filePaths, // nie moc potrebné ale môže sa zísť neskôr
        ]);
    }
}
