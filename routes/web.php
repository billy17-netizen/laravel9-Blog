<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/create-user-image', function () {
//   $image = \App\Models\Image::find(1);
//   return $image->imageable;
//
//});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/posts/{post:slug}', [PostsController::class, 'show'])->name('posts.show');
Route::post('/posts/{post:slug}', [PostsController::class, 'addComment'])->name('posts.add-comment');


Route::get('/about',AboutController::class)->name('about');

Route::get('/contact',[ContactController::class , 'create'])->name('contact.create');
Route::post('/contact',[ContactController::class , 'store'])->name('contact.store');

require __DIR__.'/auth.php';
