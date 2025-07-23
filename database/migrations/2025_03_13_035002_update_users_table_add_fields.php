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
        Schema::table('users', function (Blueprint $table) {
            // Si la colonne n'existe pas, ajouter une nouvelle colonne
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable(false);
            }

            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable(false)->unique();
            }

            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable(false);
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'password']);
        });
    }


};
