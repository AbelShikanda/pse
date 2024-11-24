<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAcessTokensMirrorTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::create('personal_access_tokens_mirrors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('change_type')->nullable();
            $table->timestamp('changed_at')->nullable();
            $table->timestamps();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_personal_access_tokens_mirror_insert
            AFTER INSERT ON personal_access_tokens
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";

                INSERT INTO personal_access_tokens_mirrors (
                    tokenable_id, tokenable_type, name, token, abilities, last_used_at, expires_at, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.tokenable_id, NEW.tokenable_type, NEW.name, NEW.token, NEW.abilities, NEW.last_used_at, NEW.expires_at, USER(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_personal_access_tokens_mirror_update
            AFTER UPDATE ON personal_access_tokens
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";

                INSERT INTO personal_access_tokens_mirrors (
                    tokenable_id, tokenable_type, name, token, abilities, last_used_at, expires_at, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.tokenable_id, NEW.tokenable_type, NEW.name, NEW.token, NEW.abilities, NEW.last_used_at, NEW.expires_at, USER(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_personal_access_tokens_mirror_delete
            AFTER DELETE ON personal_access_tokens
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "delete";

                INSERT INTO personal_access_tokens_mirrors (
                    tokenable_id, tokenable_type, name, token, abilities, last_used_at, expires_at, updated_by, change_type, changed_at
                ) VALUES (
                    OLD.tokenable_id, OLD.tokenable_type, OLD.name, OLD.token, OLD.abilities, OLD.last_used_at, OLD.expires_at, USER(), action_type, NOW()
                );
            END;
        ');
    }
}
