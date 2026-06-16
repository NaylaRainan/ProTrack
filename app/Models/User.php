<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * Mass Assignment
     */
    protected $fillable = [

        'name',

        'email',

        'password',

        'role'

    ];

    /**
     * Hidden Attribute
     */
    protected $hidden = [

        'password',

        'remember_token'

    ];

    /**
     * Cast
     */
    protected $casts = [

        'email_verified_at' => 'datetime'

    ];

    /**
     * Relasi Progress Log
     */
    public function progressLogs()
    {
        return $this->hasMany(
            ProgressLog::class
        );
    }

    /**
     * Cek Admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek Develop
     */
    public function isDevelop()
    {
        return $this->role === 'develop';
    }

    /**
     * Cek Offset
     */
    public function isOffset()
    {
        return $this->role === 'offset';
    }

    /**
     * Cek Plotter
     */
    public function isPlotter()
    {
        return $this->role === 'plotter';
    }

    /**
     * Cek UV
     */
    public function isUv()
    {
        return $this->role === 'uv';
    }

    /**
     * Cek Finishing
     */
    public function isFinishing()
    {
        return $this->role === 'finishing';
    }

    /**
     * Nama Role Yang Lebih Rapi
     */
    public function getRoleLabelAttribute()
    {
        return match ($this->role) {

            'admin' => 'Administrator',

            'develop' => 'Develop',

            'offset' => 'Offset',

            'plotter' => 'Plotter',

            'uv' => 'UV',

            'finishing' => 'Finishing',

            default => 'User'

        };
    }
}