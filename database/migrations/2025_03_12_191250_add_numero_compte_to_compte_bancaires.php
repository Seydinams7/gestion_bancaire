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
    {    Schema::table('compte_bancaires', function (Blueprint $table) {
        // Vérifiez si la colonne n'existe pas avant de l'ajouter
        if (!Schema::hasColumn('compte_bancaires', 'numero_compte')) {
            $table->string('numero_compte')->nullable()->after('solde');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            //
        });
    }
};
