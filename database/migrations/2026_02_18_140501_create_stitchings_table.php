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
        Schema::create('stitchings', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->float('total_quantity')->default(0);
            $table->timestamp('date');
            $table->timestamps();
        });

        Schema::create('stitching_items', function (Blueprint $table) {
            $table->id();
            $table->integer('stitching_id');
            $table->integer('lot_id');
            $table->integer('lot_item_id');
            $table->integer('employee_id');
            $table->integer('department_id');
            $table->float('quantity')->default(0);
            $table->float('price')->default(0);
            $table->string('description')->nullable();
            $table->float('total')->default(0);
            $table->float('advance')->default(0);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stitchings');
        Schema::dropIfExists('stitching_items');
    }
};
