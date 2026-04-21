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
        Schema::create('borrow_tools', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->string('status')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->dateTime('check_out_date')->nullable();
            $table->dateTime('check_in_date')->nullable();
            $table->string('actual_date_returned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_tools');
    }
};
