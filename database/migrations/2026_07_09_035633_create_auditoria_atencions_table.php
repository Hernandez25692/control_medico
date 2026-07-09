<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditoria_atenciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('atencion_diaria_id')
                ->nullable()
                ->constrained('atencion_diarias')
                ->nullOnDelete();

            $table->foreignId('medico_id')
                ->constrained('medicos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('concepto_id')
                ->constrained('conceptos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('fecha');

            $table->unsignedInteger('valor_anterior')->default(0);
            $table->unsignedInteger('valor_nuevo')->default(0);

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria_atenciones');
    }
};