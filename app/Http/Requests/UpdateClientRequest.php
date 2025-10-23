<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cni' => 'required|string|unique:clients,cni,' . $this->route('client')->id,
            'user_id' => 'required|uuid|unique:clients,user_id,' . $this->route('client')->id . '|exists:users,id',
        ];
    }
}