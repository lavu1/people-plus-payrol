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
        Schema::create('next_of_kin', function (Blueprint $table) {
            $table->id();
            $table->string('next_of_kin_name');
            $table->string('next_of_kin_identification_number');
            $table->string('next_of_kin_phone');
            $table->string('next_of_kin_email');
            $table->text('next_of_kin_address');
            $table->foreignId('town_id')->nullable()->constrained('towns');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('next_of_kin');
    }
};
