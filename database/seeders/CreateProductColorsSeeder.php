<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProductColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_colors')->insert([
            [
                'id' => 1,
                'name' => 'Black',
                'slug' => 'black',
                'created_at' => Carbon::create('2022', '11', '26', '13', '54', '23'),
                'updated_at' => Carbon::create('2022', '11', '26', '13', '54', '23'),
            ],
            [
                'id' => 2,
                'name' => 'White',
                'slug' => 'white',
                'created_at' => Carbon::create('2022', '11', '26', '14', '09', '01'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '09', '01'),
            ],
            [
                'id' => 3,
                'name' => 'Blue',
                'slug' => 'blue',
                'created_at' => Carbon::create('2022', '11', '26', '14', '09', '18'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '09', '18'),
            ],
            [
                'id' => 4,
                'name' => 'Navy Blue',
                'slug' => 'navy blue',
                'created_at' => Carbon::create('2022', '11', '26', '14', '09', '36'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '09', '36'),
            ],
            [
                'id' => 5,
                'name' => 'Grey',
                'slug' => 'grey',
                'created_at' => Carbon::create('2022', '11', '26', '14', '10', '18'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '10', '18'),
            ],
            [
                'id' => 6,
                'name' => 'Royal Blue',
                'slug' => 'royal blue',
                'created_at' => Carbon::create('2022', '11', '26', '14', '11', '03'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '11', '03'),
            ],
            [
                'id' => 7,
                'name' => 'Purple',
                'slug' => 'purple',
                'created_at' => Carbon::create('2022', '11', '26', '14', '11', '25'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '11', '25'),
            ],
            [
                'id' => 8,
                'name' => 'Pink',
                'slug' => 'pink',
                'created_at' => Carbon::create('2022', '11', '26', '14', '11', '36'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '11', '36'),
            ],
            [
                'id' => 4,
                'name' => 'Maroon',
                'slug' => 'maroon',
                'created_at' => Carbon::create('2022', '11', '26', '14', '09', '36'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '09', '36'),
            ],
            [
                'id' => 5,
                'name' => 'Brown',
                'slug' => 'brown',
                'created_at' => Carbon::create('2022', '11', '26', '14', '10', '18'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '10', '18'),
            ],
            [
                'id' => 6,
                'name' => 'Yellow',
                'slug' => 'yellow',
                'created_at' => Carbon::create('2022', '11', '26', '14', '11', '03'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '11', '03'),
            ],
            [
                'id' => 7,
                'name' => 'Beige',
                'slug' => 'beige',
                'created_at' => Carbon::create('2022', '11', '26', '14', '11', '25'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '11', '25'),
            ],
            [
                'id' => 8,
                'name' => 'Emerald',
                'slug' => 'emerald',
                'created_at' => Carbon::create('2022', '11', '26', '14', '11', '36'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '11', '36'),
            ],
        ]);
    }
}
