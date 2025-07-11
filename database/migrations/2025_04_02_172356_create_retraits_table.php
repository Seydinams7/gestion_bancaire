<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('retraits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compte_id')->constrained('compte_bancaires')->onDelete('cascade');
            $table->decimal('montant', 15, 2);
            $table->timestamp('date_retrait')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('retraits');
    }
};

