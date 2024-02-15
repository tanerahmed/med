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

    public function listArticlesBySpecialty($specialty_id)
    {

        $articles = Article::where('status', 'accepted')->where('specialty', $specialty_id)->get();



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
