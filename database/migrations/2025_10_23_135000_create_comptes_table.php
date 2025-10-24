<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compte_models', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('numeroCompte')->unique();
            $table->enum("type", ['epargne', 'cheque']);
            $table->string('devise');
            $table->decimal('solde', 15, 2)->default(0);
            $table->enum("statut", ['actif', 'bloque', 'ferme'])->default('actif');
            $table->uuid('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_models');
    }
};