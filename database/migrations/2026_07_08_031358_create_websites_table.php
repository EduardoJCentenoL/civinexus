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
        Schema::create('websites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('page_name', 150);
            $table->string('slug')->unique(); //?URL especifica del usuario y dependiente del la URL de la plataforma
            $table->string('theme_color', 50);
            $table->text('page_description')->nullable();
            $table->string('logo', 50);

            //Relaciones
            $table->foreignId('tenant_id')->constrained('users', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
