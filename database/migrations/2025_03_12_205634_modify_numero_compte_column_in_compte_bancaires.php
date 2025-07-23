<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            $table->string('numero_compte', 255)->change();  // Augmenter la taille de la colonne
        });
    }

    public function down()
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            $table->string('numero_compte', 100)->change();  // Revenir à la taille initiale
        });
    }

};
