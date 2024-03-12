<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class CanvaHomeController extends Controller
{
    public function index()
    {

        // get issue ids
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();
    
        return view('canva.home', ['issueIds' => $issueIds]);
    }


    public function getCurrentIssue()
    {
        $lastArticle = Article::latest()->first();

        return view('canva.showArticle', ['article' => $lastArticle]);
        // return view('frontend.current_issue',  ['article' => $lastArticle]);
    }


    public function getJornalInfo()
    {
        return view('frontend.journal_info');
    }


}
