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
        Schema::create('transaction_models', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid('compte_id');
            $table->foreign('compte_id')->references('id')->on('compte_models');
            $table->enum("type", ['debit', 'credit']);
            $table->decimal('montant', 15, 2);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_models');
    }
};
