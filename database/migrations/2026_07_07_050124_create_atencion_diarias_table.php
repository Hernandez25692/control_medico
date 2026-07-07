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
        Schema::create('atencion_diarias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('medico_id')
                ->constrained('medicos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('concepto_id')
                ->constrained('conceptos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('fecha');

            $table->unsignedInteger('cantidad')->default(0);

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(['medico_id', 'concepto_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencion_diarias');
    }
};
