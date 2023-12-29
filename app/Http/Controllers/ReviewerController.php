<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    public function ReviewerDashboard()
    {
        return view('reviewer.dashboard');
    }
}
