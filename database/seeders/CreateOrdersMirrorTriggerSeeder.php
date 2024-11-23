<?php

namespace Database\Seeders;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class CreateOrdersMirrorTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::create('order_mirrors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('order_items_id')->constrained('order_items')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string('quantity')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('reference');
            $table->boolean('complete')->default(0);
            $table->string('updated_by')->nullable();
            $table->string('change_type')->nullable();
            $table->timestamp('changed_at')->nullable();
            $table->timestamps();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_order_mirror_insert
            AFTER INSERT ON orders
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";
                
                INSERT INTO order_mirrors (
                    id, order_items_id, user_id, product_id, quantity, price, reference,
                    complete, updated_by, change_type, changed_at
                )
                VALUES (
                    NEW.id, NULL, NEW.user_id, NULL, NULL, NEW.price, NEW.reference,
                    NEW.complete, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_order_mirror_insert
            AFTER INSERT ON order_items
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";
                
                INSERT INTO order_mirrors (
                    order_id, order_items_id, user_id, product_id, quantity, price, reference,
                    complete, updated_by, change_type, changed_at
                )
                VALUES (
                    NEW.order_id, NEW.id, (SELECT user_id FROM orders WHERE id = NEW.order_id), NEW.product_id, 
                    NEW.quantity, NEW.price, (SELECT reference FROM orders WHERE id = NEW.order_id), 
                    (SELECT complete FROM orders WHERE id = NEW.order_id), 
                    user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_order_mirror_update
            AFTER UPDATE ON orders
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";
                INSERT INTO order_mirrors (
                    id, order_items_id, user_id, product_id, quantity, price, reference,
                    complete, updated_by, change_type, changed_at
                )
                VALUES (
                    NEW.id, NULL, NEW.user_id, NULL, NULL, NEW.price, NEW.reference,
                    NEW.complete, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_order_mirror_update
            AFTER UPDATE ON order_items
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";
                INSERT INTO order_mirrors (
                    order_id, order_items_id, user_id, product_id, quantity, price, reference,
                    complete, updated_by, change_type, changed_at
                )
                VALUES (
                    NEW.order_id, NEW.id, (SELECT user_id FROM orders WHERE id = NEW.order_id), NEW.product_id, 
                    NEW.quantity, NEW.price, (SELECT reference FROM orders WHERE id = NEW.order_id), 
                    (SELECT complete FROM orders WHERE id = NEW.order_id), user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_order_mirror_delete
            AFTER DELETE ON orders
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "delete";
                INSERT INTO order_mirrors (
                    id, order_items_id, user_id, product_id, quantity, price, reference,
                    complete, updated_by, change_type, changed_at
                )
                VALUES (
                    OLD.id, NULL, OLD.user_id, NULL, NULL, OLD.price, OLD.reference,
                    OLD.complete, user(), action_type, NOW()
                );
            END
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_order_mirror_delete
            AFTER DELETE ON order_items
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "delete";
                INSERT INTO order_mirrors (
                    order_id, order_items_id, user_id, product_id, quantity, price, reference,
                    complete, updated_by, change_type, changed_at
                )
                VALUES (
                    OLD.order_id, OLD.id, (SELECT user_id FROM orders WHERE id = OLD.order_id), 
                    OLD.product_id, OLD.quantity, OLD.price, (SELECT reference FROM orders WHERE id = OLD.order_id), 
                    (SELECT complete FROM orders WHERE id = OLD.order_id), user(), action_type, NOW()
                );
            END;
        ');
    }
}
