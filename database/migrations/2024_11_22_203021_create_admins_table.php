<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('username', 190)->unique();
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('is_admin')->default('0');
            $table->boolean('is_staff')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
