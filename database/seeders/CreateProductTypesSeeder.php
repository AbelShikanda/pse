<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProductTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            [
                'id' => 1,
                'name' => 'short sleeve round-necked t-shirts',
                'slug' => 'short',
                'created_at' => Carbon::create('2022', '11', '26', '14', '41', '19'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '41', '19'),
            ],
            [
                'id' => 2,
                'name' => 'short sleeve v-necked t-shirts',
                'slug' => 'short',
                'created_at' => Carbon::create('2022', '11', '26', '14', '41', '39'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '41', '39'),
            ],
            [
                'id' => 3,
                'name' => 'Pocketed Sweatshirt',
                'slug' => 'Pocketed',
                'created_at' => Carbon::create('2022', '11', '26', '14', '41', '55'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '41', '55'),
            ],
            [
                'id' => 4,
                'name' => 'Sweatshirt',
                'slug' => 'Sweatshirt',
                'created_at' => Carbon::create('2022', '11', '26', '14', '42', '04'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '42', '04'),
            ],
            [
                'id' => 5,
                'name' => 'Pocketed Sweatpants',
                'slug' => 'Pocketed',
                'created_at' => Carbon::create('2022', '11', '26', '14', '42', '20'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '42', '20'),
            ],
            [
                'id' => 6,
                'name' => 'Sweatpants',
                'slug' => 'Sweatpants',
                'created_at' => Carbon::create('2022', '11', '26', '14', '42', '35'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '42', '35'),
            ],
            [
                'id' => 7,
                'name' => 'Pocketed Hoodie',
                'slug' => 'Pocketed',
                'created_at' => Carbon::create('2022', '11', '26', '14', '43', '16'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '43', '16'),
            ],
            [
                'id' => 8,
                'name' => 'Hoodie',
                'slug' => 'Hoodie',
                'created_at' => Carbon::create('2022', '11', '26', '14', '43', '30'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '43', '30'),
            ],
            [
                'id' => 9,
                'name' => 'Zipped Hoodie',
                'slug' => 'Zipped',
                'created_at' => Carbon::create('2022', '11', '26', '14', '43', '44'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '43', '44'),
            ],
            [
                'id' => 10,
                'name' => 'Caps',
                'slug' => 'Caps',
                'created_at' => Carbon::create('2024', '05', '13', '12', '29', '50'),
                'updated_at' => Carbon::create('2024', '05', '13', '12', '29', '50'),
            ],
            [
                'id' => 11,
                'name' => 'Polo Tees',
                'slug' => 'Polo',
                'created_at' => Carbon::create('2024', '05', '13', '12', '30', '10'),
                'updated_at' => Carbon::create('2024', '05', '13', '12', '30', '10'),
            ],
        ]);
    }
}
