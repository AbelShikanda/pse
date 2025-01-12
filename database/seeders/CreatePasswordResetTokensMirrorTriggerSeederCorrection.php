<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePasswordResetTokensMirrorTriggerSeederCorrection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_resets_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_password_resets_mirror_insert
            AFTER INSERT ON password_resets
            FOR EACH ROW
            BEGIN
                INSERT INTO password_resets_mirrors (
                    email, token, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.email, NEW.token, user(), "insert", NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_resets_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_password_resets_mirror_update
            AFTER UPDATE ON password_resets
            FOR EACH ROW
            BEGIN
                UPDATE password_resets_mirrors
                SET 
                    token = NEW.token,
                    updated_by = user(),
                    change_type = "update",
                    changed_at = NOW()
                WHERE email = NEW.email;
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_resets_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_password_resets_mirror_delete
            AFTER DELETE ON password_resets
            FOR EACH ROW
            BEGIN
                IF EXISTS (SELECT 1 FROM password_resets_mirrors WHERE email = OLD.email) THEN
                    UPDATE password_resets_mirrors
                    SET 
                        token = OLD.token,
                        updated_by = user(),
                        change_type = "delete",
                        changed_at = NOW()
                    WHERE email = OLD.email;
                END IF;
            END;
        ');
    }
}
