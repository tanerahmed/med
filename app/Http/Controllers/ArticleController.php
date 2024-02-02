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
use App\Mail\ReviewRequestEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public $articleId = '';
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

        // Admin got all articles!
        if ($user->role === 'admin') {
            $articles = Article::all();
        }

        $preparedReviews = [];

        // foreach ($articles as $article) {
        $reviews = Review::all();

        // Проверяваме само веднъж за празни ревюта
        if (!$reviews->isEmpty()) {
            // Подготвяме ревюта
            foreach ($reviews as $review) {
                $preparedReview = $review->toArray();

                // Обработваме първия ревютор
                if ($review['reviewer_id_1']) {
                    $preparedReview['reviewer1_name'] = User::find($review['reviewer_id_1'])->name;
                } else {
                    $preparedReview['reviewer1_name'] = '';
                }

                if ($review['reviewer_id_2']) {
                    $preparedReview['reviewer2_name'] = User::find($review['reviewer_id_2'])->name;
                } else {
                    $preparedReview['reviewer2_name'] = '';
                }

                if ($review['reviewer_id_3']) {
                    $preparedReview['reviewer3_name'] = User::find($review['reviewer_id_3'])->name;
                } else {
                    $preparedReview['reviewer3_name'] = '';
                }

                // Добавяме подготвеното ревю към списъка с подготвени ревюта
                $preparedReviews[] = $preparedReview;

                // Make status logic
                // if ($review->rating_1 === null || $review->rating_2 === null) {
                //     $articles[$review->article_id]['statusFromReview'] = '<button type="button" class="btn btn-secondary" disabled>Pending</button>';
                // } elseif ($review->rating_1 === 'accepted' && $review->rating_2 === 'accepted') {
                //     $articles[$review->article_id]['statusFromReview'] = '<button type="button" class="btn btn-success" disabled>Accepted</button>';
                // } elseif (
                //     ($review->rating_1 === 'accepted' && $review->rating_2 === 'accepted with revision') ||
                //     ($review->rating_1 === 'accepted with revision' && $review->rating_2 === 'accepted')
                // ) {
                //     $articles[$review->article_id]['statusFromReview'] = '<button type="button" class="btn btn-warning" disabled>Accept with revision</button>';
                // } elseif ($review->rating_1 === 'declined' || $review->rating_2 === 'declined') {
                //     $articles[$review->article_id]['statusFromReview'] = '<button type="button" class="btn btn-danger" disabled>Declined</button>';
                // }


            }
        }
        // dd($articles);
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

                $this->articleId = $article->id;
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
                        array_push($this->emails, $authorData['contact']);
                    }
                }

                // Създаване на празен запис в таблицата Review
                Review::create([
                    'article_id' => $this->articleId,
                    'rating_1' => null,
                    'reviewer_id_1' => null,
                    'rating_2' => null,
                    'reviewer_id_2' => null,
                    'rating_3' => null,
                    'reviewer_id_3' => null,
                ]);

            });
        } catch (\Exception $e) {

            $notification = array(
                'message' => 'An error occurred while creating the article. Please try again.',
                'alert-type' => 'danger'
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
            'message' => 'Article was created successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('article.list')->with($notification);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $reviewers = User::where('role', 'reviewer')->get();
        $review = Review::where('article_id', $id)->first();

        // Предайте променливата $article към изгледа за редактиране на статията
        return view('author.edit', compact('article', 'reviewers', 'review'));
    }

    public function update(Request $request, $id)
    {
        // Валидация на данните от формата за редактиране на статия
        $request->validate([
            // Добавете валидацията според вашите изисквания
        ]);

        // Намиране на статията за редактиране по предоставения идентификатор
        // $article = Article::findOrFail($id);

        // Обновяване на данните на статията с информацията от формата
        // $article->update([
        //     // Обновете съответно с полята, които трябва да се обновят
        // ]);


        $review = Review::where('article_id', $id)->first();
        if ($review) {
            // Обновете прегледа с информацията от формата
            $review->update([
                'reviewer_id_1' => $request->input('reviewer_id_1'),
                'reviewer_id_2' => $request->input('reviewer_id_2'),
                'reviewer_id_3' => $request->input('reviewer_id_3'),
            ]);
            $notification = array(
                'message' => 'Review updated successfully.',
                'alert-type' => 'success'
            );

            return redirect()->route('article.list')->with($notification);
        } else {
            return redirect()->back()->with('error', 'Review not found.');
        }
    }


    // първо провери дали reviwer_id го има в review, ако го няма тогава прати имейл
    public function sendEmailForReviewRequest(Request $request, $id)
    {
        $review = Review::where('article_id', $id)->first();
        if ($review) {
            $reviewerIds = [$review->reviewer_id_1, $review->reviewer_id_2, $review->reviewer_id_3];
            foreach (['reviewer_id_1', 'reviewer_id_2', 'reviewer_id_3'] as $reviewerIdKey) {
                $reviewerId = $request->input($reviewerIdKey);

                if ($reviewerId && !in_array($reviewerId, $reviewerIds)) {
                    $user = User::find($reviewerId);

                    if ($user) {
                        $subject = 'Reviewer Request';
                        $body = [
                            'name' => $user->name,
                            'article' => $id,
                            'link' => '<a href="#">LINK</a> to approve.'
                        ];

                        Mail::to($user->email)->send(new ReviewRequestEmail($subject, $body));
                    }
                }
            }
            $notification = array(
                'message' => 'Review requests was sent successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('article.list')->with($notification);
        }
        
        // Error
        $notification = array(
            'message' => 'There is a problem, plase try again later.',
            'alert-type' => 'danger'
        );
        return redirect()->route('article.list')->with($notification);
    }

}







