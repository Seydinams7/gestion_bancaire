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
            $table->integer('retraits_mois')->default(0);
            $table->timestamp('dernier_retrait')->nullable();
        });
    }

    public function down()
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            $table->dropColumn('retraits_mois');
            $table->dropColumn('dernier_retrait');
        });
    }

};
