<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPoductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_poduct_sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_sizes_id')->constrained('product_sizes')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('product_poduct_sizes');
    }
}
