<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductMaterials extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_materials')->insert([
            [
                'id' => 1,
                'name' => 'Cotton',
                'slug' => 'Cotton',
                'created_at' => Carbon::create('2022', '11', '26', '14', '17', '09'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '17', '09'),
            ],
            [
                'id' => 2,
                'name' => 'Cotton/Polyester',
                'slug' => 'Cotton',
                'created_at' => Carbon::create('2022', '11', '26', '14', '17', '20'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '17', '20'),
            ],
            [
                'id' => 3,
                'name' => 'Polyester',
                'slug' => 'Polyester',
                'created_at' => Carbon::create('2022', '11', '26', '14', '17', '35'),
                'updated_at' => Carbon::create('2022', '11', '26', '14', '17', '35'),
            ],
        ]);
    }
}
