<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class CanvaArticlesController extends Controller
{
    public function listArticles()
    {
        $articles = Article::where('status', 'accepted')->get();
        $activeSpecialty = ''; 

        return view('canva.listArticles', compact('articles', 'activeSpecialty'));
    }

    public function listArticlesBySpecialty($specialty)
    {
        $articles = Article::where('status', 'accepted')->where('specialty', $specialty)->get();
        $activeSpecialty = $specialty;

        return view('canva.listArticles', compact('articles', 'activeSpecialty'));
    }


    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $activeSpecialty = '';

        // Търсене на статии по ключова дума
        $articles = Article::where(function($query) use ($keyword) {
            $query->where('title', 'like', "%{$keyword}%")
                ->orWhere('abstract', 'like', "%{$keyword}%")
                ->orWhere('keywords', 'like', "%{$keyword}%")
                ->orWhere('scientific_area', 'like', "%{$keyword}%")
                ->orWhere('specialty', 'like', "%{$keyword}%")
                ->orWhere('funding_name', 'like', "%{$keyword}%")
                ->orWhere('grant_id', 'like', "%{$keyword}%");
        })->get();
    

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
