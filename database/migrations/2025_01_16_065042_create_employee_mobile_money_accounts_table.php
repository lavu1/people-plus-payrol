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
        Schema::create('employee_mobile_money', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_money_number')->unique();
            $table->foreignId('mno_id')->constrained('mobile_network_operators');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_mobile_money');
    }
};
