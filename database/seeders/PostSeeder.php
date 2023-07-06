<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Post::factory(12)->create();
    }
}
