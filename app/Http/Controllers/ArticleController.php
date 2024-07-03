<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
    public function getArticles(Request $request)
    {
        // Laravel's paginate method automatically handles 
        // the page query parameter when it exists in the request. When Article::paginate(5) 
        // is called, Laravel internally checks for the page query parameter and fetches the 
        // appropriate records for that page.
        $sort = $request->get('sort', 'desc'); // Default to descending order
        $articles = Article::orderBy('id', $sort)->paginate(5); 
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
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Validate the image
        ]);

        // Handle the file upload
        if ($request->hasFile('content')) {
            $path = $request->file('content')->store('public/articles'); // Store the image

            // Create the article
            $article = Article::create([
                'title' => $request->title,
                'excerpt' => $request->excerpt,
                'content' => 'http://127.0.0.1:8000' . Storage::url($path), // Store the URL with base URL
            ]);

            return response()->json($article, 201);
        }

        return response()->json(['error' => 'File not uploaded'], 400);
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

        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
    
        if ($validator->fails()) {
            \Log::error('Validation Errors: ', $validator->errors()->toArray());
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
    


        // Handle the file upload if a new image is provided
        if ($request->hasFile('content')) {
            // Store the new image
            $path = $request->file('content')->store('public/articles');
            $article->content = 'http://127.0.0.1:8000' . Storage::url($path); // Update with the new URL
        }
    

        // Update other fields
        $article->title = $request->title;
        $article->excerpt = $request->excerpt;
        $article->save();
    

        return response()->json(['success' => true, 'article' => $article], 200);
    }
    






    
    /**
     * Remove the specified article from the database
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