<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class Post_CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        DB::table('post_category')->insert([
            'post_id' => 1,
            'category_id' => 2,
        ]);
        DB::table('post_category')->insert([
            'post_id' => 2,
            'category_id' => 5,
        ]);
        */
        DB::table('category_post')->insert([
            'post_id' => 2,
            'category_id' => 3,
        
        ]);
        
    }
}
