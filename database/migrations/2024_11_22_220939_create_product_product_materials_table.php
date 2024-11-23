<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProductMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->foreignId('products_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('product_materials_id')->constrained('product_materials')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('product_product_materials');
    }
}
