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
        Schema::create('employees', function (Blueprint $table) {
             $table->id();
             $table->string('name');
             $table->string('father_name')->nullable();
             $table->string('phone')->nullable();
             $table->string('gender')->nullable();
             $table->string('nic')->nullable();
             $table->string('dob')->nullable();
             $table->string('email')->nullable();
             $table->integer('group_id')->nullable();
             $table->integer('department_id')->nullable();
             $table->integer('designation_id')->nullable();
             $table->boolean('status')->default(1);

             $table->timestamp('joined_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
