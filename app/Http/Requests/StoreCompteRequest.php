<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulaire' => 'required|uuid|exists:clients,id',
            'type' => 'required|in:epargne,cheque',
            'devise' => 'required|string',
            'statut' => 'in:actif,bloque,ferme',
        ];
    }
}