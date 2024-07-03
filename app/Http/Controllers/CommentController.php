<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use Carbon\Carbon;

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

        $comment->formatted_created_at = Carbon::parse($comment->created_at)
            ->setTimezone('America/Chicago')
            ->format('m-d-Y h:i:s A');


        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }
}
