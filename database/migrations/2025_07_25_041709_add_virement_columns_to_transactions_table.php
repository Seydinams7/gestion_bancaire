<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('compte_source_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('compte_dest_id')->nullable()->after('compte_source_id');

            $table->foreign('compte_source_id')
                ->references('id')
                ->on('compte_bancaires')
                ->onDelete('cascade');

            $table->foreign('compte_dest_id')
                ->references('id')
                ->on('compte_bancaires')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['compte_source_id']);
            $table->dropForeign(['compte_dest_id']);
            $table->dropColumn(['compte_source_id', 'compte_dest_id']);
        });
    }
};
