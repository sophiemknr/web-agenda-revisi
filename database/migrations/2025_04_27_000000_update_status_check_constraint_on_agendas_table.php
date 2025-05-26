<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing check constraint
        DB::statement('ALTER TABLE agendas DROP CONSTRAINT IF EXISTS agendas_status_check;');

        // Add the new check constraint with allowed statuses including "reschedule"
        DB::statement("ALTER TABLE agendas ADD CONSTRAINT agendas_status_check CHECK (status IN ('draft', 'tentative', 'confirmed', 'cancel', 'reschedule'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the updated check constraint
        DB::statement('ALTER TABLE agendas DROP CONSTRAINT IF EXISTS agendas_status_check;');

        // Revert to the original constraint (without 'reschedule')
        DB::statement("ALTER TABLE agendas ADD CONSTRAINT agendas_status_check CHECK (status IN ('draft', 'tentative', 'confirmed', 'cancel'));");
    }
};
