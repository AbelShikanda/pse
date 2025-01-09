<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersMirrorTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::create('user_mirrors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('town')->nullable();
            $table->string('location')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('updated_by')->nullable();
            $table->string('change_type')->nullable();
            $table->timestamp('changed_at')->nullable();
            $table->timestamps();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_user_mirror_insert
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";

                INSERT INTO user_mirrors (
                    uuid, first_name, last_name, email, gender, phone, town, location, 
                    email_verified_at, password, updated_by, change_type, changed_at
                )
                VALUES (
                    NEW.uuid, NEW.first_name, NEW.last_name, NEW.email, NEW.gender, NEW.phone, 
                    NEW.town, NEW.location, NEW.email_verified_at, NEW.password, 
                    user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_user_mirror_update
            AFTER UPDATE ON users
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";

                UPDATE user_mirrors
                SET 
                    first_name = NEW.first_name,
                    last_name = NEW.last_name,
                    email = NEW.email,
                    gender = NEW.gender,
                    phone = NEW.phone,
                    town = NEW.town,
                    location = NEW.location,
                    email_verified_at = NEW.email_verified_at,
                    password = NEW.password,
                    updated_by = user(),
                    change_type = action_type,
                    changed_at = NOW()
                WHERE uuid = NEW.uuid;
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_user_mirror_delete
            AFTER DELETE ON users
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "delete";

                INSERT INTO user_mirrors (
                    uuid, first_name, last_name, email, gender, phone, town, location, 
                    email_verified_at, password, updated_by, change_type, changed_at
                )
                VALUES (
                    OLD.uuid, OLD.first_name, OLD.last_name, OLD.email, OLD.gender, OLD.phone, 
                    OLD.town, OLD.location, OLD.email_verified_at, OLD.password, 
                    user(), action_type, NOW()
                );
            END;
        ');
    }
}
