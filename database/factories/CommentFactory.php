<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'article_id' => Article::factory(),
            'body' => $this->faker->paragraph,
        ];
    }
}
