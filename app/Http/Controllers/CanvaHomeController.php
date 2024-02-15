<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CanvaHomeController extends Controller
{
    public function index()
    {

        $currentIssue = 'get current ishue from DB';
        $archive = 'get last issues line from articles';

        return view('canva.home', compact('currentIssue', 'archive'));
    }
}
