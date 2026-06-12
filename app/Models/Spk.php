<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spk extends Model
{
    protected $fillable = [
        'customer_id',
        'production_department_id',
        'no_spk',
        'tanggal_spk',
        'deadline_date',
        'priority',
        'status',
        'keterangan'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function department()
    {
        return $this->belongsTo(
            ProductionDepartment::class,
            'production_department_id'
        );
    }

    public function details()
    {
        return $this->hasMany(
            SpkDetail::class
        );
    }

    public function progressLogs()
    {
        return $this->hasMany(
            ProgressLog::class
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($spk) {

            $year = now()->format('y');
            $month = now()->format('m');

            $last = self::whereYear(
                'created_at',
                now()->year
            )->count() + 1;

            $spk->no_spk =
                'SPK/' .
                $year . '/' .
                $month . '/' .
                str_pad(
                    $last,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

            if (!$spk->tanggal_spk) {
                $spk->tanggal_spk = now()->toDateString();
            }

        });
    }
}