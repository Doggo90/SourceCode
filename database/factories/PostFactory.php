<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'logo' => $this->faker->imageUrl(640, 480, 'business', true),  // Example image
            'body' => $this->faker->sentence(),
            'tags' => implode(',', $this->faker->words(3)),  // Tags separated by commas
            'is_archived' => $this->faker->boolean(10),  // 10% chance of being archived
            'is_approved' => $this->faker->boolean(50),
            'upvote' => $this->faker->numberBetween(0, 1000),  // Random upvote number
            'user_id' => User::factory(),  // Associate with a random user
        ];
    }
}
