<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'nama_customer'
    ];

    public function spks()
    {
        return $this->hasMany(Spk::class);
    }
}