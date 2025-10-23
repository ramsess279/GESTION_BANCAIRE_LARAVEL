<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Validation personnalisée sans regex ni rules().
     */
    public function validateCustom()
    {
        $data = $this->all();
        $errors = [];

        if (empty($data['titulaire'])) {
            $errors['titulaire'] = 'Le titulaire est obligatoire.';
        }

        if (!in_array($data['type'] ?? '', ['epargne', 'cheque'])) {
            $errors['type'] = 'Le type doit être epargne ou cheque.';
        }

        if (empty($data['devise'])) {
            $errors['devise'] = 'La devise est obligatoire.';
        }

        if (!in_array($data['statut'] ?? '', ['actif', 'bloque', 'ferme'])) {
            $errors['statut'] = 'Le statut est invalide.';
        }

        if ($errors) {
            abort(422, json_encode(['errors' => $errors]));
        }
    }
}