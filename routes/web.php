<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SinglePostController;
use App\Http\Controllers\CommentController;


// Define a route for the homepage, displaying a 'welcome' view
Route::get('/', function () {
    return view('welcome');
});

//Define a route to a form to create a new post
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

// Route to store the newly created post (form submission)
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');

// Define a route for viewing posts with 'auth' middleware for authentication
Route::get('/posts', [PostController::class, 'index'])->middleware('auth')->name('posts.index');

//Define a route for viewing single post
Route::get('/posts/{postId}', [SinglePostController::class, 'show'])->name('posts.show');

//Define a route to handle submission of a new comment
Route::post('/posts/{postId}/comments', [CommentController::class, 'store']) ->middleware('auth') ->name('comments.store');

// Route for user registration form
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

// Define a dashboard route that requires both 'auth' and 'verified' middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group routes that require authentication
Route::middleware('auth')->group(function () {
    // Route for editing user profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // Route for updating user profile
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Route for deleting user profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include additional authentication-related routes from 'auth.php' file
require __DIR__.'/auth.php';
