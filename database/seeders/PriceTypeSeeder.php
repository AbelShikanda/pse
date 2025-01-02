<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prices')->insert([
            [
                'id' => 1,
                'price' => 900,
                'type_id' => 1,
                'created_at' => Carbon::create('2022', '11', '26', '14', '41', '19'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '41', '19'),
            ],
            [
                'id' => 2,
                'price' => 1800,
                'type_id' => 2,
                'created_at' => Carbon::create('2022', '11', '26', '14', '41', '39'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '41', '39'),
            ],
            [
                'id' => 3,
                'price' => 2000,
                'type_id' => 3,
                'created_at' => Carbon::create('2022', '11', '26', '14', '41', '55'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '41', '55'),
            ],
            [
                'id' => 4,
                'price' => 2000,
                'type_id' => 4,
                'created_at' => Carbon::create('2022', '11', '26', '14', '42', '04'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '42', '04'),
            ],
            [
                'id' => 5,
                'price' => 2500,
                'type_id' => 5,
                'created_at' => Carbon::create('2022', '11', '26', '14', '42', '20'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '42', '20'),
            ],
            [
                'id' => 6,
                'price' => 2500,
                'type_id' => 6,
                'created_at' => Carbon::create('2022', '11', '26', '14', '42', '35'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '42', '35'),
            ],
            [
                'id' => 7,
                'price' => 2500,
                'type_id' => 7,
                'created_at' => Carbon::create('2022', '11', '26', '14', '43', '16'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '43', '16'),
            ],
            [
                'id' => 8,
                'price' => 2500,
                'type_id' => 8,
                'created_at' => Carbon::create('2022', '11', '26', '14', '43', '30'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '43', '30'),
            ],
            [
                'id' => 9,
                'price' => 3800,
                'type_id' => 9,
                'created_at' => Carbon::create('2022', '11', '26', '14', '43', '44'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '43', '44'),
            ],
            [
                'id' => 10,
                'price' => 650,
                'type_id' => 10,
                'created_at' => Carbon::create('2024', '05', '13', '12', '29', '50'),
                'updated_at' => Carbon::create('2024', '05', '13', '12', '29', '50'),
            ],
            [
                'id' => 11,
                'price' => 1000,
                'type_id' => 11,
                'created_at' => Carbon::create('2024', '05', '13', '12', '30', '10'),
                'updated_at' => Carbon::create('2024', '05', '13', '12', '30', '10'),
            ],
        ]);
    }
}
