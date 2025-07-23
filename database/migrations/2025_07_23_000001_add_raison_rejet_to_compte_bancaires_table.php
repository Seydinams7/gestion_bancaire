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
        Schema::table('compte_bancaires', function (Blueprint $table) {
            $table->text('raison_rejet')->nullable();
            $table->text('raison_rejet_fermeture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            $table->dropColumn(['raison_rejet', 'raison_rejet_fermeture']);
        });
    }
};

