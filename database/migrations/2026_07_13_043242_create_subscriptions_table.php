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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_date');
            $table->date('expiration_date');
            $table->string('subscription_status', 50)->default('active'); // active, expired, canceled

            // Relaciones limpias según convenciones de Laravel
            $table->foreignId('membership_id')
                ->constrained('memberships')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('tenant_id')->constrained('users', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();

            $table->timestamps();
        });

        // Restricción CHECK para asegurar integridad de estados en la BD
        DB::statement("ALTER TABLE subscriptions ADD CONSTRAINT chk_subscription_status
            CHECK (subscription_status IN ('active', 'expired', 'canceled'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //ELIMINACION DE RESTRICCION CHECK ANTES DE ELIMINAR LA TABLA
        if (Schema::hasTable('subscriptions')) {
            DB::statement('ALTER TABLE subscriptions DROP CHECK chk_subscription_status');
        }

        Schema::dropIfExists('subscriptions');
    }
};
