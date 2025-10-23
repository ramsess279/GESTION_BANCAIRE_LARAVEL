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
        Schema::table('clients', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('compte_models', function (Blueprint $table) {
            $table->index('client_id');
            $table->index('type');
            $table->index('statut');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('compte_models', function (Blueprint $table) {
            $table->dropIndex(['client_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['statut']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });
    }
};
