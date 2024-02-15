<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class CanvaArticlesController extends Controller
{
    public function listArticles()
    {
        $articles = Article::where('status', 'accepted')->get();

        return view('canva.listArticles', compact('articles'));
    }

    public function listArticlesBySpecialty($specialty)
    {
        $articles = Article::where('status', 'accepted')->where('specialty', $specialty)->get();
        $activeSpecialty = $specialty;
        
        return view('canva.listArticles', compact('articles', 'activeSpecialty'));
    }


    // Взима артикълс на отделното списание - issue
    // public function listArticlesByIssue($issueId)
    // {
    //     // Тук може би ще държим в отделна таблица Issue Articles ?!?
    //     $issueArticles = IssueArticle::where('issueId', $issueId)->get();
    //     $articles = Articles::where [issueArticles]
    //     dd($articles);
    // }

}
