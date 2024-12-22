<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model
{
    use HasFactory;

    protected $table = 'experiencia_laboral';

    protected $fillable = [
        'user_id',
        'cargo',
        'empresa',
        'fecha_inicio',
        'fecha_fin',
        'logros',
        'archivo',
        'trabaja_actualmente',
    ];

    /**
     * Relación con users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Almacenar y acceder a los archivos como un array
     */
    protected $casts = [
        'archivo' => 'array',
    ];
}