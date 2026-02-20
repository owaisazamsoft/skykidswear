<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->integer('product_id');
            $table->double('total_quantity')->default(0);
            $table->timestamp('date');
            $table->timestamps();
        });
    
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }

    
};
