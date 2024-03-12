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
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();

        return view('frontend.journal_info', ['issueIds' => $issueIds]);
    }

    
    
    public function gdpr()
    {
        // get issue ids
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();
 
        return view('frontend.gdpr', ['issueIds' => $issueIds]);
    }
    
    public function editorial_and_peer_review_proces()
    {
        // get issue ids
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();
 
        return view('frontend.editorial_publishing_practice', ['issueIds' => $issueIds]);
    }
    public function editorialBoard()
    {
        // Логика за получаване на issue IDs
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();

        return view('frontend.editorial_board', ['issueIds' => $issueIds]);
    }

    public function ethicalPublishingPractice()
    {
        // Логика за получаване на issue IDs
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();

        return view('frontend.ethical_publishing_practice', ['issueIds' => $issueIds]);
    }

    public function contactUs()
    {
        // Логика за получаване на issue IDs
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();

        return view('frontend.contact_us', ['issueIds' => $issueIds]);
    }

    public function submissionGuidance()
    {
        // Логика за получаване на issue IDs
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();

        return view('frontend.submission_guidance', ['issueIds' => $issueIds]);
    }

    public function tehnicalPublishingPractice()
    {
        // Логика за получаване на issue IDs
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();

        return view('frontend.tehnical_publishing_practice', ['issueIds' => $issueIds]);
    }

    public function editorial_publishing_practice()
    {
        // Логика за получаване на issue IDs
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();

        return view('frontend.editorial_publishing_practice', ['issueIds' => $issueIds]);
    }

}
