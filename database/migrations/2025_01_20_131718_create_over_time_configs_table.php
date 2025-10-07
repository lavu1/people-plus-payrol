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
        Schema::create('over_time_configs', function (Blueprint $table) {
            $table->id();
            $table->enum('over_time_type', ['weekend', 'holidays','excess_hours']);
            $table->double('hourly_rate');
            $table->double('calculation_rate');
            $table->boolean('status');
            $table->boolean('is_taxable');
            $table->foreignId('position_id')->constrained('positions');
            $table->foreignId('company_id')->constrained('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('over_time_configs');
    }
};
