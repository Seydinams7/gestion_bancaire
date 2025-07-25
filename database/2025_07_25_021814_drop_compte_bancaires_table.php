<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('compte_bancaires');
    }

    public function down(): void
    {
        // Optionnel : recréer une version minimale si tu fais un rollback
        Schema::create('compte_bancaires', function ($table) {
            $table->id();
            $table->timestamps();
        });
    }
};
