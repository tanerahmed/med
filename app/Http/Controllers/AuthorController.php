<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function AuthorDashboard()
    {
        return view('author.dashboard');
    }
}
