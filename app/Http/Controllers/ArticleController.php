<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index');
    }

    public function getArticles()
    {

        // Laravel Pagination: Laravel's paginate method automatically handles 
        // the page query parameter when it exists in the request. When Article::paginate(5) 
        // is called, Laravel internally checks for the page query parameter and fetches the 
        // appropriate records for that page.

        $articles = Article::paginate(5); 
        return response()->json($articles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
        ]);

        $article = Article::create($request->all());

        return response()->json($article);
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return response()->json($article);
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
        ]);
    
        $article->update($request->all());
    
        return response()->json(['success' => true]);
    }
    

    public function destroy(Article $article, Request $request)
    {
        $article->delete();
    
        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true]);
        } else {
            return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
        }
    }
    
    
}
