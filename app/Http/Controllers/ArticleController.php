<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display the articles index view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('articles.index');
    }

    /**
     * Fetch a paginated list of articles and return as JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArticles()
    {
        // Laravel Pagination: Laravel's paginate method automatically handles 
        // the page query parameter when it exists in the request. When Article::paginate(5) 
        // is called, Laravel internally checks for the page query parameter and fetches the 
        // appropriate records for that page.
        $articles = Article::paginate(5); 
        return response()->json($articles);
    }

    /**
     * Store a new article in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
        ]);

        // Create a new article using the validated data
        $article = Article::create($request->all());

        // Return the created article as a JSON response
        return response()->json($article);
    }

    /**
     * Display the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function show(Article $article)
    {
        // Pass the article to the view for displaying
        return view('articles.show', compact('article'));
    }

    /**
     * Return the specified article data as JSON for editing.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Article $article)
    {
        // Return the article data as a JSON response
        return response()->json($article);
    }

    /**
     * Update the specified article in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Article $article)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
        ]);

        // Update the article using the validated data
        $article->update($request->all());

        // Return a success message as a JSON response
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified article from the database.
     *
     * @param  \App\Models\Article  $article
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article, Request $request)
    {
        // Delete the article from the database
        $article->delete();

        // Check if the request was made via AJAX
        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Return a success message as a JSON response for AJAX requests
            return response()->json(['success' => true]);
        } else {
            // Redirect to the articles index with a success message for non-AJAX requests
            return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
        }
    }
}
