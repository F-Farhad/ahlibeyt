<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::namespace('App\Http\Controllers\Main')->group(function(){
    Route::get('/', MainController::class)->name('main');
});

Route::namespace('App\Http\Controllers\Widget')->group(function(){
    Route::get('/about-us', PageAboutUsController::class)->name('about-us');
});

Route::namespace('App\Http\Controllers\Post')->prefix('post')->group(function(){
    Route::get('/', IndexController::class)->name('post.index');
    Route::get('/{post:slug}', ShowController::class)->name('post.show');
});

Route::namespace('App\Http\Controllers\Category')->prefix('category')->group(function(){
    Route::get('{category:slug}', ShowAllPostsCategoryController::class)->name('category.showAllPosts');
    Route::get('{category:slug}/{post:slug}', ShowPostCategoryController::class)->name('category.showPost');
});

Route::namespace('App\Http\Controllers\Tag')->prefix('tag')->group(function(){
    Route::get('{tag:slug}', ShowAllPostsTagController::class)->name('tag.showAllPosts');
    Route::get('{tag:slug}/{post:slug}', ShowPostTagController::class)->name('tag.showPost');
});



