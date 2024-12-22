<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormacionAcademica extends Model
{
    use HasFactory;

    protected $table = 'formacion_academica';

    protected $fillable = [
        'user_id',
        'titulo_obtenido',
        'institucion',
        'fecha_inicio',
        'fecha_fin',
    ];

    /**
     * Relación con users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}