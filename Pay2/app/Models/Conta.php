<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
     protected $fillable = [
        'id',
        'saldo',
        'user_id',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

public function movimento()
{
    return $this->hasMany(Movimento::class);
}

}
