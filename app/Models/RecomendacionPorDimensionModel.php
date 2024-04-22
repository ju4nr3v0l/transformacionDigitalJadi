<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecomendacionPorDimensionModel extends Model
{
    protected $primaryKey = 'recomendacionDimensionId';
    protected $table = 'recomendacion_dimension';
    public $timestamps = false;

    protected $attributes = [
        'recomendacion_copilot' => null
    ];
    protected $fillable = [
        'usuarioFk',
        'dimensionFk',
        'fecha',
        'recomendacion_copilot',
        'promt'
    ];


    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(Usuarios::class, 'usuarioFk', 'usuarioConsultoriaId');
    }
    public function dimensiones(): BelongsTo
    {
        return $this->belongsTo(Dimensiones::class, 'dimensionFk', 'dimensionId');
    }
}
