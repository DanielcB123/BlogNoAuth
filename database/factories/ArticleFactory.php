<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'excerpt' => $this->faker->paragraph,
            'content' => $this->faker->imageUrl(640, 480),
        ];
    }

    public function withComments(int $count = 5)
    {
        return $this->has(
            Comment::factory()->count($count),
            'comments'
        );
    }
}
