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
    Schema::table('contracts', function (Blueprint $table) {
        // Optimisation pour les recherches
        $table->index('user_id', 'idx_contracts_user');
        $table->index('statut', 'idx_contracts_status');
    });

    Schema::table('claims', function (Blueprint $table) {
        $table->index('contract_id', 'idx_claims_contract');
        $table->index('user_id', 'idx_claims_user');
        $table->index('expert_id', 'idx_claims_expert');
        $table->index('statut', 'idx_claims_status');
    });
    
    Schema::table('premiums', function (Blueprint $table) {
        $table->index('contract_id', 'idx_premiums_contract');
    });
}
};
