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
        Schema::create('over_time_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('over_time_type', ['weekend', 'holidays','excess_hours']);
            $table->integer('requested_hours');
            $table->text('justification');
            $table->date('dates_requested');
            $table->decimal('computed_cost');
            $table->enum('status',['pending', 'approved', 'rejected', 'adjusted']);
            $table->boolean('is_taxable');
            $table->text('hod_comments')->nullable();
            $table->text('hr_comments')->nullable();
            $table->boolean('supervisor_triggered');
            $table->foreignId('company_employee_id')->constrained('company_employees');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('over_time_requests');
    }
};
