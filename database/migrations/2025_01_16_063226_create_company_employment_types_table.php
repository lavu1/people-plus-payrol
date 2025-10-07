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
        Schema::create('company_employment_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name')->unique();
            $table->text('description')->nullable();
            //$table->foreignId('company_id')->constrained('companies');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_employment_types');
    }
};
