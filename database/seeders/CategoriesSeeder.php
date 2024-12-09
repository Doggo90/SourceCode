<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([

            [
            'name' => 'Computer Science',
            ],
            [
            'name' => 'Education',
            ],
            [
            'name' => 'Student FAQ',
            ],

            [
            'name' => 'Elementary Education',
            ],
            [
            'name' => 'Mathematics',
            ],
            [
            'name' => 'Information Technology',
            ]

        ]);
    }
}
