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
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount_paid', 12, 2)->unsigned(); // Monto abonado
            $table->string('payment_method', 50);               // Transferencia, Efectivo, etc.
            $table->string('reference_number', 100)->nullable(); // Número de transferencia bancaria
            $table->date('payment_date');

            // Relación con la factura a la que pertenece el abono
            $table->foreignId('bill_id')->constrained('bills')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_payments');
    }
};
