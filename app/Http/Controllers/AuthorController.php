<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Article;

class AuthorController extends Controller
{
    public function AuthorDashboard()
    {
        return view('author.dashboard');
    }


    public function showArticlesByAuthor($email)
    {
        $articles = Article::whereHas('authors', function ($query) use ($email) {
            $query->where('contact_email', $email);
        })->paginate(10);

        // Извличаме името на автора от първата статия
        $author = $articles->first()->authors->where('contact_email', $email)->first();

        $activeSpecialty = '';

        // get issue ids
        $allArticles = Article::all();
        $issueIds = $allArticles->pluck('issue_id')->unique()->toArray();
        $issueIds = array_filter($issueIds, fn($value) => !is_null($value)); // премахва null стойностите
        rsort($issueIds); // сортира масива в нарастващ ред

        $specialties = $articles->pluck('specialty')->unique()->filter(function ($value) {
            return !is_null($value) && $value !== 'Select Speciality';
        })->toArray();

        return view('canva.listArticles', compact('articles', 'author', 'issueIds', 'activeSpecialty', 'specialties'));
    }

}
