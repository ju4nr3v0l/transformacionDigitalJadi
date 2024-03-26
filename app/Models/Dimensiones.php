<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dimensiones extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'dimensionId';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'dimensionId',
        'nombre',
        'capaciades'
    ];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function capacidades(): HasMany
    {
        return $this->hasMany(Capacidades::class, 'dimensionFk', 'dimensionId');
    }
}
