<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_sizes')->insert([
            [
                'id' => 2,
                'name' => 'S',
                'slug' => 'S',
                'created_at' => Carbon::create('2022', '11', '26', '14', '32', '35'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '32', '35'),
            ],
            [
                'id' => 3,
                'name' => 'M',
                'slug' => 'M',
                'created_at' => Carbon::create('2022', '11', '26', '14', '32', '44'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '32', '44'),
            ],
            [
                'id' => 4,
                'name' => 'L',
                'slug' => 'L',
                'created_at' => Carbon::create('2022', '11', '26', '14', '33', '44'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '33', '44'),
            ],
            [
                'id' => 5,
                'name' => 'XL',
                'slug' => 'XL',
                'created_at' => Carbon::create('2022', '11', '26', '14', '34', '17'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '34', '17'),
            ],
            [
                'id' => 6,
                'name' => 'XXL',
                'slug' => 'XXL',
                'created_at' => Carbon::create('2022', '11', '26', '14', '34', '27'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '34', '27'),
            ],
            [
                'id' => 7,
                'name' => 'XXXL',
                'slug' => 'XXXL',
                'created_at' => Carbon::create('2022', '11', '26', '14', '34', '36'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '34', '36'),
            ],
            [
                'id' => 8,
                'name' => '2yr',
                'slug' => '2yr',
                'created_at' => Carbon::create('2022', '11', '26', '14', '34', '53'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '34', '53'),
            ],
            [
                'id' => 9,
                'name' => '4yr',
                'slug' => '4yr',
                'created_at' => Carbon::create('2022', '11', '26', '14', '35', '01'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '35', '01'),
            ],
            [
                'id' => 10,
                'name' => '6yr',
                'slug' => '6yr',
                'created_at' => Carbon::create('2022', '11', '26', '14', '35', '09'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '35', '09'),
            ],
            [
                'id' => 11,
                'name' => '8yr',
                'slug' => '8yr',
                'created_at' => Carbon::create('2022', '11', '26', '14', '35', '17'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '35', '17'),
            ],
        ]);
    }
}
