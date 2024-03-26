<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RespuestasPreguntas extends Model
{
    protected $primaryKey = 'respuestaId';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'respuestaId',
        'texto',
        'clasificacion',
        'peso',
        'preguntaFk'
    ];

    public function preguntas(): BelongsTo
    {
        return $this->belongsTo(preguntas::class, 'preguntaFk', 'preguntaId');
    }

    public function respuestasUsuarios(): HasMany
    {
        return $this->hasMany(RespuestasUsuarios::class, 'respuestaFk', 'respuestaId');
    }
}
