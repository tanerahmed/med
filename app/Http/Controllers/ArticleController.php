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
use App\Models\User;
use App\Models\Review;

use Illuminate\Support\Facades\Mail;
use App\Mail\CoAuthorRequestEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public $articleTitle = '';
    public $emails = [];

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

        $preparedReviews = [];

        // foreach ($articles as $article) {
            $reviews = Review::all();

            // Проверяваме само веднъж за празни ревюта
            if ($reviews !== null) {
                // Подготвяме ревюта
                foreach ($reviews as $review) {
                    $preparedReview = $review->toArray();
        
                    // Обработваме първия ревютор
                    if ($review['reviewer_id_1']) {
                        $preparedReview['reviewer1_name'] = User::find($review['reviewer_id_1'])->name;
                    } else {
                        $preparedReview['reviewer1_name'] = 'N/A';
                    }
        
                    if ($review['reviewer_id_2']) {
                        $preparedReview['reviewer2_name'] = User::find($review['reviewer_id_2'])->name;
                    } else {
                        $preparedReview['reviewer2_name'] = 'N/A';
                    }

                    if ($review['reviewer_id_3']) {
                        $preparedReview['reviewer3_name'] = User::find($review['reviewer_id_3'])->name;
                    } else {
                        $preparedReview['reviewer3_name'] = 'N/A';
                    }
        
                    // Добавяме подготвеното ревю към списъка с подготвени ревюта
                    $preparedReviews[] = $preparedReview;
                }
            } else {
                // Ако няма ревюта, добавяме съобщението за липса на ревю
                $preparedReviews[] = ['message' => 'There is no review'];
            }
        // }
        // dd(  $preparedReviews);
        // Показване на изгледа с данните за статиите и ревютата
        return view('author.articles', ['articles' => $articles, 'preparedReviews' => $preparedReviews]);

    }
    public function articleStore(Request $request)
    {
        $user = Auth::user();

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
            $errors = $validator->errors()->all();
            return back()->with('errors', $errors);
            // $validator->getMessageBag()->toArray();
            // return back()->with('error', 'An error occurred while validat data. Please try again with correct data.');
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

                $this->articleTitle = $article->title;

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
                        // prepare emails for notification
                        array_push($this->emails,  $authorData['contact']);
                    }
                }
            });
        } catch (\Exception $e) {

            $notification = array(
                'message'=> 'An error occurred while creating the article. Please try again.',
                'alert-type'=>'danger'
            );

            return back()->with($notification);
        }
        
        // Send Email
        $subject = 'Co Author Request';
        $body['name'] = $user->name;
        $body['title'] = $this->articleTitle;
        $body['link'] = "Clik to the<a href='#'>LINK</a> to aprrove.";
        
        foreach ($this->emails as $email) {
            Mail::to($email)->send(new CoAuthorRequestEmail($subject, $body));
        }

        $notification = array(
            'message'=> 'Article was created successfully.',
            'alert-type'=>'success'
        );
        
        return redirect()->route('article.list')->with($notification);
    }

}







