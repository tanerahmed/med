<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Article;
use App\Models\ReviewComment;
use App\Models\InvitedReviewer;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewArticleEmail;
use App\Mail\UserApproveReviewRequestEmail;
use App\Mail\UserRejectReviewRequestEmail;
use App\Mail\FullAcceptArticleEmail;
use App\Mail\ReviewArticleForAdminEmail;
use ZipArchive;

// Activity Log


class ReviewerController extends Controller
{
    public function ReviewerDashboard()
    {
        return view('reviewer.dashboard');
    }

    public function reviewList()
    {
        // Извличане на текущия логнат потребител
        $user = Auth::user();

        $reviews = Review::where('reviewer_id_1', $user->id)
            ->orWhere('reviewer_id_2', $user->id)
            ->orWhere('reviewer_id_3', $user->id)
            ->get();

        foreach ($reviews as $review) {
            if ($review->reviewer_id_1 === $user->id) {
                $rating = $review->rating_1;
            } elseif ($review->reviewer_id_2 === $user->id) {
                $rating = $review->rating_2;
            } elseif ($review->reviewer_id_3 === $user->id) {
                $rating = $review->rating_3;
            }

            if ($rating == null) {
                $review->status_color = 'secondary';
                $review->status_text = 'Pending';
            } elseif ($rating == 'accepted') {
                $review->status_color = 'success';
                $review->status_text = 'Accepted';
            } elseif ($rating == 'accepted with revision') {
                $review->status_color = 'warning';
                $review->status_text = 'accepted with revision';
            } elseif ($rating == 'declined') {
                $review->status_color = 'danger';
                $review->status_text = 'Declined';
            }
        }

        // Показване на изгледа с данните за статиите
        return view('reviewer.reviews', ['reviews' => $reviews]);

    }

    public function review(Article $article)
    {
        return view('reviewer.review', compact('article'));
    }

    public function downloadArticleFiles(Article $article)
    {
        // Създаване на нов ZIP архив
        $zip = new ZipArchive;
        $zipFileName = "article_id = " . $article->id . ".zip";

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {

            //  TITLE PAGE dont show in ZIP file if is REVIWER
            $user = Auth::user();
            if ($user->role !== "reviewer") {
                foreach ($article->titlePage as $value) {
                    $filePath = storage_path('app/public/' . $value->file_path);
                    $filePath = str_replace('\\', '/', $filePath);
                    $zip->addFile($filePath, basename($filePath));
                }
            }

            foreach ($article->manuscript as $value) {
                $filePath = storage_path('app/public/' . $value->file_path);
                $filePath = str_replace('\\', '/', $filePath);
                $zip->addFile($filePath, basename($filePath));
            }

            foreach ($article->supplementaryFiles as $value) {
                $filePath = storage_path('app/public/' . $value->file_path);
                $filePath = str_replace('\\', '/', $filePath);
                $zip->addFile($filePath, basename($filePath));
            }

            foreach ($article->tables as $value) {
                $filePath = storage_path('app/public/' . $value->file_path);
                $filePath = str_replace('\\', '/', $filePath);
                $zip->addFile($filePath, basename($filePath));
            }

            foreach ($article->coverLetter as $value) {
                $filePath = storage_path('app/public/' . $value->file_path);
                $filePath = str_replace('\\', '/', $filePath);
                $zip->addFile($filePath, basename($filePath));
            }

            foreach ($article->figures as $value) {
                $filePath = storage_path('app/public/' . $value->file_path);
                $filePath = str_replace('\\', '/', $filePath);
                $zip->addFile($filePath, basename($filePath));
            }

            // Затваряне на ZIP архива
            $zip->close();
        }

        // Сваляне на ZIP архива
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    private function prepareQuestions($answer1, $answer2, $answer3)
    {
        $result = "Question 1 : $answer1 <br>
                    Qestion 2 : $answer2 <br>
                    Question 3 : $answer3";
        return $result;

    }

    public function store(Request $request)
    {
        $zipFile = '';
        $filePath = '';
        $user = Auth::user();
        $req = $request->all();
        $articleId = $request->input('articleId');
        $article = Article::find($articleId);

        if ($request->hasFile('zip_file')) {
            $zipFile = $request->file('zip_file')[0];
            $zipFilePath = $zipFile->store('review_zip_files', 'public');

            $filePath = storage_path('app/public/' . $zipFilePath);
            $filePath = str_replace('\\', '/', $filePath);
        }
        $body['article_title'] = $article->title;
        $body['articleId'] = $articleId;
        $body['reviwer_name'] = $user->name;
        // $body['question1'] = $request->input('question1');
        // $body['question2'] = $request->input('question2');
        // $body['question3'] = $request->input('question3');
        // $body['zipFile'] = $zipFile;
        // $body['titlePages'] = $request->input('title_pages');
        // $body['manuscript'] = $request->input('manuscript');
        // $body['figures'] = $request->input('figures');
        // $body['tables'] = $request->input('tables');s
        // $body['supplementary'] = $request->input('supplementary');
        // $body['coverLetter'] = $request->input('cover_letter');
        // $body['keywords'] = $request->input('keywords');
        // $body['title'] = $request->input('title');
        // $body['abstract'] = $request->input('abstract');
        $body['review_comments'] = $request->input('review_comments');
        $body['rating'] = $request->input('rating');

        $review = Review::where('article_id', $articleId)->first();
        $rating = $request->input('rating');
        if ($review->reviewer_id_1 === $user->id) {
            $review->rating_1 = $rating;
        } elseif ($review->reviewer_id_2 === $user->id) {
            $review->rating_2 = $rating;
        } elseif ($review->reviewer_id_3 === $user->id) {
            $review->rating_3 = $rating;
        }
        $review->save();

        // Проверяме дали ще даваме право на Автор да прави промени по артикъла
        // Повторно зареждане на инстанцията на Review
        $review = Review::where('article_id', $articleId)->latest()->first();
        // $review = Review::where('article_id', $articleId)->first();

        // Проверка на комбинацията от рейтинги
        $ratings = [$review->rating_1, $review->rating_2, $review->rating_3];
        if (in_array('accepted', $ratings) && in_array('accepted', $ratings)) {
            // $article->author_can_edit = 1;
            $article->status = 'accepted';
            $article->save();
        } 
        if (in_array('accepted', $ratings) && in_array('accepted with revision', $ratings)) {
            // $article->author_can_edit = 1;
            $article->status = 'pending';
            $article->save();
        }
        elseif (in_array('declined', $ratings) && in_array('accepted', $ratings)) {
            // $article->author_can_edit = 1;
            $article->status = 'pending';
            $article->save();
        } elseif (in_array('declined', $ratings) && in_array('accepted with revision', $ratings)) {
            // $article->author_can_edit = 1;
            $article->status = 'pending';
            $article->save();
        } elseif (in_array('declined', $ratings) && in_array('declined', $ratings)) {
            // $article->author_can_edit = 1;
            $article->status = 'declined';
            $article->save();
        } elseif (count(array_filter($ratings, fn($rating) => $rating === 'accepted with revision')) >= 2) {
            // $article->author_can_edit = 1;
            $article->status = 'pending';
            $article->save();
        } else {
            // $article->author_can_edit = 0;
            $article->save();
        }

        $review_questions = $this->prepareQuestions($request->input('answer1'), $request->input('answer2'), $request->input('answer3'));
        // Review Comments
        $reviewComment = new ReviewComment();
        $reviewComment->article_id = $article->id;
        $reviewComment->user_id = $user->id;
        $reviewComment->rating = $request->input('rating');
        $reviewComment->review_questions = $review_questions;
        $reviewComment->review_comments = $request->input('review_comments');
        $reviewComment->file_path = '';
        $reviewComment->save();

        // Activity LOG
        activity()
            ->withProperties(['review' => "$user->email raited article #$articleId with $rating"])
            ->log('reviwe article');


        $acceptedCount = 0;
        if ($review->rating_1 === 'accepted') {
            $acceptedCount++;
        }
        if ($review->rating_2 === 'accepted') {
            $acceptedCount++;
        }
        if ($review->rating_3 === 'accepted') {
            $acceptedCount++;
        }
        // SEND ONLY TO ADMIN !!!!
        //$subject = "Review Article #" . $articleId;
        $subject = "Article '$article->title' was reviwed.";
        if (!empty($filePath)) {
            // Mail::to($article->user->email)->send(new ReviewArticleEmail($subject, $body, $filePath));
            Mail::to("Superuser.blmprime@gmail.com")->send(new ReviewArticleEmail($subject, $body, $filePath));
        } else {
            // Mail::to($article->user->email)->send(new ReviewArticleEmail($subject, $body));
            Mail::to("Superuser.blmprime@gmail.com")->send(new ReviewArticleEmail($subject, $body));
        }

        if ($acceptedCount >= 2) {
            // Ако има поне два "accepted" рейтинга, извикваме метода за създаване на XML файла
            $xmlController = new XMLController();
            $response = $xmlController->generateXML($article);

            // Ъпдейтваме и Article table и му даваме да е ACCEPTED!
            $article->status = 'accepted';
            $article->save();
            // send email full acceot
            Mail::to($article->user->email)->send(new FullAcceptArticleEmail($subject, $body));

            // Activity LOG
            activity()
                ->withProperties(['fullAccept' => "Article #$articleId is FULL ACCEPT!"])
                ->log('article full accept');


            // Проверка на резултата и връщане на пренасочване или съобщение за грешка
            if ($response->getStatusCode() === 200) {
                // Значи XML файлат е създаден успешно
            }
        }

        $notification = array(
            'message' => 'You reviewd article successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('review.list')->with($notification);
    }

    public function showReviewComments($article_id, $user_id)
    {

        $reviews = ReviewComment::where('article_id', $article_id)
            ->where('user_id', $user_id)
            ->get();

        return view('reviewer.show_review_comments', ['reviews' => $reviews]);

    }

    public function approveReviewRequest($user_id, $review_id)
    {

        $user = Auth::user();

        if ($user->id != intval($user_id)) {
            abort(404);
        }

        $review = Review::find($review_id);

        // трябва да вземем автора и да му пратим имейл, че ревювър еди кой си е приел да е ревювър
        $author_email = $review->article->user->email;

        $reviewerIds = [$review->reviewer_id_1, $review->reviewer_id_2, $review->reviewer_id_3];

        // Ако ревювъра вече е един от тях, не правим нищо 
        // т.е. Ако няма как да имаме един и същ човек да е два пъти ревъвър на един артикъл
        if (!in_array($user->id, $reviewerIds)) {
            if ($review->reviewer_id_1 === null) {
                $review->reviewer_id_1 = $user->id;
            } elseif ($review->reviewer_id_2 === null) {
                $review->reviewer_id_2 = $user->id;
            } elseif ($review->reviewer_id_3 === null) {
                // Проверка дали rating_1 и rating_2 съдържат "accepted" или "accepted with revision" а другият е "declined"
                //  Само тогава записваме Арбитър - Ревювър 3
                $isRating1Accepted = in_array($review->rating_1, ['accepted', 'accepted with revision']);
                $isRating2Accepted = in_array($review->rating_2, ['accepted', 'accepted with revision']);
                $isRating1Declined = $review->rating_1 === 'declined';
                $isRating2Declined = $review->rating_2 === 'declined';

                // Проверка на условието
                if (($isRating1Accepted && $isRating2Declined) || ($isRating1Declined && $isRating2Accepted)) {
                    $review->reviewer_id_3 = $user->id;
                }
            }// Тува вече квотата е пълна от Ревювъри и казваме, че към момента няма как да стане ревювър
            else {
                $notification = array(
                    'message' => 'All reviewers found.',
                    'alert-type' => 'error'
                );
                return redirect()->route('review.list')->with($notification);
            }

            $articleId = $review->article->id;
            $article = Article::find($articleId);
            $article->author_can_edit = 0;
            $article->status = 'pending';
            $article->save();

            $review->save();

            // Activity LOG
            activity()
                ->performedOn($review)
                ->withProperties(['approveReviewRequestArticleId' => "$user->email accepet to be reviwer on article id # " . $review->article->id])
                ->log('approve review');
        }

        // Проверяваме ако имаме запис в дадения Ревювър само тогава пращаме имейли и записваме в логовете
        $reviewSecond = Review::find($review_id);
        $reviewerIdsSecond = [$reviewSecond->reviewer_id_1, $reviewSecond->reviewer_id_2, $reviewSecond->reviewer_id_3];
        if (in_array($user->id, $reviewerIdsSecond)) {
            $subject = "Reviwer accept";
            $body['reviwer'] = $user->name; // Reviwer
            $body['article_id'] = $review->article->id;

            // NOT send to author
            // $author_email = $review->article->user->email;
            // Mail::to($author_email)->send(new UserApproveReviewRequestEmail($subject, $body));

            // send to  admin
            Mail::to('superuser.blmprime@gmail.com')->send(new UserApproveReviewRequestEmail($subject, $body));

        }
        $notification = array(
            'message' => 'You approve review request successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('review.list')->with($notification);
    }

    public function rejectReviewRequest($user_id, $review_id)
    {
        $user = Auth::user();

        if ($user->id != $user_id) {
            abort(404);
        }
        $review = Review::find($review_id);

        $invitedReviewer = new InvitedReviewer();
        $invitedReviewer->article_id = $review->article->id;
        $invitedReviewer->user_id = $user->id;
        $invitedReviewer->rejected = true;
        $invitedReviewer->save();

        // Activity LOG
        activity()
            ->performedOn($review)
            ->withProperties(['rejectReviewRequest' => "$user->email rejected to be reviwer on article id #" . $review->article->id])
            ->log('reject review');

        $subject = "Reviwer rejected";
        $body['reviewer'] = $user->name;
        $body['article_id'] = $review->article->id;

        // send to author NO NEEDED!
        $author_email = $review->article->user->email;
        //   Mail::to($author_email)->send(new UserRejectReviewRequestEmail($subject, $body));
        // send to  admin
        Mail::to('superuser.blmprime@gmail.com')->send(new UserRejectReviewRequestEmail($subject, $body));

        $notification = array(
            'message' => 'You reject review request successfully.',
            'alert-type' => 'danger'
        );

        return redirect()->route('review.list')->with($notification);

    }

}
