<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Article;
use PhpOffice\PhpWord\IOFactory;

class CanvaArticlesController extends Controller
{
    public function listArticles()
    {
        $articles = Article::where('status', 'accepted')->get();
        $activeSpecialty = '';
        // get issue ids
        $articles = Article::all();
        $issueIds = $articles->pluck('issue_id')->unique()->toArray();

        return view('canva.listArticles', compact('articles', 'issueIds', 'activeSpecialty'));
    }

    public function listArticlesBySpecialty($specialty)
    {
        $articles = Article::where('status', 'accepted')->where('specialty', $specialty)->get();
        $activeSpecialty = $specialty;
        // get issue ids
        $allArticles = Article::all();
        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();

        return view('canva.listArticles', compact('articles', 'issueIds', 'activeSpecialty'));
    }


    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $activeSpecialty = '';
        // get issue ids
        $allArticles = Article::all();
        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();

        // Търсене на статии по ключова дума
        $articles = Article::where(function ($query) use ($keyword) {
            $query->where('title', 'like', "%{$keyword}%")
                ->orWhere('abstract', 'like', "%{$keyword}%")
                ->orWhere('keywords', 'like', "%{$keyword}%")
                ->orWhere('scientific_area', 'like', "%{$keyword}%")
                ->orWhere('specialty', 'like', "%{$keyword}%")
                ->orWhere('funding_name', 'like', "%{$keyword}%")
                ->orWhere('grant_id', 'like', "%{$keyword}%");
        })
        ->where('status', 'accepted')
        ->get();


        return view('canva.listArticles', compact('articles', 'issueIds', 'activeSpecialty'));
    }

    public function showArticle(Article $article)
    {

        return view('canva.showArticle', compact('article'));
    }


    // Взима артикълс на отделното списание - issue
    public function listArticlesByIssue($issueId)
    {
        // Тук може би ще държим в отделна таблица Issue Articles ?!?
        $articles = Article::where('issue_id', $issueId)->where('status', 'accepted')->get();
        $activeSpecialty = '';
        // get issue ids
        $allArticles = Article::all();
        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();

        return view('canva.listArticlesByIssueId', compact('articles', 'issueId', 'issueIds', 'activeSpecialty'));
    }

}
