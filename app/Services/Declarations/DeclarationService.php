<?php
// app/Services/DeclarationService.php

namespace App\Services\Declarations;

use App\Models\Declaration;
use Illuminate\Support\Facades\DB;

class DeclarationService
{
    public function create(array $data): Declaration
    {
        return DB::transaction(function () use ($data) {
            return Declaration::create([
                'numero_e'          => $data['numero_e'],
                'date_e'            => $data['date_e'],
                'importateur_id'    => $data['importateur_id'],
                'exportateur_id'    => $data['exportateur_id'] ?? null,
                'regime'            => $data['regime'],
                'bureau_douane'     => $data['bureau_douane'],
                'pays_provenance'   => $data['pays_provenance'],
                'pays_destination'  => $data['pays_destination'],
                'taux_change'       => $data['taux_change'] ?? null,
                'declarant_id'      => $data['declarant_id'] ?? null,
                'numero_conteneur'  => $data['numero_conteneur'] ?? null,
                'notes'             => $data['notes'] ?? null,
            ]);
        });
    }

    public function update(Declaration $declaration, array $data): Declaration
    {
        return DB::transaction(function () use ($declaration, $data) {
            $declaration->update($data);
            return $declaration;
        });
    }

    public function delete(Declaration $declaration): void
    {
        $declaration->delete();
    }

    public static function getDeclarations()
    {
        return Declaration::all();
    }
}
