<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CompteModel extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($compte) {
            if (empty($compte->id)) {
                $compte->id = Str::uuid();
            }
            if (empty($compte->numeroCompte)) {
                // Exemple de génération : préfixe + 10 chiffres aléatoires
                $compte->numeroCompte = 'CPT-' . strtoupper(Str::random(10));
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(ClientModel::class, 'client_id');
    }
}