<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_owner' => rand(1, 10),
            'content' => "Ceci est le contenue d'un de mes post. bref oublie tout ca"
        ];
    }
}
