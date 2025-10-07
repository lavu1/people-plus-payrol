<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_employee_id')
                ->constrained('company_employees')
                ->onDelete('restrict');
            $table->integer('leave_days_sold')->comment('Number of leave days sold by the employee');
            $table->decimal('sale_amount', 10, 2)->comment('Amount earned from selling leave days');
            $table->enum('status', ['Pending', 'Processed'])
                ->default('Pending')
                ->comment('Status of the leave sale request');
            $table->foreignId('payroll_id')->nullable()->constrained('payrolls');
            $table->longText('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_sales');
    }
}
