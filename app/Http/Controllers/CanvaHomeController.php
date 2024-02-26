<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CanvaHomeController extends Controller
{
    public function index()
    {

        // Home page

        return view('canva.home', compact('currentIssue', 'archive'));
    }


    public function getCurrentIssue()
    {
        $currentIssue = 'get current ishue from DB';
        $archive = 'get last issues line from articles';

        return view('frontend.current_issue', compact('currentIssue', 'archive'));
    }


    public function getJornalInfo()
    {
        return view('frontend.journal_info');
    }


}
