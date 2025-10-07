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
        Schema::create('advance_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_employee_id')->constrained('company_employees');
            $table->decimal('amount');
            $table->enum('a_type', ['fixed', 'percentage'])
                ->default('fixed');
            $table
                ->decimal('value', 10, 2)
                ->comment('Amount of deduction awarded');
            $table->text('reason')->nullable();
            $table->boolean('status')->nullable();
            $table->enum('frequency', ['Monthly', 'One-Time'])->default('Monthly')->comment('Deduction frequency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_applications');
    }
};
