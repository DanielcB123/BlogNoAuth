<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

// Redirect the root URL to the articles index route
Route::get('/', function () {
    return redirect()->route('articles.index');
});

// Register resource routes for the ArticleController, except for 'edit', and 'index' actions
Route::resource('articles', ArticleController::class)->except(['edit', 'index']);

// Route for displaying the articles index page
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Route for fetching articles to populate table
Route::get('/articles-data', [ArticleController::class, 'getArticles'])->name('articles.data');

// Route for displaying the articles data in the edit modal for a specific article
Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

// Route for displaying a specific article in seperate page
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Route for deleting a specific article
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');