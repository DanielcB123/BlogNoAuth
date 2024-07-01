<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return redirect()->route('articles.index');
});

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::resource('articles', ArticleController::class)->except(['create', 'edit', 'index']);

Route::get('/articles-data', [ArticleController::class, 'getArticles'])->name('articles.data');

Route::get('/articles/create', function () {
    return view('articles.create');
})->name('articles.create');

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
