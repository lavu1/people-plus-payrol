<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('restrict');
            $table->string('name', 100);
            $table->enum('d_type', ['fixed', 'percentage'])
                ->default('fixed');
            $table
                ->decimal('value', 10, 2)
                ->comment('Amount of deduction awarded');
//            $table->decimal('amount', 10, 2)->nullable();
//            $table->decimal('percentage', 5, 2)->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_statutory')->default(false);
            $table->string('destination', 255);
            $table->foreignId('position_id')->constrained('positions');
            $table->enum('frequency', ['Monthly', 'One-Time'])->default('Monthly')->comment('Deduction frequency');
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
        Schema::dropIfExists('deductions');
    }
}
