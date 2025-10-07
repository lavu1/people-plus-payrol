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
        Schema::create('company_employees', function (Blueprint $table) {
            $table->id();

            $table->date('date_of_birth');
            $table->string('employee_identification_number');
            $table->double('salary');
            $table->foreignId('salary_grade_id')->constrained('salary_grades');
            $table->foreignId('company_employment_type_id')->constrained('company_employment_types');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('position_id')->constrained('positions');
            $table->foreignId('currency_id')->constrained('currencies');
            $table->foreignId('employee_bank_account_id')->constrained('employee_bank_accounts');
            $table->foreignId('employee_mobile_money_id')->nullable()->constrained('employee_mobile_money');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            //$table->foreignId('country_id')->nullable()->constrained('countries');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_employees');
    }
};
