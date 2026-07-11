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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method_name', 100);
            $table->string('provider', 100);
            $table->string('account_reference', 150);
            $table->string('currency', 10)->default('USD');

            //Relaciones
            $table->foreignId('tenant_id')->constrained('users', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies' )
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });

        //? DB::statement("ALTER TABLE payment_methods  ADD CONSTRAINT chk_payment_currency
        //? CHECK (currency IN ('USD', 'NIO', 'EUR'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        /*if (Schema::hasTable('payment_methods')) {
            DB::statement('ALTER TABLE payment_methods DROP CHECK chk_payment_currency');
        }*/

        Schema::dropIfExists('payment_methods');
    }
};
