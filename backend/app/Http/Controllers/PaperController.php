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

    public function getEssaysByStudentAndConference($studentId, $conferenceId)
{
    // Získať všetky práce priradené študentovi a konferencii, vrátane celého objektu konferencie a sekcie
    $essays = Paper::with(['conference', 'section', 'paper_status'])
                   ->where('conference_idconference', $conferenceId)
                   ->whereHas('users', function($query) use ($studentId) {
                       $query->where('user_iduser', $studentId);
                   })
                   ->get();

    // Skontrolovať, či existujú práce
    if ($essays->isEmpty()) {
        return response()->json(['message' => 'Žiadne práce pre tohto študenta v tejto konferencii sa nenašli'], 404);
    }
    
    return response()->json($essays, 200);
}
}
