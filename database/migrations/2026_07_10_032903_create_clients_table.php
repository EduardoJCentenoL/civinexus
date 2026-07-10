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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('email', 150)->unique();
            $table->string('phone_number', 50);
            $table->string('client_type', 50);
            $table->string('address');
            $table->
            $table->timestamps();
        });

        DB::statement("ALTER TABLE clients ADD CONSTRAINT chk_client_type
        CHECK (client_type IN('person', 'enterprise))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        if (Schema::hasTable('clients')) {
            DB::statement('ALTER TABLE clients DROP CHECK chk_client_type');
        }

        Schema::dropIfExists('clients');
    }
};
