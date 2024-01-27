<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewerController extends Controller
{
    public function ReviewerDashboard()
    {
        return view('reviewer.dashboard');
    }

    public function reviewList()
    {
        // Извличане на текущия логнат потребител
        $user = Auth::user();

        $reviews = Review::where('reviewer_id_1', $user->id)
        ->orWhere('reviewer_id_2', $user->id)
        ->orWhere('reviewer_id_3', $user->id)
        ->get();

        foreach ($reviews as $review) {
            if ($review->reviewer_id_1 === $user->id) {
                $rating = $review->rating_1;
            } elseif ($review->reviewer_id_2 === $user->id) {
                $rating = $review->rating_2;
            } elseif ($review->reviewer_id_3 === $user->id) {
                $rating = $review->rating_3;
            }

            if ($rating == null){
                $review->status_color = 'secondary';
                $review->status_text =  'Pending' ;
            } elseif ($rating == 'accepted'){
                $review->status_color = 'success';
                $review->status_text =  'Accepted' ;
            } elseif ($rating == 'accepted with revision'){
                $review->status_color = 'warning';
                $review->status_text =  'accepted with revision' ;
            }elseif ($rating == 'declined'){
                $review->status_color = 'danger';
                $review->status_text =  'Declined' ;
            }            
        }

        // Показване на изгледа с данните за статиите
        return view('reviewer.reviews', ['reviews' => $reviews]);

    }



}
