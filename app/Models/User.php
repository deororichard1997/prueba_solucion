<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'rango_salarial',
        'nivel_profesional',
        'nombre_completo',
        'profesion',
        'especializacion',
        'numero_documento',
        'ciudad_de_empleo',
        'traslado',
        'celular',
        'linkedin',
        'valor_agregado',
        'feliz_en_la_labor',
        'talento_profesional',
        'ideas',
        'datos_complementarios',
        'competencias',
        'tipo_cultura',
        'jornada',
        'tipo_formacion',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function formacionAcademica()
    {
        return $this->hasMany(FormacionAcademica::class);
    }

    public function experienciaLaboral()
    {
        return $this->hasMany(ExperienciaLaboral::class);
    }
}
