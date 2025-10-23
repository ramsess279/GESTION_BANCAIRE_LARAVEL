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

    /**
     * Scope pour récupérer les comptes non supprimés (statut != ferme).
     */
    public function scopeNonSupprimes($query)
    {
        return $query->where('statut', '!=', 'ferme');
    }

    /**
     * Scope pour récupérer un compte par son numéro.
     */
    public function scopeNumero($query, $numero)
    {
        return $query->where('numeroCompte', $numero);
    }

    /**
     * Scope pour récupérer les comptes d'un client basé sur le nom ou email.
     */
    public function scopeClient($query, $search)
    {
        return $query->whereHas('client.user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }
}