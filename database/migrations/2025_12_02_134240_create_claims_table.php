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
    Schema::create('claims', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->text('description');
        $table->decimal('montant_reclame', 10, 2);
        $table->dateTime('date_declaration')->useCurrent();
        
        // Statuts du sinistre
        $table->enum('statut', ['en_attente', 'valide', 'rejete', 'indemnise'])->default('en_attente');
        
        $table->string('ipfs_hash', 100)->nullable(); // Preuve IPFS
        
        // Expert qui gère le dossier
        $table->foreignId('expert_id')->nullable()->constrained('users');
        $table->text('commentaire_expert')->nullable();
        
        $table->string('transaction_hash', 66)->nullable();
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
