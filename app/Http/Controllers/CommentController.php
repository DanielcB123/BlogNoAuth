<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $comment = $article->comments()->create([
            'body' => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }
}
