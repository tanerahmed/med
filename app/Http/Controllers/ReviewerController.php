<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Article;
use App\Models\User;
use App\Models\InvitedReviewer;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewArticleEmail;
use App\Mail\UserApproveReviewRequestEmail;
use App\Mail\UserRejectReviewRequestEmail;
use App\Mail\FullAcceptArticleEmail;
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

            // TODO Тази директория има липсващи файлове не е АКТУАЛНА 
            // TODO Откоментирай когато занулиш БД

            // foreach ($article->titlePage as $value) {
            //     $filePath = storage_path('app/public/' . $value->file_path);
            //     $filePath = str_replace('\\', '/', $filePath);
            //     $zip->addFile($filePath, basename($filePath));
            // }

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

        $body['articleId'] = $articleId;
        $body['reviwer_name'] = $user->name;
        $body['question1'] = $request->input('question1');
        $body['question2'] = $request->input('question2');
        $body['question3'] = $request->input('question3');
        $body['zipFile'] = $zipFile;
        $body['titlePages'] = $request->input('title_pages');
        $body['manuscript'] = $request->input('manuscript');
        $body['figures'] = $request->input('figures');
        $body['tables'] = $request->input('tables');
        $body['supplementary'] = $request->input('supplementary');
        $body['coverLetter'] = $request->input('cover_letter');
        $body['keywords'] = $request->input('keywords');
        $body['title'] = $request->input('title');
        $body['abstract'] = $request->input('abstract');
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

        $subject = "Review Article #" . $articleId;
        if (!empty($filePath)) {
            Mail::to($article->user->email)->send(new ReviewArticleEmail($subject, $body, $filePath));
        } else {
            Mail::to($article->user->email)->send(new ReviewArticleEmail($subject, $body));
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


            // Проверка на резултата и връщане на пренасочване или съобщение за грешка
            if ($response->getStatusCode() === 200) {
                // Значи XML файлат е създаден успешно
            }
        }



        // Activity LOG
        activity()
            ->performedOn($review)
            ->withProperties(['rating' => $rating, 'article_id' => $article->id])
            ->log('raited');

        $notification = array(
            'message' => 'You reviewd article successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('review.list')->with($notification);
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
            }
            $review->save();

            // Activity LOG
            activity()
                ->performedOn($review)
                ->withProperties(['approveReviewRequestArticleId' => $review->article->id])
                ->log('approve review'); // action create, edit, delete
        }



        $subject = "Reviwer accept";
        $body['reviwer'] = $user->name; // Reviwer
        $body['article_id'] = $review->article->id;

        // send to author
        $author_email = $review->article->user->email;
        Mail::to($author_email)->send(new UserApproveReviewRequestEmail($subject, $body));
        // send to  admin
        Mail::to('admin@gmail.com')->send(new UserApproveReviewRequestEmail($subject, $body));

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
            ->withProperties(['rejectReviewRequest' => $review->article->id])
            ->log('reject review'); // action create, edit, delete

        $subject = "Reviwer rejected";
        $body['reviewer'] = $user->name;
        $body['article_id'] = $review->article->id;

        // send to author NO NEEDED!
        $author_email = $review->article->user->email;
     //   Mail::to($author_email)->send(new UserRejectReviewRequestEmail($subject, $body));
        // send to  admin
        Mail::to('admin@gmail.com')->send(new UserRejectReviewRequestEmail($subject, $body));

        $notification = array(
            'message' => 'You reject review request successfully.',
            'alert-type' => 'danger'
        );

        return redirect()->route('review.list')->with($notification);

    }

}
