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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->text('company_name');
            $table->text('address');
            $table->text('phone');
            $table->text('email');
            $table->string('logo_url')->nullable();
            $table->string('TPIN')->nullable();
            $table->string('pacra_number');
            $table->foreignId('town_id')->constrained('towns')->onDelete('restrict');
//            $table->foreignId('sector_id')->constrained('sectors')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};



