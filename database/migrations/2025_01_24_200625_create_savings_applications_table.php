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
        Schema::create('savings_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_employee_id')->constrained('company_employees');
            $table->decimal('value',4);
            $table->text('reason')->nullable();
            $table->boolean('status')->nullable();
            $table->enum('s_type', ['fixed', 'percentage'])
                ->default('fixed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings_applications');
    }
};
