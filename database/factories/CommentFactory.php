<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_owner' => rand(1, 11),
            'id_post' => rand(7, 30),
            'content' => "j ais trouver tres interessant de commenter cette publication"
        ];
    }
}
