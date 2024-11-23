<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_types_id')->constrained('product_types')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('product_product_types');
    }
}
