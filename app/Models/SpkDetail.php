<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpkDetail extends Model
{
    protected $fillable = [
        'spk_id',
        'nama_file',
        'bahan',
        'panjang',
        'lebar',
        'qty',
        'finishing'
    ];

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }
}