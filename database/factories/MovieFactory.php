<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => ucwords(fake()->words(2, true)),
            'description' => fake()->text(),
            'image_url' => 'https://flxt.tmsimg.com/assets/p22804_p_v8_av.jpg',
            'genre' => fake()->randomElement(['comedy', 'fantasy', 'sci fi', 'horror', 'thriller']),
            'num_visits' => fake()->numberBetween(1, 100)
        ];
    }
}
