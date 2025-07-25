<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('compte_bancaires', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->enum('type_compte', ['courant', 'epargne']);
            $table->decimal('solde', 15, 2)->default(0.00);

            $table->string('numero_compte')->unique();
            $table->string('code_guichet', 10)->nullable();
            $table->string('code_banque')->nullable();
            $table->string('cle_rib')->nullable();

            $table->enum('statut', ['en_attente', 'actif', 'cloture'])->default('en_attente');

            $table->string('numero_carte')->nullable();
            $table->string('date_expiration')->nullable();
            $table->string('cvv')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compte_bancaires');
    }
};
