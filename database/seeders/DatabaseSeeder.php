<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Article::factory()
            ->count(10) // Number of articles to create
            ->withComments(3) // Number of comments per article
            ->create();
    }
}
