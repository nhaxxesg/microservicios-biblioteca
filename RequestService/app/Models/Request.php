<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'usuario_id',
        'descripcion',
        'estado',
        'prestamo_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_de_registro' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Los estados posibles para una solicitud
     */
    public const ESTADOS = [
        'pendiente',
        'aprobada',
        'rechazada',
        'en_proceso',
        'completada'
    ];
}
