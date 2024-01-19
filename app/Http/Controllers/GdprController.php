<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GdprController extends Controller
{
    public function index()
    {
        return view('frontend.gdpr');
    }
}
