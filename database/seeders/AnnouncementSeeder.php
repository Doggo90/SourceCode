<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('announcements')->insert([
            // Admin
            [
                'title' => 'Nulla tempora aut quo atque mollitia repellat ipsum.',
                'body' => 'Et aut aut quis facere dolores exercitationem. Sit dolorem velit culpa rerum. Inventore nemo quam qui corporis error. Dignissimos qui fugiat quia dolores.',
                'user_id' => '1',
                'created_at' => now(),
            ],
        ]);
    }
}
