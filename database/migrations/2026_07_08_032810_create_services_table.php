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
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('details');
            $table->decimal('base_price', 10, 2);
            $table->string('time_estimated');//? Tiempo estimado definido por el que otorga el servicio(semanas, meses, entre otros segun su criterio)
            $table->string('service_image');
            $table->string('quotation_type', 100);
            $table->string('service_status', 50)->default('active');

            //Relaciones
            $table->foreignId('tenant_id')->constrained('users', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('service_type_id')->constrained('service_types')
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });

        DB::statement("ALTER TABLE services  ADD CONSTRAINT chk_service_status
        CHECK (service_status IN ('active', 'inactive', 'on_demand', 'paused', 'seasonal'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        if (Schema::hasTable('services')) {
            DB::statement('ALTER TABLE services DROP CHECK chk_service_status');
        }

        Schema::dropIfExists('services');
    }
};
