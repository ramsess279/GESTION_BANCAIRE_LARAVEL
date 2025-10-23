<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionModel extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'compte_id', 'type', 'montant', 'description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->id)) {
                $transaction->id = Str::uuid();
            }
        });
    }

    public function compte()
    {
        return $this->belongsTo(CompteModel::class, 'compte_id');
    }
}
