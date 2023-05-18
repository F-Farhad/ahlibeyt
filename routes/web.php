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
Route::namespace('App\Http\Controllers\Widget')->group(function(){
    Route::get('/about-us', PageAboutUsController::class)->name('about-us');
});

Route::namespace('App\Http\Controllers\Post')->group(function(){
    Route::get('/', IndexController::class)->name('post.index');
    Route::get('/{post:slug}', ShowController::class)->name('post.show');
});

Route::namespace('App\Http\Controllers\Category')->group(function(){
    Route::get('/category/{category:slug}', IndexController::class)->name('category.index');
    Route::get('/category/{category:slug}/{post:slug}', ShowController::class)->name('category.show.post');
});

Route::namespace('App\Http\Controllers\Tag')->group(function(){
    Route::get('/tag/{tag:slug}', IndexController::class)->name('tag.index');
    Route::get('/tag/{tag:slug}/{post:slug}', ShowController::class)->name('tag.show.post');
});

