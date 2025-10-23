<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cni' => 'required|string|unique:clients,cni',
            'user_id' => 'required|uuid|unique:clients,user_id|exists:users,id',
        ];
    }
}