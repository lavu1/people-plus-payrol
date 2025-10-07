<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
            $table->
            foreignId('company_employee_id')
                ->constrained('company_employees')
                ->onDelete('cascade')->comment('Reference to the employee requesting the advance');
            $table->decimal('amount', 10, 2)->comment('Advance amount requested by the employee');
            //$table->enum('status', ['Pending', 'Approved', 'Rejected', 'Cancelled', 'Completed'])->default('Pending')->comment('Status of the advance request');
            $table->enum('status', ['Pending', 'Processed'])
                ->default('Processed')
                ->comment('Status of the leave sale request');
            $table->foreignId('payroll_id')->constrained('payrolls')->onDelete('cascade');
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
        Schema::dropIfExists('advances');
    }
}
