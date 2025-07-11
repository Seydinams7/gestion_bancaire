<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            // Rendre la colonne 'code_banque' nullable
            $table->string('code_banque')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            // Si vous souhaitez annuler, vous pouvez soit le supprimer, soit définir NULL
            $table->string('code_banque')->nullable()->change();
        });
    }

};
