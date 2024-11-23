<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetTokensMirrorTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::create('password_reset_tokens_mirrors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('token');
            $table->string('updated_by')->nullable();
            $table->string('change_type')->nullable();
            $table->timestamp('changed_at')->nullable();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_reset_tokens_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_password_reset_tokens_mirror_insert
            AFTER INSERT ON password_reset_tokens
            FOR EACH ROW
            BEGIN
                DECLARE action_payload TEXT;
                DECLARE action_exception TEXT;

                SET action_payload = CONCAT("Inserted token for email: ", NEW.email);
                SET action_exception = "";

                INSERT INTO password_reset_tokens_mirrors (
                    email, token, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.email, NEW.token, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_reset_tokens_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_password_reset_tokens_mirror_update
            AFTER UPDATE ON password_reset_tokens
            FOR EACH ROW
            BEGIN
                DECLARE action_payload TEXT;
                DECLARE action_exception TEXT;

                SET action_payload = CONCAT("Updated token for email: ", NEW.email);
                SET action_exception = "";

                INSERT INTO password_reset_tokens_mirrors (
                    email, token, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.email, NEW.token, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_reset_tokens_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_password_reset_tokens_mirror_delete
            AFTER DELETE ON password_reset_tokens
            FOR EACH ROW
            BEGIN
                DECLARE action_payload TEXT;
                DECLARE action_exception TEXT;

                SET action_payload = CONCAT("Deleted token for email: ", OLD.email);
                SET action_exception = "";

                INSERT INTO password_reset_tokens_mirrors (
                    email, token, updated_by, change_type, changed_at
                ) VALUES (
                    OLD.email, OLD.token, OLD.created_at, user(), action_type, NOW()
                );
            END;
        ');
    }
}
