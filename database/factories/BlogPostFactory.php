<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => Str::slug(fake()->sentence()),
            'user_id' => 1,
            'category_id' => 1,
            'content' => fake()->paragraph(5),
            'excerpt' => fake()->sentence,
            'thumbnail' => null,
            'status' => 'publish',
            'published_at' => Carbon::now()
        ];
    }
}
