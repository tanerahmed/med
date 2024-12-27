<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
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
use App\Models\InvitedReviewer;
use App\Models\ReviewComment;
use App\Models\PDF;

use Illuminate\Support\Facades\Mail;
use App\Mail\CoAuthorRequestEmail;
use App\Mail\ReviewRequestEmail;
use App\Mail\AdminGetArticleCreatedEmail;
use App\Mail\ArticleEditEmail;
use App\Mail\ForceReviewerEmail;
use App\Mail\ArticlePublishedEmail;
use App\Mail\ArticleDeleteddEmail;
use App\Mail\AdminAcceptArticleEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Huy 
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Settings;
use setasign\Fpdi\Tcpdf\Fpdi;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;

use PhpOffice\PhpWord\IOFactory as PhpWordIOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as PhpSpreadsheetIOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Html as PhpSpreadsheetWriterHtml;
use Illuminate\Support\Facades\File;


class ArticleController extends Controller
{
    public $articleId = '';
    public $articleTitle = '';
    public $emails = [];

    public function articleCreate(Request $request)
    {

        $user = Auth::user();
        // dd($user->role );

        // if ($user->role !== "admin" && $user->role !== "author") {
        //     abort(403);
        // }

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

        foreach ($articles as $article) {
            // Извличане на всички ревюта за текущата статия
            $reviews = Review::where('article_id', $article->id)->get();

            // Преброяване на "accepted" и "declined" рейтингите във всички ревюта
            $ratings = $reviews->flatMap(function ($review) {
                return [$review->rating_1, $review->rating_2, $review->rating_3];
            });

            $acceptedCount = $ratings->filter(function ($rating) {
                return $rating === 'accepted';
            })->count();

            $declinedCount = $ratings->filter(function ($rating) {
                return $rating === 'declined';
            })->count();

            // Проверка дали има 2 или повече accepted или declined рейтинги
            $article->isAccepted = ($acceptedCount >= 2);
            $article->isDeclined = ($declinedCount >= 2);
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
                    $preparedReview['reviewer1_id'] = User::find($review['reviewer_id_1'])->id;
                } else {
                    $preparedReview['reviewer1_name'] = '';
                }

                if ($review['reviewer_id_2']) {
                    $preparedReview['reviewer2_name'] = User::find($review['reviewer_id_2'])->name;
                    $preparedReview['reviewer2_id'] = User::find($review['reviewer_id_2'])->id;

                } else {
                    $preparedReview['reviewer2_name'] = '';
                }

                if ($review['reviewer_id_3']) {
                    $preparedReview['reviewer3_name'] = User::find($review['reviewer_id_3'])->name;
                    $preparedReview['reviewer3_id'] = User::find($review['reviewer_id_3'])->id;

                } else {
                    $preparedReview['reviewer3_name'] = '';
                }

                // Добавяме подготвеното ревю към списъка с подготвени ревюта
                $preparedReviews[] = $preparedReview;
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
            'article_type' => 'required|in:original article,review,letter to the editor,case of the month/how do I do it',
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

            return response()->json([
                'success' => false,
                'errors' => $errors 
            ], 422); // 422 е HTTP статус код за неуспешна валидация

           // return back()->with('errors', $errors);
            // $validator->getMessageBag()->toArray();
            // return back()->with('error', 'An error occurred while validat data. Please try again with correct data.');
        }

        try {
            DB::transaction(function () use ($request) {
                $article = new Article();
                $article->user_id = Auth::id();
                $article->type = $request->input('article_type');
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
                if ($request->hasFile('title_pages')) {
                    foreach ($request->file('title_pages') as $file) {
                        // $filePath = $file->store('title_pages/' . $this->articleId, 'public'); // Записва файла в папката storage/app/public/title_pages
                        $filePath = $file->storeAs('title_pages/' . $this->articleId, $file->getClientOriginalName(), 'public');

                        $titlePage = new TitlePage();
                        $titlePage->article_id = $article->id;
                        $titlePage->file_path = $filePath;
                        $titlePage->save();
                    }
                }

                // Manuscript
                if ($request->hasFile('manuscript')) {
                    foreach ($request->file('manuscript') as $file) {
                        $filePath = $file->storeAs('manuscripts/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $manuscript = new Manuscript();
                        $manuscript->article_id = $article->id;
                        $manuscript->file_path = $filePath;
                        $manuscript->save();
                    }
                }

                // Figures
                if ($request->hasFile('figures')) {
                    foreach ($request->file('figures') as $file) {
                        $filePath = $file->storeAs('figures/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $figure = new Figure();
                        $figure->article_id = $article->id;
                        $figure->file_path = $filePath;
                        $figure->save();
                    }
                }

                // Tables
                if ($request->hasFile('tables')) {
                    foreach ($request->file('tables') as $file) {
                        $filePath = $file->storeAs('tables/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $table = new Table();
                        $table->article_id = $article->id;
                        $table->file_path = $filePath;
                        $table->save();
                    }
                }

                // Supplementary Files
                if ($request->hasFile('supplementary')) {
                    foreach ($request->file('supplementary') as $file) {
                        $filePath = $file->storeAs('supplementary_files/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $supplementaryFile = new SupplementaryFile();
                        $supplementaryFile->article_id = $article->id;
                        $supplementaryFile->file_path = $filePath;
                        $supplementaryFile->save();
                    }
                }

                // Cover Letter
                if ($request->hasFile('cover_letter')) {
                    foreach ($request->file('cover_letter') as $file) {
                        $filePath = $file->storeAs('cover_letters/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $coverLetter = new CoverLetter();
                        $coverLetter->article_id = $article->id;
                        $coverLetter->file_path = $filePath;
                        $coverLetter->save();
                    }
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
                        // APPROVED == 1 ?!?
                        $author->approved = 1;
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
                $notification = array(
                    'message' => 'Article created successfully.',
                    'alert-type' => 'success'
                );


            }); // transaction
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'errors' => 'An error occurred while creating the article. Please try again.'
            ], 422); // 422 е HTTP статус код за неуспешна валидация

        }

        // Activity LOG
        activity()
            ->withProperties(['createArticle' => "Author $user->email create article with id #$this->articleId", 'articleName' => $this->articleTitle, 'articleId' => $this->articleId])
            ->log('create article');


        // Send Email Co Authors
        $subject = 'Co Author Request';
        $body['name'] = $user->name;
        $body['title'] = $this->articleTitle;
        $domain = URL::to('/');

        foreach ($this->emails as $email) {
            // $body['link'] = $domain . '/co-author-approve/' . $this->articleId . '/' . $email;
            Mail::to($email)->send(new CoAuthorRequestEmail($subject, $body));
        }

        // Send Email to Admin 
        $subject = "Created Article from: " . $user->name;

        Mail::to("superuser.blmprime@gmail.com")->send(new AdminGetArticleCreatedEmail($subject, $body));

        return response()->json([
            'success' => true,
            'redirect_url' => route('article.list'),
            'message' => 'Article was created successfully.'
        ]);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);


        // Неможе автора да бъде ревювър на себе си
        $excludedId = $article->user->id;

        $reviewers = User::where('role', 'reviewer')->whereNot('id', $excludedId)->get();
        $review = Review::where('article_id', $id)->first();

        // Получаване на списъка с поканените рецензенти за съответната статия
        $invitedReviewers = InvitedReviewer::where('article_id', $id)->get();



        // Предайте променливата $article към изгледа за редактиране на статията
        return view('author.edit', compact('article', 'reviewers', 'review', 'invitedReviewers'));
    }

    // Update - FORCE ADDED REVIWER
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Валидация на данните от формата за редактиране на статия
        $request->validate([
            // Добавете валидацията според вашите изисквания
        ]);

        // Намиране на статията за редактиране по предоставения идентификатор
        $article = Article::findOrFail($id);

        $review = Review::where('article_id', $id)->first();

        // $reviewerIds = [$review->reviewer_id_1, $review->reviewer_id_2, $review->reviewer_id_3];
        $reviewerIds = array_filter([$review->reviewer_id_1, $review->reviewer_id_2, $review->reviewer_id_3], function ($value) {
            return $value !== null;
        });

        $requestReviewerIds = array_filter([
            $request->input('reviewer_id_1'),
            $request->input('reviewer_id_2'),
            $request->input('reviewer_id_3'),
        ], function ($value) {
            return $value !== null;
        });

        // Проверяваме за съвпадения между двата масива
        $matchingIds = array_intersect($requestReviewerIds, $reviewerIds);

        // Ако има съвпадения, извеждаме съобщение и прекратяваме изпълнението на кода
        if (!empty($matchingIds)) {
            $notification = [
                'message' => 'Reviewer already selected.',
                'alert-type' => 'error'
            ];
            return redirect()->route('article.list')->with($notification);
        }


        if ($review) {
            // Обновете прегледа с информацията от формата
            $review->update([
                'reviewer_id_1' => $request->input('reviewer_id_1'),
                'reviewer_id_2' => $request->input('reviewer_id_2'),
                'reviewer_id_3' => $request->input('reviewer_id_3'),
            ]);

            $subject = 'Force added Reviewer for Article #' . $id;

            $reviewerIds = [
                $request->input('reviewer_id_1'),
                $request->input('reviewer_id_2'),
                $request->input('reviewer_id_3'),
            ];

            foreach ($reviewerIds as $reviewerId) {
                if ($reviewerId) {
                    $reviewer = User::findOrFail($reviewerId);
                    $body = [
                        'name' => $reviewer->name,
                        'article' => $id,
                    ];
                    Mail::to($reviewer->email)->send(new ForceReviewerEmail($subject, $body));
                    // Activity LOG
                    activity()
                        ->performedOn($review)
                        ->withProperties(['force_reviewer_msg' => "Admin added $reviewer->name to be reviewer on article #$id", 'articleName' => $article->title, 'articleId' => $article->id])
                        ->log('force reviewer');
                }
            }

            $notification = array(
                'message' => 'Review updated successfully.',
                'alert-type' => 'success'
            );


            return redirect()->route('article.list')->with($notification);
        } else {
            return redirect()->back()->with('error', 'Review not found.');
        }
    }

    private function cutAndReturnOnlyFileName($arr)
    {
        $file_names = [];
        foreach ($arr as $val) {
            $file_names[] = basename($val->file_path);
        }

        return $file_names;
    }

    public function articleEdit($articleId)
    {
        $article = Article::findOrFail($articleId);
        $fileNames['titlePage'] = $this->cutAndReturnOnlyFileName($article->titlePage);
        $fileNames['manuscript'] = $this->cutAndReturnOnlyFileName($article->manuscript);
        $fileNames['figures'] = $this->cutAndReturnOnlyFileName($article->figures);
        $fileNames['tables'] = $this->cutAndReturnOnlyFileName($article->tables);
        $fileNames['supplementaryFiles'] = $this->cutAndReturnOnlyFileName($article->supplementaryFiles);
        $fileNames['coverLetter'] = $this->cutAndReturnOnlyFileName($article->coverLetter);

        return view('author.articleEdit', compact('article', 'fileNames'));
    }

    public function addIssueIdBlade($articleId)
    {
        $maxIssueId = Article::max('issue_id');
        $article = Article::findOrFail($articleId);

        $latestPdf = PDF::where('article_id', $articleId)
                        ->orderBy('created_at', 'asc')
                        ->first();
        // dd($article->pdfs);

        return view('author.editIssue', compact('article', 'maxIssueId', 'latestPdf'));
    }

    public function addIssueId(Request $request, $articleId)
    {
        $issueId = $request->input('issue_id');
        $maxIssueId = Article::max('issue_id');

        if ($issueId < $maxIssueId) {
            $notification = [
                'message' => 'You can not publish article in old issue.',
                'alert-type' => 'error'
            ];
            return redirect()->route('article.list')->with($notification);
        }

        $article = Article::findOrFail($articleId);
        if ($article->status == 'accepted') {
            if ($request->has('issue_id')) {
                $article->issue_id = $issueId;
            }
            // Create Final HTML FILE for frontend
            if ($request->hasFile('final_article')) {
                $file = $request->file('final_article');
                $finalFilePath = $file->storeAs('final_articles/' . $articleId, $file->getClientOriginalName(), 'public');
                $article->final_article_path = $finalFilePath;
            }
            
            $article->save();

            // Crate PDF file for downloading in frontend
            if ($request->hasFile('pdf_file')) {
                $file = $request->file('pdf_file');
                $filePath = $file->storeAs('pdfs/' . $articleId, $file->getClientOriginalName(), 'public');

                PDF::create([
                    'file_path' => $filePath,
                    'article_id' => $article->id,
                ]);
            }


            // Activity LOG
            activity()
                ->withProperties(['publishArticle' => "Admin publish article '$article->title' with issue #$issueId.", 'articleName' => $article->title, 'articleId' => $article->id])
                ->log('publish article');


            //EMAIL че е PUBLISH
            $authorEmail = $article->user->email;
            $subject = 'Admin published your Article ' . $article->title . ' with #' . $article->id;
            $body = [
                'article_id' => $article->id,
                'article_title' => $article->title,
            ];
            Mail::to($authorEmail)->send(new ArticlePublishedEmail($subject, $body));

            $notification = [
                'message' => 'Article was published successfully.',
                'alert-type' => 'success'
            ];
        }
        return redirect()->route('article.list')->with($notification);

    }


    public function adminAcceptArticle(Request $request, $articleId)
    {
        $article = Article::findOrFail($articleId);
        $article->admin_accept = $request->has('admin_accept') ? 1 : 0;
        if ($request->has('admin_accept') == 1) {
            $article->author_can_edit = 0;
        }
        $article->save();

        // Activity LOG
        activity()
            ->withProperties(['acceptArticle' => "Editor accept article #$article->id  - $article->title", 'articleName' => $article->title, 'articleId' => $article->id])
            ->log('editor accept article');

        $subject = "Editor accept your article : " . $article->title;
        $body['article_id'] = $article->id;
        $body['article_title'] = $article->title;
        $body['author_name'] = $article->user->name;

        // Send Email Author
        Mail::to($article->user->email)->send(new AdminAcceptArticleEmail($subject, $body));

        $notification = [
            'message' => 'Article was accepted successfully.',
            'alert-type' => 'success'
        ];
        return redirect()->route('article.list')->with($notification);


    }
    public function adminAcceptArticleBlade($articleId)
    {
        $article = Article::findOrFail($articleId);
        return view('author.adminAcceptArticle', compact('article'));
    }

    public function articleUpdate(Request $request, $articleId)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            // Валидацията на данните тук...
        ]);


        try {
            DB::transaction(function () use ($request, $articleId) {
                $article = Article::findOrFail($articleId);

                if ($request->has('type')) {
                    $article->type = $request->input('type');
                }
                if ($request->has('specialty')) {
                    $article->specialty = $request->input('specialty');
                }
                if ($request->has('scientific_area')) {
                    $article->scientific_area = $request->input('scientific_area');
                }
                if ($request->has('title')) {
                    $article->title = $request->input('title');
                }
                if ($request->has('abstract')) {
                    $article->abstract = $request->input('abstract');
                }
                if ($request->has('keywords')) {
                    $article->keywords = $request->input('keywords');
                }
                if ($request->has('funding_name')) {
                    $article->funding_name = $request->input('funding_name');
                }
                if ($request->has('grant_id')) {
                    $article->grant_id = $request->input('grant_id');
                }
                // за да можем да зададем issue _Id ние трябва да имаме SATUS == ACCEPTED
                if ($article->status == 'accepted') {
                    if ($request->has('issue_id')) {
                        $article->issue_id = $request->input('issue_id');
                    }
                }

                // This action doing at  public function adminAcceptArticle
                // $article->admin_accept = $request->has('admin_accept') ? 1 : 0;

                // след ъпдейт на артикъл автора пак чака повторно разрешение за да прави промени
                $article->author_can_edit = 0;

                $article->save();

                $this->articleId = $article->id;
                $this->articleTitle = $article->title;

                // Пример за обновяване на TitlePage записи
                if ($request->hasFile('title_pages')) {
                    TitlePage::where('article_id', $articleId)->delete();
                    foreach ($request->file('title_pages') as $file) {
                        $filePath = $file->storeAs('title_pages/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $titlePage = new TitlePage();
                        $titlePage->article_id = $article->id;
                        $titlePage->file_path = $filePath;
                        $titlePage->save();
                    }
                }
                // Manuscript
                if ($request->hasFile('manuscript')) {
                    Manuscript::where('article_id', $articleId)->delete();
                    foreach ($request->file('manuscript') as $file) {
                        $filePath = $file->storeAs('manuscripts/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $manuscript = new Manuscript();
                        $manuscript->article_id = $article->id;
                        $manuscript->file_path = $filePath;
                        $manuscript->save();
                    }
                }

                // Figures
                if ($request->hasFile('figures')) {
                    Figure::where('article_id', $articleId)->delete();
                    foreach ($request->file('figures') as $file) {
                        $filePath = $file->storeAs('figures/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $figure = new Figure();
                        $figure->article_id = $article->id;
                        $figure->file_path = $filePath;
                        $figure->save();
                    }
                }

                // Tables
                if ($request->hasFile('tables')) {
                    Table::where('article_id', $articleId)->delete();
                    foreach ($request->file('tables') as $file) {
                        $filePath = $file->storeAs('tables/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $table = new Table();
                        $table->article_id = $article->id;
                        $table->file_path = $filePath;
                        $table->save();
                    }
                }

                // Supplementary Files
                if ($request->hasFile('supplementary')) {
                    SupplementaryFile::where('article_id', $articleId)->delete();
                    foreach ($request->file('supplementary') as $file) {
                        $filePath = $file->storeAs('supplementary_files/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $supplementaryFile = new SupplementaryFile();
                        $supplementaryFile->article_id = $article->id;
                        $supplementaryFile->file_path = $filePath;
                        $supplementaryFile->save();
                    }
                }

                // Cover Letter
                if ($request->hasFile('cover_letter')) {
                    CoverLetter::where('article_id', $articleId)->delete();
                    foreach ($request->file('cover_letter') as $file) {
                        $filePath = $file->storeAs('cover_letter/' . $this->articleId, $file->getClientOriginalName(), 'public');
                        $coverLetter = new CoverLetter();
                        $coverLetter->article_id = $article->id;
                        $coverLetter->file_path = $filePath;
                        $coverLetter->save();
                    }
                }

                // ИЗТРИВАНЕ НА ФАЙЛОВЕТЕ
                // Изтриване на заглавни страници (title pages)
                if ($request->has('delete_title_pages')) {
                    foreach ($request->input('delete_title_pages') as $fileName) {
                        // Изтриване на файла от системата
                        $filePath = storage_path("app/public/title_pages/$articleId/$fileName");
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
                        // Изтриване на записа от базата данни
                        TitlePage::where('file_path', "title_pages/$articleId/$fileName")
                            ->where('article_id', $article->id)
                            ->delete();
                    }
                }

                // Изтриване на ръкописи (manuscripts)
                if ($request->has('delete_manuscripts')) {
                    foreach ($request->input('delete_manuscripts') as $fileName) {
                        // Изтриване на файла от системата
                        $filePath = storage_path("app/public/manuscripts/$articleId/$fileName");
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
                        // Изтриване на записа от базата данни
                        Manuscript::where('file_path', "manuscripts/$articleId/$fileName")
                            ->where('article_id', $article->id)
                            ->delete();
                    }
                }

                // Изтриване на фигури (figures)
                if ($request->has('delete_figures')) {
                    foreach ($request->input('delete_figures') as $fileName) {
                        // Изтриване на файла от системата
                        $filePath = storage_path("app/public/figures/$articleId/$fileName");
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
                        // Изтриване на записа от базата данни
                        Figure::where('file_path', "figures/$articleId/$fileName")
                            ->where('article_id', $article->id)
                            ->delete();
                    }
                }

                // Изтриване на таблици (tables)
                if ($request->has('delete_tables')) {
                    foreach ($request->input('delete_tables') as $fileName) {
                        // Изтриване на файла от системата
                        $filePath = storage_path("app/public/tables/$articleId/$fileName");
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
                        // Изтриване на записа от базата данни
                        Table::where('file_path', "tables/$articleId/$fileName")
                            ->where('article_id', $article->id)
                            ->delete();
                    }
                }

                // Изтриване на допълнителни файлове (supplementary files)
                if ($request->has('delete_supplementary')) {
                    foreach ($request->input('delete_supplementary') as $fileName) {
                        // Изтриване на файла от системата
                        $filePath = storage_path("app/public/supplementary/$articleId/$fileName");
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
                        // Изтриване на записа от базата данни
                        SupplementaryFile::where('file_path', "supplementary/$articleId/$fileName")
                            ->where('article_id', $article->id)
                            ->delete();
                    }
                }

                // Изтриване на съпроводителни писма (cover letters)
                if ($request->has('delete_cover_letter')) {
                    foreach ($request->input('delete_cover_letter') as $fileName) {
                        // Изтриване на файла от системата
                        $filePath = storage_path("app/public/cover_letters/$articleId/$fileName");
                        if (File::exists($filePath)) {
                            File::delete($filePath);
                        }
                        // Изтриване на записа от базата данни
                        CoverLetter::where('file_path', "cover_letters/$articleId/$fileName")
                            ->where('article_id', $article->id)
                            ->delete();
                    }
                }

                // след като автора нарпави промени по статията даваме рпаво на всички Ревювъри да могат да правят ревю
                $review = Review::where('article_id', $articleId)->first();
                $review->reviewer_id_1_canedit = 1;
                $review->reviewer_id_2_canedit = 1;
                $review->reviewer_id_3_canedit = 1;
                $review->save();
            });
        } catch (\Exception $e) {
            $notification = [
                'message' => 'An error occurred while updating the article. Please try again.',
                'alert-type' => 'danger'
            ];
            return back()->with($notification);
        }
        // Activity LOG
        activity()
            ->withProperties(['updateArticle' => "Author $user->email update article with id #$this->articleId", 'articleName' => $this->articleTitle, 'articleId' => $this->articleId])
            ->log('update article');




        // Send Email to Admin 
        $subject = "Edit Article : " . $this->articleTitle;
        $body['article_id'] = $this->articleId;
        $body['title'] = $this->articleTitle;

        // Send Email to Admin 
        Mail::to("superuser.blmprime@gmail.com")->send(new ArticleEditEmail($subject, $body));

        // Send Email to Reviewers  !!!!!!  NO NEEDED !!!!!!
        // $review = Review::where('article_id', $articleId)->first();
        // if ($review) {
        //     $reviewerIds = [$review->reviewer_id_1, $review->reviewer_id_2, $review->reviewer_id_3];

        //     foreach ($reviewerIds as $reviewerId) {
        //         if ($reviewerId) {
        //             $user = User::find($reviewerId);
        //             if ($user) {
        //                 Mail::to($user->email)->send(new ArticleEditEmail($subject, $body));
        //             }
        //         }
        //     }
        // }

        $notification = [
            'message' => 'Article was updated successfully.',
            'alert-type' => 'success'
        ];
        return redirect()->route('article.list')->with($notification);

    }

    public function sendEmailForReviewRequest(Request $request, $id)
    {
       
        $review = Review::where('article_id', $id)->first();
        if ($review) {
            $reviewerIds = [$review->reviewer_id_1, $review->reviewer_id_2, $review->reviewer_id_3];
            foreach (['reviewer_id_1', 'reviewer_id_2', 'reviewer_id_3'] as $reviewerIdKey) {
                $reviewerId = $request->input($reviewerIdKey);

                if ($reviewerId && !in_array($reviewerId, $reviewerIds)) {
                    $user = User::find($reviewerId);
                    // Изпрати покана ако не си пращал преди.
                    $invitedReviewers = InvitedReviewer::where('article_id', $id)->pluck('user_id')->toArray();
                    if (!in_array($reviewerId, $invitedReviewers)) {
                        if ($user) {
                            $subject = 'Reviewer Request for Article #' . $id;
                            $domain = URL::to('/');
                            $body = [
                                'name' => $user->name,
                                'article' => $id,
                                'link_approve' => $domain . '/reviews/request/' . $user->id . '/' . $review->id,
                                'link_reject' => $domain . '/reviews/request/reject/' . $user->id . '/' . $review->id,
                            ];

                            Mail::to($user->email)->send(new ReviewRequestEmail($subject, $body));

                            // Запазваме информация за поканения рецензент в таблицата
                            InvitedReviewer::saveInvitedReviewer($id, $user->id);

                            $article = Article::findOrFail($id);
                            // Activity LOG
                            activity()
                                ->withProperties(['sendEmailForReviewRequest' => "$user->email got email for review request on article id #$id", 'articleName' => $article->title, 'articleId' => $article->id])
                                ->log('sent email review request');
                            $notification = array(
                                'message' => 'Review requests was sent successfully.',
                                'alert-type' => 'success'
                            );
                        }
                    // Ако вече сме изпратили имейл към ревювър за с покана не пращай повече!
                    }else{
                        $notification = array(
                            'message' => 'Review requests already was sent.',
                            'alert-type' => 'danger'
                        );
                    }
                }
            }

            return redirect()->route('article.list')->with($notification);
        }

        // Error
        $notification = array(
            'message' => 'There is a problem, plase try again later.',
            'alert-type' => 'danger'
        );
        return redirect()->route('article.list')->with($notification);
    }

    public function coAuthorApprove($articleId, $coAuthorEmail)
    {
        $author = Author::where('article_id', $articleId)->where('contact_email', $coAuthorEmail)->first();
        $author->approved = true;
        $author->save();

        // // Activity LOG
        // activity()
        //     ->withProperties(['coAuthorApprove' => "$coAuthorEmail approve to be Co Author on article #$articleId"])
        //     ->log('Co Author approve');

        return view('co_author_accept_thanks_page');
    }

    public function destroy($id)
    {
        // Намери артикула, който ще изтрием
        $article = Article::findOrFail($id);

        $deleted_article_title = $article->title;
        $deleted_article_id = $article->id;

        $article->coverLetter()->delete();
        $article->titlePage()->delete();
        $article->manuscript()->delete();
        $article->figures()->delete();
        $article->tables()->delete();
        $article->supplementaryFiles()->delete();


        // Изтриване на свързаните коментари за ревюта
        ReviewComment::where('article_id', $article->id)->delete();

        // Изтрий самия артикул от базата данни
        $article->delete();

        $user = Auth::user();

        //EMAIL че е PUBLISH
        $authorEmail = $article->user->email;
        $subject = 'Admin published your Article ' . $article->title . ' with #' . $article->id;
        $body = [
            'article_id' => $article->id,
            'article_title' => $article->title,
            'author' => $user->name
        ];
        Mail::to("superuser.blmprime@gmail.com")->send(new ArticleDeleteddEmail($subject, $body));

        // Activity LOG
        activity()
            ->withProperties(['deleteArticle' => "$user->email deleted article id #$id", 'articleName' => $deleted_article_title, 'articleId' => $deleted_article_id])
            ->log('delete article');

        // Пренасочи към страницата, където се показват всички артикули,
        // или към друго място в зависимост от изискванията на вашето приложение
        return redirect()->route('article.list')->with('success', 'Article deleted successfully');
    }


    public function summaryPdfFile(Article $article)
    {

        $pdf = new FPDI(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Author');
        $pdf->SetTitle('Document title');
        $pdf->SetSubject('Document subject');
        $pdf->SetKeywords('keyword1, keyword2, keyword3');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->AddPage();

        $htmlType = '<div style="text-align: center; background-color: #808080; color: #ffffff;">
        <h1>' . $article->type . '</h1></div>';

        $pdf->writeHTML($htmlType);
        $pdf->writeHTML('<h1>' . $article->title . '</h1><p></p>');
        $pdf->writeHTML("<hr>");
        $abstract_html = '<p><h2>Abstract:</h2><br>' . $article->abstract . '</p><br>';
        $pdf->writeHTML($abstract_html);
        $pdf->writeHTML("<hr>");
        $coauthors_html = '<p><h2>Keywords:</h2>' . $article->keywords . '</p><br>';
        $pdf->writeHTML($coauthors_html);

        // $article->titlePage = без него!
        foreach ([$article->manuscript, $article->figures, $article->tables, $article->supplementaryFiles, $article->coverLetter] as $files) {
            foreach ($files as $file) {
                $filePath = storage_path('app/public/' . $file->file_path);
                $filePath = str_replace('\\', '/', $filePath);

                $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                $content = '';

                try {
                    switch ($ext) {
                        case 'doc':
                        case 'docx':
                            $phpWord = PhpWordIOFactory::load($filePath);
                            $htmlWriter = PhpWordIOFactory::createWriter($phpWord, 'HTML');
                            $htmlFile = tempnam(sys_get_temp_dir(), 'phpword');
                            $htmlWriter->save($htmlFile);
                            $content = file_get_contents($htmlFile);
                            unlink($htmlFile);
                            $pdf->AddPage();
                            $pdf->writeHTML($content, true, false, true, false, '');
                            break;
                        case 'xlsx':
                        case 'xls':
                            $spreadsheet = PhpSpreadsheetIOFactory::load($filePath);
                            $htmlWriter = new PhpSpreadsheetWriterHtml($spreadsheet);
                            $htmlFile = tempnam(sys_get_temp_dir(), 'phpspreadsheet');
                            $htmlWriter->save($htmlFile);
                            $content = file_get_contents($htmlFile);
                            unlink($htmlFile);
                            $pdf->AddPage();
                            $pdf->writeHTML($content, true, false, true, false, '');
                            break;
                        case 'pdf':
                            $pageCount = $pdf->setSourceFile($filePath);
                            $pdf->AddPage();
                            for ($i = 1; $i <= $pageCount; $i++) {
                                $tplIdx = $pdf->importPage($i);
                                $pdf->useTemplate($tplIdx);
                                if ($i < $pageCount) {
                                    $pdf->AddPage();
                                }
                            }
                            break;
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                            // $pdf->Image($filePath, 10, 10, '', '', '', '', '', false, 300, '', false, false, 0, false, false, false);
                            // Добавяне на изображение
                            // $pdf->Image($file, $x, $y, $w, $h, $type, $link, $align, $resize, $dpi, $palign, $ismask, $imgmask, $border, $fitbox, $hidden, $fitonpage);
                            // Ако искате изображението да пасне на ширината на страницата и да се мащабира пропорционално:
                            $pdf->AddPage();
                            $margin = 10; // Може да се променя според нуждите за маржове.
                            $pageWidth = $pdf->GetPageWidth() - 2 * $margin; // ширина на страницата минус маржовете от двете страни
                            $pageHeight = $pdf->GetPageHeight() - 2 * $margin; // височина на страницата минус маржовете от двете страни

                            // Получаване размерите на изображението
                            list($width, $height) = getimagesize($filePath);

                            // Изчисляване на аспектното съотношение
                            $aspectRatio = $width / $height;

                            // Изчисляване на новите размери
                            if ($width > $height) {
                                // Ландшафтно изображение
                                $newWidth = $pageWidth; // ширината на страницата е максималната ширина
                                $newHeight = $newWidth / $aspectRatio;
                                if ($newHeight > $pageHeight) {
                                    $newHeight = $pageHeight;
                                    $newWidth = $newHeight * $aspectRatio;
                                }
                            } else {
                                // Портретно изображение
                                $newHeight = $pageHeight;
                                $newWidth = $newHeight * $aspectRatio;
                                if ($newWidth > $pageWidth) {
                                    $newWidth = $pageWidth;
                                    $newHeight = $newWidth / $aspectRatio;
                                }
                            }

                            // Добавяне на изображението
                            $pdf->Image($filePath, $margin, $margin, $newWidth, $newHeight, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
                            break;
                        case 'html':
                            $content = file_get_contents($filePath);
                            $pdf->AddPage();
                            $pdf->writeHTML($content, true, false, true, false, '');
                            break;
                        default:
                            break;
                    }
                } catch (\Exception $e) {

                    \Log::error("Error processing file {$filePath}: " . $e->getMessage());
                }
            }
        }

        $pdf->lastPage();
        $pdf->Output('article_id_#' . $article->id . '.pdf', 'I');
    }



    private function mergePdf($apiKey, $uploadedFiles)
    {
        // Създаване на URL
        $url = "https://api.pdf.co/v1/pdf/merge";

        // Подготовка на параметрите за заявката
        $parameters = array();
        $parameters["name"] = "result.pdf";
        $parameters["url"] = join(",", $uploadedFiles);

        // Създаване на JSON payload
        $data = json_encode($parameters);

        // Създаване на заявка
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("x-api-key: " . $apiKey, "Content-type: application/json"));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        // Изпълнение на заявката
        $result = curl_exec($curl);

        if (curl_errno($curl) == 0) {
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($status_code == 200) {
                $json = json_decode($result, true);

                if (!isset($json["error"]) || $json["error"] == false) {
                    $resultFileUrl = $json["url"];

                    // Показване на линк към резултатния документ
                    echo "<div><h2>Conversion Result:</h2><a href='" . $resultFileUrl . "' target='_blank'>" . $resultFileUrl . "</a></div>";
                } else {
                    // Показване на грешката, която върна услугата
                    echo "<p>Error: " . $json["message"] . "</p>";
                }
            } else {
                // Показване на грешка при заявка
                echo "<p>Status code: " . $status_code . "</p>";
                echo "<p>" . $result . "</p>";
            }
        } else {
            // Показване на грешка при изпълнение на CURL заявката
            echo "Error: " . curl_error($curl);
        }

        // Почистване
        curl_close($curl);
    }


    // public function downloadArticlePDFFiles(Article $article)
    // {

    //     $apiKey = "tanerahmed87@gmail.com_0MODe75ov9bco2OuOWwYHB9x308U3C0T0d1HxWDDwf26wwLl6t1vj0Qsf836nam8";


    //     $uploadedFiles = [];

    //     foreach ([$article->coverLetter, $article->figures, $article->manuscript, $article->supplementaryFiles, $article->tables, $article->titlePage] as $files) {
    //         foreach ($files as $file) {
    //             $filePath = storage_path('app/public/' . $file->file_path);
    //             $filePath = str_replace('\\', '/', $filePath);
    //             $uploadedFiles[] = $filePath; // Добавяне на пътя до файла в масива с качени файлове
    //         }
    //     }

    //     // dd($uploadedFiles);
    //     /*
    //       array:1 [▼ // app\Http\Controllers\ArticleController.php:954
    //       0 => "C:/xampp/htdocs/med/storage/app/public/manuscripts/65/file-sample_100kB.doc"
    //             ]
    //      */


    //     $this->mergePdf($apiKey, $uploadedFiles);
    // }

    public function updateAuthorCanEdit($id, Request $request)
    {
        $article = Article::findOrFail($id);
        $article->author_can_edit = $request->input('author_can_edit', 0);
        $article->save();

        $notification = array(
            'message' => 'Send Edit to article' . $article->title . ' successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('article.list')->with($notification);
    }


}







