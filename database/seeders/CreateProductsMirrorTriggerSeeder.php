<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsMirrorTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::create('product_mirrors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thumbnail')->nullable();
            $table->string('full')->nullable();
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->string('updated_by')->nullable();
            $table->string('change_type')->nullable();
            $table->timestamp('changed_at')->nullable();
            $table->timestamps();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS trg_product_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_product_mirror_insert
            AFTER INSERT ON product_images
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";

                INSERT INTO product_mirrors (
                    thumbnail, full, products_id, updated_by, change_type, changed_at
                )
                VALUES (
                    NEW.thumbnail, NEW.full, NEW.products_id, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_product_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_product_mirror_update
            AFTER UPDATE ON product_images
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";

                INSERT INTO product_mirrors (
                    thumbnail, full, products_id, updated_by, change_type, changed_at
                )
                VALUES (
                    NEW.thumbnail, NEW.full, NEW.products_id, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_product_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_product_mirror_delete
            AFTER DELETE ON product_images
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "delete";

                INSERT INTO product_mirrors (
                    thumbnail, full, products_id, updated_by, change_type, changed_at
                )
                VALUES (
                    OLD.thumbnail, OLD.full, OLD.products_id, user(), action_type, NOW()
                );
            END;
        ');
    }
}
