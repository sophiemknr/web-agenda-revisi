<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- Jangan lupa tambahkan ini

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status');
            $table->date('date');
            $table->string('jam')->nullable();
            $table->string('tempat')->nullable();
            $table->string('disposition')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });

        // Menambahkan constraint untuk memastikan data status valid
        DB::statement("ALTER TABLE agendas ADD CONSTRAINT agendas_status_check CHECK (status IN ('draft', 'tentative', 'confirmed', 'cancel', 'reschedule'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
