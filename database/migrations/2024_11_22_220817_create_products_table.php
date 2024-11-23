<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('categories_id')->constrained('product_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_id')->constrained('product_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('colors_id')->constrained('product_colors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sizes_id')->constrained('product_sizes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('materials_id')->constrained('product_materials')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('price', 10, 2);
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();
            $table->tinyInteger('whatsapp')->default(0);
            $table->tinyInteger('telegram')->default(0);
            $table->tinyInteger('website')->default(0);
            $table->tinyInteger('promotion')->default(0);
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
        Schema::dropIfExists('products');
    }
}
