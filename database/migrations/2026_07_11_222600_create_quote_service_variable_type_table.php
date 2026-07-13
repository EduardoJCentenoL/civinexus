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
        Schema::create('quote_service_variable_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('input_quantity')->unsigned();

            //? Relaciones
            $table->foreignId('quote_service_id')->constrained('quote_service')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('variable_type_id')->constrained('variable_types')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_service_variable_type');
    }
};
