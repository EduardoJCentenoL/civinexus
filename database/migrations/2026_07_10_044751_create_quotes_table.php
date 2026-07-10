<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('project_description');
            $table->string('project_location_address');
            $table->decimal('budget', 12, 2)->unsigned();
            $table->string('quote_status', 50)->default('pending');
            $table->string('priority', 50)->default('regular');
            $table->date('application_date');

            //?Relaciones
            $table->foreignId('tenant_id')->constrained('users', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('clients')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('locations')
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });

        //?Restriccion para el quote_status
        DB::statement("ALTER TABLE quotes ADD CONSTRAINT chk_quote_status
        CHECK (quote_status IN('pending', 'reviewing', 'accepted', 'rejected'))");//? Estados de la cotizacion, por ahora solo esos

        //?Restriccion para el priority
        DB::statement("ALTER TABLE quotes ADD CONSTRAINT chk_priority
        CHECK (priority IN('immediate', 'regular', 'flexible', 'on-hold'))");//? inmediata, regular, flexivle y en espera
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
