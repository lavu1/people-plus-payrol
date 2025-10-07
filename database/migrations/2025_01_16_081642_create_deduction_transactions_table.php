<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deduction_transactions', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('deduction_id')
                ->constrained('deductions')
                ->onDelete('cascade')
                ->comment('Reference to the deduction being applied');
            $table
                ->foreignId('company_employee_id')
                ->constrained('company_employees')
                ->onDelete('cascade')
                ->comment('Reference to the employee for the deduction');
            $table
                ->foreignId('payroll_id')
                ->constrained('payrolls')
                ->onDelete('cascade')
                ->comment('Reference to the payroll cycle');
            $table->decimal('amount', 10, 2)->comment('Specific amount deducted from the employee');
            $table->timestamp('transaction_date')->useCurrent()->comment('Date the deduction was processed');
            $table->timestamps();  // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deduction_transactions');
    }
}
