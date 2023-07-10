<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    //

    protected $fillable = [
        'code',
        'valor',
        'receiver',
        'conta_id',
        
    ];
    public function conta()
    {
        return $this->belongsTo(Conta::class);
    }

    
}
