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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->char('gender', 2);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number', 16);
            $table->string('profile_photo', 255);
            $table->text('professsional_description')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('account_status', 50);
            $table->rememberToken();

            //RELACIONES
            $table->foreignId('user_type_id')->constrained('user_types')
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });


        //Aplicar CHECK CONSTRAINT con SQL Nativo
        DB::statement('ALTER TABLE users ADD CONSTRAINT chk_user_account_status
        CHECK (name IN("ACTIVO", "INACTIVO", "SUSPENDIDO", "BLOQUEADO"))');

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        if (Schema::hasTable('users')) {
            DB::statement('ALTER TABLE users DROP CHECK chk_user_account_status');
        }

        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
