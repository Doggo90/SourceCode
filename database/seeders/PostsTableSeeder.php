<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            // Admin
            [
                'title' => 'Nulla tempora aut quo atque mollitia repellat ipsum.',
                'tags' => 'laravel, api, backend',
                'body' => 'Et aut aut quis facere dolores exercitationem. Sit dolorem velit culpa rerum. Inventore nemo quam qui corporis error. Dignissimos qui fugiat quia dolores.',
                'user_id' => '1'
            ],
        ]);
    }
}
