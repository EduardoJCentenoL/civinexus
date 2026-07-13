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
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bill_number', 100)->unique(); //? Folio único de factura
            $table->date('emision_date');
            $table->date('due_date'); //? Fecha límite de pago
            $table->decimal('subtotal', 12, 2)->unsigned();
            $table->decimal('iva_amount', 12, 2)->unsigned()->default(0.00);
            $table->decimal('total', 12, 2)->unsigned();  // subtotal + iva_amount
            $table->string('bill_status', 50)->default('pending');

            // Relación con la respuesta de cotización aprobada
            $table->foreignId('quote_response_id')->constrained('quote_responses')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });

         // Restricción CHECK para los estados de la factura
        DB::statement("ALTER TABLE bills ADD CONSTRAINT chk_bill_status
            CHECK (bill_status IN ('pending', 'partial', 'paid', 'canceled'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        if (Schema::hasTable('bills')) {
            DB::statement('ALTER TABLE bills DROP CHECK chk_bill_status');
        }

        Schema::dropIfExists('bills');
    }
};
