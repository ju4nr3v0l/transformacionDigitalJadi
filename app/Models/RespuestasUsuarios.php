<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RespuestasUsuarios extends Model
{

    protected $primaryKey = 'respuestaUsuarioId';
    public $timestamps = false;

    protected $attributes = [
        'recomendacion_copilot' => null
    ];
    protected $fillable = [
        'respuestaFk',
        'usuarioFk',
        'fecha'
    ];


    public function respuestasPreguntas(): BelongsTo
    {
        return $this->belongsTo(RespuestasPreguntas::class, 'respuestaFk', 'respuestaId');
    }

    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(Usuarios::class, 'usuarioFk', 'usuarioConsultoriaId');
    }
}
