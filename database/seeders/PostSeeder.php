<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*
        DB::table('posts')->insert([
            'title' => '最近全然大胸筋が肥大化しない件について',
            'body' => '週5で筋トレしてんのに全然肥大化しません助けて下さい',
            'image_file_name' => 'WIN_20200504_15_51_45_Pro.jpg',
            'user_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        */
        DB::table('posts')->insert([
            'title' => '最近全然上腕二頭筋が肥大化しない件について',
            'body' => '週5で筋トレしてんのに全然肥大化しません助けて下さい',
            'image_file_name' => 'WIN_20200504_15_51_45_Pro.jpg',
            'user_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
