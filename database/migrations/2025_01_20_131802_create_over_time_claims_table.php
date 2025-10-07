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
        Schema::create('over_time_claims', function (Blueprint $table) {
            $table->id();
            $table->integer('actual_hours');
            $table->integer('computed_cost');
            $table->integer('adjusted_hours');
            $table->integer('final_hours');
            $table->foreignId('over_time_requests_id')->constrained('over_time_requests');
            $table->foreignId('company_employee_id')->constrained('company_employees');
            $table->foreignId('payroll_id')->nullable()->constrained('payrolls');
            $table->enum('status', ['Pending', 'Processed'])
                ->default('Pending')
                ->comment('Status of the overtime request');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('over_time_claims');
    }
};
