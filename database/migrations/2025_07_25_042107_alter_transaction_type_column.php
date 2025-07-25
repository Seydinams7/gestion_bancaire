<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Supprimer la contrainte check existante
        DB::statement("ALTER TABLE transactions DROP CONSTRAINT IF EXISTS transactions_type_check");

        // Modifier la colonne type avec une nouvelle contrainte check
        DB::statement("ALTER TABLE transactions
            ADD CONSTRAINT transactions_type_check
            CHECK (type IN ('depot', 'retrait', 'virement'))");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions DROP CONSTRAINT IF EXISTS transactions_type_check");

        // Revenir à l'ancienne contrainte
        DB::statement("ALTER TABLE transactions
            ADD CONSTRAINT transactions_type_check
            CHECK (type IN ('depot', 'retrait'))");
    }
};
