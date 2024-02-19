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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // !!!!! Logout !!!!!
    Route::get('/logout', [AdminPanelAuthController::class, 'adminPanelLogout'])->name('admin.logout');
});

require __DIR__.'/auth.php';


// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/user/list', [AdminController::class, 'userList'])->name('admin.users-list');
    Route::get('/admin/user/create', [AdminController::class, 'userCreate'])->name('admin.users-create');
    Route::post('/admin/user/store', [AdminController::class, 'userStore'])->name('admin.users-store');
    Route::delete('/admin/user/delete/{user}', [AdminController::class, 'userDestroy'])->name('admin.users-destroy');

});


Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
Route::get('/gdpr', [GdprController::class, 'index'])->name('gdpr');
Route::get('/editorial-publishing-practice', [EditorialPublishingPracticeController::class, 'index'])->name('editorial_publishing_practice');
Route::view('/contact-us', 'frontend.contact_us')->name('contact_us');

// article create
Route::get('/article_/create', [ArticleController::class, 'articleCreate'])->name('article.create');
Route::post('/article_/store', [ArticleController::class, 'articleStore'])->name('article.store');
Route::get('/articles_',       [ArticleController::class, 'articleList'])->name('article.list');
Route::get('/articles_/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

Route::get('/articles_/{id}/article-edit', [ArticleController::class, 'articleEdit'])->name('articles.articleEdit');
Route::put('/articles_/article-edit/{id}', [ArticleController::class, 'articleUpdate'])->name('articles.articleUpdate');

Route::put('/articles_/{id}', [ArticleController::class, 'update'])->name('articles.update');
Route::post('/articles_/{id}', [ArticleController::class, 'sendEmailForReviewRequest'])->name('articles.sendEmailForReviewRequest');

// Author
Route::get('/author/dashboard', [AuthorController::class, 'AuthorDashboard'])->middleware('auth', 'role:author')->name('author.dashboard');
// Co Author approve Thankyou Page
Route::get('/co-author-approve/{article_id}/{authrom_email}', [ArticleController::class, 'coAuthorApprove'])->name('articles.coAuthorApprove');




// Reviewer 
Route::get('/reviewer/dashboard',   [ReviewerController::class, 'ReviewerDashboard'])->name('reviewer.dashboard');
Route::get('/review/list',          [ReviewerController::class, 'reviewList'])->name('review.list');
Route::get('/review/{article}',     [ReviewerController::class, 'review'])->name('review');
Route::post('/review/store',        [ReviewerController::class, 'store'])->name('review.store');
Route::get('/review-download-files/{article}',     [ReviewerController::class, 'downloadArticleFiles'])->name('review.downolad_files');


Route::get('/reviews/request/{user_id}/{review_id}', [ReviewerController::class, 'approveReviewRequest'])->middleware(['auth', 'role:reviewer'])->name('reviews.approveReviewRequest');
Route::get('/reviews/request/reject/{user_id}/{review_id}', [ReviewerController::class, 'rejectReviewRequest'])->middleware(['auth', 'role:reviewer'])->name('reviews.rejectReviewRequest');

Route::put('/reviews/{id}', [ReviewerController::class, 'update'])->name('reviews.update');

// CANVAS TEMPLATE

Route::get('/gdpr', function () { return view('canva.gdpr'); })->name('gdpr');
Route::get('/journal-info', function () { return view('canva.journal_info'); })->name('journal_info');
Route::get('/editorial-peer-review-process', function () { return view('canva.editorial_and_peer_review_proces'); })->name('editorial_and_peer_review_proces');


Route::get('/articles',   [CanvaArticlesController::class, 'listArticles'])->name('canva.listArticles');
Route::get('/article/{article}',   [CanvaArticlesController::class, 'showArticle'])->name('canva.showArticle');
Route::get('/articles/search', [CanvaArticlesController::class, 'search'])->name('canva.article.search');
Route::get('/articles/{specialty}',   [CanvaArticlesController::class, 'listArticlesBySpecialty'])->name('canva.listArticlesBySpecialty');


// Login with ORCID
Route::get('/login/orcid', 'Auth\LoginController@redirectToOrcid');
Route::get('/login/orcid/callback', 'Auth\LoginController@handleOrcidCallback');
