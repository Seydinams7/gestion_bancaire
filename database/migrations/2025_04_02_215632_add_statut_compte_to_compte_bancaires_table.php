<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            $table->enum('statut_compte', ['en_attente', 'valide', 'rejete'])->default('en_attente');
        });
    }

    public function down()
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            $table->dropColumn('statut_compte');
        });
    }
};

