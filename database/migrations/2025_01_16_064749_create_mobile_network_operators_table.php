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
        Schema::create('mobile_network_operators', function (Blueprint $table) {
            $table->id();
            $table->enum('operator_name',['MTN', 'Zamtel', 'Airtel']);
            $table->string('operator_code')->nullable();
            $table->string('operator_logo_url')->nullable();
            $table->double('max_transfer_amount')->default(10000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_network_operators');
    }
};
