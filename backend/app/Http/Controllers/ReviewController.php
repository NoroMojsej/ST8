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
        try {
            $review = Review::with(['status'])->findOrFail($id);
    
            return response()->json($review, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Review not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the review.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function createReview(Request $request){
        try {
            $validatedData = $request->validate([
                'user_iduser' => 'required|exists:user,iduser',
            ]);
    
            $review = Review::create([
                'user_iduser' => $validatedData['user_iduser'],
                'created_on' => now(),
                'updated_on' => now(),
            ]);
    
            return response()->json([
                'message' => 'Vytvorené hodnotenie pre recenzenta.',
                'review' => $review,
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the review.',
                'error' => $e->getMessage(),
            ], 500);
        }      
    }


    public function saveReview(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|exists:review,idreview',
                'grade1' => 'required|in:A,B,C,D,E,F',
                'grade2' => 'required|in:A,B,C,D,E,F',
                'grade3' => 'required|in:A,B,C,D,E,F',
                'grade4' => 'required|in:A,B,C,D,E,F',
                'grade5' => 'required|in:A,B,C,D,E,F',
                'grade6' => 'required|in:A,B,C,D,E,F',
                'grade7' => 'required|in:A,B,C,D,E,F',
                'grade8' => 'required|in:A,B,C,D,E,F',
                'grade9' => 'required|in:A,B,C,D,E,F',
                'grade10' => 'required|in:A,B,C,D,E,F',
                'yesno1' => 'required|integer|in:0,1',
                'yesno2' => 'required|integer|in:0,1',
                'yesno3' => 'required|integer|in:0,1',
                'yesno4' => 'required|integer|in:0,1',
                'yesno5' => 'required|integer|in:0,1',
                'yesno6' => 'required|integer|in:0,1',
                'yesno7' => 'required|integer|in:0,1',
                'yesno8' => 'required|integer|in:0,1',
                'yesno9' => 'required|integer|in:0,1',
                'yesno10' => 'required|integer|in:0,1',
                'yesno11' => 'required|integer|in:0,1',
                'yesno12' => 'required|integer|in:0,1',
                'yesno13' => 'required|integer|in:0,1',
                'yesno14' => 'required|integer|in:0,1',
                'txt_plus' => 'required|string|max:500',
                'txt_minus' => 'required|string|max:500',
                'txt_general' => 'nullable|string|max:500',
                'user_iduser' => 'required|exists:user,iduser',
    
                'created_on' => 'nullable|date',
                'updated_on' => 'nullable|date',
    
                'review_status_idreview_status' => 'required|exists:review_status,idreview_status',
            ]);
    
            if ($request->has('id')) {
                $review = Review::findOrFail($request->id);
                $review->update($validatedData);
            }
    
            return response()->json([
                'message' => 'Hodnotenie zaznamenané',
                'review_id' => $review->idreview,
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Review not found.',
                'error' => $e->getMessage(),
            ], 404);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while saving the review.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
