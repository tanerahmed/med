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
        // $articles = Article::whereNotNull('issue_id')->get();
        $articles = Article::whereNotNull('issue_id')->paginate(10);

        $activeSpecialty = '';

        // get issue ids
        $allArticles = Article::all();
        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();
        $issueIds = array_filter($issueIds, fn($value) => !is_null($value)); // премахва null стойностите
        rsort($issueIds); // сортира масива в нарастващ ред

        $specialties = $articles->pluck('specialty')->unique()->filter(function ($value) {
            return !is_null($value) && $value !== 'Select Speciality';
        })->toArray();

        return view('canva.listArticles', compact('articles', 'issueIds', 'activeSpecialty', 'specialties'));
    }

    public function listArticlesBySpecialty($specialty)
    {
        $articles = Article::whereNotNull('issue_id')->where('specialty', $specialty)->paginate(10);
        $activeSpecialty = $specialty;

        // get issue ids
        $allArticles = Article::all();
        $filteredArticles = $allArticles->filter(function ($article) {
            return !is_null($article->issue_id);
        });

        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();
        $issueIds = array_filter($issueIds, fn($value) => !is_null($value)); // премахва null стойностите
        rsort($issueIds); // сортира масива в нарастващ ред

        $specialties = $filteredArticles->pluck('specialty')->unique()->filter(function ($value) {
            return !is_null($value) && $value !== 'Select Speciality';
        })->toArray();

        return view('canva.listArticles', compact('articles', 'issueIds', 'activeSpecialty', 'specialties'));
    }


    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $activeSpecialty = '';

        // get issue ids
        $allArticles = Article::all();
        $filteredArticles = $allArticles->filter(function ($article) {
            return !is_null($article->issue_id);
        });

        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();
        $issueIds = array_filter($issueIds, fn($value) => !is_null($value)); // премахва null стойностите
        rsort($issueIds); // сортира масива в нарастващ ред

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

        $specialties = $filteredArticles->pluck('specialty')->unique()->filter(function ($value) {
            return !is_null($value) && $value !== 'Select Speciality';
        })->toArray();
        return view('canva.listArticles', compact('articles', 'issueIds', 'activeSpecialty',  'specialties'));
    }

    public function showArticle(Article $article)
    {
        // get issue ids
        $allArticles = Article::all();
        $filteredArticles = $allArticles->filter(function ($article) {
            return !is_null($article->issue_id);
        });

        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();
        $issueIds = array_filter($issueIds, fn($value) => !is_null($value)); // премахва null стойностите
        rsort($issueIds); // сортира масива в нарастващ ред

        // content == HTML File !
        $content = Storage::get('public/' . $article->final_article_path);

        $specialties = $filteredArticles->pluck('specialty')->unique()->filter(function ($value) {
            return !is_null($value) && $value !== 'Select Speciality';
        })->toArray();

        return view('canva.showArticle', compact('article', 'issueIds', 'content',  'specialties'));
    }


    // Взима артикълс на отделното списание - issue
    public function listArticlesByIssue($issueId)
    {
        // Тук може би ще държим в отделна таблица Issue Articles ?!?
        $articles = Article::where('issue_id', $issueId)->whereNotNull('issue_id')->paginate(10);
        $activeSpecialty = '';

        // get issue ids
        $allArticles = Article::all();
        $filteredArticles = $allArticles->filter(function ($article) {
            return !is_null($article->issue_id);
        });

        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();
        $issueIds = array_filter($issueIds, fn($value) => !is_null($value)); // премахва null стойностите
        rsort($issueIds); // сортира масива в нарастващ ред

        $specialties = $filteredArticles->pluck('specialty')->unique()->filter(function ($value) {
            return !is_null($value) && $value !== 'Select Speciality';
        })->toArray();
        return view('canva.listArticlesByIssueId', compact('articles', 'issueId', 'issueIds', 'activeSpecialty',  'specialties'));
    }

}
