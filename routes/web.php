<?php

use App\Http\Controllers\PostController;
use App\Models\Post;
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

Route::get('/', function () {
    return view('welcome', ['posts'=>Post::get()]);
})->name('home');


Route::get('create', [PostController::class, 'create'])->name('create');
Route::post('store', [PostController::class, 'store'])->name('store');
Route::get('edit/{post}', [PostController::class, 'edit'])->name('edit');
Route::post('update/{post}', [PostController::class, 'update'])->name('update');
Route::get('destroy/{id}', [PostController::class, 'destroy'])->name('destroy');
Route::get('show/{id}', [PostController::class, 'index'])->name('show');
Route::get('/media/{id}', [PostController::class, 'mediaDelete'])->name('media.delete');


Route::post('upload', [PostController::class, 'uploadImg'])->name('temp.upload');