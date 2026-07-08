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
        Schema::create('specialty_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('years_experience')->unsigned()->default(0);
            $table->string('certification_number')->nullable();
            $table->string('specialty_status', 50)->default('PENDIENTE');//Si no le defino el size por defecto queda en 255(por si se me olvida)

            //Relaciones
            $table->foreignId('user_id')->constrained('users')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('specialty_id')->constrained('specialties')
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });

        //Aplicar CHECK CONSTRAINT con SQL Nativo
        DB::statement("ALTER TABLE state ADD CONSTRAINT chk_specialty_status
        CHECK (specialty_status IN ('PENDIENTE', 'APROBADO', 'RECHAZADO', 'INACTIVO', 'EXPIRADO', 'SUSPENDIDO', 'BLOQUEADO'))");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        if (Schema::hasTable('specialty_user')) {
            DB::statement('ALTER TABLE specialty_user DROP CHECK chk_specialty_status');
        }

        Schema::dropIfExists('specialty_user');
    }
};
