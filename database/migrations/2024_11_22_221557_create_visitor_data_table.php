<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_data', function (Blueprint $table) {
            $table->id();
            $table->text('ip_address');              
            $table->mediumText('country')->nullable();     
            $table->mediumText('region')->nullable();      
            $table->mediumText('city')->nullable();        
            $table->mediumText('user_agent')->nullable();        
            $table->mediumText('referrer')->nullable();    
            $table->mediumText('utm_source')->nullable();  
            $table->mediumText('utm_medium')->nullable();  
            $table->mediumText('utm_campaign')->nullable();
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
        Schema::dropIfExists('visitor_data');
    }
}
