<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'category' => '雑談',
        ]);
        DB::table('categories')->insert([
            'category' => '胸',
        ]);
        DB::table('categories')->insert([
            'category' => '背中',
        ]);
        DB::table('categories')->insert([
            'category' => '肩',
        ]);
        DB::table('categories')->insert([
            'category' => '腕',
        ]);
        DB::table('categories')->insert([
            'category' => '下半身',
        ]);
    }
}
