<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Organization;
use App\Models\User;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            AnnouncementSeeder::class,
            OrganizationSeeder::class,
            CategoriesSeeder::class,
        ]);
        \App\Models\User::factory(6)->create();

        // $this->call(PostsTableSeeder::class);
        // \App\Models\Post::factory(10)->create();
        Post::factory()->count(20)->create();
        Comment::factory()->count(20)->create();
        User::all()->each(function ($user) {
            $user->organizations()->attach(
                Organization::inRandomOrder()->take(rand(1, 3))->pluck('id')
            );
        });
    }
}
