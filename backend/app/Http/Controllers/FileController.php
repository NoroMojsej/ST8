<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    
    public function uploadFiles(Request $request)
{
    // Validate the files
    $request->validate([
        'files.*' => 'required|mimes:pdf,docx|max:2048', // Limit to 2MB per file
    ]);

    $filePaths = [];

    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            // Store the file in the 'uploads' directory
            $filePath = $file->store('uploads', 'public'); // 'public' is the disk
            $filePaths[] = $filePath;
        }
    }

    return response()->json([
        'message' => 'Files uploaded successfully.',
        'paths' => $filePaths, // Return file paths to the frontend
    ], 200);
}

}
