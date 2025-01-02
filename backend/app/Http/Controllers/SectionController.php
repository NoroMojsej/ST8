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
        $request->validate([
            'section_id' => 'required|exists:section,idsection',
        ]);

        $section = Section::findOrFail($request['section_id']);
        $section->delete();

        return response()->json([
            'message' => 'Section deleted successfully',
            'section_id' => $request['section_id'],
        ], 200);
    }


}