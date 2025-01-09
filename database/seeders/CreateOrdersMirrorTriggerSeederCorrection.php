<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateOrdersMirrorTriggerSeederCorrection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_order_mirror_update
            AFTER UPDATE ON orders
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";
                
                UPDATE order_mirrors
                SET 
                    complete = NEW.complete,
                    updated_by = user(),
                    change_type = action_type,
                    changed_at = NOW()
                WHERE order_id = NEW.id;
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_update_items');
        DB::unprepared('
            CREATE TRIGGER trg_order_mirror_update_items
            AFTER UPDATE ON order__items
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";
                
                UPDATE order_mirrors
                SET 
                    quantity = NEW.quantity,
                    price = NEW.price,
                    product_id = NEW.product_id,
                    updated_by = user(),
                    change_type = action_type,
                    changed_at = NOW()
                WHERE order_items_id = NEW.id;
            END;
        ');
    }
}
