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

use Illuminate\Support\Facades\Mail;
use App\Mail\CoAuthorRequestEmail;
use App\Mail\ReviewRequestEmail;
use App\Mail\AdminGetArticleCreatedEmail;
use App\Mail\ArticleEditEmail;
use App\Mail\ForceReviewerEmail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Huy 
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Settings;
use setasign\Fpdi\Tcpdf\Fpdi;
use TCPDF;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;

class ArticleController extends Controller
{
    public $articleId = '';
    public $articleTitle = '';
    public $emails = [];

    public function articleCreate(Request $request)
    {

        $user = Auth::user();
        // dd($user->role );

        if ($user->role !== "admin" && $user->role !== "author") {
            abort(403);
        }

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
                $notification = array (
                    'message' => 'Article created successfully.',
                    'alert-type' => 'success'
                );


            }); // transaction
        } catch (Exception $e) {

            $notification = array(
                'message' => 'An error occurred while creating the article. Please try again.',
                'alert-type' => 'danger'
            );

            return back()->with($notification);
        }

        // Activity LOG
        activity()
            ->withProperties(['createArticle' => "Author $user->email create article with id #$this->articleId"])
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

        // Получаване на списъка с поканените рецензенти за съответната статия
        $invitedReviewers = InvitedReviewer::where('article_id', $id)->get();



        // Предайте променливата $article към изгледа за редактиране на статията
        return view('author.edit', compact('article', 'reviewers', 'review', 'invitedReviewers'));
    }
    
    // Update - FORCE ADDED REVIWER
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
                        ->withProperties(['force_reviewer_msg' => "Admin added $reviewer->name to be reviewer on article #$id"])
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

                $article->admin_accept = $request->has('admin_accept') ? 1 : 0;
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
                if ($request->hasFile('title_pages')) {
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
            ->withProperties(['updateArticle' => "Author $user->email update article with id #$this->articleId"])
            ->log('update article');


        // Send Email to Admin 
        $subject = "Edit Article : " . $this->articleTitle;
        $body['article_id'] = $this->articleId;
        $body['title'] = $this->articleTitle;

        Mail::to("superuser.blmprime@gmail.com")->send(new ArticleEditEmail($subject, $body));

        // Send Email to Reviewers 
        $review = Review::where('article_id', $articleId)->first();
        if ($review) {
            $reviewerIds = [$review->reviewer_id_1, $review->reviewer_id_2, $review->reviewer_id_3];

            foreach ($reviewerIds as $reviewerId) {
                if ($reviewerId) {
                    $user = User::find($reviewerId);
                    if ($user) {
                        Mail::to($user->email)->send(new ArticleEditEmail($subject, $body));
                    }
                }
            }
        }

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

                        // Activity LOG
                        activity()
                            ->withProperties(['sendEmailForReviewRequest' => "$user->email got email for review request on article id #$id"])
                            ->log('sent email review request');
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

        $article->coverLetter()->delete();
        $article->titlePage()->delete();
        $article->manuscript()->delete();
        $article->figures()->delete();
        $article->tables()->delete();
        $article->supplementaryFiles()->delete();
        // Изтрий самия артикул от базата данни
        $article->delete();

        $user = Auth::user();

        // Activity LOG
        activity()
            ->withProperties(['deleteArticle' => "$user->email deleted article id #$id"])
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

        $rendererName = Settings::PDF_RENDERER_DOMPDF;
        $rendererLibraryPath = base_path('vendor/dompdf/dompdf');
        Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

        foreach ([$article->coverLetter, $article->figures, $article->manuscript, $article->supplementaryFiles, $article->tables] as $files) {
            foreach ($files as $file) {
                $filePath = storage_path('app/public/' . $file->file_path);
                $filePath = str_replace('\\', '/', $filePath);

                $ext = pathinfo($filePath, PATHINFO_EXTENSION);

                $content = '';
                switch ($ext) {
                    case 'doc':
                        $php_word = \PhpOffice\PhpWord\IOFactory::load($filePath, 'MsDoc');
                        $html_writer = new \PhpOffice\PhpWord\Writer\HTML($php_word);
                        $html_file = tempnam(sys_get_temp_dir(), 'phpword');
                        $html_writer->save($html_file);
                        $content = file_get_contents($html_file);
                        unlink($html_file);
                        $pdf->AddPage();
                        $pdf->writeHTML($content, true, false, true, false, '');
                        break;
                    case 'docx':
                        $php_word = \PhpOffice\PhpWord\IOFactory::load($filePath);
                        $html_writer = new \PhpOffice\PhpWord\Writer\HTML($php_word);
                        $html_file = tempnam(sys_get_temp_dir(), 'phpword');
                        $html_writer->save($html_file);
                        $content = file_get_contents($html_file);
                        unlink($html_file);
                        $pdf->AddPage();
                        $pdf->writeHTML($content, true, false, true, false, '');
                        break;
                    case 'pdf':
                        $pdf->AddPage();
                        $pdf->Write(10, 'This is a PDF file');
                        $pagecount1 = $pdf->setSourceFile($filePath);
                        // Import pages from the source PDF file
                        for ($i = 1; $i <= $pagecount1; $i++) {
                            $tplIdx = $pdf->importPage($i);
                            $pdf->useTemplate($tplIdx);
                            if ($i < $pagecount1) {
                                $pdf->AddPage();
                            }
                        }

                        break;
                    case 'jpg':
                        $pdf->AddPage();
                        $pdf->Image($filePath, 10, 10, '', '', '', '', '', false, 300, '', false, false, 0, false, false, false);
                        break;
                    case 'jpeg':
                        $pdf->AddPage();
                        $pdf->Image($filePath, 0, 0, '', '', '', '', '', false, 300, '', false, false, 0, false, false, false);
                        break;
                    case 'png':
                        $pdf->AddPage();
                        $pdf->Image($filePath, 0, 0, '', '', '', '', '', false, 300, '', false, false, 0, false, false, false);
                        break;
                    case 'html':
                        $content = file_get_contents($filePath);
                        $pdf->AddPage();
                        $pdf->writeHTML($content, true, false, true, false, '');
                        break;
                    default:
                        break;
                }
            }
        }
        // reset pointer to the last page
        $pdf->lastPage();
        $pdf->Output('article_id_#' . $article->id . '.pdf', 'I');

    }
    public function downloadArticlePDFFiles(Article $article)
    {

        $pdf = new FPDI(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Taner Ahmed');
        $pdf->SetTitle('Document title');
        $pdf->SetSubject('Document subject');
        $pdf->SetKeywords('keyword1, keyword2, keyword3');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Zara Computers', 'by Taner Ahmed zaracomputers.bg');
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // $pdf->SetFont('freeserif', '', 10);
        $pdf->AddPage();

        $htmlType = '<div style="text-align: center; background-color: #808080; color: #ffffff;">
        <h1>' . $article->type . '</h1></div>';

        $pdf->writeHTML($htmlType);

        $pdf->writeHTML('<h1>' . $article->title . '</h1><p></p>');


        $htmlAuthors = '';
        // https://www.facebook.com/taner.ahmed -  създаде този сайт Танер Ахмед
        if ($article->authors->isNotEmpty()) {
            // Генериране на съдържанието за съавторите
            $coauthors_html = '<p><strong>Co-Authors:</strong><br>';
            foreach ($article->authors as $author) {
                $coauthors_html .= $author->first_name . ' ' . $author->family_name . '<br>';
            }
            $coauthors_html .= '</p>';

            // Добавяне на съдържанието на съавторите към основната HTML
            $htmlAuthors .= $coauthors_html;
        }

        // Записване на HTML в PDF документа
        $pdf->writeHTML($htmlAuthors);

        $pdf->writeHTML("<hr>");

        $abstract_html = '<p><h2>Abstract:</h2><br>' . $article->abstract . '</p><br>';
        $pdf->writeHTML($abstract_html);

        $pdf->writeHTML("<hr>");

        $coauthors_html = '<p><h2>Keywords:</h2>' . $article->keywords . '</p><br>';
        $pdf->writeHTML($coauthors_html);

        $rendererName = Settings::PDF_RENDERER_DOMPDF;
        $rendererLibraryPath = base_path('vendor/dompdf/dompdf');
        Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

        foreach ([$article->coverLetter, $article->figures, $article->manuscript, $article->supplementaryFiles, $article->tables, $article->titlePage] as $files) {
            foreach ($files as $file) {
                $filePath = storage_path('app/public/' . $file->file_path);
                $filePath = str_replace('\\', '/', $filePath);

                $ext = pathinfo($filePath, PATHINFO_EXTENSION);

                $content = '';
                switch ($ext) {
                    case 'doc':
                        $php_word = \PhpOffice\PhpWord\IOFactory::load($filePath, 'MsDoc');
                        $html_writer = new \PhpOffice\PhpWord\Writer\HTML($php_word);
                        $html_file = tempnam(sys_get_temp_dir(), 'phpword');
                        $html_writer->save($html_file);
                        $content = file_get_contents($html_file);
                        unlink($html_file);
                        $pdf->AddPage();
                        $pdf->writeHTML($content, true, false, true, false, '');
                        break;
                    case 'docx':
                        $php_word = \PhpOffice\PhpWord\IOFactory::load($filePath);
                        $html_writer = new \PhpOffice\PhpWord\Writer\HTML($php_word);
                        $html_file = tempnam(sys_get_temp_dir(), 'phpword');
                        $html_writer->save($html_file);
                        $content = file_get_contents($html_file);
                        unlink($html_file);
                        $pdf->AddPage();
                        $pdf->writeHTML($content, true, false, true, false, '');
                        break;
                    case 'pdf':
                        $pdf->AddPage();
                        $pdf->Write(10, '');
                        $pagecount1 = $pdf->setSourceFile($filePath);
                        // Import pages from the source PDF file
                        for ($i = 1; $i <= $pagecount1; $i++) {
                            $tplIdx = $pdf->importPage($i);
                            $pdf->useTemplate($tplIdx);
                            if ($i < $pagecount1) {
                                $pdf->AddPage();
                            }
                        }

                        break;
                    case 'jpg':
                        $pdf->AddPage();
                        $pdf->SetXY(20, 20);
                        $pdf->Image($filePath, '', '', 100, 100, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
                        break;
                    case 'jpeg':
                        $pdf->AddPage();
                        $pdf->SetXY(20, 20);
                        $pdf->Image($filePath, '', '', 100, 100, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
                        break;
                    // case 'png':
                    //     $pdf->AddPage();
                    //     $pdf->Image($filePath, 0, 0, '', '', '', '', '', false, 300, '', false, false, 0, false, false, false);
                    //     break;

                    case 'xlsx':
                        $spreadsheet = IOFactory::load($filePath);
                        $pdfWriter = new Dompdf($spreadsheet);
                        $pdfWriter->save('output.pdf');

                        $pdfFilePath = 'output.pdf'; // Пътят към PDF файла

                        $pdf->AddPage();
                        $pdf->Write(10, '');
                        $pagecount1 = $pdf->setSourceFile($pdfFilePath);
                        // Import pages from the source PDF file
                        for ($i = 1; $i <= $pagecount1; $i++) {
                            $tplIdx = $pdf->importPage($i);
                            $pdf->useTemplate($tplIdx);
                            if ($i < $pagecount1) {
                                $pdf->AddPage();
                            }
                        }

                        break;

                    case 'html':
                        $content = file_get_contents($filePath);
                        $pdf->AddPage();
                        $pdf->writeHTML($content, true, false, true, false, '');
                        break;
                    default:
                        break;
                }
            }
        }
        // reset pointer to the last page
        $pdf->lastPage();
        $pdf->Output('article_id_#' . $article->id . '.pdf', 'I');
    }


}







