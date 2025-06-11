<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prestamos';

    protected $fillable = [
        'libro_id',
        'user_id',
        'sancion_id',
        'solicitud_id',
        'fecha_prestamo',
        'fecha_devolucion_prevista',
        'fecha_devolucion_real',
        'estado',
        'prestamo_id'
    ];

    protected $dates = [
        'fecha_prestamo',
        'fecha_devolucion_prevista',
        'fecha_devolucion_real',
        'deleted_at'
    ];

    protected $casts = [
        'fecha_prestamo' => 'datetime',
        'fecha_devolucion_prevista' => 'datetime',
        'fecha_devolucion_real' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isRetrasado()
    {
        if ($this->fecha_devolucion_real === null && now()->greaterThan($this->fecha_devolucion_prevista)) {
            return true;
        }
        return false;
    }

    public static function ESTADOS()
    {
        return [
            'ACTIVO' => 'activo',
            'DEVUELTO' => 'devuelto',
            'RETRASADO' => 'retrasado',
            'RENOVADO' => 'renovado',
            'CANCELADO' => 'cancelado'
        ];
    }
}
