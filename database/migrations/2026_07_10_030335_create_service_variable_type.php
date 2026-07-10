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
        Schema::create('service_variable_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_required')->default(false);
            $table->decimal('min_value', 10, 2);
            $table->decimal('max_value', 10, 2);
            $table->decimal('extra_price', 10, 2)->default(0);

            //Relaciones
            $table->foreignId('service_id')->constrained('services')
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
        Schema::dropIfExists('service_variable_type');
    }
};
