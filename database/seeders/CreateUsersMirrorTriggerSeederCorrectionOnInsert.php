<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateUsersMirrorTriggerSeederCorrectionOnInsert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_user_mirror_insert
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                DECLARE existing_count INT;
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";

                -- Check if a record with the same email exists and is marked as deleted
                SELECT COUNT(*) INTO existing_count
                FROM user_mirrors
                WHERE email = NEW.email AND change_type = "delete";

                -- If a deleted record exists, update it
                IF existing_count > 0 THEN
                    UPDATE user_mirrors
                    SET 
                        change_type = action_type, 
                        changed_at = NOW(),
                        first_name = NEW.first_name,
                        last_name = NEW.last_name,
                        phone = NEW.phone,
                        town = NEW.town,
                        location = NEW.location,
                        password = NEW.password,
                        updated_by = user(),
                        uuid = NEW.uuid 
                    WHERE email = NEW.email AND change_type = "delete";
                ELSE
                    -- Otherwise, insert a new record
                    INSERT INTO user_mirrors (
                        uuid, first_name, last_name, email, gender, phone, town, location, 
                        email_verified_at, password, updated_by, change_type, changed_at
                    )
                    VALUES (
                        NEW.uuid, NEW.first_name, NEW.last_name, NEW.email, NEW.gender, NEW.phone, 
                        NEW.town, NEW.location, NEW.email_verified_at, NEW.password, 
                        user(), action_type, NOW()
                    );
                END IF;
            END;
        ');

    }
}
