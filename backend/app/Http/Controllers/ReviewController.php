<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewStatus;

class ReviewController extends Controller
{
    public function submitReview(Request $request)
    {
        $request->validate([
            //review validations
            'grade1' => 'nullable|in:A,B,C,D,E,F',
            'grade2' => 'nullable|in:A,B,C,D,E,F',
            'grade3' => 'nullable|in:A,B,C,D,E,F',
            'grade4' => 'nullable|in:A,B,C,D,E,F',
            'grade5' => 'nullable|in:A,B,C,D,E,F',
            'grade6' => 'nullable|in:A,B,C,D,E,F',
            'grade7' => 'nullable|in:A,B,C,D,E,F',
            'grade8' => 'nullable|in:A,B,C,D,E,F',
            'grade9' => 'nullable|in:A,B,C,D,E,F',
            'grade10' => 'nullable|in:A,B,C,D,E,F',
            'yesno1' => 'nullable|integer|in:0,1',
            'yesno2' => 'nullable|integer|in:0,1',
            'yesno3' => 'nullable|integer|in:0,1',
            'yesno4' => 'nullable|integer|in:0,1',
            'yesno5' => 'nullable|integer|in:0,1',
            'yesno6' => 'nullable|integer|in:0,1',
            'yesno7' => 'nullable|integer|in:0,1',
            'yesno8' => 'nullable|integer|in:0,1',
            'yesno9' => 'nullable|integer|in:0,1',
            'yesno10' => 'nullable|integer|in:0,1',
            'yesno11' => 'nullable|integer|in:0,1',
            'yesno12' => 'nullable|integer|in:0,1',
            'txt_plus' => 'nullable|string|max:500',
            'txt_minus' => 'nullable|string|max:500',
            'txt_general' => 'nullable|string|max:500',
            'user_iduser' => 'required|exists:user,iduser',

            //review status validations
            'status' => 'nullable|string|size:2',
            'status_desc' => 'nullable|string|max:100',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $reviewStatus = ReviewStatus::create([
            'status' => $request->positive_status,
            'status_desc' => $request->positive_description,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,

        ]);

        $review = Review::create([
            'grade1' => $request->grade1,
            'grade2' => $request->grade2,
            'grade3' => $request->grade3,
            'grade4' => $request->grade4,
            'grade5' => $request->grade5,
            'grade6' => $request->grade6,
            'grade7' => $request->grade7,
            'grade8' => $request->grade8,
            'grade9' => $request->grade9,
            'grade10' => $request->grade10,

            'yesno1' => $request->yesno1,
            'yesno2' => $request->yesno2,
            'yesno3' => $request->yesno3,
            'yesno4' => $request->yesno4,
            'yesno5' => $request->yesno5,
            'yesno6' => $request->yesno6,
            'yesno7' => $request->yesno7,
            'yesno8' => $request->yesno8,
            'yesno9' => $request->yesno9,
            'yesno10' => $request->yesno10,
            'yesno11' => $request->yesno11,
            'yesno12' => $request->yesno12,

            'txt_plus' => $request->txt_plus,
            'txt_minus' => $request->txt_minus,
            'txt_general' => $request->txt_general,

            'review_status_idreview_status' => $reviewStatus->id,
            'user_iduser' => $request->user_iduser,         //treba zmenit na id usera ktoreho praca sa reviewuje
        ]);        

    
        return response()->json([
            'message' => 'Hodnotenie zaznamenané',
        ]);
    }
}
