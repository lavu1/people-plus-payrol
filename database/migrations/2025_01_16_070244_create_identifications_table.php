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
        Schema::create('identifications', function (Blueprint $table) {
            $table->id();
            $table->enum('identification_type', ['NRC', 'Passport', 'Drivers License', 'ID Card', 'Residence Permit', 'Other'])->comment('Type of identification');
            $table->string('identification_number')->unique();
            $table->text('nrc_url')->nullable();
            $table->text('photo_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identifications');
    }
};
