<?php

namespace App\Http\Controllers;

use App\Models\Paper;

class PaperController extends Controller
{
    public function getPapersByConference($conferenceId)
    {
        $papers = Paper::where('conference_idconference', $conferenceId)->get();
        return response()->json($papers);
    }
}
