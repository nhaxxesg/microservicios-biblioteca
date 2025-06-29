<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sancion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'usuario_id',
        'book_id',
        'motivo',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa')
                    ->where('fecha_inicio', '<=', now())
                    ->where('fecha_fin', '>', now());
    }

    public function scopePorLibro($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }
}
