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
        $articles = Article::whereNotNull('issue_id')->get();

        $activeSpecialty = '';
        // get issue ids
        $allArticles = Article::all();
        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();

        return view('canva.listArticles', compact('articles', 'issueIds', 'activeSpecialty'));
    }

    public function listArticlesBySpecialty($specialty)
    {
        $articles = Article::whereNotNull('issue_id')->where('specialty', $specialty)->get();
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
        ->whereNotNull('issue_id')
        ->get();


        return view('canva.listArticles', compact('articles', 'issueIds', 'activeSpecialty'));
    }

    public function showArticle(Article $article)
    {
        $allArticles = Article::all();
        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();
        $content = Storage::get('public/'.$article->final_article_path);
        // $content = Storage::get('public/final_articles/1/tttttt.html');

        return view('canva.showArticle', compact('article', 'issueIds', 'content'));
    }


    // Взима артикълс на отделното списание - issue
    public function listArticlesByIssue($issueId)
    {
        // Тук може би ще държим в отделна таблица Issue Articles ?!?
        $articles = Article::where('issue_id', $issueId)->whereNotNull('issue_id')->get();
        $activeSpecialty = '';
        // get issue ids
        $allArticles = Article::all();
        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();

        return view('canva.listArticlesByIssueId', compact('articles', 'issueId', 'issueIds', 'activeSpecialty'));
    }

}
