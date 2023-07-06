<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_comment' => rand(30, 33),
            'id_comment' => rand(35,  40),
            'id_comment' => rand(69, 73),
            'id_comment' => rand(59 , 66),
            'id_owner' => rand(1, 11)
        ];
    }
}
