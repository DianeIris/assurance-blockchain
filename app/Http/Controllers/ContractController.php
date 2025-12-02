<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract; // On importe le modèle
use Illuminate\Support\Facades\Auth; // Pour savoir qui est connecté
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    /**
     * Liste des contrats de l'utilisateur connecté
     * GET /api/contracts
     */
    public function index()
    {
        // On récupère l'utilisateur connecté via le Token
        $user = Auth::user();
        
        // On récupère uniquement SES contrats
        $contracts = $user->contracts;

        return response()->json([
            'status' => 'success',
            'data' => $contracts
        ]);
    }

    /**
     * Créer un nouveau contrat (Souscription)
     * POST /api/contracts
     */
    public function store(Request $request)
    {
        // 1. Validation des données du formulaire
        $validator = Validator::make($request->all(), [
            'type_assurance' => 'required|string',
            'montant_couverture' => 'required|numeric',
            'prime_mensuelle' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // 2. Création du contrat relié à l'utilisateur connecté
        $contract = Contract::create([
            'user_id' => Auth::id(), // Laravel remplit ça tout seul grâce au Token !
            'type_assurance' => $request->type_assurance,
            'montant_couverture' => $request->montant_couverture,
            'prime_mensuelle' => $request->prime_mensuelle,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'statut' => 'brouillon', // Statut par défaut selon le PDF
        ]);

        return response()->json([
            'message' => 'Contrat créé avec succès (Brouillon)',
            'contrat' => $contract
        ], 201);
    }
}