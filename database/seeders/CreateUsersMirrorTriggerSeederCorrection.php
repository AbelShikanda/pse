<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateUsersMirrorTriggerSeederCorrection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
