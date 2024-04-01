<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UsuariosConsultoria extends Model
{

    protected $primaryKey = 'usuarioConsultoriaId';


    protected $fillable = [
        'nit',
        'nombre_inmobiliaria',
        'nombre_completo',
        'cargo',
        'celular',
        'correo',
        'step'

    ];

    public function respuestasUsuarios(): HasMany
    {
        return $this->hasMany(RespuestasUsuarios::class, 'usuarioFk', 'usuarioConsultoriaId');
    }

}
