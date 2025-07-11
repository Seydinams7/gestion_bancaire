<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Dans la méthode up de la migration
    public function up()
    {
        Schema::table('retraits', function (Blueprint $table) {
            $table->timestamps(); // Cela ajoutera les colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retraits', function (Blueprint $table) {
            //
        });
    }
};
