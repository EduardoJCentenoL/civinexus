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
        Schema::create('social_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('platform_name', 100);
            $table->string('profile_url');
            $table->string('social_media_status')->default('ACTIVA');

            //Relaciones
            $table->foreignId('tenant_id')->constrained('users', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });

        //Aplicar CHECK CONSTRAINT con SQL Nativo
        DB::statement("ALTER TABLE social_media ADD CONSTRAINT chk_social_media_status
        CHECK (social_media_status IN('ACTIVA', 'INACTIVA', 'SUSPENDIDA'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        if (Schema::hasTable('social_media')) {
            DB::statement('ALTER TABLE social_media DROP CHECK chk_social_media_status');
        }

        Schema::dropIfExists('social_media');
    }
};
