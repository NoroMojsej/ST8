<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Paper;
use App\Models\ReviewStatus;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{

    public function getAllReviews() 
    {
        $reviews = Review::all();

        return response()->json($reviews, 200);
    }
    

    public function getReviewById($id) 
    {             
        $review = Review::with(['status'])->findOrFail($id);

        return response()->json($review, 200);

    }


    public function saveReview(Request $request)
    {
        $request->validate([
            //review validations
            'id' => [
                'required',
                function ($attribute, $value, $fail) {
                    // new or existing
                    if ($value !== 'new' && !\App\Models\Review::where('idreview', $value)->exists()) {
                        $fail('The selected review id is invalid.');
                    }
                },
            ],
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

            'created_on' => 'nullable|date',
            'updated_on' => 'nullable|date',

            //review status validations
            'review_status_idreview_status' => 'nullable|exists:review_status,idreview_status',
            'status' => 'nullable|string|size:2',
            'status_desc' => 'nullable|string|max:100',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
        ]);

        //update
        if ($request->has('id') && $request->id != 'new') {
            $review = Review::findOrFail($request->id);
            $review->update($request->all());

        } else{
            //create
            $reviewStatus = ReviewStatus::create([
                'status' => $request->status,
                'status_desc' => $request->status_desc,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to,
    
                'created_on' => $request->created_on,
                'updated_on' => $request->updated_on,
    
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
    
                'review_status_idreview_status' => $reviewStatus->idreview_status,
                'user_iduser' => $request->user_iduser,
    
                'created_on' => $request->created_on,
                'updated_on' => $request->updated_on,
            ]);

        }

               

    
        return response()->json([
            'message' => 'Hodnotenie zaznamenané',
            'review_id' => $review->idreview,
        ]);
    }

    public function deleteReview(Request $request)
    {
        try {
            $request->validate([
                'review_id' => 'required',
            ]);

            $review = Review::findOrFail($request['review_id']);

            $review->delete();

            return response()->json([
                'message' => 'Review deleted successfully.',
                'review_id' => $request['review_id'],
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
                'message' => 'The review does not exist or has already been deleted.',
                'review_id' => $request['review_id'] ?? null,
            ], 404);
        } catch (\Exception $e) {
            // Handle other Exceptions
            return response()->json([
                'message' => 'An unexpected error occurred while trying to delete the review.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createReviewAndUpdatePaper(Request $request, $userId)
{
    $validated = $request->validate([
        'essayIds' => 'required|array',
        'essayIds.*' => 'required|integer|exists:paper,idpaper',
    ]);

    try {
        DB::transaction(function () use ($validated, $userId) {
            foreach ($validated['essayIds'] as $paperId) {
                $review = Review::create([
                    'user_iduser' => $userId,
                ]);

                Paper::where('idpaper', $paperId)->update([
                    'review_idreview' => $review->idreview,
                ]);
            }
        });

        return response()->json(['status' => 'success', 'message' => 'Reviews created and Papers updated.'], 200);

    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}
