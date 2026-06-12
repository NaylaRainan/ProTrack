<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionDepartment extends Model
{
    protected $fillable = [
        'nama_bagian'
    ];

    public function spks()
    {
        return $this->hasMany(Spk::class);
    }
}