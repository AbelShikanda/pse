<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateProductPriceTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared('
        CREATE TRIGGER update_product_price_on_price_change
        AFTER UPDATE ON prices
        FOR EACH ROW
        BEGIN
            UPDATE products
            SET price = NEW.price
            WHERE type_id = NEW.id;
        END;
    ');
    }
}
