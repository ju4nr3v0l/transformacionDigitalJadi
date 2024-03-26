<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Capacidades extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'capacidadId';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'capacidadId',
        'nombre',
        'descripcion',
        'dimensionFk'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;



    public function dimensiones(): BelongsTo
    {
        return $this->belongsTo(Dimensiones::class, 'capacidadFk', 'capacidadId');
    }

    public function preguntas(): HasMany
    {
        return $this->hasMany(preguntas::class, 'dimensionFk', 'dimensionId');
    }
}
