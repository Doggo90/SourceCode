<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  // Associate with a random user
            'post_id' => Post::factory(),  // Associate with a random post
            'comment_body' => $this->faker->sentence(),  // Random comment content
            'is_helpful' => $this->faker->boolean(15),  // 15% chance of being marked helpful
            // 'upvotes' => $this->faker->numberBetween(0, 1000),  // Random upvote number
        ];
    }
}
