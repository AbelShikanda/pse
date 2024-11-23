<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            [
                'id' => 1,
                'name' => 'Inspiring',
                'slug' => 'inspiring',
                'created_at' => Carbon::create('2022', '11', '26', '14', '52', '39'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '52', '39'),
            ],
            [
                'id' => 2,
                'name' => 'Music',
                'slug' => 'music',
                'created_at' => Carbon::create('2022', '11', '26', '14', '52', '51'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '52', '51'),
            ],
            [
                'id' => 3,
                'name' => 'Career',
                'slug' => 'career',
                'created_at' => Carbon::create('2022', '11', '26', '14', '53', '07'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '53', '07'),
            ],
            [
                'id' => 4,
                'name' => 'Birthdays',
                'slug' => 'birthdays',
                'created_at' => Carbon::create('2022', '11', '26', '14', '53', '17'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '53', '17'),
            ],
            [
                'id' => 5,
                'name' => 'Family',
                'slug' => 'family',
                'created_at' => Carbon::create('2022', '11', '26', '14', '53', '31'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '53', '31'),
            ],
            [
                'id' => 6,
                'name' => 'Couple',
                'slug' => 'couple',
                'created_at' => Carbon::create('2022', '11', '26', '14', '53', '51'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '53', '51'),
            ],
            [
                'id' => 7,
                'name' => 'Sports',
                'slug' => 'sports',
                'created_at' => Carbon::create('2022', '11', '26', '14', '54', '12'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '54', '12'),
            ],
            [
                'id' => 8,
                'name' => 'Children',
                'slug' => 'children',
                'created_at' => Carbon::create('2022', '11', '26', '14', '55', '24'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '55', '24'),
            ],
            [
                'id' => 9,
                'name' => 'Trending',
                'slug' => 'trending',
                'created_at' => Carbon::create('2022', '11', '26', '14', '55', '47'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '55', '47'),
            ],
        ]);
    }
}
