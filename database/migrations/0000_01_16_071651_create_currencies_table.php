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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code', 3)->unique()->comment('ISO 4217 currency code, e.g., USD, EUR');
            $table->string('currency_name')->comment('Full name of the currency, e.g., US Dollar, Euro');
            $table->string('symbol', 10)->nullable()->comment('Symbol of the currency, e.g., $, €');
            $table->double('exchange_rate')->default(1)->comment('Exchange rate to a base currency, default is 1');
            $table->boolean('is_active')->default(false)->comment('Indicates if the currency is active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
