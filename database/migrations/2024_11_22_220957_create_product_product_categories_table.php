<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_categories_id')->constrained('product_categories')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('product_product_categories');
    }
}
