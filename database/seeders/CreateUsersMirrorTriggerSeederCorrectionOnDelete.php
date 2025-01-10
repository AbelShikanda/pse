<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateUsersMirrorTriggerSeederCorrectionOnDelete extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_user_mirror_delete
            AFTER DELETE ON users
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                DECLARE existing_count INT;

                SET action_type = "delete";

                -- Check if a record with the same email already exists in user_mirrors
                SELECT COUNT(*) INTO existing_count
                FROM user_mirrors
                WHERE email = OLD.email;

                -- If a record exists in user_mirrors, update it instead of inserting
                IF existing_count > 0 THEN
                    UPDATE user_mirrors
                    SET 
                        change_type = action_type, 
                        updated_at = NOW() -- Update only the updated_at field
                    WHERE email = OLD.email;
                ELSE
                    -- If no record exists, insert a new record
                    INSERT INTO user_mirrors (
                        uuid, first_name, last_name, email, gender, phone, town, location, 
                        email_verified_at, password, updated_by, change_type, changed_at
                    )
                    VALUES (
                        OLD.uuid, OLD.first_name, OLD.last_name, OLD.email, OLD.gender, OLD.phone, 
                        OLD.town, OLD.location, OLD.email_verified_at, OLD.password, 
                        user(), action_type, NOW()
                    );
                END IF;
            END;
        ');
    }
}
