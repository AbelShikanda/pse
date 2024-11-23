<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProductPriceTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared('
            CREATE TRIGGER update_product_price_on_type_change
            BEFORE UPDATE ON products
            FOR EACH ROW
            BEGIN

                DECLARE new_price DECIMAL(10,2);
                
        		-- and in the event products id is correct and transaction amount is wrong
        		
                IF OLD.type_id != NEW.type_id THEN
                    -- Fetch the price from product_types based on the new type_id
                    SELECT price INTO new_price 
                    FROM prices 
                    WHERE id = NEW.type_id;

                    -- Update the price in the products table
                    SET NEW.price = new_price;
                END IF;

            END;
        ');
    }

    /**
     * Reverse the database seeds.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_product_price_on_type_change');
    }
}
