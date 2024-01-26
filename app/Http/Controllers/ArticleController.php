<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use App\Models\TitlePage;
use App\Models\Manuscript;
use App\Models\Figure;
use App\Models\Table;
use App\Models\SupplementaryFile;
use App\Models\CoverLetter;
use App\Models\Author;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function articleCreate(Request $request)
    {
        return view('author.create');
    }

    public function articleList()
    {
        // Извличане на текущия логнат потребител
        $user = Auth::user();

        // Извличане на статиите на потребителя
        $articles = $user->articles;


        // TODO добави логика за статус на article !!!!!!!!!!!!!!s
        foreach ($articles as $article) {
            // $article->status_color = $article->isActive ? 'success' : 'danger';
            $article->status_color = 'success';
            // $article->status_text = $article->isActive ? 'Active' : 'Not Active';
            $article->status_text =  'Active' ;
        }


        // Показване на изгледа с данните за статиите
        return view('author.articles', ['articles' => $articles]);

    }
    public function articleStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:original article,review,letter to the editor,case of the month/how do I do it',
            'specialty' => 'required',
            'scientific_area' => 'nullable',
            'title' => 'required',
            'abstract' => 'required',
            'keywords' => 'required|max:500',
            'funding_name' => 'nullable',
            'grant_id' => 'nullable',
            // Останалата валидация на данните тук...
        ]);

        if ($validator->fails()) {
            $validator->getMessageBag()->toArray();
            return back()->with('error', 'An error occurred while validat data. Please try again with correct data.');
        }

        try {
            DB::transaction(function () use ($request) {
                $article = new Article();
                $article->user_id = Auth::id();
                $article->type = $request->input('type');
                $article->specialty = $request->input('specialty');
                $article->scientific_area = $request->input('scientific_area');
                $article->title = $request->input('title');
                $article->abstract = $request->input('abstract');
                $article->keywords = $request->input('keywords');
                $article->funding_name = $request->input('funding_name');
                $article->grant_id = $request->input('grant_id');
                $article->save();



                // TitlePage
                foreach ($request->file('title_pages') as $file) {
                    $filePath = $file->store('title_pages', 'public'); // Записва файла в папката storage/app/public/title_pages

                    $titlePage = new TitlePage();
                    $titlePage->article_id = $article->id;
                    $titlePage->file_path = $filePath;
                    $titlePage->save();
                }

                // Manuscript
                foreach ($request->file('manuscript') as $file) {
                    $filePath = $file->store('manuscripts', 'public');

                    $manuscript = new Manuscript();
                    $manuscript->article_id = $article->id;
                    $manuscript->file_path = $filePath;
                    $manuscript->save();
                }

                // Figures
                foreach ($request->file('figures') as $file) {
                    $filePath = $file->store('figures', 'public');

                    $figure = new Figure();
                    $figure->article_id = $article->id;
                    $figure->file_path = $filePath;
                    $figure->save();
                }

                // Tables
                foreach ($request->file('tables') as $file) {
                    $filePath = $file->store('tables', 'public');

                    $table = new Table();
                    $table->article_id = $article->id;
                    $table->file_path = $filePath;
                    $table->save();
                }

                // Supplementary Files
                foreach ($request->file('supplementary') as $file) {
                    $filePath = $file->store('supplementary_files', 'public');

                    $supplementaryFile = new SupplementaryFile();
                    $supplementaryFile->article_id = $article->id;
                    $supplementaryFile->file_path = $filePath;
                    $supplementaryFile->save();
                }

                // Cover Letter
                foreach ($request->file('cover_letter') as $file) {
                    $filePath = $file->store('cover_letters', 'public');

                    $coverLetter = new CoverLetter();
                    $coverLetter->article_id = $article->id;
                    $coverLetter->file_path = $filePath;
                    $coverLetter->save();
                }

                if ($request->has('authors')) {
                    foreach ($request->input('authors') as $authorData) {
                        $author = new Author();
                        $author->article_id = $article->id;
                        $author->first_name = $authorData['first_name'];
                        $author->middle_name = $authorData['middle_name'];
                        $author->family_name = $authorData['family_name'];
                        $author->primary_affiliation = $authorData['primary_affiliation'];
                        $author->contact_email = $authorData['contact'];
                        $author->author_contributions = $authorData['contributions'];
                        $author->save();
                    }
                }
            });
        } catch (\Exception $e) {

            return back()->with('error', 'An error occurred while creating the article. Please try again.');
        }

        return back()->with('success', 'Article created successfully.');
    }



}







