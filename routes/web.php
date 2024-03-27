<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\CanvaHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPanelAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\GdprController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EditorialPublishingPracticeController;
use App\Http\Controllers\XMLController;
use App\Http\Controllers\CanvaArticlesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [CanvaHomeController::class, 'index'])->name('canvaHome.index');


Route::get('/dashboard', [Dashboard::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/user/list', [AdminController::class, 'userList'])->name('admin.users-list');
    Route::get('/admin/user/create', [AdminController::class, 'userCreate'])->name('admin.users-create');
    Route::post('/admin/user/store', [AdminController::class, 'userStore'])->name('admin.users-store');
    Route::delete('/admin/user/delete/{user}', [AdminController::class, 'userDestroy'])->name('admin.users-destroy');
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');

});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // !!!!! Logout !!!!!
    Route::get('/logout', [AdminPanelAuthController::class, 'adminPanelLogout'])->name('admin.logout');

    // article
    Route::get('/article_/create', [ArticleController::class, 'articleCreate'])->name('article.create');
    Route::post('/article_/store', [ArticleController::class, 'articleStore'])->name('article.store');
    Route::get('/articles_',       [ArticleController::class, 'articleList'])->name('article.list');
    Route::get('/articles_/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

    Route::get('/articles_/{id}/article-edit', [ArticleController::class, 'articleEdit'])->name('articles.articleEdit');
    Route::put('/articles_/article-edit/{id}', [ArticleController::class, 'articleUpdate'])->name('articles.articleUpdate');

    Route::put('/articles_/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::post('/articles_/{id}', [ArticleController::class, 'sendEmailForReviewRequest'])->name('articles.sendEmailForReviewRequest');


    Route::get('/reviwer-download-pdf-files/{article}',     [ArticleController::class, 'summaryPdfFile'])->name('review.summary_pdf');

    // Author
    Route::get('/author/dashboard', [AuthorController::class, 'AuthorDashboard'])->middleware('auth', 'role:author')->name('author.dashboard');


    // Reviewer 
    Route::get('/reviewer/dashboard',   [ReviewerController::class, 'ReviewerDashboard'])->name('reviewer.dashboard');
    Route::get('/review/list',          [ReviewerController::class, 'reviewList'])->name('review.list');
    Route::get('/review/{article}',     [ReviewerController::class, 'review'])->name('review');
    Route::post('/review/store',        [ReviewerController::class, 'store'])->name('review.store');
    Route::get('/review-download-files/{article}',     [ReviewerController::class, 'downloadArticleFiles'])->name('review.downolad_files');
    Route::get('/reviews/request/{user_id}/{review_id}', [ReviewerController::class, 'approveReviewRequest'])->middleware(['auth', 'role:reviewer'])->name('reviews.approveReviewRequest');
    Route::get('/reviews/request/reject/{user_id}/{review_id}', [ReviewerController::class, 'rejectReviewRequest'])->middleware(['auth', 'role:reviewer'])->name('reviews.rejectReviewRequest');
    Route::put('/reviews/{id}', [ReviewerController::class, 'update'])->name('reviews.update');
    // user role update
    Route::post('admin/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('admin.assign-role');


});

Route::get('/article-download-pdf-files/{article}',     [ArticleController::class, 'downloadArticlePDFFiles'])->name('admin.downolad_summary_pdf');

// NOT NEEDED Co Author approve Thankyou Page 
// Route::get('/co-author-approve/{article_id}/{authrom_email}', [ArticleController::class, 'coAuthorApprove'])->name('articles.coAuthorApprove');

// CANVAS TEMPLATE
Route::get('/current-issue',     [CanvaHomeController::class, 'getCurrentIssue'])->name('current_issue');
Route::get('/journal-info',     [CanvaHomeController::class, 'getJornalInfo'])->name('journal_info');
Route::get('/gdpr', [CanvaHomeController::class, 'gdpr'] )->name('gdpr');

Route::get('/editorial-peer-review-process', [CanvaHomeController::class, 'editorial_and_peer_review_proces'])->name('editorial_and_peer_review_proces');

Route::get('/editorial-publishing-practice', [CanvaHomeController::class, 'editorial_publishing_practice'])->name('editorial_publishing_practice');
Route::get('/editorial-board', [CanvaHomeController::class, 'editorialBoard'])->name('editorial_board');
Route::get('/ethical-publishing-practice', [CanvaHomeController::class, 'ethicalPublishingPractice'])->name('ethical_publishing_practice');
Route::get('/contact-us', [CanvaHomeController::class, 'contactUs'])->name('contact_us');
Route::get('/submission-guidance', [CanvaHomeController::class, 'submissionGuidance'])->name('submission_guidance');
Route::get('/tehnical-publishing-practice', [CanvaHomeController::class, 'tehnicalPublishingPractice'])->name('tehnical_publishing_practice');


// Front End 
Route::get('/articles',   [CanvaArticlesController::class, 'listArticles'])->name('canva.listArticles');
Route::get('/article/{article}',   [CanvaArticlesController::class, 'showArticle'])->name('canva.showArticle');
Route::get('/articles/search', [CanvaArticlesController::class, 'search'])->name('canva.article.search');
Route::get('/articles/{specialty}',   [CanvaArticlesController::class, 'listArticlesBySpecialty'])->name('canva.listArticlesBySpecialty');
Route::get('/issue/{id}',   [CanvaArticlesController::class, 'listArticlesByIssue'])->name('canva.listArticlesByIssue');

// Route::get('/login/orcid', 'Auth\LoginController@redirectToOrcid');
// Route::get('/login/orcid/callback', 'Auth\LoginController@handleOrcidCallback');
