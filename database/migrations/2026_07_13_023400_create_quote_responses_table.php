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
        Schema::create('quote_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('adjusted_price', 12, 2)->unsigned(); //?precio final ofertado por el que ofrece el servicio
            $table->text('details');
            $table->string('estimated_duration', 150); //?Ejm: Dos semanas, un mes o lo que sea
            $table->text('payment_conditions')->nullable(); //? Condiciones de pago, por ejemplo un porcentaje de anticipo y el resto al finalizar
            $table->date('valid_until'); //? Fecha de vencimiento o valides de la propuesta
            $table->string('response_status', 50)->default('sent');
            $table->date('response_date');

            //? Relaciones
            $table->foreignId('quote_id')->constrained('quotes')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('users', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });

        DB::statement("ALTER TABLE quote_responses ADD CONSTRAINT chk_response_status
        CHECK (response_status IN('sent', 'accepted', 'rejected', 'expired', 'canceled'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        if (Schema::hasTable('quote_responses')) {
            DB::statement('ALTER TABLE quote_responses DROP CHECK chk_response_status');
        }

        Schema::dropIfExists('quote_responses');
    }
};
