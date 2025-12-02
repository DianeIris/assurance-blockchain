<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'user_id',
        'description',
        'montant_reclame',
        'date_declaration',
        'statut',       // en_attente, valide, rejete, indemnise
        'ipfs_hash',
        'expert_id',
        'commentaire_expert',
        'date_validation',
        'transaction_hash'
    ];

    // Le sinistre appartient à un contrat
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    // Le sinistre est déclaré par un utilisateur (Assuré)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Le sinistre peut être géré par un expert (qui est aussi un User)
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }
}