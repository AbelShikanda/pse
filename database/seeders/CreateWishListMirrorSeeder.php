<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWishlistMirrorTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::create('wish_lists_mirrors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->string('updated_by')->nullable();
            $table->string('change_type')->nullable();
            $table->timestamp('changed_at')->nullable();
            $table->timestamps();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS trg_wish_lists_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_wish_lists_mirror_insert
            AFTER INSERT ON wish_lists
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";

                INSERT INTO wish_lists_mirrors (
                    user_id, product_id, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.user_id, NEW.product_id, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_wish_lists_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_wish_lists_mirror_update
            AFTER UPDATE ON wish_lists
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";

                INSERT INTO wish_lists_mirrors (
                    user_id, product_id, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.user_id, NEW.product_id, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_wish_lists_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_wish_lists_mirror_delete
            AFTER DELETE ON wish_lists
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "delete";

                INSERT INTO wish_lists_mirrors (
                    user_id, product_id, updated_by, change_type, changed_at
                ) VALUES (
                    OLD.user_id, OLD.product_id, user(), action_type, NOW()
                );
            END;
        ');
    }
}
