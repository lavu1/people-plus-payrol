<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGratuitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gratuities', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('company_employee_id')
                ->constrained('company_employees')
                ->onDelete('restrict')
                ->comment('Reference to the employee receiving the gratuity');
            $table->enum('g_type', ['fixed', 'percentage'])
                ->default('fixed');
            $table
                ->decimal('value', 10, 2)
                ->comment('Amount of gratuity awarded');
//            $table
//                ->date('gratuity_date')
//                ->comment('Date when the gratuity was paid or recorded');
            $table
                ->text('notes')
                ->nullable()
                ->comment('Optional notes about the gratuity');
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
        Schema::dropIfExists('gratuities');
    }
}
