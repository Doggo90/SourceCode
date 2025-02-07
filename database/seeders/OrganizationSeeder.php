<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            // Admin
            [
                'name' => 'None at the moment',
                'nickname' => 'N/A',
            ],
            [
                'name' => 'Bright and Young Technology Enthusiasts Society',
                'nickname' => 'BYTES',
            ],
            [
                'name' => 'Radicals',
                'nickname' => 'RADICALS',
            ],
            [
                'name' => 'Central Student Government',
                'nickname' => 'CSG',
            ],
            [
                'name' => 'Future Administrators, Managers, and Executive Society',
                'nickname' => 'FAMES',
            ],
            [
                'name' => 'Alliance of Bachelor of Elementary Education Students',
                'nickname' => 'ABEES',
            ],
            [
                'name' => 'Circle of Potential Educators',
                'nickname' => 'CPE',
            ],
            [
                'name' => 'Faculty Members',
                'nickname' => 'FM',
            ],
        ]);
    }
}
