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
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')
                ->nullable()
                ->constrained('solicituds')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('soporte_id')
                ->nullable()
                ->constrained('soportes')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('comentario');
            $table->string('estado');
            $table->timestamp('fecha_solucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimientos');
    }
};
