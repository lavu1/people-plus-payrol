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
        Schema::create('salary_grades', function (Blueprint $table) {
            $table->id();
            $table->string('grade_name');
            $table->double('min_salary');
            $table->double('max_salary');
            $table->foreignId('company_branch_id')->constrained('company_branches');
            $table->double('gratuity_percentage')->default(0)->comment('Percentage of basic salary for gratuity calculation');
            $table->double('pension_percentage')->default(0)->comment('Percentage of basic salary for pension contribution');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_grades');
    }
};
