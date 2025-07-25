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
            $table->string('numero_carte')->nullable();
            $table->string('date_expiration')->nullable(); // format MM/YY
            $table->string('cvv')->nullable();
        });
    }

    public function down()
    {
        Schema::table('compte_bancaires', function (Blueprint $table) {
            $table->dropColumn(['numero_carte', 'date_expiration', 'cvv']);
        });
    }

};
