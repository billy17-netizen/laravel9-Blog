<?php

use App\Http\Controllers\AdminControllers\AdminSettingsController;
use App\Http\Controllers\AdminControllers\AdminCategoriesController;
use App\Http\Controllers\AdminControllers\AdminContactsController;
use App\Http\Controllers\AdminControllers\AdminPostsController;
use App\Http\Controllers\AdminControllers\AdminRolesController;
use App\Http\Controllers\AdminControllers\AdminUsersController;
use App\Http\Controllers\AdminControllers\AdminTagsController;
use App\Http\Controllers\AdminControllers\AdminCommentsController;
use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\AdminControllers\TinyMCEController;


use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TagController;
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


//Route Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/posts/{post:slug}', [PostsController::class, 'show'])->name('posts.show');
Route::post('/posts/{post:slug}', [PostsController::class, 'addComment'])->name('posts.add-comment');

Route::get('/about', AboutController::class)->name('about');

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/tags/{tag:name}', [TagController::class, 'show'])->name('tag.show');

require __DIR__ . '/auth.php';

//Route Admin
Route::prefix('admin')->name('admin.')->middleware(['auth','CheckPermissions'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('upload_tinymce_image', [TinyMCEController::class, 'uploadTinymceImage'])->name('upload_tinymce_image');

    Route::resource('posts', AdminPostsController::class);
    Route::resource('categories', AdminCategoriesController::class);

    Route::resource('tags', AdminTagsController::class)->only(['index', 'show','destroy']);
    Route::resource('comments', AdminCommentsController::class)->except('show');

    Route::resource('roles', AdminRolesController::class)->except('show');

    Route::resource('users', AdminUsersController::class);

    Route::get('contacts', [AdminContactsController::class, 'index'])->name('contacts');
    Route::delete('contacts/{contact}', [AdminContactsController::class, 'destroy'])->name('contacts.destroy');

    Route::get('settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [AdminSettingsController::class, 'update'])->name('settings.update');


});
