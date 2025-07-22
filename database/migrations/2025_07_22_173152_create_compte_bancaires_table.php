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
        Schema::create('compte_bancaires', function (Blueprint $table) {
            $table->id();
            $table->string('numero_compte')->unique();
            $table->string('code_banque')->nullable();
            $table->string('code_guichet')->nullable();
            $table->string('cle_controle')->nullable();
            $table->enum('statut', ['en attente', 'actif', 'cloture'])->default('en attente');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_bancaires');
    }
};
