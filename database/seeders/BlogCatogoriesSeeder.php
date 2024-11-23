<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blog_categories')->insert([
            [
                'id' => 1,
                'name' => 'Inspiring',
                'slug' => 'inspiring',
                'created_at' => Carbon::create('2023', '01', '27', '15', '53', '02'),
                'updated_at' => Carbon::create('2023', '01', '27', '15', '53', '02'),
            ],
            [
                'id' => 2,
                'name' => 'Fashion',
                'slug' => 'fashion',
                'created_at' => Carbon::create('2023', '01', '27', '15', '56', '58'),
                'updated_at' => Carbon::create('2023', '01', '27', '15', '56', '58'),
            ],
            [
                'id' => 3,
                'name' => 'Parenting',
                'slug' => 'parenting',
                'created_at' => Carbon::create('2023', '01', '27', '15', '58', '22'),
                'updated_at' => Carbon::create('2023', '01', '27', '15', '58', '22'),
            ],
            [
                'id' => 4,
                'name' => 'Sports',
                'slug' => 'sports',
                'created_at' => Carbon::create('2023', '01', '27', '15', '58', '59'),
                'updated_at' => Carbon::create('2023', '01', '27', '15', '58', '59'),
            ],
        ]);
    }
}
