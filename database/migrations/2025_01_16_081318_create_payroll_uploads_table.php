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
        Schema::create('payroll_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('upload_file_path');
            $table->enum('status', ['Pending', 'Processed', 'Failed'])->default('Pending');
            $table->string('employee_name');
            $table->string('employee_number')->unique();
            $table->string('bank_details')->nullable();
            $table->string('mobile_money_phone_number')->nullable();
            $table->string('social_security_number')->nullable();
            $table->string('tpin')->nullable();
            $table->date('date_of_birth');
            $table->string('email')->unique();
            $table->decimal('basic_pay', 15, 2);
            $table->enum('pay_type', ['monthly', 'hourly']);
            $table->integer('leave_days_taken')->default(0);
            $table->decimal('overtime_hours_payable', 15, 2)->default(0);
            $table->string('allowance_name')->nullable();
            $table->decimal('allowance_amount', 15, 2)->nullable();
//            $table->string('upload_file_path');
//            $table->enum('status', ['Pending', 'Processed', 'Failed'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_uploads');
    }
};
