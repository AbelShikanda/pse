<?php

namespace Database\Seeders;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsMirrorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::create('failed_jobs_mirrors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
            $table->string('updated_by')->nullable();
            $table->string('change_type')->nullable();
            $table->timestamp('changed_at')->nullable();
            $table->timestamps();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_insert');
        DB::unprepared('
            CREATE TRIGGER trg_failed_jobs_mirror_insert
            AFTER INSERT ON failed_jobs
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";

                INSERT INTO failed_jobs_mirrors (
                    uuid, connection, queue, payload, exception, failed_at, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.uuid, NEW.connection, NEW.queue, NEW.payload, NEW.exception, NEW.failed_at, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_update');
        DB::unprepared('
            CREATE TRIGGER trg_failed_jobs_mirror_update
            AFTER UPDATE ON failed_jobs
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";

                INSERT INTO failed_jobs_mirrors (
                    uuid, connection, queue, payload, exception, failed_at, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.uuid, NEW.connection, NEW.queue, NEW.payload, NEW.exception, NEW.failed_at, user(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_delete');
        DB::unprepared('
            CREATE TRIGGER trg_failed_jobs_mirror_delete
            AFTER DELETE ON failed_jobs
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "delete";

                INSERT INTO failed_jobs_mirrors (
                    uuid, connection, queue, payload, exception, failed_at, updated_by, change_type, changed_at
                ) VALUES (
                    OLD.uuid, OLD.connection, OLD.queue, OLD.payload, OLD.exception, OLD.failed_at, user(), action_type, NOW()
                );
            END;
        ');
    }
}
