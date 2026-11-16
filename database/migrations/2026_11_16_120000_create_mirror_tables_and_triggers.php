<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMirrorTablesAndTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * PostgreSQL only: creates the audit mirror tables (previously built by
     * the MySQL trigger seeders) and translates every MySQL trigger to
     * PL/pgSQL from database/postgres/mirror_triggers.sql.
     */
    public function up()
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        if (!Schema::hasTable('user_mirrors')) {
            Schema::create('user_mirrors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('uuid');
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
        }

        if (!Schema::hasTable('product_mirrors')) {
            Schema::create('product_mirrors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('thumbnail')->nullable();
                $table->string('full')->nullable();
                $table->foreignId('products_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
                $table->string('updated_by')->nullable();
                $table->string('change_type')->nullable();
                $table->timestamp('changed_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('blog_mirrors')) {
            Schema::create('blog_mirrors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('thumbnail')->nullable();
                $table->string('full')->nullable();
                $table->foreignId('blogs_id')->constrained('blogs')->onDelete('cascade')->onUpdate('cascade');
                $table->string('updated_by')->nullable();
                $table->string('change_type')->nullable();
                $table->timestamp('changed_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('wish_lists_mirrors')) {
            Schema::create('wish_lists_mirrors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('product_id')->constrained('products');
                $table->string('updated_by')->nullable();
                $table->string('change_type')->nullable();
                $table->timestamp('changed_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_mirrors')) {
            Schema::create('order_mirrors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('order_id')->nullable()->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('order_items_id')->nullable()->constrained('order__items')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('product_id')->nullable()->constrained('products')->onUpdate('cascade')->onDelete('cascade');
                $table->string('quantity')->nullable();
                $table->decimal('price', 10, 2);
                $table->string('reference');
                $table->boolean('complete')->default(false);
                $table->string('updated_by')->nullable();
                $table->string('change_type')->nullable();
                $table->timestamp('changed_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('password_resets_mirrors')) {
            Schema::create('password_resets_mirrors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('email')->unique();
                $table->string('token');
                $table->string('updated_by')->nullable();
                $table->string('change_type')->nullable();
                $table->timestamp('changed_at')->nullable();
            });
        }

        if (!Schema::hasTable('personal_access_tokens_mirrors')) {
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
        }

        if (!Schema::hasTable('failed_jobs_mirrors')) {
            Schema::create('failed_jobs_mirrors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->text('payload');
                $table->text('exception');
                $table->timestamp('failed_at')->useCurrent();
                $table->string('updated_by')->nullable();
                $table->string('change_type')->nullable();
                $table->timestamp('changed_at')->nullable();
                $table->timestamps();
            });
        }

        DB::unprepared(file_get_contents(database_path('postgres/mirror_triggers.sql')));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        DB::unprepared('DROP TRIGGER IF EXISTS update_product_price_on_price_change ON prices');
        DB::unprepared('DROP TRIGGER IF EXISTS update_product_price_on_type_change ON products');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_delete ON failed_jobs');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_update ON failed_jobs');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_insert ON failed_jobs');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_delete ON personal_access_tokens');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_update ON personal_access_tokens');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_insert ON personal_access_tokens');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_resets_mirror_delete ON password_resets');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_resets_mirror_update ON password_resets');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_password_resets_mirror_insert ON password_resets');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_wish_lists_mirror_delete ON wish_lists');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_wish_lists_mirror_update ON wish_lists');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_wish_lists_mirror_insert ON wish_lists');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_blog_mirror_delete ON blog_images');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_blog_mirror_update ON blog_images');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_blog_mirror_insert ON blog_images');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_product_mirror_delete ON product_images');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_product_mirror_update ON product_images');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_product_mirror_insert ON product_images');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_delete ON order__items');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_delete ON orders');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_update_items ON order__items');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_update ON orders');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_insert ON order__items');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_order_mirror_insert ON orders');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_mirror_delete ON users');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_mirror_update ON users');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_user_mirror_insert ON users');
    }
}
