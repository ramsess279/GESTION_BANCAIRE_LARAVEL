<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    use HasFactory;

    protected $table = 'clients'; // Important pour lier à la table 'clients'
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'cni', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comptes()
    {
        return $this->hasMany(CompteModel::class, 'client_id');
    }
}
