<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'アキラ',
            'email' => 'furuse_yuta@icloud.com',
            'password' => 'password',
            'introduce' => '筋トレ歴2か月です。',
            'image_file_name' => 'WIN_20200504_15_51_45_Pro.jpg',
            'reported_number' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
