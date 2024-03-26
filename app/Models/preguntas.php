<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class preguntas extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'preguntaId';

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
        'preguntaId',
        'texto',
        'clasificacion',
        'peso',
        'capacidadFk'
    ];

    public function capacidades(): BelongsTo
    {
        return $this->belongsTo(Capacidades::class, 'capacidadFk', 'capacidadId');
    }

    public function RespuestasPreguntas(): HasMany
    {
        return $this->hasMany(RespuestasPreguntas::class, 'preguntaFk', 'preguntaId');
    }
}
