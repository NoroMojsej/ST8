<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Section;


class SectionController extends Controller
{

    public function getAllSections() 
    {
        $sections = Section::all();

        return response()->json($sections, 200);
    }

    public function saveSection(Request $request)
    {
        $request->validate([
            'section_id' => 'nullable|integer',
            'section_text' => 'required|string|max:255',
        ]);
    
        //update existujucej sekcie ak som dostala validne section_id
        if ($request->has('section_id') && Section::where('idsection', $request['section_id'])->exists()) {
            $section = Section::findOrFail($request['section_id']);
            $section->text = $request['section_text'];
            $message = 'Section updated successfully';
        } else {
            //vytvorenie novej sekcie
            $section = new Section();
            $section->text = $request['section_text'];
            $message = 'Section created successfully';
        }
    
        $section->save();
    
        return response()->json([
            'message' => $message,
            'section' => $section,
        ], 200);
    }

    public function deleteSection(Request $request)
    {
        try {
            $request->validate([
                'section_id' => 'required',
            ]);

            $section = Section::findOrFail($request['section_id']);

            $section->delete();

            return response()->json([
                'message' => 'Section deleted successfully.',
                'section_id' => $request['section_id'],
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            //Validation Exceptions
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            //Not found Exceptions
            return response()->json([
                'message' => 'The section does not exist or has already been deleted.',
                'section_id' => $request['section_id'] ?? null,
            ], 404);
        } catch (\Exception $e) {
            // Handle other Exceptions
            return response()->json([
                'message' => 'An unexpected error occurred while trying to delete the section.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}