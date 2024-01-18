<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPanelAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

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


// !!!!! TODO REMOVE !!!!!
Route::get('/', function () {
    return view('welcome');
});

// !!!!! TODO REMOVE !!!!!
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
// Author
Route::middleware(['auth', 'role:author'])->group(function () {
    Route::get('/author/dashboard', [AuthorController::class, 'AuthorDashboard'])->name('author.dashboard');


});
// Editor
Route::middleware(['auth', 'role:editor'])->group(function () {

});

// Reviewer
Route::middleware(['auth', 'role:reviewer'])->group(function () {
    Route::get('/reviewer/dashboard', [ReviewerController::class, 'ReviewerDashboard'])->name('reviewer.dashboard');
});

// User - just user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard');
});


// Logs
Route::get('/logs', [LogController::class, 'index'])->name('logs.index');




// Login with ORCID
Route::get('/login/orcid', 'Auth\LoginController@redirectToOrcid');
Route::get('/login/orcid/callback', 'Auth\LoginController@handleOrcidCallback');
