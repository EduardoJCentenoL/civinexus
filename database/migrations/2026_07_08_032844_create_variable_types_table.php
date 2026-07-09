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
        Schema::create('variable_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('display_name', 150);
            $table->text('details');
            $table->string('measure_unit', 50);// ejemplo: m², m³, unidades, dias, entre otros

            //Relaciones
            $table->foreignId('variable_category_id')->constrained('variable_categories')
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variable_types');
    }
};
