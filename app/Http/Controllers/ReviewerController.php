<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Article;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewArticleEmail;
use App\Mail\UserApproveReviewRequestEmail;
use ZipArchive;

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
        // TODO ЕТО ТАКА СЕ СЛАВА СНИМКИ ИЛИ ФАЙЛОВЕ В VIEW BLADE
        // TODO <img src="{{  asset("storage/".  $article->figures[0]->file_path) }}" alt="" />

        // Създаване на нов ZIP архив
        $zip = new ZipArchive;
        $zipFileName = "article_id = " . $article->id . ".zip";

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {

            // TODO Тази директория има липсващи файлове не е АКТУАЛНА
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

        
        $subject = "Review Article #" . $articleId;        
        if (!empty($filePath)) {
            Mail::to($user->email)->send(new ReviewArticleEmail($subject, $body, $filePath));
        } else {
            Mail::to($user->email)->send(new ReviewArticleEmail($subject, $body));
        }

        // TODO log the action


        $review = Review::where('article_id', $articleId)->first();

        if ($review->reviewer_id_1 === $user->id) {
            $review->rating_1 = $request->input('rating');
        } elseif ($review->reviewer_id_2 === $user->id) {
            $review->rating_2 = $request->input('rating');
        } elseif ($review->reviewer_id_3 === $user->id) {
            $review->rating_3 = $request->input('rating');
        }
        $review->save();

        $notification = array(
            'message' => 'You reviewd article successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('review.list')->with($notification);
    }


    public function editReviewRequest($user_id, $review_id)
    {

        $user = Auth::user();

        if ($user->id != $user_id) {
            abort(404);
        }

        $review = Review::find($review_id);

        $reviewerIds = [$review->reviewer_id_1, $review->reviewer_id_2, $review->reviewer_id_3];
        
        // Ако ревювъра вече е един от тях, не правим нищо 
        // т.е. Ако няма как да имаме един и същ човек да е два пъти ревъвър на един артикъл
        if (!in_array($user->id, $reviewerIds)) {
            if ($review->reviewer_id_1 === null) {
                $review->reviewer_id_1 = $user->id;
            } elseif ($review->reviewer_id_2 === null) {
                $review->reviewer_id_2 = $user->id;
            } elseif ($review->reviewer_id_3 === null) {
                $review->reviewer_id_3 = $user->id;
            }
            $review->save();
        }

 dd($review->article->id);
        $subject = "Reviwer accept";
        $body['user'] = $user->name;
        $body['article_id'] = $review->article->id; 

        Mail::to($user->email)->send(new UserApproveReviewRequestEmail($subject, $body));

        $notification = array(
            'message' => 'You approve review request successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('review.list')->with($notification);
    }
    
}
