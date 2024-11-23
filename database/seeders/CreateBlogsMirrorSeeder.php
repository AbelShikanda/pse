<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBlogsMirrorTriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::create('Blogs_mirrors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thumbnail')->nullable();
            $table->string('full')->nullable();
            $table->foreignId('blogs_id')->constrained('blogs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('updated_by')->nullable();
            $table->string('change_type')->nullable();
            $table->timestamp('changed_at')->nullable();
            $table->timestamps();
        });

        DB::unprepared('DROP TRIGGER IF EXISTS trg_blog_mirror_insert;');
        DB::unprepared('
            CREATE TRIGGER trg_blog_mirror_insert
            AFTER INSERT ON blog_images
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "insert";

                INSERT INTO blogs_mirrors (
                    thumbnail, full, blogs_id, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.thumbnail, NEW.full, NEW.blogs_id, USER(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_blog_mirror_update;');
        DB::unprepared('
            CREATE TRIGGER trg_blog_mirror_update
            AFTER UPDATE ON blog_images
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "update";

                INSERT INTO blogs_mirrors (
                    thumbnail, full, blogs_id, updated_by, change_type, changed_at
                ) VALUES (
                    NEW.thumbnail, NEW.full, NEW.blogs_id, USER(), action_type, NOW()
                );
            END;
        ');

        DB::unprepared('DROP TRIGGER IF EXISTS trg_blog_mirror_delete;');
        DB::unprepared('
            CREATE TRIGGER trg_blog_mirror_delete
            AFTER DELETE ON blog_images
            FOR EACH ROW
            BEGIN
                DECLARE action_type VARCHAR(50);
                SET action_type = "delete";

                INSERT INTO blogs_mirrors (
                    thumbnail, full, blogs_id, updated_by, change_type, changed_at
                ) VALUES (
                    OLD.thumbnail, OLD.full, OLD.blogs_id, USER(), action_type, NOW()
                );
            END;
        ');
    }
}
